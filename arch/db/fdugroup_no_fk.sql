SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `fdugroup` DEFAULT CHARACTER SET utf8 ;
USE `fdugroup` ;

-- -----------------------------------------------------
-- Table `fdugroup`.`group_category`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_category` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_category` (
  `cat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cat_name` VARCHAR(45) NOT NULL,
  `cat_pid` INT(11) NOT NULL,
  PRIMARY KEY (`cat_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 48
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_censor_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_censor_type` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_censor_type` (
  `csr_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `csr_type_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`csr_type_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_censor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_censor` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_censor` (
  `csr_id` INT(11) NOT NULL AUTO_INCREMENT,
  `csr_type_id` INT(11) NOT NULL,
  `csr_first_id` INT(11) NOT NULL,
  `csr_second_id` INT(11) NULL DEFAULT NULL,
  `csr_status` INT(11) NOT NULL DEFAULT '1',
  `csr_content` TEXT NULL DEFAULT NULL,
  `csr_send_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`csr_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8;

CREATE INDEX `csr_type_id` ON `fdugroup`.`group_censor` (`csr_type_id` ASC, `csr_first_id` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_groups` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_groups` (
  `gro_id` INT(11) NOT NULL AUTO_INCREMENT,
  `gro_creator` INT(11) NOT NULL,
  `cat_id` INT(11) NULL DEFAULT NULL,
  `gro_name` VARCHAR(45) NOT NULL,
  `gro_member_count` INT(11) NOT NULL,
  `gro_created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `gro_intro` LONGTEXT NULL DEFAULT NULL,
  `gro_picture` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`gro_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_user_role`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_user_role` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_user_role` (
  `rol_id` INT(11) NOT NULL AUTO_INCREMENT,
  `rol_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`rol_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `rol_name_UNIQUE` ON `fdugroup`.`group_user_role` (`rol_name` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_users` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_users` (
  `u_id` INT(11) NOT NULL AUTO_INCREMENT,
  `u_role_id` INT(11) NOT NULL,
  `u_name` VARCHAR(45) NOT NULL,
  `u_mail` VARCHAR(45) NOT NULL,
  `u_password` VARCHAR(255) NOT NULL,
  `u_region` VARCHAR(45) NULL DEFAULT NULL COMMENT '地区',
  `u_mobile` VARCHAR(45) NULL DEFAULT NULL COMMENT '手机号',
  `u_qq` VARCHAR(45) NULL DEFAULT NULL,
  `u_weibo` VARCHAR(45) NULL DEFAULT NULL,
  `u_register_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `u_status` INT(11) NOT NULL DEFAULT '0' COMMENT '0: 无效用户\n1: 激活用户',
  `u_picture` VARCHAR(45) NULL DEFAULT NULL COMMENT '头像 url',
  `u_intro` TEXT NULL DEFAULT NULL,
  `u_homepage` VARCHAR(45) NULL DEFAULT NULL,
  `u_credits` INT(11) NULL DEFAULT '0' COMMENT '积分',
  `u_permission` INT(11) NULL DEFAULT NULL,
  `u_privacy` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`u_id`, `u_role_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `u_name_UNIQUE` ON `fdugroup`.`group_users` (`u_name` ASC);

CREATE UNIQUE INDEX `u_mail_UNIQUE` ON `fdugroup`.`group_users` (`u_mail` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_topic`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_topic` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_topic` (
  `top_id` INT(11) NOT NULL AUTO_INCREMENT,
  `gro_id` INT(11) NOT NULL,
  `u_id` INT(11) NOT NULL,
  `top_title` VARCHAR(45) NOT NULL,
  `top_created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `top_content` LONGTEXT NOT NULL,
  `top_last_comment_time` TIMESTAMP NULL DEFAULT NULL,
  `top_comment_count` INT(11) NOT NULL,
  PRIMARY KEY (`top_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_comment` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_comment` (
  `com_id` INT(11) NOT NULL AUTO_INCREMENT,
  `com_pid` INT(11) NOT NULL,
  `top_id` INT(11) NOT NULL,
  `u_id` INT(11) NOT NULL,
  `com_created_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `com_content` TEXT NOT NULL,
  PRIMARY KEY (`com_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_entity_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_entity_type` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_entity_type` (
  `typ_id` INT(11) NOT NULL AUTO_INCREMENT,
  `typ_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`typ_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `typ_name_UNIQUE` ON `fdugroup`.`group_entity_type` (`typ_name` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_friends` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_friends` (
  `f_id` INT(11) NOT NULL AUTO_INCREMENT,
  `f_uid` INT(11) NOT NULL,
  `f_fid` INT(11) NOT NULL,
  PRIMARY KEY (`f_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 22
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_group_has_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_group_has_group` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_group_has_group` (
  `group_id1` INT(11) NOT NULL,
  `group_id2` INT(11) NOT NULL,
  PRIMARY KEY (`group_id1`, `group_id2`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_group_has_users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_group_has_users` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_group_has_users` (
  `gro_id` INT(11) NOT NULL,
  `u_id` INT(11) NOT NULL,
  `join_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '加入时间',
  `status` INT(11) NOT NULL,
  `join_comment` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`gro_id`, `u_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `fdugroup`.`group_message_type`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_message_type` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_message_type` (
  `msg_type_id` INT(11) NOT NULL AUTO_INCREMENT,
  `msg_type_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`msg_type_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `msg_type_name_UNIQUE` ON `fdugroup`.`group_message_type` (`msg_type_name` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_messages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_messages` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_messages` (
  `msg_id` INT(11) NOT NULL AUTO_INCREMENT,
  `msg_type_id` INT(11) NOT NULL,
  `msg_receiver_id` INT(11) NOT NULL,
  `msg_sender_id` INT(11) NOT NULL COMMENT 'According to message_type\ntype=\'system\', sender_id=0\ntype=\'group\', sender_id=group_id\ntype=\'user\', sender_id = user_id',
  `msg_title` VARCHAR(45) NULL DEFAULT NULL,
  `msg_content` TEXT NOT NULL,
  `msg_status` INT(11) NOT NULL DEFAULT '0' COMMENT '1: not read\n2: read\nothers..',
  `msg_send_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`msg_id`, `msg_type_id`, `msg_receiver_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 43
DEFAULT CHARACTER SET = utf8;

CREATE UNIQUE INDEX `msg_id_UNIQUE` ON `fdugroup`.`group_messages` (`msg_id` ASC);


-- -----------------------------------------------------
-- Table `fdugroup`.`group_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `fdugroup`.`group_tag` ;

CREATE TABLE IF NOT EXISTS `fdugroup`.`group_tag` (
  `tag_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_name` VARCHAR(45) NOT NULL,
  `group_entity_type` INT(11) NOT NULL,
  `entity_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`tag_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 1
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
