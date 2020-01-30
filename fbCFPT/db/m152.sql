-- MySQL Script generated by MySQL Workbench
-- Thu Jan 30 15:12:36 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema m152
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema m152
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `m152` DEFAULT CHARACTER SET utf8 ;
USE `m152` ;

-- -----------------------------------------------------
-- Table `m152`.`post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `m152`.`post` (
  `idPost` INT NOT NULL AUTO_INCREMENT,
  `commentaire` MEDIUMTEXT NOT NULL,
  `creationDate` TIMESTAMP NOT NULL,
  `modificationDate` TIMESTAMP NULL,
  PRIMARY KEY (`idPost`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `m152`.`media`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `m152`.`media` (
  `idMedia` INT NOT NULL AUTO_INCREMENT,
  `typeMedia` VARCHAR(45) NOT NULL,
  `nomMedia` VARCHAR(45) NOT NULL,
  `creationDate` TIMESTAMP NOT NULL,
  `modificationDate` TIMESTAMP NULL,
  `idPost` INT NOT NULL,
  PRIMARY KEY (`idMedia`, `idPost`),
  INDEX `fk_media_post_idx` (`idPost` ASC) VISIBLE,
  CONSTRAINT `fk_media_post`
    FOREIGN KEY (`idPost`)
    REFERENCES `m152`.`post` (`idPost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;