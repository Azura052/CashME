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
  `idUsuario` INT NOT NULL,
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
  `idusuarioDir` INT NOT NULL,
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
  `idAdmin` INT NOT NULL,
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

-- Inserción de datos en la tabla `usuario`
INSERT INTO `dbCashme`.`usuario` (`idUsuario`, `usuarioNom`, `usuarioApePat`, `usuarioApeMat`, `usuarioTel`, `usuarioEmail`, `usuarioContra`, `ingresoSaldo`, `ahorroSaldo`, `deudaSaldo`) VALUES
(1, 'Juan', 'Perez', 'Gomez', '5551234567', 'juan.perez@example.com', 'password123', 10000, 5000, 2000),
(2, 'Maria', 'Lopez', 'Martinez', '5559876543', 'maria.lopez@example.com', 'password456', 8000, 3000, 1000),
(3, 'Carlos', 'Hernandez', 'Diaz', '5551122334', 'carlos.hernandez@example.com', 'password789', 15000, 7000, 5000),
(4, 'Ana', 'Garcia', 'Ruiz', '5555566778', 'ana.garcia@example.com', 'password101', 12000, 4000, 3000),
(5, 'Luis', 'Martinez', 'Vega', '5554455667', 'luis.martinez@example.com', 'password202', 9000, 2500, 1500);

-- Inserción de datos en la tabla `usuarioDir`
INSERT INTO `dbCashme`.`usuarioDir` (`idusuarioDir`, `usuarioDireccionEstado`, `usuarioDireccionCP`, `usuarioDireccioncol`, `usuarioDireccionCalle`, `usuario_idUsuario`) VALUES
(1, 'Ciudad de Mexico', '01000', 'Centro', 'Calle 1', 1),
(2, 'Estado de Mexico', '02000', 'Norte', 'Calle 2', 2),
(3, 'Puebla', '03000', 'Este', 'Calle 3', 3),
(4, 'Jalisco', '04000', 'Oeste', 'Calle 4', 4),
(5, 'Nuevo Leon', '05000', 'Sur', 'Calle 5', 5);

-- Inserción de datos en la tabla `Admin`
INSERT INTO `dbCashme`.`Admin` (`idAdmin`, `AdminUser`, `AdminContra`) VALUES
(1, 'admin', 'adminpass');

-- Inserción de datos en la tabla `Ingreso`
INSERT INTO `dbCashme`.`Ingreso` (`idIngreso`, `IngresoDesc`, `IngresoMonto`, `IngresoFecha`, `usuario_idUsuario`) VALUES
(1, 'Salario', 10000, '2024-12-01', 1),
(2, 'Freelance', 5000, '2024-12-02', 2),
(3, 'Bonificación', 7000, '2024-12-03', 3),
(4, 'Venta', 2000, '2024-12-04', 4),
(5, 'Intereses', 3000, '2024-12-05', 5);

-- Inserción de datos en la tabla `Ahorro`
INSERT INTO `dbCashme`.`Ahorro` (`idAhorro`, `AhorroDesc`, `AhorroMonto`, `AhorroFecha`, `usuario_idUsuario`) VALUES
(1, 'Meta de viaje', 2000, '2024-12-01', 1),
(2, 'Emergencias', 3000, '2024-12-02', 2),
(3, 'Fondo retiro', 5000, '2024-12-03', 3),
(4, 'Educación', 4000, '2024-12-04', 4),
(5, 'Inversiones', 2500, '2024-12-05', 5);

-- Inserción de datos en la tabla `Gasto`
INSERT INTO `dbCashme`.`Gasto` (`idGasto`, `GastoDesc`, `GastoMonto`, `GastoFecha`, `GastoCobro`, `usuario_idUsuario`) VALUES
(1, 'Renta', 5000, '2024-12-01', 'Tarjeta', 1),
(2, 'Supermercado', 2000, '2024-12-02', 'Efectivo', 2),
(3, 'Transporte', 1500, '2024-12-03', 'Tarjeta', 3),
(4, 'Ropa', 3000, '2024-12-04', 'Tarjeta', 4),
(5, 'Servicios', 2500, '2024-12-05', 'Efectivo', 5);

-- Inserción de datos en la tabla `Deuda`
INSERT INTO `dbCashme`.`Deuda` (`idDeuda`, `DeudaDesc`, `DeudaMonto`, `DeudaFecha`, `usuario_idUsuario`) VALUES
(1, 'Crédito hipotecario', 2000, '2024-12-01', 1),
(2, 'Crédito automotriz', 1000, '2024-12-02', 2),
(3, 'Tarjeta crédito', 5000, '2024-12-03', 3),
(4, 'Préstamo personal', 3000, '2024-12-04', 4),
(5, 'Educativo', 1500, '2024-12-05', 5);
