SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `user` (
  `id_user` INT(11) NOT NULL AUTO_INCREMENT ,
  `login` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `email` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `password` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  `name` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  `surname` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  PRIMARY KEY (`id_user`) )
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `blog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `blog` (
  `id_blog` INT(11) NOT NULL AUTO_INCREMENT ,
  `short` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  `long` VARCHAR(150) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  `id_user` INT(11) NOT NULL ,
  PRIMARY KEY (`id_blog`, `id_user`) ,
  INDEX `fk_blog_user` (`id_user` ASC) ,
  CONSTRAINT `fk_blog_user`
    FOREIGN KEY (`id_user` )
    REFERENCES `user` (`id_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `category` (
  `id_category` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `description` VARCHAR(200) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  PRIMARY KEY (`id_category`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `configuration`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `configuration` (
  `id_configuration` INT(11) NOT NULL ,
  `DateFormat` VARCHAR(45) NOT NULL ,
  `TimeZone` VARCHAR(45) NOT NULL ,
  `FilePrev` VARCHAR(45) NOT NULL ,
  `FolderPrev` VARCHAR(45) NOT NULL ,
  `Admin_Email` VARCHAR(45) NOT NULL ,
  `Admin_id` INT(11) NOT NULL ,
  `Lang` VARCHAR(45) NOT NULL ,
  `TimeFormat` VARCHAR(45) NOT NULL ,
  `Template` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id_configuration`, `Admin_id`) ,
  INDEX `fk_configuration_user` (`Admin_id` ASC) ,
  CONSTRAINT `fk_configuration_user`
    FOREIGN KEY (`Admin_id` )
    REFERENCES `user` (`id_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `topic`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `topic` (
  `id_topic` INT(11) NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NULL DEFAULT NULL ,
  `user_id_user` INT(11) NOT NULL ,
  `added_date` VARCHAR(8) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `added_time` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `first_topic` INT(11) NOT NULL ,
  `category_id_category` INT(11) NOT NULL ,
  PRIMARY KEY (`id_topic`, `category_id_category`, `first_topic`) ,
  INDEX `fk_topic_category` (`category_id_category` ASC) ,
  CONSTRAINT `fk_topic_category`
    FOREIGN KEY (`category_id_category` )
    REFERENCES `category` (`id_category` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `post`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `post` (
  `id_post` INT(11) NOT NULL AUTO_INCREMENT ,
  `value` VARCHAR(11500) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `added_date` VARCHAR(8) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `added_time` VARCHAR(8) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `topic_id_topic` INT(11) NOT NULL ,
  `user_id_user` INT(11) NOT NULL ,
  PRIMARY KEY (`id_post`, `topic_id_topic`, `user_id_user`) ,
  INDEX `fk_post_topic` (`topic_id_topic` ASC) ,
  INDEX `fk_post_user` (`user_id_user` ASC) ,
  CONSTRAINT `fk_post_topic`
    FOREIGN KEY (`topic_id_topic` )
    REFERENCES `topic` (`id_topic` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_user`
    FOREIGN KEY (`user_id_user` )
    REFERENCES `user` (`id_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;


-- -----------------------------------------------------
-- Table `shoutbox`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `shoutbox` (
  `id_shoutbox` INT(11) NOT NULL AUTO_INCREMENT ,
  `text` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_polish_ci' NOT NULL ,
  `user_id_user` INT(11) NOT NULL ,
  PRIMARY KEY (`id_shoutbox`, `user_id_user`) ,
  INDEX `fk_shoutbox_user` (`user_id_user` ASC) ,
  CONSTRAINT `fk_shoutbox_user`
    FOREIGN KEY (`user_id_user` )
    REFERENCES `user` (`id_user` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_polish_ci;



--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `login`, `email`, `password`, `name`, `surname`) VALUES
(1, 'admin', 'biuro@onewebpro.pl', '21232f297a57a5a743894a0e4a801fc3', 'Maciej', 'Roma&Aring;'),
(2, 'user', 'maciej.romanski@o2.pl', 'ee11cbb19052e40b07aac0ca060c23ee', 'user', 'user');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
