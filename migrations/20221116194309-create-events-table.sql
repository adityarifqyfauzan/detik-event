
-- +migrate Up
CREATE TABLE `detik_test_db`.`events` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    `name` VARCHAR(255) NOT NULL, 
    `description` TEXT NULL, 
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
-- +migrate Down
DROP TABLE `detik_test_db`.`events`;