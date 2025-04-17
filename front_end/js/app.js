const { createApp } = Vue;

const API_BASE_URL = 'http://api.cc.localhost';

// Configure Axios defaults
axios.defaults.baseURL = API_BASE_URL;
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Content-Type'] = 'application/json';

createApp({
    data() {
        return {
            categories: [],
            courses: [],
            selectedCategory: null,
            loading: false,
            error: null
        };
    },
    
    computed: {
        filteredCourses() {
            if (!this.selectedCategory) {
                return this.courses;
            }
            return this.courses.filter(course => {
                // Check if the course belongs to the selected category or any of its subcategories
                return this.isCourseInCategory(course, this.selectedCategory);
            });
        }
    },
    
    methods: {
        async fetchCategories() {
            try {
                this.loading = true;
                const response = await axios.get('/categories');
                const flatCategories = response.data.data;

                // Convert flat categories into a tree structure
                const categoryMap = {};
                flatCategories.forEach(category => {
                    category.children = [];
                    categoryMap[category.id] = category;
                });

                this.categories = [];
                flatCategories.forEach(category => {
                    if (category.parent_id) {
                        categoryMap[category.parent_id].children.push(category);
                    } else {
                        this.categories.push(category);
                    }
                });
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching categories:', error);
            } finally {
                this.loading = false;
            }
        },
        
        async fetchCourses() {
            try {
                this.loading = true;
                const response = await axios.get('/courses');
                this.courses = response.data.data;
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching courses:', error);
            } finally {
                this.loading = false;
            }
        },
        
        selectCategory(categoryId) {
            this.selectedCategory = this.selectedCategory === categoryId ? null : categoryId;
        },
        
        isCourseInCategory(course, categoryId) {
            // Find the category in our categories array
            const category = this.categories.find(c => c.id === categoryId);
            if (!category) return false;
            
            // Check if the course's category matches or is a subcategory
            return this.isSubcategory(course.category_id, categoryId);
        },
        
        isSubcategory(categoryId, parentId) {
            // If the category ID matches the parent ID, it's a direct match
            if (categoryId === parentId) {
                return true;
            }
            
            // Find the category
            const category = this.categories.find(c => c.id === categoryId);
            if (!category) {
                return false;
            }
            
            // If the category has a parent_id that matches the parentId, it's a subcategory
            if (category.parent_id === parentId) {
                return true;
            }
            
            // If the category has a parent_id, recursively check if its parent is a subcategory
            if (category.parent_id) {
                return this.isSubcategory(category.parent_id, parentId);
            }
            
            return false;
        }
    },
    
    async mounted() {
        await Promise.all([
            this.fetchCategories(),
            this.fetchCourses()
        ]);
    }
}).mount('#app');