SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `fdugroup` ;

-- -----------------------------------------------------
-- Table `fdugroup`.`catagory`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`catagory` (
  `cat_id` INT NOT NULL,
  `cat_name` VARCHAR(45) NOT NULL,
  `cat_pid` INT NOT NULL,
  PRIMARY KEY (`cat_id`),
  INDEX `fk_catagory_catagory1_idx` (`cat_pid` ASC),
  CONSTRAINT `fk_catagory_catagory1`
    FOREIGN KEY (`cat_pid`)
    REFERENCES `fdugroup`.`catagory` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`users` (
  `u_ID` INT NOT NULL,
  `u_name` VARCHAR(45) NOT NULL,
  `u_mail` VARCHAR(45) NOT NULL,
  `u_password` VARCHAR(255) NOT NULL,
  `u_region` VARCHAR(45) NULL COMMENT '地区',
  `u_mobile` VARCHAR(45) NULL COMMENT '手机号',
  `u_qq` VARCHAR(45) NULL,
  `u_weibo` VARCHAR(45) NULL,
  `u_register_time` DATETIME NOT NULL,
  `u_status` INT NOT NULL COMMENT '0: 无效用户\n1: 激活用户',
  `u_picture` VARCHAR(45) NULL COMMENT '头像 url',
  `u_intro` TEXT NULL,
  `u_homepage` VARCHAR(45) NULL,
  `u_credits` INT NULL COMMENT '积分',
  `u_permission` INT NULL,
  `u_privacy` INT NULL,
  PRIMARY KEY (`u_ID`),
  UNIQUE INDEX `u_name_UNIQUE` (`u_name` ASC),
  UNIQUE INDEX `u_mail_UNIQUE` (`u_mail` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`group` (
  `gro_id` INT NOT NULL,
  `gro_creator` INT NOT NULL,
  `cat_id` INT NOT NULL,
  `gro_name` VARCHAR(45) NOT NULL,
  `gro_member_count` INT NOT NULL,
  `gro_created_time` DATETIME NOT NULL,
  `gro_intro` LONGTEXT NOT NULL,
  PRIMARY KEY (`gro_id`),
  INDEX `fk_group_catagory1_idx` (`cat_id` ASC),
  INDEX `fk_group_users1_idx` (`gro_creator` ASC),
  CONSTRAINT `fk_group_catagory1`
    FOREIGN KEY (`cat_id`)
    REFERENCES `fdugroup`.`catagory` (`cat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_users1`
    FOREIGN KEY (`gro_creator`)
    REFERENCES `fdugroup`.`users` (`u_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`topic`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`topic` (
  `top_id` INT NOT NULL,
  `gro_id` INT NOT NULL,
  `u_id` INT NOT NULL,
  `top_title` VARCHAR(45) NOT NULL,
  `top_created_time` DATETIME NOT NULL,
  `top_content` LONGTEXT NOT NULL,
  `top_last_comment_time` DATETIME NOT NULL,
  `top_comment_count` INT NOT NULL,
  PRIMARY KEY (`top_id`),
  INDEX `fk_topic_group1_idx` (`gro_id` ASC),
  INDEX `fk_topic_users1_idx` (`u_id` ASC),
  CONSTRAINT `fk_topic_group1`
    FOREIGN KEY (`gro_id`)
    REFERENCES `fdugroup`.`group` (`gro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_topic_users1`
    FOREIGN KEY (`u_id`)
    REFERENCES `fdugroup`.`users` (`u_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`comment` (
  `com_id` INT NOT NULL,
  `com_pid` INT NOT NULL,
  `top_id` INT NOT NULL,
  `u_id` INT NOT NULL,
  `com_created_time` DATETIME NOT NULL,
  `com_content` TEXT NOT NULL,
  PRIMARY KEY (`com_id`),
  INDEX `fk_comment_topic_idx` (`top_id` ASC),
  INDEX `fk_comment_comment1_idx` (`com_pid` ASC),
  INDEX `fk_comment_users1_idx` (`u_id` ASC),
  CONSTRAINT `fk_comment_topic`
    FOREIGN KEY (`top_id`)
    REFERENCES `fdugroup`.`topic` (`top_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_comment1`
    FOREIGN KEY (`com_pid`)
    REFERENCES `fdugroup`.`comment` (`com_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comment_users1`
    FOREIGN KEY (`u_id`)
    REFERENCES `fdugroup`.`users` (`u_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_has_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`group_has_users` (
  `gro_id` INT NOT NULL,
  `u_id` INT NOT NULL,
  `join_time` DATETIME NOT NULL COMMENT '加入时间',
  `status` INT NOT NULL,
  `comment` TEXT NULL,
  PRIMARY KEY (`gro_id`, `u_id`),
  INDEX `fk_group_has_users_users1_idx` (`u_id` ASC),
  INDEX `fk_group_has_users_group1_idx` (`gro_id` ASC),
  CONSTRAINT `fk_group_has_users_group1`
    FOREIGN KEY (`gro_id`)
    REFERENCES `fdugroup`.`group` (`gro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_has_users_users1`
    FOREIGN KEY (`u_id`)
    REFERENCES `fdugroup`.`users` (`u_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`entity_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`entity_type` (
  `typ_id` INT NOT NULL AUTO_INCREMENT,
  `typ_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`typ_id`),
  UNIQUE INDEX `typ_name_UNIQUE` (`typ_name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`tag` (
  `tag_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_name` VARCHAR(45) NOT NULL,
  `entity_type` INT NOT NULL,
  `entity_id` INT NULL,
  PRIMARY KEY (`tag_id`),
  INDEX `fk_tag_entity_type1_idx` (`entity_type` ASC),
  CONSTRAINT `fk_tag_entity_type1`
    FOREIGN KEY (`entity_type`)
    REFERENCES `fdugroup`.`entity_type` (`typ_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_has_group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `fdugroup`.`group_has_group` (
  `group_id1` INT NOT NULL,
  `group_id2` INT NOT NULL,
  PRIMARY KEY (`group_id1`, `group_id2`),
  INDEX `fk_group_has_group_group2_idx` (`group_id2` ASC),
  INDEX `fk_group_has_group_group1_idx` (`group_id1` ASC),
  CONSTRAINT `fk_group_has_group_group1`
    FOREIGN KEY (`group_id1`)
    REFERENCES `fdugroup`.`group` (`gro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_has_group_group2`
    FOREIGN KEY (`group_id2`)
    REFERENCES `fdugroup`.`group` (`gro_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
