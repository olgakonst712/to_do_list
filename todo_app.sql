# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: localhost (MySQL 5.6.35)
# Base de données: todo_app
# Temps de génération: 2017-11-17 14:58:12 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `task_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_title` varchar(30) DEFAULT NULL,
  `task_description` text,
  `task_created_on` varchar(30) DEFAULT NULL,
  `task_end` varchar(30) DEFAULT NULL,
  `task_ended_on` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;

INSERT INTO `tasks` (`task_id`, `task_title`, `task_description`, `task_created_on`, `task_end`, `task_ended_on`)
VALUES
	(1,'Laundry','Make the laundry\nYep, that sucks','1510647702','1511132399','1510828998'),
	(2,'Save the Whales','Cause they are dying\nYep, that sucks','1510647826','1511132399',NULL),
	(3,'Drink Coffee','Cause it\'s fucking 9 o\'clock','1510640826','1510647826','1510828987'),
	(6,'Eat','Cause i\'m hungry','1510650600','1510661400','1510744010'),
	(52,'Nice Task Dude','Thanks','1447586421','1510744821','1510858813'),
	(53,'My Test','TEST','1510744848','1510744848',NULL),
	(55,'My todo','descr','1510744800','1510744800','1510837173'),
	(58,'Nouveau','Test','1510745400','1510745400','1510828851'),
	(59,'Ceci est une tache','Ceci n\'est pas une tache','1510659000','1542281400','1510828992'),
	(64,'Fake Title','Fake desc','1234567890','0987654321','1510828975'),
	(67,'Buy cigarettes','Stupid','1510826443','1510999243',NULL),
	(68,'Watch Thor','Maybe','1510916451','1511089251','1510858811'),
	(69,'Maybe watch blablabla','NO IDEA','1510916430','1511002830','1510858800'),
	(70,'Make a Film','About nothing','1510830014','1510916414',NULL),
	(71,'Sleep','Some time','1510851639','1510902039','1510906330'),
	(72,'Say Hi To Daniel','Yeap','1510836336','1510922736','1510923814');

/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
