SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 ;
USE `fdugroup` ;

-- -----------------------------------------------------
-- Table `fdugroup`.`group_wallet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_wallet` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_wallet` (
  `u_id` INT(11) NOT NULL AUTO_INCREMENT,
  `w_type` VARCHAR(45) NOT NULL,
  `w_money` INT NOT NULL DEFAULT 0,
  `w_frozen_money` INT NOT NULL,
  `w_timestamp` TIMESTAMP NOT NULL,
  PRIMARY KEY (`u_id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
