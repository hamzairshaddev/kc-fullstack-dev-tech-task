USE course_catalog;

-- up
-- First create the table without the foreign key constraint
CREATE TABLE `courses` (
    `id` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `image_preview` VARCHAR(255),
    `category_id` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

-- Then add the foreign key constraint
ALTER TABLE `courses`
ADD CONSTRAINT `fk_course_category`
FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE;
