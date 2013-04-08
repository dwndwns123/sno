SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `field-test` DEFAULT CHARACTER SET latin1 ;
USE `field-test` ;

-- -----------------------------------------------------
-- Table `field-test`.`Countries`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Countries` (
  `country_id` INT(11) NOT NULL ,
  `country_code` VARCHAR(2) NOT NULL ,
  `name` VARCHAR(50) NOT NULL )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`Gender`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Gender` (
  `gender_id` INT(11) NOT NULL ,
  `gender` VARCHAR(10) NOT NULL ,
  UNIQUE INDEX `id` (`gender_id` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`Users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Users` (
  `user_id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(5) NULL DEFAULT NULL ,
  `first_name` VARCHAR(25) NOT NULL ,
  `last_name` VARCHAR(50) NOT NULL ,
  `email` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(50) NOT NULL ,
  `role` VARCHAR(50) NOT NULL ,
  `age` INT(11) NULL DEFAULT NULL ,
  `gender_id` INT(11) NULL DEFAULT NULL ,
  `country_id` INT(11) NOT NULL ,
  `date_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `date_created` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' ,
  PRIMARY KEY (`user_id`) ,
  INDEX `fk_Users_Gender_idx` (`gender_id` ASC) ,
  INDEX `fk_Users_Countries1_idx` (`country_id` ASC) ,
  CONSTRAINT `fk_Users_Gender`
    FOREIGN KEY (`gender_id` )
    REFERENCES `field-test`.`Gender` (`gender_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Users_Countries1`
    FOREIGN KEY (`country_id` )
    REFERENCES `field-test`.`Countries` (`country_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`Encounters`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Encounters` (
  `encounter_id` MEDIUMINT(9) NULL AUTO_INCREMENT ,
  `user_id` INT(11) NOT NULL ,
  INDEX `fk_Encounters_Users1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_Encounters_Users1`
    FOREIGN KEY (`user_id` )
    REFERENCES `field-test`.`Users` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`SCT_Concepts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`SCT_Concepts` (
  `sct_id` INT(11) NOT NULL ,
  `concept_name` VARCHAR(250) NOT NULL ,
  PRIMARY KEY (`sct_id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`Encounter_Reasons`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Encounter_Reasons` (
  `rfe_id` MEDIUMINT(9) NOT NULL AUTO_INCREMENT ,
  `encounter_id` MEDIUMINT NULL ,
  `refset_id` INT(11) NOT NULL COMMENT 'this differentiates between health issues & RFE' ,
  `sct_id` INT(11) NULL DEFAULT NULL ,
  `sct_scale` INT(11) NULL DEFAULT NULL ,
  `sct_alt` VARCHAR(250) NULL DEFAULT NULL ,
  `map_code_id` INT(11) NULL DEFAULT NULL ,
  `map_scale` INT(11) NULL DEFAULT NULL ,
  `map_alt_id` INT(11) NULL DEFAULT NULL ,
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`rfe_id`) ,
  INDEX `fk_Encounter_Reasons_Encounters1_idx` (`encounter_id` ASC) ,
  INDEX `fk_Encounter_Reasons_SCT_Concepts1_idx` (`sct_id` ASC) ,
  CONSTRAINT `fk_Encounter_Reasons_Encounters1`
    FOREIGN KEY (`encounter_id` )
    REFERENCES `field-test`.`Encounters` (`encounter_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Encounter_Reasons_SCT_Concepts1`
    FOREIGN KEY (`sct_id` )
    REFERENCES `field-test`.`SCT_Concepts` (`sct_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `field-test`.`Map_Concepts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `field-test`.`Map_Concepts` (
  `map_id` INT(11) NOT NULL ,
  `map_code` VARCHAR(25) NOT NULL ,
  `label` VARCHAR(250) NOT NULL ,
  `sct_id` MEDIUMINT NULL ,
  PRIMARY KEY (`map_code`) ,
  INDEX `fk_Map_Concepts_Encounter_Reasons1_idx` (`map_id` ASC) ,
  INDEX `fk_Map_Concepts_SCT_Concepts1_idx` (`sct_id` ASC) ,
  CONSTRAINT `fk_Map_Concepts_Encounter_Reasons1`
    FOREIGN KEY (`map_id` )
    REFERENCES `field-test`.`Encounter_Reasons` (`map_code_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Map_Concepts_SCT_Concepts1`
    FOREIGN KEY (`sct_id` )
    REFERENCES `field-test`.`SCT_Concepts` (`sct_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;

USE `field-test` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
