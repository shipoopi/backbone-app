# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.46)
# Database: unity
# Generation Time: 2012-02-25 15:56:59 +0000
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table product_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `product_user`;

CREATE TABLE `product_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

LOCK TABLES `product_user` WRITE;
/*!40000 ALTER TABLE `product_user` DISABLE KEYS */;
INSERT INTO `product_user` (`id`,`product_id`,`user_id`)
VALUES
	(17,73,90);

/*!40000 ALTER TABLE `product_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`,`name`,`description`,`user_id`)
VALUES
	(75,'Unity','Unity is an agile project management application',1);

/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table releases
# ------------------------------------------------------------

DROP TABLE IF EXISTS `releases`;

CREATE TABLE `releases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(250) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `due_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=latin1;

LOCK TABLES `releases` WRITE;
/*!40000 ALTER TABLE `releases` DISABLE KEYS */;
INSERT INTO `releases` (`id`,`title`,`description`,`start_date`,`end_date`,`product_id`,`due_date`)
VALUES
	(61,'Version 1 Release','First minimal release',NULL,NULL,75,'2012-03-31'),
	(62,'Version 1.1','',NULL,NULL,75,'2012-04-30');

/*!40000 ALTER TABLE `releases` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table sprints
# ------------------------------------------------------------

DROP TABLE IF EXISTS `sprints`;

CREATE TABLE `sprints` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `release_id` int(11) NOT NULL,
  `goal` varchar(100) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=latin1;

LOCK TABLES `sprints` WRITE;
/*!40000 ALTER TABLE `sprints` DISABLE KEYS */;
INSERT INTO `sprints` (`id`,`release_id`,`goal`,`start_date`,`end_date`)
VALUES
	(70,61,'Finish burndown','2012-02-21','2012-02-27'),
	(71,61,'Finish off Acl','2012-02-28','2012-03-05');

/*!40000 ALTER TABLE `sprints` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table story
# ------------------------------------------------------------

DROP TABLE IF EXISTS `story`;

CREATE TABLE `story` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `estimate` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `priority` int(11) NOT NULL DEFAULT '1',
  `release_id` int(11) DEFAULT NULL,
  `sprint_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

LOCK TABLES `story` WRITE;
/*!40000 ALTER TABLE `story` DISABLE KEYS */;
INSERT INTO `story` (`id`,`title`,`description`,`estimate`,`product_id`,`status`,`priority`,`release_id`,`sprint_id`)
VALUES
	(106,'Test the sprint','Test and fix any outstanding issues in the sprint',8,75,'Pending',3,61,70),
	(105,'Add authorization','As a registered user I should only be allowed to create/view/edit/see pages depending on my access level',5,75,'Pending',7,61,71),
	(104,'Split a story into multiple stories','As a registered user I want to split a big story into two and maintain a history',2,75,'Pending',11,62,NULL),
	(103,'Assigning story to a component','As a registered user I want to assign a story to a component',2,75,'Pending',13,62,NULL),
	(101,'Email notifications','As a registered user I would like to receive email notifications whenever a story/task is assigned to me ',3,75,'Pending',10,62,NULL),
	(100,'Search for a user story','As a team member/scrum master I want to search for a user story',1,75,'Pending',9,62,NULL),
	(97,'Assign role to a team member','As a scrum master I want to assign a role to a team member',2,75,'Pending',4,61,71),
	(98,'Registration','As a guest user I want to register to user unity',3,75,'Pending',1,61,70),
	(99,'Change personal info','As a registered user I would like to change my personal details such as First name, Last name , email and other contact details',2,75,'Pending',2,61,70),
	(102,'Add components to a product','As a scrum master I would like to create/view/edit/delete components to a product',2,75,'Pending',12,62,NULL),
	(96,'Assign a task to a user','As a scrum master I want to assign a task to the team member',2,75,'Pending',8,61,71),
	(107,'Attach files to a user story','As a registered user I want to attach files to a user story',3,75,'Pending',14,62,NULL),
	(108,'Add story statuses','Add story statuses',2,75,'Pending',5,61,71),
	(109,'Add task statuses','As a registered user I would like to add task statuses',2,75,'Pending',6,61,71),
	(110,'Integrate code review','As a registered user I would like to use a code review tool with unity',1,75,'Pending',17,NULL,NULL),
	(112,'Test cases','As a registered user I would like to add acceptance criteria or test cases to a user story',3,75,'Pending',16,62,NULL),
	(113,'Adds comments to a user story','As a registered user I want to add comments to a user story',2,75,'Pending',18,NULL,NULL),
	(114,'Marking a story as epic, theme','As a registered user I would like to mark a story as a epic, theme spike or bug',0,75,'Pending',15,62,NULL);

/*!40000 ALTER TABLE `story` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table story_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `story_statuses`;

CREATE TABLE `story_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(25) NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` enum('new','planned','started','done') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

LOCK TABLES `story_statuses` WRITE;
/*!40000 ALTER TABLE `story_statuses` DISABLE KEYS */;
INSERT INTO `story_statuses` (`id`,`value`,`product_id`,`type`)
VALUES
	(1,'New',75,'new'),
	(2,'Planned',75,'new'),
	(3,'Started',75,'new'),
	(4,'Done',75,'new');

/*!40000 ALTER TABLE `story_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table task_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `task_statuses`;

CREATE TABLE `task_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

LOCK TABLES `task_statuses` WRITE;
/*!40000 ALTER TABLE `task_statuses` DISABLE KEYS */;
INSERT INTO `task_statuses` (`id`,`title`,`order`)
VALUES
	(1,'Pending',1),
	(2,'Started',2),
	(3,'Testing',3),
	(4,'Done',4);

/*!40000 ALTER TABLE `task_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(250) DEFAULT NULL,
  `estimate` int(11) DEFAULT NULL,
  `story_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`,`email`,`password`,`first_name`,`last_name`,`telephone`,`address`,`country`,`postcode`)
VALUES
	(1,'hashinp@gmail.com','hashin','Hashin','Panakkaparambil','447939447199','48 Amherst Street','United Kingdom','CF11 7DR'),
	(94,'hash@gmail.com','hash',NULL,NULL,NULL,NULL,NULL,NULL),
	(93,'chucknorris@gmail.com','chuck',NULL,NULL,NULL,NULL,NULL,NULL),
	(92,'chuck@gmail.com','chuck',NULL,NULL,NULL,NULL,NULL,NULL),
	(89,'fdfdfdf','habaputy','fdf','fdf',NULL,NULL,NULL,NULL),
	(88,'fdf','ynube@av','fdf','fdf',NULL,NULL,NULL,NULL),
	(87,'mkkknm','qeqaparu','knn','nkn',NULL,NULL,NULL,NULL),
	(85,'fsdfdsfdf','a$a%u$ap','dsa','fsdfsfs',NULL,NULL,NULL,NULL),
	(86,'m,m','qeqa@ebu','m,m','m,m',NULL,NULL,NULL,NULL),
	(84,'sdffsdfdsf','a@e#u@ez','dsa','fsdfsfs',NULL,NULL,NULL,NULL),
	(82,'qfdf','denyzazy','fd','vsd',NULL,NULL,NULL,NULL),
	(83,'sdf','ge@ybeqa','dsa','fsdfsfs',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
