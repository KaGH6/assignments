-- 以下のデータを番号順で挿入してください。

-- データ挿入1
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- データ挿入2
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- データ挿入3
ALTER SCHEMA `apprentice3`  DEFAULT COLLATE utf8mb4_general_ci ;

-- データ挿入4
CREATE TABLE IF NOT EXISTS `apprentice3`.`channels` (
  `channel_id` INT(11) NOT NULL AUTO_INCREMENT,
  `channel_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`channel_id`),
  UNIQUE INDEX `channel_name_UNIQUE` (`channel_name` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入5
CREATE TABLE IF NOT EXISTS `apprentice3`.`programs` (
  `program_id` INT(11) NOT NULL AUTO_INCREMENT,
  `program_name` VARCHAR(20) NOT NULL,
  `genre_id` INT(11) NOT NULL,
  `channel_id` INT(11) NOT NULL,
  PRIMARY KEY (`program_id`),
  INDEX `channel_id_idx` (`channel_id` ASC) VISIBLE,
  INDEX `genre_id_idx` (`genre_id` ASC) VISIBLE,
  CONSTRAINT `genre_id_fk`
    FOREIGN KEY (`genre_id`)
    REFERENCES `apprentice3`.`genres` (`genre_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `channel_id_fk`
    FOREIGN KEY (`channel_id`)
    REFERENCES `apprentice3`.`channels` (`channel_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入6
CREATE TABLE IF NOT EXISTS `apprentice3`.`series` (
  `program_id` INT(11) NOT NULL,
  `series_id` INT(11) NOT NULL AUTO_INCREMENT,
  `series_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`series_id`),
  INDEX `program_id_idx` (`program_id` ASC) VISIBLE,
  CONSTRAINT `program_id_fk5`
    FOREIGN KEY (`program_id`)
    REFERENCES `apprentice3`.`programs` (`program_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入7
CREATE TABLE IF NOT EXISTS `apprentice3`.`seasons` (
  `series_id` INT(11) NOT NULL,
  `season_id` INT(11) NOT NULL AUTO_INCREMENT,
  `season_number` VARCHAR(45) NOT NULL,
  `program_id` INT(11) NOT NULL,
  PRIMARY KEY (`season_id`),
  INDEX `series_id_idx` (`series_id` ASC) VISIBLE,
  INDEX `program_id_idx` (`program_id` ASC) VISIBLE,
  CONSTRAINT `series_id_fk`
    FOREIGN KEY (`series_id`)
    REFERENCES `apprentice3`.`series` (`series_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `program_id_fk4`
    FOREIGN KEY (`program_id`)
    REFERENCES `apprentice3`.`programs` (`program_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入8
CREATE TABLE IF NOT EXISTS `apprentice3`.`episodes` (
  `season_id` INT(11) NOT NULL,
  `episode_id` INT(11) NOT NULL AUTO_INCREMENT,
  `episode_name` VARCHAR(40) NOT NULL,
  `episode_time` INT(11) NOT NULL,
  `view_number` INT(11) NOT NULL,
  `episode_description` VARCHAR(200) NULL DEFAULT '見てください',
  `program_id` INT(11) NOT NULL,
  PRIMARY KEY (`episode_id`),
  INDEX `season_id_idx` (`season_id` ASC) VISIBLE,
  INDEX `program_id_idx` (`program_id` ASC) VISIBLE,
  CONSTRAINT `season_id`
    FOREIGN KEY (`season_id`)
    REFERENCES `apprentice3`.`seasons` (`season_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `program_id_fk3`
    FOREIGN KEY (`program_id`)
    REFERENCES `apprentice3`.`programs` (`program_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入9
CREATE TABLE IF NOT EXISTS `apprentice3`.`program_schedules` (
  `schedule_id` INT(11) NOT NULL AUTO_INCREMENT,
  `release_date` DATETIME NOT NULL,
  `channel_id` INT(11) NOT NULL,
  `episode_id` INT(11) NOT NULL,
  PRIMARY KEY (`schedule_id`),
  INDEX `channel_id_idx` (`channel_id` ASC) VISIBLE,
  INDEX `episode_id_idx` (`episode_id` ASC) VISIBLE,
  CONSTRAINT `channel_id_fk2`
    FOREIGN KEY (`channel_id`)
    REFERENCES `apprentice3`.`channels` (`channel_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `episode_id_fk`
    FOREIGN KEY (`episode_id`)
    REFERENCES `apprentice3`.`episodes` (`episode_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- データ挿入10
CREATE TABLE IF NOT EXISTS `apprentice3`.`genres` (
  `genre_id` INT(11) NOT NULL AUTO_INCREMENT,
  `genre_name` VARCHAR(40) NULL DEFAULT NULL,
  PRIMARY KEY (`genre_id`),
  UNIQUE INDEX `genre_name_UNIQUE` (`genre_name` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Placeholder table for view `apprentice3`.`view1`
-- -----------------------------------------------------
-- CREATE TABLE IF NOT EXISTS `apprentice3`.`view1` (`id` INT);


-- USE `apprentice3`;

-- -- -----------------------------------------------------
-- -- View `apprentice3`.`view1`
-- -- -----------------------------------------------------
-- DROP TABLE IF EXISTS `apprentice3`.`view1`;
-- USE `apprentice3`;

-- データ挿入11
SET SQL_MODE=@OLD_SQL_MODE;
-- データ挿入12
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
-- データ挿入13
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
