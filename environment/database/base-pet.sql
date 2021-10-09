SET names 'utf8';

CREATE TABLE IF NOT EXISTS `pet` (
    `id` VARCHAR(36) NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    `age` TINYINT(3) NOT NULL,
    `species_key` VARCHAR(100) NOT NULL,
    `breed_name` VARCHAR(100) NOT NULL,
    `owner_id` VARCHAR(36) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
