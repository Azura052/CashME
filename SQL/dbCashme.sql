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
-- Table `dbCashme`.`Deuda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Deuda` (
  `idDeuda` INT NOT NULL AUTO_INCREMENT,
  `DeudaDesc` VARCHAR(45) NULL,
  `DeudaMonto` FLOAT NULL,
  `DeudaFecha` DATE NULL,
  `DeudaCobro` VARCHAR(45) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idDeuda`),
  INDEX `fk_Deuda_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Deuda_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Adeudo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Adeudo` (
  `idAdeudo` INT NOT NULL AUTO_INCREMENT,
  `AdeudoDesc` VARCHAR(45) NULL,
  `AdeudoMonto` FLOAT NULL,
  `AdeudoFecha` DATE NULL,
  `AdeudoCobro` VARCHAR(45) NULL,
  `AdeudoEstado` VARCHAR(45) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idAdeudo`),
  INDEX `fk_Adeudo_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Adeudo_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Inversion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Inversion` (
  `idInversion` INT NOT NULL AUTO_INCREMENT,
  `InversionDesc` VARCHAR(45) NULL,
  `InversionMonto` FLOAT NULL,
  `InversionFecha` DATE NULL,
  `InversionPor` FLOAT NULL,
  `InversionRen` FLOAT NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idInversion`),
  INDEX `fk_Inversion_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Inversion_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dbCashme`.`Presupuesto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbCashme`.`Presupuesto` (
  `idPresupuesto` INT NOT NULL AUTO_INCREMENT,
  `PresupuestoDesc` VARCHAR(45) NULL,
  `PresupuestoMonto` FLOAT NULL,
  `PresupuestoFecha` DATE NULL,
  `PresupuestoTipo` VARCHAR(45) NULL,
  `usuario_idUsuario` INT NOT NULL,
  PRIMARY KEY (`idPresupuesto`),
  INDEX `fk_Presupuesto_usuario1_idx` (`usuario_idUsuario` ASC) VISIBLE,
  CONSTRAINT `fk_Presupuesto_usuario1`
    FOREIGN KEY (`usuario_idUsuario`)
    REFERENCES `dbCashme`.`usuario` (`idUsuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Ingresar Datos de prueba en la base de datos

-- Insertar un administrador
INSERT INTO `dbCashme`.`Admin` (`AdminUser`, `AdminContra`)
VALUES ('Admin1', 'password123');

-- Insertar usuarios
INSERT INTO `dbCashme`.`usuario` (`usuarioNom`, `usuarioApePat`, `usuarioApeMat`, `usuarioTel`, `usuarioEmail`, `usuarioContra`)
VALUES 
('Juan', 'Pérez', 'Gómez', '1234567890', 'juan.perez@example.com', 'contra123'),
('Ana', 'López', 'Martínez', '0987654321', 'ana.lopez@example.com', 'contra123'),
('Carlos', 'Hernández', 'Sánchez', '1122334455', 'carlos.hernandez@example.com', 'contra123');

-- Insertar direcciones para los usuarios
INSERT INTO `dbCashme`.`usuarioDir` (`usuarioDireccionEstado`, `usuarioDireccionCP`, `usuarioDireccioncol`, `usuarioDireccionCalle`, `usuario_idUsuario`)
VALUES 
('Estado1', '10000', 'Colonia1', 'Calle1', 1),
('Estado2', '20000', 'Colonia2', 'Calle2', 2),
('Estado3', '30000', 'Colonia3', 'Calle3', 3);

-- Insertar datos en Ingresos
INSERT INTO `dbCashme`.`Ingreso` (`IngresoDesc`, `IngresoMonto`, `IngresoFecha`, `usuario_idUsuario`)
VALUES 
('Salario', 15000, '2025-01-01', 1),
('Freelance', 5000, '2025-01-02', 1),
('Inversión', 2000, '2025-01-03', 1),
('Salario', 12000, '2025-01-01', 2),
('Venta', 4000, '2025-01-02', 2),
('Inversión', 3000, '2025-01-03', 2),
('Salario', 14000, '2025-01-01', 3),
('Freelance', 6000, '2025-01-02', 3),
('Venta', 2500, '2025-01-03', 3);

-- Insertar datos en Deudas
INSERT INTO `dbCashme`.`Deuda` (`DeudaDesc`, `DeudaMonto`, `DeudaFecha`, `DeudaCobro`, `usuario_idUsuario`)
VALUES 
('Préstamo', 10000, '2025-01-01', 'Mensual', 1),
('Hipoteca', 50000, '2025-01-02', 'Anual', 1),
('Tarjeta Crédito', 3000, '2025-01-03', 'Mensual', 1),
('Préstamo', 15000, '2025-01-01', 'Mensual', 2),
('Hipoteca', 60000, '2025-01-02', 'Anual', 2),
('Tarjeta Crédito', 4000, '2025-01-03', 'Mensual', 2),
('Préstamo', 20000, '2025-01-01', 'Mensual', 3),
('Hipoteca', 70000, '2025-01-02', 'Anual', 3),
('Tarjeta Crédito', 5000, '2025-01-03', 'Mensual', 3);

-- Insertar datos en Adeudos
INSERT INTO `dbCashme`.`Adeudo` (`AdeudoDesc`, `AdeudoMonto`, `AdeudoFecha`, `AdeudoCobro`, `AdeudoEstado`, `usuario_idUsuario`)
VALUES 
('Préstamo', 5000, '2025-01-01', 'Mensual', 'Pendiente', 1),
('Compra', 2000, '2025-01-02', 'Semanal', 'Pagado', 1),
('Servicio', 1500, '2025-01-03', 'Mensual', 'Pendiente', 1),
('Préstamo', 6000, '2025-01-01', 'Mensual', 'Pendiente', 2),
('Compra', 2500, '2025-01-02', 'Semanal', 'Pagado', 2),
('Servicio', 1200, '2025-01-03', 'Mensual', 'Pendiente', 2),
('Préstamo', 7000, '2025-01-01', 'Mensual', 'Pendiente', 3),
('Compra', 3000, '2025-01-02', 'Semanal', 'Pagado', 3),
('Servicio', 1000, '2025-01-03', 'Mensual', 'Pendiente', 3);

-- Insertar datos en Inversiones
INSERT INTO `dbCashme`.`Inversion` (`InversionDesc`, `InversionMonto`, `InversionFecha`, `InversionPor`, `InversionRen`, `usuario_idUsuario`)
VALUES 
('CETES', 10000, '2025-01-01', 4.0, 10400, 1),
('Bonos', 15000, '2025-01-02', 3.5, 15525, 1),
('Acciones', 20000, '2025-01-03', 8.0, 21600, 1),
('CETES', 12000, '2025-01-01', 4.0, 12480, 2),
('Bonos', 14000, '2025-01-02', 3.5, 14490, 2),
('Acciones', 18000, '2025-01-03', 8.0, 19440, 2),
('CETES', 15000, '2025-01-01', 4.0, 15600, 3),
('Bonos', 17000, '2025-01-02', 3.5, 17595, 3),
('Acciones', 19000, '2025-01-03', 8.0, 20520, 3);

-- Insertar datos en Presupuestos
INSERT INTO `dbCashme`.`Presupuesto` (`PresupuestoDesc`, `PresupuestoMonto`, `PresupuestoFecha`, `PresupuestoTipo`, `usuario_idUsuario`)
VALUES 
('Viaje', 10000, '2025-01-01', 'Personal', 1),
('Ropa', 2000, '2025-01-02', 'Gasto', 1),
('Educación', 3000, '2025-01-03', 'Inversión', 1),
('Viaje', 12000, '2025-01-01', 'Personal', 2),
('Ropa', 2500, '2025-01-02', 'Gasto', 2),
('Educación', 3500, '2025-01-03', 'Inversión', 2),
('Viaje', 14000, '2025-01-01', 'Personal', 3),
('Ropa', 3000, '2025-01-02', 'Gasto', 3),
('Educación', 4000, '2025-01-03', 'Inversión', 3);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;