-- MySQL Workbench Synchronization
-- Generated: 2025-02-07 23:59
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: PC_User

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

ALTER TABLE `apprentice`.`programs` 
DROP FOREIGN KEY `channel_id_fk`;

ALTER TABLE `apprentice`.`series` 
DROP FOREIGN KEY `program_id_fk`;

ALTER TABLE `apprentice`.`seasons` 
DROP FOREIGN KEY `series_id_fk`;

ALTER TABLE `apprentice`.`episodes` 
DROP FOREIGN KEY `season_id`;

ALTER TABLE `apprentice`.`program_schedules` 
DROP FOREIGN KEY `channel_id_fk2`,
DROP FOREIGN KEY `episode_id_fk`;

ALTER TABLE `apprentice`.`channels` 
COLLATE = utf8mb4_general_ci ;

ALTER TABLE `apprentice`.`programs` 
COLLATE = utf8mb4_general_ci ;

ALTER TABLE `apprentice`.`series` 
COLLATE = utf8mb4_general_ci ;

ALTER TABLE `apprentice`.`seasons` 
COLLATE = utf8mb4_general_ci ;

ALTER TABLE `apprentice`.`episodes` 
COLLATE = utf8mb4_general_ci ,
ADD COLUMN `episode_time` INT(11) NOT NULL AFTER `episode_name`,
ADD COLUMN `release_date` DATE NOT NULL AFTER `episode_time`;

ALTER TABLE `apprentice`.`program_schedules` 
COLLATE = utf8mb4_general_ci ,
DROP COLUMN `episode_time`,
DROP COLUMN `release_date`,
ADD COLUMN `schedule` DATETIME NOT NULL AFTER `schedule_id`;

ALTER TABLE `apprentice`.`genres` 
COLLATE = utf8mb4_general_ci ;

ALTER TABLE `apprentice`.`programs` 
DROP FOREIGN KEY `genre_id_fk`;

ALTER TABLE `apprentice`.`programs` ADD CONSTRAINT `genre_id_fk`
  FOREIGN KEY (`genre_id`)
  REFERENCES `apprentice`.`genres` (`genre_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `channel_id_fk`
  FOREIGN KEY (`channel_id`)
  REFERENCES `apprentice`.`channels` (`channel_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `apprentice`.`series` 
ADD CONSTRAINT `program_id_fk`
  FOREIGN KEY (`program_id`)
  REFERENCES `apprentice`.`programs` (`program_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `apprentice`.`seasons` 
ADD CONSTRAINT `series_id_fk`
  FOREIGN KEY (`series_id`)
  REFERENCES `apprentice`.`series` (`series_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `apprentice`.`episodes` 
ADD CONSTRAINT `season_id`
  FOREIGN KEY (`season_id`)
  REFERENCES `apprentice`.`seasons` (`season_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `apprentice`.`program_schedules` 
ADD CONSTRAINT `channel_id_fk2`
  FOREIGN KEY (`channel_id`)
  REFERENCES `apprentice`.`channels` (`channel_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
ADD CONSTRAINT `episode_id_fk`
  FOREIGN KEY (`episode_id`)
  REFERENCES `apprentice`.`episodes` (`episode_id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
