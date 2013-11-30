SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 ;
USE `fdugroup` ;

-- -----------------------------------------------------
-- Table `fdugroup`.`group_syslog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_syslog` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_syslog` (
  `log_id` INT NOT NULL AUTO_INCREMENT,
  `u_id` INT NOT NULL DEFAULT 0,
  `type` VARCHAR(45) NOT NULL COMMENT 'the type of the log message, like system, php, user, etc',
  `message` TEXT NOT NULL,
  `severity` INT NOT NULL COMMENT 'emrgency severity',
  `path` VARCHAR(255) NOT NULL,
  `referer_uri` VARCHAR(255) NULL,
  `host` VARCHAR(45) NOT NULL,
  `timestamp` TIMESTAMP NOT NULL,
  PRIMARY KEY (`log_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
