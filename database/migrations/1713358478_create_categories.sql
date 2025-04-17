USE course_catalog;

-- up
-- First create the table without the foreign key constraint
CREATE TABLE `categories` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `parent_id` VARCHAR(255),
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
);

-- Then add the self-referencing foreign key constraint
ALTER TABLE `categories`
ADD CONSTRAINT `fk_category_parent`
FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL;
