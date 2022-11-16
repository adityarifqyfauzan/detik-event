
-- +migrate Up
CREATE TABLE `detik_test_db`.`tickets` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT, 
    `event_id` INT UNSIGNED NOT NULL, 
    `code` VARCHAR(10) NOT NULL, 
    `status` ENUM('available','claimed') NOT NULL DEFAULT 'available',
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
    PRIMARY KEY (`id`),
    INDEX `fk_event_tickets_ticket1_idx` (`event_id` ASC),
    CONSTRAINT `fk_event_tickets_ticket1`
        FOREIGN KEY (`event_id`)
            REFERENCES `detik_test_db`.`events` (`id`)
            ON DELETE NO ACTION
            ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- +migrate Down
DROP TABLE `detik_test_db`.`tickets`;