SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 ;
USE `fdugroup` ;

-- -----------------------------------------------------
-- Table `fdugroup`.`group_accesslog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_accesslog` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_accesslog` (
  `aid` INT NOT NULL AUTO_INCREMENT,
  `u_id` INT NOT NULL DEFAULT 0 COMMENT '0 for anonymous users',
  `host` VARCHAR(45) NOT NULL COMMENT 'the hostname of the user who\'s visiting the page',
  `title` VARCHAR(255) NOT NULL COMMENT 'the title of this page',
  `path` VARCHAR(255) NOT NULL COMMENT 'the internal path of the page',
  `uri` VARCHAR(255) NULL COMMENT 'Referrer URI',
  `timestamp` TIMESTAMP NOT NULL,
  PRIMARY KEY (`aid`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_rating`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_rating` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_rating` (
  `rating_id` INT NOT NULL AUTO_INCREMENT,
  `entity_type` INT(11) NOT NULL,
  `entity_id` INT NOT NULL,
  `value` INT NOT NULL,
  `value_type` VARCHAR(45) NOT NULL,
  `tag` VARCHAR(45) NOT NULL,
  `u_id` INT NOT NULL,
  `host` VARCHAR(255) NOT NULL,
  `timestamp` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`rating_id`))
ENGINE = InnoDB;

CREATE INDEX `fk_group_rating_group_entity_type1_idx` ON `fdugroup`.`group_rating` (`entity_type` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_rating_statistic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_rating_statistic` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_rating_statistic` (
  `stat_id` INT NOT NULL AUTO_INCREMENT,
  `stat_type` VARCHAR(45) NULL,
  `entity_type` INT(11) NOT NULL,
  `entity_id` INT NOT NULL,
  `value_type` VARCHAR(45) NOT NULL,
  `value` INT NOT NULL,
  `tag` VARCHAR(45) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL,
  PRIMARY KEY (`stat_id`))
ENGINE = InnoDB;

CREATE INDEX `fk_group_rating_statistic_group_entity_type1_idx` ON `fdugroup`.`group_rating_statistic` (`entity_type` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
