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
  `usuarioSesion` DATE NULL,
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
VALUES ('admin1@example.com', 'password123');

-- Insertar usuarios
INSERT INTO `dbCashme`.`usuario` (`usuarioNom`, `usuarioApePat`, `usuarioApeMat`, `usuarioTel`, `usuarioEmail`, `usuarioContra`, `usuarioSesion`)
VALUES 
('Juan', 'Pérez', 'Gómez', '1234567890', 'juan.perez@example.com', 'contra123', '2025-01-01'),
('Ana', 'López', 'Martínez', '0987654321', 'ana.lopez@example.com', 'contra123', '2025-01-01'),
('Carlos', 'Hernández', 'Sánchez', '1122334455', 'carlos.hernandez@example.com', 'contra123', '2025-01-01');
('Luis', 'Ramírez', 'Flores', '5678901234', 'luis.ramirez@example.com', 'contra123', '2025-01-01'),
('María', 'García', 'Núñez', '6789012345', 'maria.garcia@example.com', 'contra123', '2025-01-01'),
('Pedro', 'Mendoza', 'Torres', '7890123456', 'pedro.mendoza@example.com', 'contra123', '2025-01-01'),
('Sofía', 'Martínez', 'Rojas', '8901234567', 'sofia.martinez@example.com', 'contra123', '2025-01-01'),
('Diego', 'Jiménez', 'Hernández', '9012345678', 'diego.jimenez@example.com', 'contra123', '2025-01-01'),
('Elena', 'Vargas', 'Castillo', '1234509876', 'elena.vargas@example.com', 'contra123', '2025-01-01'),
('Gabriel', 'Ortega', 'Ruiz', '2345678901', 'gabriel.ortega@example.com', 'contra123', '2025-01-01');


-- Insertar direcciones para los usuarios
INSERT INTO `dbCashme`.`usuarioDir` (`usuarioDireccionEstado`, `usuarioDireccionCP`, `usuarioDireccioncol`, `usuarioDireccionCalle`, `usuario_idUsuario`)
VALUES 
('Estado1', '10000', 'Colonia1', 'Calle1', 1),
('Estado2', '20000', 'Colonia2', 'Calle2', 2),
('Estado3', '30000', 'Colonia3', 'Calle3', 3);
('Estado4', '40000', 'Colonia4', 'Calle4', 4),
('Estado5', '50000', 'Colonia5', 'Calle5', 5),
('Estado6', '60000', 'Colonia6', 'Calle6', 6),
('Estado7', '70000', 'Colonia7', 'Calle7', 7),
('Estado8', '80000', 'Colonia8', 'Calle8', 8),
('Estado9', '90000', 'Colonia9', 'Calle9', 9),
('Estado10', '10001', 'Colonia10', 'Calle10', 10);

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
('Venta', 2500, '2025-01-03', 3),
('Salario', 13000, '2025-01-01', 4),
('Freelance', 5500, '2025-01-02', 4),
('Inversión', 2200, '2025-01-03', 4),
('Salario', 11000, '2025-01-01', 5),
('Venta', 4500, '2025-01-02', 5),
('Inversión', 3200, '2025-01-03', 5),
('Salario', 12500, '2025-01-01', 6),
('Freelance', 5200, '2025-01-02', 6),
('Venta', 2700, '2025-01-03', 6),
('Salario', 13500, '2025-01-01', 7),
('Freelance', 5800, '2025-01-02', 7),
('Inversión', 2300, '2025-01-03', 7),
('Salario', 11500, '2025-01-01', 8),
('Venta', 4700, '2025-01-02', 8),
('Inversión', 3300, '2025-01-03', 8),
('Salario', 14500, '2025-01-01', 9),
('Freelance', 6100, '2025-01-02', 9),
('Venta', 2900, '2025-01-03', 9),
('Salario', 10500, '2025-01-01', 10),
('Freelance', 4900, '2025-01-02', 10),
('Inversión', 3400, '2025-01-03', 10);

-- Insertar datos en Deudas
INSERT INTO `dbCashme`.`Deuda` (`DeudaDesc`, `DeudaMonto`, `DeudaFecha`, `DeudaCobro`, `usuario_idUsuario`)
VALUES 
('Préstamo', 10000, '2025-01-01', 'Banco', 1),
('Hipoteca', 50000, '2025-01-02', 'Mama', 1),
('Tarjeta Crédito', 3000, '2025-01-03', 'Tarjeta de MercadoPago', 1),
('Préstamo', 15000, '2025-01-01', 'Banco', 2),
('Hipoteca', 60000, '2025-01-02', 'Mama', 2),
('Tarjeta Crédito', 4000, '2025-01-03', 'Tarjeta de MercadoPago', 2),
('Préstamo', 20000, '2025-01-01', 'Banco', 3),
('Hipoteca', 70000, '2025-01-02', 'Tarjeta de MercadoPago', 3),
('Tarjeta Crédito', 5000, '2025-01-03', 'Mama', 3),
('Préstamo', 25000, '2025-01-01', 'Banco', 4),
('Hipoteca', 80000, '2025-01-02', 'Mama', 4),
('Tarjeta Crédito', 6000, '2025-01-03', 'Tarjeta de MercadoPago', 4),
('Préstamo', 30000, '2025-01-01', 'Banco', 5),
('Hipoteca', 90000, '2025-01-02', 'Mama', 5),
('Tarjeta Crédito', 7000, '2025-01-03', 'Tarjeta de MercadoPago', 5),
('Préstamo', 35000, '2025-01-01', 'Banco', 6),
('Hipoteca', 100000, '2025-01-02', 'Mama', 6),
('Tarjeta Crédito', 8000, '2025-01-03', 'Tarjeta de MercadoPago', 6),
('Préstamo', 40000, '2025-01-01', 'Banco', 7),
('Hipoteca', 110000, '2025-01-02', 'Mama', 7),
('Tarjeta Crédito', 9000, '2025-01-03', 'Tarjeta de MercadoPago', 7),
('Préstamo', 45000, '2025-01-01', 'Banco', 8),
('Hipoteca', 120000, '2025-01-02', 'Mama', 8),
('Tarjeta Crédito', 10000, '2025-01-03', 'Tarjeta de MercadoPago', 8),
('Préstamo', 50000, '2025-01-01', 'Banco', 9),
('Hipoteca', 130000, '2025-01-02', 'Mama', 9),
('Tarjeta Crédito', 11000, '2025-01-03', 'Tarjeta de MercadoPago', 9),
('Préstamo', 55000, '2025-01-01', 'Banco', 10),
('Hipoteca', 140000, '2025-01-02', 'Mama', 10),
('Tarjeta Crédito', 12000, '2025-01-03', 'Tarjeta de MercadoPago', 10);

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
('Servicio', 1000, '2025-01-03', 'Mensual', 'Pendiente', 3),
('Préstamo', 8000, '2025-01-01', 'Mensual', 'Pendiente', 4),
('Compra', 3500, '2025-01-02', 'Semanal', 'Pagado', 4),
('Servicio', 2000, '2025-01-03', 'Mensual', 'Pendiente', 4),
('Préstamo', 9000, '2025-01-01', 'Mensual', 'Pendiente', 5),
('Compra', 4000, '2025-01-02', 'Semanal', 'Pagado', 5),
('Servicio', 2500, '2025-01-03', 'Mensual', 'Pendiente', 5),
('Préstamo', 10000, '2025-01-01', 'Mensual', 'Pendiente', 6),
('Compra', 4500, '2025-01-02', 'Semanal', 'Pagado', 6),
('Servicio', 3000, '2025-01-03', 'Mensual', 'Pendiente', 6),
('Préstamo', 11000, '2025-01-01', 'Mensual', 'Pendiente', 7),
('Compra', 5000, '2025-01-02', 'Semanal', 'Pagado', 7),
('Servicio', 3500, '2025-01-03', 'Mensual', 'Pendiente', 7),
('Préstamo', 12000, '2025-01-01', 'Mensual', 'Pendiente', 8),
('Compra', 5500, '2025-01-02', 'Semanal', 'Pagado', 8),
('Servicio', 4000, '2025-01-03', 'Mensual', 'Pendiente', 8),
('Préstamo', 13000, '2025-01-01', 'Mensual', 'Pendiente', 9),
('Compra', 6000, '2025-01-02', 'Semanal', 'Pagado', 9),
('Servicio', 4500, '2025-01-03', 'Mensual', 'Pendiente', 9),
('Préstamo', 14000, '2025-01-01', 'Mensual', 'Pendiente', 10),
('Compra', 6500, '2025-01-02', 'Semanal', 'Pagado', 10),
('Servicio', 5000, '2025-01-03', 'Mensual', 'Pendiente', 10);

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
('Acciones', 19000, '2025-01-03', 8.0, 20520, 3),
('CETES', 11000, '2025-01-01', 4.0, 11440, 4),
('Bonos', 16000, '2025-01-02', 3.5, 16560, 4),
('Acciones', 21000, '2025-01-03', 8.0, 22680, 4),
('CETES', 13000, '2025-01-01', 4.0, 13520, 5),
('Bonos', 18000, '2025-01-02', 3.5, 18630, 5),
('Acciones', 22000, '2025-01-03', 8.0, 23760, 5),
('CETES', 14000, '2025-01-01', 4.0, 14560, 6),
('Bonos', 19000, '2025-01-02', 3.5, 19665, 6),
('Acciones', 23000, '2025-01-03', 8.0, 24840, 6),
('CETES', 15000, '2025-01-01', 4.0, 15600, 7),
('Bonos', 20000, '2025-01-02', 3.5, 20700, 7),
('Acciones', 24000, '2025-01-03', 8.0, 25920, 7),
('CETES', 16000, '2025-01-01', 4.0, 16640, 8),
('Bonos', 21000, '2025-01-02', 3.5, 21735, 8),
('Acciones', 25000, '2025-01-03', 8.0, 27000, 8),
('CETES', 17000, '2025-01-01', 4.0, 17760, 9),
('Bonos', 22000, '2025-01-02', 3.5, 22770, 9),
('Acciones', 26000, '2025-01-03', 8.0, 28080, 9),
('CETES', 18000, '2025-01-01', 4.0, 18720, 10),
('Bonos', 23000, '2025-01-02', 3.5, 23805, 10),
('Acciones', 27000, '2025-01-03', 8.0, 29160, 10);

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
('Educación', 4000, '2025-01-03', 'Inversión', 3),
('Viaje', 16000, '2025-01-01', 'Personal', 4),
('Ropa', 3500, '2025-01-02', 'Gasto', 4),
('Educación', 4500, '2025-01-03', 'Inversión', 4),
('Viaje', 18000, '2025-01-01', 'Personal', 5),
('Ropa', 4000, '2025-01-02', 'Gasto', 5),
('Educación', 5000, '2025-01-03', 'Inversión', 5),
('Viaje', 20000, '2025-01-01', 'Personal', 6),
('Ropa', 4500, '2025-01-02', 'Gasto', 6),
('Educación', 5500, '2025-01-03', 'Inversión', 6),
('Viaje', 22000, '2025-01-01', 'Personal', 7),
('Ropa', 5000, '2025-01-02', 'Gasto', 7),
('Educación', 6000, '2025-01-03', 'Inversión', 7),
('Viaje', 24000, '2025-01-01', 'Personal', 8),
('Ropa', 5500, '2025-01-02', 'Gasto', 8),
('Educación', 6500, '2025-01-03', 'Inversión', 8),
('Viaje', 26000, '2025-01-01', 'Personal', 9),
('Ropa', 6000, '2025-01-02', 'Gasto', 9),
('Educación', 7000, '2025-01-03', 'Inversión', 9),
('Viaje', 28000, '2025-01-01', 'Personal', 10),
('Ropa', 6500, '2025-01-02', 'Gasto', 10),
('Educación', 7500, '2025-01-03', 'Inversión', 10);

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;