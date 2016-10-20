-- -----------------------------------------------------
-- Schema/database camagru
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `camagru` ;
CREATE SCHEMA IF NOT EXISTS `camagru` DEFAULT CHARACTER SET utf8 ;
USE `camagru` ;
-- -----------------------------------------------------
-- Table `camagru`.`users`
-- -----------------------------------------------------
CREATE TABLE `users` (
  `Name` text NOT NULL,
  `Surname` text NOT NULL,
  `Password` text NOT NULL,
  `Email` text NOT NULL,
  `Verify` tinyint(1) NOT NULL,
  PRIMARY KEY (`email`(128)))
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users';


CREATE TABLE `Pictures` (
  `Picture` LONGBLOB NOT NULL,
  `Comment` TEXT NOT NULL,
  `Like` TEXT NOT NULL,
  `Email` TEXT NOT NULL,
  PRIMARY KEY (`email`(128)))
  ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pictures';