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
  `ID` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `password` text(32) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='users';

