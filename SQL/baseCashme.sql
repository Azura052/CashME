-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema bdCashme
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bdCashme
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bdCashme` DEFAULT CHARACTER SET utf8 ;
USE `bdCashme` ;

-- -----------------------------------------------------
-- Table `bdCashme`.`usuarioDir`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bdCashme`.`usuarioDir` (
  `idusuarioDir` INT NOT NULL,
  `usuarioDireccionEstado` VARCHAR(45) NULL,
  `usuarioDireccionCP` VARCHAR(45) NULL,
  `usuarioDireccioncol` VARCHAR(45) NULL,
  `usuarioDireccionCalle` VARCHAR(45) NULL,
  PRIMARY KEY (`idusuarioDir`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bdCashme`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bdCashme`.`usuario` (
  `idUsuario` INT NOT NULL,
  `usuarioNom` VARCHAR(45) NULL,
  `usuarioApePat` VARCHAR(30) NULL,
  `usuarioApeMat` VARCHAR(30) NULL,
  `usuarioTel` VARCHAR(45) NULL,
  `usuarioEmail` VARCHAR(45) NULL,
  `usuarioContra` VARCHAR(45) NULL,
  `usuarioDir_idusuarioDir` INT NOT NULL,
  PRIMARY KEY (`idUsuario`),
  INDEX `fk_Usuario_usuarioDireccion_idx` (`usuarioDir_idusuarioDir` ASC) VISIBLE,
  CONSTRAINT `fk_Usuario_usuarioDireccion`
    FOREIGN KEY (`usuarioDir_idusuarioDir`)
    REFERENCES `bdCashme`.`usuarioDir` (`idusuarioDir`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bdCashme`.`usuarioMov`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bdCashme`.`usuarioMov` (
  `idUsuarioMov` INT NOT NULL,
  `usuarioMovimiento` VARCHAR(45) NULL,
  `usuarioMovMonto` INT NULL,
  `usuarioMovDesc` VARCHAR(60) NULL,
  `usuarioMovFecha` VARCHAR(45) NULL,
  `usuarioMovFechaSal` VARCHAR(45) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idUsuarioMov`),
  INDEX `fk_usuarioMov_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_usuarioMov_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `bdCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bdCashme`.`Admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bdCashme`.`Admin` (
  `idAdmin` INT NOT NULL,
  `AdminUser` VARCHAR(45) NULL,
  `AdminContra` VARCHAR(45) NULL,
  PRIMARY KEY (`idAdmin`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
