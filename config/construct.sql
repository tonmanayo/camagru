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
  `name` text NOT NULL,
  `surname` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `Verify` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users';
