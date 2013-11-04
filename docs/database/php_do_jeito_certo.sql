CREATE SCHEMA IF NOT EXISTS `php_do_jeito_certo` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `php_do_jeito_certo` ;

-- -----------------------------------------------------
-- Table `php_do_jeito_certo`.`sexo`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `php_do_jeito_certo`.`sexo` (
  `sigla` CHAR(1) NOT NULL ,
  `nome` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`sigla`) ,
  UNIQUE INDEX `sigla_UNIQUE` (`sigla` ASC) )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `php_do_jeito_certo`.`agenda`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `php_do_jeito_certo`.`agenda` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(255) NOT NULL ,
  `email` VARCHAR(150) NULL ,
  `telefone` CHAR(14) NOT NULL ,
  `sexo_sigla` CHAR(1) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_agenda_sexo_idx` (`sexo_sigla` ASC) ,
  CONSTRAINT `fk_agenda_sexo`
    FOREIGN KEY (`sexo_sigla` )
    REFERENCES `php_do_jeito_certo`.`sexo` (`sigla` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- INSERT `php_do_jeito_certo`.`sexo`
-- -----------------------------------------------------
INSERT INTO `php_do_jeito_certo`.`sexo` (`sigla`, `nome`) VALUES ('F', 'Feminino');
INSERT INTO `php_do_jeito_certo`.`sexo` (`sigla`, `nome`) VALUES ('M', 'Masculino');