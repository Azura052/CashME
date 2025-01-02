-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema dbCashme
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema dbCashme
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbCashme` DEFAULT CHARACTER SET utf8 ;
USE `dbCashme` ;

-- -----------------------------------------------------
-- Table `dbCashme`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `usuarioNom` VARCHAR(45) NULL,
  `usuarioApePat` VARCHAR(30) NULL,
  `usuarioApeMat` VARCHAR(30) NULL,
  `usuarioTel` VARCHAR(45) NULL,
  `usuarioEmail` VARCHAR(45) NULL,
  `usuarioContra` VARCHAR(45) NULL,
  `ingresoSaldo` FLOAT NULL,
  `ahorroSaldo` FLOAT NULL,
  `deudaSaldo` FLOAT NULL,
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`usuarioDir`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`usuarioDir` (
  `idusuarioDir` INT NOT NULL AUTO_INCREMENT,
  `usuarioDireccionEstado` VARCHAR(45) NULL,
  `usuarioDireccionCP` VARCHAR(45) NULL,
  `usuarioDireccioncol` VARCHAR(45) NULL,
  `usuarioDireccionCalle` VARCHAR(45) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idusuarioDir`),
  INDEX `fk_usuarioDir_usuario_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_usuarioDir_usuario`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Admin`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Admin` (
  `idAdmin` INT NOT NULL AUTO_INCREMENT,
  `AdminUser` VARCHAR(45) NULL,
  `AdminContra` VARCHAR(45) NULL,
  PRIMARY KEY (`idAdmin`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Ingreso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Ingreso` (
  `idIngreso` INT NOT NULL,
  `IngresoDesc` VARCHAR(45) NULL,
  `IngresoMonto` FLOAT NULL,
  `IngresoFecha` DATE NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idIngreso`),
  INDEX `fk_Ingreso_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Ingreso_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Ahorro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Ahorro` (
  `idAhorro` INT NOT NULL,
  `AhorroDesc` VARCHAR(45) NULL,
  `AhorroMonto` FLOAT NULL,
  `AhorroFecha` DATE NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idAhorro`),
  INDEX `fk_Ahorro_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Ahorro_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Gasto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Gasto` (
  `idGasto` INT NOT NULL,
  `GastoDesc` VARCHAR(45) NULL,
  `GastoMonto` FLOAT NULL,
  `GastoFecha` DATE NULL,
  `GastoCobro` VARCHAR(20) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idGasto`),
  INDEX `fk_Gasto_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Gasto_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Deuda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Deuda` (
  `idDeuda` INT NOT NULL,
  `DeudaDesc` VARCHAR(45) NULL,
  `DeudaMonto` FLOAT NULL,
  `DeudaFecha` DATE NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idDeuda`),
  INDEX `fk_Deuda_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Deuda_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
