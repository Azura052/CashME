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
  `gastoSaldo` FLOAT NULL,
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
  `idIngreso` INT NOT NULL AUTO_INCREMENT,
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
  `idAhorro` INT NOT NULL AUTO_INCREMENT,
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
  `idGasto` INT NOT NULL AUTO_INCREMENT,
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
  `idDeuda` INT NOT NULL AUTO_INCREMENT,
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

-- Meter Datos para pruebas

-- Insertar administrador
INSERT INTO `dbCashme`.`Admin` (`AdminUser`, `AdminContra`)
VALUES ('adminUser', 'adminPass123');

-- Insertar usuarios
INSERT INTO `dbCashme`.`usuario` 
(`usuarioNom`, `usuarioApePat`, `usuarioApeMat`, `usuarioTel`, `usuarioEmail`, `usuarioContra`, `ingresoSaldo`, `ahorroSaldo`, `deudaSaldo`,`gastoSaldo`) 
VALUES
('Juan', 'Perez', 'Lopez', '1234567890', 'juan.perez@gmail.com', 'password123', 1000.50, 300.75, 200.25, 0),
('Ana', 'Garcia', 'Martinez', '0987654321', 'ana.garcia@gmail.com', 'password456', 1500.75, 500.50, 350.00, 0),
('Luis', 'Hernandez', 'Rodriguez', '1122334455', 'luis.hernandez@gmail.com', 'password789', 2000.00, 800.00, 500.75, 0);

-- Insertar ingresos para los usuarios
INSERT INTO `dbCashme`.`Ingreso` (`idIngreso`, `IngresoDesc`, `IngresoMonto`, `IngresoFecha`, `usuario_idUsuario`) 
VALUES
(1, 'Salario', 1000.00, '2025-01-01', 1),
(2, 'Freelance', 500.00, '2025-01-02', 1),
(3, 'Venta', 300.00, '2025-01-03', 1),
(4, 'Salario', 1500.00, '2025-01-01', 2),
(5, 'Freelance', 800.00, '2025-01-02', 2),
(6, 'Venta', 500.00, '2025-01-03', 2),
(7, 'Salario', 2000.00, '2025-01-01', 3),
(8, 'Freelance', 1000.00, '2025-01-02', 3),
(9, 'Venta', 750.00, '2025-01-03', 3);

-- Insertar ahorros para los usuarios
INSERT INTO `dbCashme`.`Ahorro` (`idAhorro`, `AhorroDesc`, `AhorroMonto`, `AhorroFecha`, `usuario_idUsuario`) 
VALUES
(1, 'Meta1', 100.00, '2025-01-01', 1),
(2, 'Meta2', 150.00, '2025-01-02', 1),
(3, 'Meta3', 50.75, '2025-01-03', 1),
(4, 'Meta1', 200.00, '2025-01-01', 2),
(5, 'Meta2', 150.00, '2025-01-02', 2),
(6, 'Meta3', 150.50, '2025-01-03', 2),
(7, 'Meta1', 300.00, '2025-01-01', 3),
(8, 'Meta2', 250.00, '2025-01-02', 3),
(9, 'Meta3', 250.00, '2025-01-03', 3);

-- Insertar deudas para los usuarios
INSERT INTO `dbCashme`.`Deuda` (`idDeuda`, `DeudaDesc`, `DeudaMonto`, `DeudaFecha`, `usuario_idUsuario`) 
VALUES
(1, 'Tarjeta', 50.00, '2025-01-01', 1),
(2, 'Préstamo', 100.00, '2025-01-02', 1),
(3, 'Hipoteca', 50.25, '2025-01-03', 1),
(4, 'Tarjeta', 150.00, '2025-01-01', 2),
(5, 'Préstamo', 100.00, '2025-01-02', 2),
(6, 'Hipoteca', 100.00, '2025-01-03', 2),
(7, 'Tarjeta', 200.00, '2025-01-01', 3),
(8, 'Préstamo', 150.00, '2025-01-02', 3),
(9, 'Hipoteca', 150.75, '2025-01-03', 3);

-- Insertar gastos para los usuarios
INSERT INTO `dbCashme`.`Gasto` (`idGasto`, `GastoDesc`, `GastoMonto`, `GastoFecha`, `GastoCobro`, `usuario_idUsuario`) 
VALUES
(1, 'Comida', 30.00, '2025-01-01', 'Efectivo', 1),
(2, 'Transporte', 20.00, '2025-01-02', 'Tarjeta', 1),
(3, 'Ropa', 50.00, '2025-01-03', 'Efectivo', 1),
(4, 'Comida', 50.00, '2025-01-01', 'Efectivo', 2),
(5, 'Transporte', 40.00, '2025-01-02', 'Tarjeta', 2),
(6, 'Ropa', 60.00, '2025-01-03', 'Efectivo', 2),
(7, 'Comida', 70.00, '2025-01-01', 'Efectivo', 3),
(8, 'Transporte', 50.00, '2025-01-02', 'Tarjeta', 3),
(9, 'Ropa', 80.00, '2025-01-03', 'Efectivo', 3);



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
