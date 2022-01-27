-- MySQL dump 10.13  Distrib 8.0.26, for Linux (x86_64)
--
-- Host: localhost    Database: research
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `academic_rank`
--

DROP TABLE IF EXISTS `academic_rank`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `academic_rank` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `academic_rank`
--

LOCK TABLES `academic_rank` WRITE;
/*!40000 ALTER TABLE `academic_rank` DISABLE KEYS */;
INSERT INTO `academic_rank` VALUES (1,'Proffessor',NULL),(2,'Associate Professor',NULL),(3,'Assistanct Professor',NULL),(4,'Lecturer',NULL),(5,'Graduate Assistant',NULL),(6,'Lab assistatnt',NULL),(7,'Other',NULL);
/*!40000 ALTER TABLE `academic_rank` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `announcement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `posted_by_id` int DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `poseted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4DB9D91C5A6D2235` (`posted_by_id`),
  CONSTRAINT `FK_4DB9D91C5A6D2235` FOREIGN KEY (`posted_by_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcement`
--

LOCK TABLES `announcement` WRITE;
/*!40000 ALTER TABLE `announcement` DISABLE KEYS */;
/*!40000 ALTER TABLE `announcement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attachement_type`
--

DROP TABLE IF EXISTS `attachement_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attachement_type` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_3CC5B1D4E1FD4933` (`submission_id`),
  CONSTRAINT `FK_3CC5B1D4E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachement_type`
--

LOCK TABLES `attachement_type` WRITE;
/*!40000 ALTER TABLE `attachement_type` DISABLE KEYS */;
INSERT INTO `attachement_type` VALUES (2,NULL,'Concept note','Concept note'),(3,NULL,'Proposal','Proposal'),(4,NULL,'References','References in different format like .bib , .ris .endnote'),(5,NULL,'Images','Images');
/*!40000 ALTER TABLE `attachement_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_history`
--

DROP TABLE IF EXISTS `backup_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `backup_date` datetime DEFAULT NULL,
  `successful` tinyint(1) DEFAULT NULL,
  `res_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_history`
--

LOCK TABLES `backup_history` WRITE;
/*!40000 ALTER TABLE `backup_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `backup_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_setting`
--

DROP TABLE IF EXISTS `backup_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `backup_setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `site_id` int DEFAULT NULL,
  `emailto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailfrom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_subject` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `db_password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `destination_dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logfile_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mysql_host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `source_dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_machine_ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emailto_cc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_app_dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remote_db_dir` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_user` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gmail_pass` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` longtext COLLATE utf8mb4_unicode_ci,
  `signature` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `backup_days` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_2D899599F6BD1646` (`site_id`),
  CONSTRAINT `FK_2D899599F6BD1646` FOREIGN KEY (`site_id`) REFERENCES `site_setting` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_setting`
--

LOCK TABLES `backup_setting` WRITE;
/*!40000 ALTER TABLE `backup_setting` DISABLE KEYS */;
INSERT INTO `backup_setting` VALUES (1,NULL,'firew.legese@ju.edu.et','1','1','name','name','name','name','name','name','name','name','name','name',NULL,'name',NULL,NULL,NULL);
/*!40000 ALTER TABLE `backup_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget`
--

DROP TABLE IF EXISTS `budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `budget` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget`
--

LOCK TABLES `budget` WRITE;
/*!40000 ALTER TABLE `budget` DISABLE KEYS */;
/*!40000 ALTER TABLE `budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budget_request`
--

DROP TABLE IF EXISTS `budget_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `budget_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_F914C57EE1FD4933` (`submission_id`),
  CONSTRAINT `FK_F914C57EE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budget_request`
--

LOCK TABLES `budget_request` WRITE;
/*!40000 ALTER TABLE `budget_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `budget_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_for_proposal`
--

DROP TABLE IF EXISTS `call_for_proposal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `call_for_proposal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `college_id` int DEFAULT NULL,
  `thematic_area_id` int DEFAULT NULL,
  `approved_by_id` int DEFAULT NULL,
  `guidelines` longtext COLLATE utf8mb4_unicode_ci,
  `deadline` datetime DEFAULT NULL,
  `subject` longtext COLLATE utf8mb4_unicode_ci,
  `post_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `research_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `heading` longtext COLLATE utf8mb4_unicode_ci,
  `uidentifier` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_co_pi` int DEFAULT NULL,
  `allow_non_academic_staff_as_pi` tinyint(1) DEFAULT NULL,
  `allow_researcher_from_another_college` tinyint(1) DEFAULT NULL,
  `allow_pi_from_other_university` tinyint(1) DEFAULT NULL,
  `funding_source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commitment_from_other_research` tinyint(1) DEFAULT NULL,
  `review_process_start` date DEFAULT NULL,
  `review_process_end` date DEFAULT NULL,
  `reviewers_decision_will_be_communicated_at` date DEFAULT NULL,
  `project_starts_on` date DEFAULT NULL,
  `views` int DEFAULT NULL,
  `approved` tinyint(1) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `is_call_from_center` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7073CA69328F8B8E` (`thematic_area_id`),
  KEY `IDX_7073CA692D234F6A` (`approved_by_id`),
  KEY `IDX_7073CA69770124B2` (`college_id`),
  CONSTRAINT `FK_7073CA692D234F6A` FOREIGN KEY (`approved_by_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_7073CA69328F8B8E` FOREIGN KEY (`thematic_area_id`) REFERENCES `thematic_area` (`id`),
  CONSTRAINT `FK_7073CA69770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_for_proposal`
--

LOCK TABLES `call_for_proposal` WRITE;
/*!40000 ALTER TABLE `call_for_proposal` DISABLE KEYS */;
INSERT INTO `call_for_proposal` VALUES (8,11,NULL,7,'<h2><span style=\"font-family:Times New Roman,Times,serif\">Cautionary Notes: Proposals should be: </span></h2>\r\n\r\n<ul>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">No longer than 20 pages including cover page and reference </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Conceived by multidisciplinary teams </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Project proposals that involve Ph.D. and Masters students are highly encouraged </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Reasonable budget </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Feasibility of the project in terms of timeframe</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">One person can serve as a PI only in 1 project, </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Only and the PI should be able to defend the project her/himself</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Declaration/signature of every team member must be attached to the Concept Note up on submission.</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">If the proposal accepted for grant funding, </span></span></p>\r\n\r\n	<ol style=\"list-style-type:lower-alpha\">\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">The PI is required to sign a binding agreement with the office of research and academic chief directorate. </span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">CVs of all members should be submitted using a special format prepared by the office for this purpose (<strong>available in our office</strong>).</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Data collection and data processing agreement should be signed between the PI and Data collectors/Lab technologists/ Data clerk etc. </span></span></p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ul>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:18px\">Important Eligibility Requirements:</span><br />\r\n<span style=\"font-size:12pt\">Failure to meet the following criteria will result in automatic rejection of the Concept Notes.</span></span></p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">If the entire research team or anyone of the team members has been granted:</span></span></p>\r\n\r\n	<ol style=\"list-style-type:lower-alpha\">\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2009, 2010 &amp; 2011 EC as a <strong>PI</strong>, an evidence of at least one publication from the research project must be shown.</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2012 EC, as a <strong>PI, </strong>an evidence of at least one publication/or accepted Manuscript from the mega research must be shown.</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2013 EC and completed the project, a full terminal report must be presented by the <strong>PI</strong>. </span></span></p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ol>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:18px\">Outline of the proposals</span><br />\r\n<span style=\"font-size:14px\">&nbsp;&nbsp;&nbsp; 1) Title of the proposed Project<br />\r\n&nbsp;&nbsp;&nbsp; 2) Background and Rationale<br />\r\n&nbsp;&nbsp;&nbsp; 3) Project Goals and Objectives<br />\r\n&nbsp;&nbsp;&nbsp; 4) Methodology<br />\r\n&nbsp;&nbsp;&nbsp; 5) Research Project team<br />\r\n&nbsp;&nbsp;&nbsp; 6) Capacity building (inclusion of PhD and/or MSc students)<br />\r\n&nbsp;&nbsp;&nbsp; 7) Research output/outcome<br />\r\n&nbsp;&nbsp;&nbsp; 8) Ethical considerations<br />\r\n&nbsp;&nbsp;&nbsp; 9) Timeline (feasibility in one year)<br />\r\n&nbsp;&nbsp;&nbsp; 10) Budget (outline just major line items and gross budget, detailed breakdown is not required at this stage)</span></span></p>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:14pt\"><strong>Submission</strong></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-family:Times New Roman,Times,serif\">Proposals</span><span style=\"font-family:Times New Roman,Times,serif\"> </span><span style=\"font-family:Times New Roman,Times,serif\">must</span><span style=\"font-family:Times New Roman,Times,serif\"> be submitted in soft copy (Word file) via </span><span style=\"font-family:Times New Roman,Times,serif\"><strong>only JU mail</strong></span><span style=\"font-family:Times New Roman,Times,serif\"> of the Applicant (</span><span style=\"font-family:Times New Roman,Times,serif\"><strong>PI</strong></span><span style=\"font-family:Times New Roman,Times,serif\">) and three hard copies to </span><span style=\"font-family:Times New Roman,Times,serif\">our office within the given time. </span></span></p>','2021-11-15 00:00:00','<p>We would like to invite interested academic staff to submit proposals on competitive mega<br />\r\nresearch project for the year 2021/22 (2014 E.C.).</p>','2021-11-11 16:24:42',NULL,'Mega research','<p>Call for Mega Research Project Proposals<br />\r\nJimma University Institute of Health (JUIH)</p>','4aaa770ad2964593e7688af098e8cc97',NULL,0,NULL,0,'Jimma University',0,'2021-11-16','2021-12-15','2021-12-17','2021-12-20',6,0,'2021-11-11 16:25:45',0),(9,11,17,4,'<h2><span style=\"font-size:18px\"><span style=\"font-family:Times New Roman,Times,serif\">Cautionary Notes: Proposals should be: </span></span></h2>\r\n\r\n<ul>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">No longer than 20 pages including cover page and reference </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Conceived by multidisciplinary teams </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Project proposals that involve Ph.D. and Masters students are highly encouraged </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Reasonable budget </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Feasibility of the project in terms of timeframe</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">One person can serve as a PI only in 1 project, </span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Only and the PI should be able to defend the project her/himself</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Declaration/signature of every team member must be attached to the Concept Note up on submission.</span></span></p>\r\n	</li>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">If the proposal accepted for grant funding, </span></span></p>\r\n\r\n	<ol style=\"list-style-type:lower-alpha\">\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">The PI is required to sign a binding agreement with the office of research and academic chief directorate. </span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">CVs of all members should be submitted using a special format prepared by the office for this purpose (<strong>available in our office</strong>).</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Data collection and data processing agreement should be signed between the PI and Data collectors/Lab technologists/ Data clerk etc. </span></span></p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ul>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:18px\">Important Eligibility Requirements:</span><br />\r\n<span style=\"font-size:12pt\">Failure to meet the following criteria will result in automatic rejection of the Concept Notes.</span></span></p>\r\n\r\n<ol>\r\n	<li>\r\n	<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">If the entire research team or anyone of the team members has been granted:</span></span></p>\r\n\r\n	<ol style=\"list-style-type:lower-alpha\">\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2009, 2010 &amp; 2011 EC as a <strong>PI</strong>, an evidence of at least one publication from the research project must be shown.</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2012 EC, as a <strong>PI, </strong>an evidence of at least one publication/or accepted Manuscript from the mega research must be shown.</span></span></p>\r\n		</li>\r\n		<li>\r\n		<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:12pt\">Mega research award in 2013 EC and completed the project, a full terminal report must be presented by the <strong>PI</strong>. </span></span></p>\r\n		</li>\r\n	</ol>\r\n	</li>\r\n</ol>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:18px\">Outline of the proposals</span><br />\r\n<span style=\"font-size:14px\">&nbsp;&nbsp;&nbsp; 1) Title of the proposed Project<br />\r\n&nbsp;&nbsp;&nbsp; 2) Background and Rationale<br />\r\n&nbsp;&nbsp;&nbsp; 3) Project Goals and Objectives<br />\r\n&nbsp;&nbsp;&nbsp; 4) Methodology<br />\r\n&nbsp;&nbsp;&nbsp; 5) Research Project team<br />\r\n&nbsp;&nbsp;&nbsp; 6) Capacity building (inclusion of PhD and/or MSc students)<br />\r\n&nbsp;&nbsp;&nbsp; 7) Research output/outcome<br />\r\n&nbsp;&nbsp;&nbsp; 8) Ethical considerations<br />\r\n&nbsp;&nbsp;&nbsp; 9) Timeline (feasibility in one year)<br />\r\n&nbsp;&nbsp;&nbsp; 10) Budget (outline just major line items and gross budget, detailed breakdown is not required at this stage)</span></span></p>\r\n\r\n<p><span style=\"font-family:Times New Roman,Times,serif\"><span style=\"font-size:14pt\"><strong>Submission</strong></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-family:Times New Roman,Times,serif\">Proposals</span><span style=\"font-family:Times New Roman,Times,serif\"> </span><span style=\"font-family:Times New Roman,Times,serif\">must</span><span style=\"font-family:Times New Roman,Times,serif\"> be submitted in soft copy (Word file) via </span><span style=\"font-family:Times New Roman,Times,serif\"><strong>only JU mail</strong></span><span style=\"font-family:Times New Roman,Times,serif\"> of the Applicant (</span><span style=\"font-family:Times New Roman,Times,serif\"><strong>PI</strong></span><span style=\"font-family:Times New Roman,Times,serif\">) and three hard copies to </span><span style=\"font-family:Times New Roman,Times,serif\">our office within the given time. </span></span></p>','2021-11-15 00:00:00','<p>Call for Mega Research Project Proposals<br />\r\nJimma University Institute of Health (JUIH)</p>','2021-11-11 16:26:48',NULL,'Mega research','<p>We would like to invite interested academic staff to submit proposals on competitive mega<br />\r\nresearch project for the year 2021/22 (2014 E.C.).</p>','869414e967f659dfad3ab76bd6571074',NULL,0,NULL,0,'Jimma University',NULL,'2021-11-16','2021-12-15','2021-12-17','2021-12-20',32,1,'2021-11-11 16:27:36',0);
/*!40000 ALTER TABLE `call_for_proposal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `co_author`
--

DROP TABLE IF EXISTS `co_author`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `co_author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `country_id` int DEFAULT NULL,
  `title_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cv` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `position` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `orcid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department_id` int NOT NULL,
  `confirmed` tinyint(1) DEFAULT NULL,
  `role_id` int NOT NULL,
  `midle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_53DCFBEDE1FD4933` (`submission_id`),
  KEY `IDX_53DCFBEDF92F3E70` (`country_id`),
  KEY `IDX_53DCFBEDA9F87BD` (`title_id`),
  KEY `IDX_53DCFBEDAE80F5DF` (`department_id`),
  KEY `IDX_53DCFBEDD60322AC` (`role_id`),
  CONSTRAINT `FK_53DCFBEDA9F87BD` FOREIGN KEY (`title_id`) REFERENCES `title` (`id`),
  CONSTRAINT `FK_53DCFBEDAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  CONSTRAINT `FK_53DCFBEDD60322AC` FOREIGN KEY (`role_id`) REFERENCES `member_role` (`id`),
  CONSTRAINT `FK_53DCFBEDE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`),
  CONSTRAINT `FK_53DCFBEDF92F3E70` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `co_author`
--

LOCK TABLES `co_author` WRITE;
/*!40000 ALTER TABLE `co_author` DISABLE KEYS */;
INSERT INTO `co_author` VALUES (20,15,NULL,2,'ayele',NULL,NULL,'ayelegirma@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,2,NULL),(21,16,NULL,3,'ayele',NULL,NULL,'ayelegirma@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,2,NULL),(22,17,NULL,2,'FREW1',NULL,NULL,'firew.legese@ju.edu.et',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,2,NULL),(23,18,NULL,2,'lsdjflsdjflj',NULL,NULL,'lsjdflsdjf@sflsjglj.com',NULL,NULL,NULL,NULL,NULL,NULL,2,NULL,1,NULL);
/*!40000 ALTER TABLE `co_author` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `collaborating_institution`
--

DROP TABLE IF EXISTS `collaborating_institution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collaborating_institution` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amountgranted` int DEFAULT NULL,
  `attachment_of_grant_award` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5138D47DE1FD4933` (`submission_id`),
  CONSTRAINT `FK_5138D47DE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborating_institution`
--

LOCK TABLES `collaborating_institution` WRITE;
/*!40000 ALTER TABLE `collaborating_institution` DISABLE KEYS */;
/*!40000 ALTER TABLE `collaborating_institution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `college`
--

DROP TABLE IF EXISTS `college`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `college` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guideline_id` int DEFAULT NULL,
  `principal_contact` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` longtext COLLATE utf8mb4_unicode_ci,
  `objective` longtext COLLATE utf8mb4_unicode_ci,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_AADA8702CC0B46A8` (`guideline_id`),
  CONSTRAINT `FK_AADA8702CC0B46A8` FOREIGN KEY (`guideline_id`) REFERENCES `guidelines` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `college`
--

LOCK TABLES `college` WRITE;
/*!40000 ALTER TABLE `college` DISABLE KEYS */;
INSERT INTO `college` VALUES (11,'Jimma University Institute of Health (JUIH)',NULL,'<p>1. Dr. Henok Gulilat (Research &amp;amp; Innovation Director, JUIH)<br />\r\nE-mail: henok.gulilat@ju.edu.et<br />\r\n2. Dr. Ahmed Zeynudin (Chief Academic &amp;amp; Research Director, JUIH)<br />\r\nE-mail: ahmed.zeynudin@ju.edu.et</p>','JIH',NULL,NULL,'JIH','<p>Jimma University Institute of Health (JUIH)</p>');
/*!40000 ALTER TABLE `college` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `college_coordinator`
--

DROP TABLE IF EXISTS `college_coordinator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `college_coordinator` (
  `id` int NOT NULL AUTO_INCREMENT,
  `college_id` int NOT NULL,
  `coordinator_id` int NOT NULL,
  `assigned_by_id` int NOT NULL,
  `status` int NOT NULL,
  `assigned_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C01B15E5770124B2` (`college_id`),
  KEY `IDX_C01B15E5E7877946` (`coordinator_id`),
  KEY `IDX_C01B15E56E6F1246` (`assigned_by_id`),
  CONSTRAINT `FK_C01B15E56E6F1246` FOREIGN KEY (`assigned_by_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_C01B15E5770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`),
  CONSTRAINT `FK_C01B15E5E7877946` FOREIGN KEY (`coordinator_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `college_coordinator`
--

LOCK TABLES `college_coordinator` WRITE;
/*!40000 ALTER TABLE `college_coordinator` DISABLE KEYS */;
INSERT INTO `college_coordinator` VALUES (3,11,7,4,1,'2021-11-09 18:07:27'),(4,11,7,4,1,'2021-11-10 15:55:52'),(5,11,7,4,1,'2021-11-11 18:52:15');
/*!40000 ALTER TABLE `college_coordinator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_us` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_us`
--

LOCK TABLES `contact_us` WRITE;
/*!40000 ALTER TABLE `contact_us` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_us` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_source`
--

DROP TABLE IF EXISTS `data_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_source` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `obtaioned_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '(DC2Type:dateinterval)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_source`
--

LOCK TABLES `data_source` WRITE;
/*!40000 ALTER TABLE `data_source` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `id` int NOT NULL AUTO_INCREMENT,
  `college_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CD1DE18A770124B2` (`college_id`),
  CONSTRAINT `FK_CD1DE18A770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (2,11,'Medwifery');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directorate_office`
--

DROP TABLE IF EXISTS `directorate_office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directorate_office` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `contact_address` longtext COLLATE utf8mb4_unicode_ci,
  `objective` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directorate_office`
--

LOCK TABLES `directorate_office` WRITE;
/*!40000 ALTER TABLE `directorate_office` DISABLE KEYS */;
INSERT INTO `directorate_office` VALUES (2,'TT director','<p>TT director</p>','<p>TT director</p>','<p>TT director</p>','<p>TT director</p>');
/*!40000 ALTER TABLE `directorate_office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directorate_office_user`
--

DROP TABLE IF EXISTS `directorate_office_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `directorate_office_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `directorate_office_id` int NOT NULL,
  `directorate_id` int NOT NULL,
  `assigned_at` datetime NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E89B57B75AA43067` (`directorate_office_id`),
  KEY `IDX_E89B57B79BFF530E` (`directorate_id`),
  CONSTRAINT `FK_E89B57B75AA43067` FOREIGN KEY (`directorate_office_id`) REFERENCES `directorate_office` (`id`),
  CONSTRAINT `FK_E89B57B79BFF530E` FOREIGN KEY (`directorate_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directorate_office_user`
--

LOCK TABLES `directorate_office_user` WRITE;
/*!40000 ALTER TABLE `directorate_office_user` DISABLE KEYS */;
INSERT INTO `directorate_office_user` VALUES (1,2,7,'2021-11-10 15:55:58',1),(2,2,7,'2021-11-11 18:52:24',1);
/*!40000 ALTER TABLE `directorate_office_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editorial_decision`
--

DROP TABLE IF EXISTS `editorial_decision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `editorial_decision` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `edited_by_id` int DEFAULT NULL,
  `decision` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revised_at` datetime DEFAULT NULL,
  `feedback` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_AF23CCA4E1FD4933` (`submission_id`),
  KEY `IDX_AF23CCA4DD7B2EBC` (`edited_by_id`),
  CONSTRAINT `FK_AF23CCA4DD7B2EBC` FOREIGN KEY (`edited_by_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_AF23CCA4E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editorial_decision`
--

LOCK TABLES `editorial_decision` WRITE;
/*!40000 ALTER TABLE `editorial_decision` DISABLE KEYS */;
/*!40000 ALTER TABLE `editorial_decision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `educational_level`
--

DROP TABLE IF EXISTS `educational_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `educational_level` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `educational_level`
--

LOCK TABLES `educational_level` WRITE;
/*!40000 ALTER TABLE `educational_level` DISABLE KEYS */;
INSERT INTO `educational_level` VALUES (1,'Phd','Phd'),(2,'MSc',NULL),(3,'BSc',NULL),(4,'Diploma',NULL),(5,'Certification',NULL);
/*!40000 ALTER TABLE `educational_level` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_message`
--

DROP TABLE IF EXISTS `email_message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `email_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_message`
--

LOCK TABLES `email_message` WRITE;
/*!40000 ALTER TABLE `email_message` DISABLE KEYS */;
INSERT INTO `email_message` VALUES (2,'CALL_FOR_PROPOSAL_ANNOUNCEMENT','New call has been announced!','New call for concept note'),(3,'CO_PI_MEMBERSHIP_NOTIFICATION','<p>Recently you have been added as a member of research. Please take alook and confrim us if it is right using the following link.</p>','CO-PI research membership confirmation'),(4,'INVOLVEMENT_ACCEPTED_SUCCESS','<p>CO-PI research membership confirmation</p>','CO-PI research membership confirmation');
/*!40000 ALTER TABLE `email_message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_form`
--

DROP TABLE IF EXISTS `evaluation_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_form` (
  `id` int NOT NULL AUTO_INCREMENT,
  `parent_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `percent` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1FCEB2F7727ACA70` (`parent_id`),
  CONSTRAINT `FK_1FCEB2F7727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `evaluation_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_form`
--

LOCK TABLES `evaluation_form` WRITE;
/*!40000 ALTER TABLE `evaluation_form` DISABLE KEYS */;
INSERT INTO `evaluation_form` VALUES (1,NULL,'Genuinity',10),(3,1,'Relevance and degree of research priority in relation to JU list of research priority and themes that demonstrates responsiveness to national and regional needs',16),(4,1,'Moderately appropriate',15),(5,NULL,'Scientific quality and contents of the project',24);
/*!40000 ALTER TABLE `evaluation_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evaluation_form_option`
--

DROP TABLE IF EXISTS `evaluation_form_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evaluation_form_option` (
  `id` int NOT NULL AUTO_INCREMENT,
  `evaluation_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` int NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B314069456C5646` (`evaluation_id`),
  CONSTRAINT `FK_B314069456C5646` FOREIGN KEY (`evaluation_id`) REFERENCES `evaluation_form` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evaluation_form_option`
--

LOCK TABLES `evaluation_form_option` WRITE;
/*!40000 ALTER TABLE `evaluation_form_option` DISABLE KEYS */;
INSERT INTO `evaluation_form_option` VALUES (2,1,'New one',2,'15'),(3,1,'Relevance and degree of research priority in relation to JU list of research priority and themes that demonstrates responsiveness to national and regional needs',4,'15');
/*!40000 ALTER TABLE `evaluation_form_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `expense` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` int DEFAULT NULL,
  `approvedexpense` int DEFAULT NULL,
  `requestedexpense` int DEFAULT NULL,
  `measurement` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `unit_cost` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_2D3A8DA6E1FD4933` (`submission_id`),
  CONSTRAINT `FK_2D3A8DA6E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expense`
--

LOCK TABLES `expense` WRITE;
/*!40000 ALTER TABLE `expense` DISABLE KEYS */;
/*!40000 ALTER TABLE `expense` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `funding_instition`
--

DROP TABLE IF EXISTS `funding_instition`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `funding_instition` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `nameoforganization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fund_allocated` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `memorad_of_trust` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_FC4CFAB6E1FD4933` (`submission_id`),
  CONSTRAINT `FK_FC4CFAB6E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funding_instition`
--

LOCK TABLES `funding_instition` WRITE;
/*!40000 ALTER TABLE `funding_instition` DISABLE KEYS */;
/*!40000 ALTER TABLE `funding_instition` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group`
--

DROP TABLE IF EXISTS `group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group`
--

LOCK TABLES `group` WRITE;
/*!40000 ALTER TABLE `group` DISABLE KEYS */;
/*!40000 ALTER TABLE `group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guideline_for_reviewer`
--

DROP TABLE IF EXISTS `guideline_for_reviewer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guideline_for_reviewer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `workunit_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `the_guidelline` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `college_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_29DD8A19AA7751AC` (`workunit_id`),
  KEY `IDX_29DD8A19770124B2` (`college_id`),
  CONSTRAINT `FK_29DD8A19770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`),
  CONSTRAINT `FK_29DD8A19AA7751AC` FOREIGN KEY (`workunit_id`) REFERENCES `work_unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guideline_for_reviewer`
--

LOCK TABLES `guideline_for_reviewer` WRITE;
/*!40000 ALTER TABLE `guideline_for_reviewer` DISABLE KEYS */;
INSERT INTO `guideline_for_reviewer` VALUES (1,NULL,'New Guideline For reviewers','New Guideline For reviewers','2021-11-08 13:54:59',11);
/*!40000 ALTER TABLE `guideline_for_reviewer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guidelines`
--

DROP TABLE IF EXISTS `guidelines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guidelines` (
  `id` int NOT NULL AUTO_INCREMENT,
  `college_id` int DEFAULT NULL,
  `guideline` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_BC2C7E1770124B2` (`college_id`),
  CONSTRAINT `FK_BC2C7E1770124B2` FOREIGN KEY (`college_id`) REFERENCES `guidelines` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guidelines`
--

LOCK TABLES `guidelines` WRITE;
/*!40000 ALTER TABLE `guidelines` DISABLE KEYS */;
/*!40000 ALTER TABLE `guidelines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutional_reviewers_board`
--

DROP TABLE IF EXISTS `institutional_reviewers_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `institutional_reviewers_board` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviewer_id` int DEFAULT NULL,
  `workunit_id` int DEFAULT NULL,
  `name_id` int DEFAULT NULL,
  `specialization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CC363EBD70574616` (`reviewer_id`),
  KEY `IDX_CC363EBDAA7751AC` (`workunit_id`),
  KEY `IDX_CC363EBD71179CD6` (`name_id`),
  KEY `IDX_CC363EBD770124B2` (`college_id`),
  CONSTRAINT `FK_CC363EBD70574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_CC363EBD71179CD6` FOREIGN KEY (`name_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_CC363EBD770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`),
  CONSTRAINT `FK_CC363EBDAA7751AC` FOREIGN KEY (`workunit_id`) REFERENCES `work_unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutional_reviewers_board`
--

LOCK TABLES `institutional_reviewers_board` WRITE;
/*!40000 ALTER TABLE `institutional_reviewers_board` DISABLE KEYS */;
/*!40000 ALTER TABLE `institutional_reviewers_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keyword`
--

DROP TABLE IF EXISTS `keyword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `keyword` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5A93713B5E237E06` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keyword`
--

LOCK TABLES `keyword` WRITE;
/*!40000 ALTER TABLE `keyword` DISABLE KEYS */;
/*!40000 ALTER TABLE `keyword` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lexik_trans_unit`
--

DROP TABLE IF EXISTS `lexik_trans_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lexik_trans_unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `domain` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_domain_idx` (`key_name`,`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lexik_trans_unit`
--

LOCK TABLES `lexik_trans_unit` WRITE;
/*!40000 ALTER TABLE `lexik_trans_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `lexik_trans_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lexik_trans_unit_translations`
--

DROP TABLE IF EXISTS `lexik_trans_unit_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lexik_trans_unit_translations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `file_id` int DEFAULT NULL,
  `trans_unit_id` int DEFAULT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `modified_manually` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `trans_unit_locale_idx` (`trans_unit_id`,`locale`),
  KEY `IDX_B0AA394493CB796C` (`file_id`),
  KEY `IDX_B0AA3944C3C583C9` (`trans_unit_id`),
  CONSTRAINT `FK_B0AA394493CB796C` FOREIGN KEY (`file_id`) REFERENCES `lexik_translation_file` (`id`),
  CONSTRAINT `FK_B0AA3944C3C583C9` FOREIGN KEY (`trans_unit_id`) REFERENCES `lexik_trans_unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lexik_trans_unit_translations`
--

LOCK TABLES `lexik_trans_unit_translations` WRITE;
/*!40000 ALTER TABLE `lexik_trans_unit_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `lexik_trans_unit_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lexik_translation_file`
--

DROP TABLE IF EXISTS `lexik_translation_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lexik_translation_file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `domain` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extention` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hash` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hash_idx` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lexik_translation_file`
--

LOCK TABLES `lexik_translation_file` WRITE;
/*!40000 ALTER TABLE `lexik_translation_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `lexik_translation_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `member_role`
--

DROP TABLE IF EXISTS `member_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `member_role` (
  `id` int NOT NULL AUTO_INCREMENT,
  `rolename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_role`
--

LOCK TABLES `member_role` WRITE;
/*!40000 ALTER TABLE `member_role` DISABLE KEYS */;
INSERT INTO `member_role` VALUES (1,'PI',NULL),(2,'CO-PI',NULL);
/*!40000 ALTER TABLE `member_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` VALUES (1,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:17:\\\"miniyee@gmail.com\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-09-04 16:32:28','2021-09-04 16:32:28',NULL),(2,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:22:\\\"firew.legese@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-09-07 18:50:37','2021-09-07 18:50:37',NULL),(3,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-09-07 19:13:22','2021-09-07 19:13:22',NULL),(4,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:15:\\\"decho@ju.ede.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-09-07 19:13:22','2021-09-07 19:13:22',NULL),(5,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-06 16:52:30','2021-11-06 16:52:30',NULL),(6,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:23:\\\"firewlegese74@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-06 16:52:31','2021-11-06 16:52:31',NULL),(7,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:23:\\\"firewlegese74@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 11:05:06','2021-11-08 11:05:06',NULL),(8,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:2:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";i:1;s:23:\\\"firewlegese12@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 11:05:07','2021-11-08 11:05:07',NULL),(9,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:23:\\\"firewlegese12@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 12:04:44','2021-11-08 12:04:44',NULL),(10,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:2:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";i:1;s:23:\\\"firewlegese74@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 12:04:44','2021-11-08 12:04:44',NULL),(11,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 18:04:29','2021-11-08 18:04:29',NULL),(12,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:2:{i:0;s:23:\\\"firewlegese74@gmail.com\\\";i:1;s:23:\\\"firewlegese12@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-08 18:04:29','2021-11-08 18:04:29',NULL),(13,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:23:\\\"henok.gulilat@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-09 18:07:27','2021-11-09 18:07:27',NULL),(14,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:23:\\\"henok.gulilat@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-10 15:55:53','2021-11-10 15:55:53',NULL),(15,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:23:\\\"henok.gulilat@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-10 15:55:58','2021-11-10 15:55:58',NULL),(16,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"henoksheba@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-10 17:58:11','2021-11-10 17:58:11',NULL),(17,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"ayelegirma@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-10 17:58:11','2021-11-10 17:58:11',NULL),(18,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"henoksheba@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:22:50','2021-11-11 18:22:50',NULL),(19,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"ayelegirma@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:22:50','2021-11-11 18:22:50',NULL),(20,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"henoksheba@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:49:10','2021-11-11 18:49:10',NULL),(21,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:20:\\\"ayelegirma@gmail.com\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:49:10','2021-11-11 18:49:10',NULL),(22,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:23:\\\"henok.gulilat@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:52:16','2021-11-11 18:52:16',NULL),(23,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";s:23:\\\"henok.gulilat@ju.edu.et\\\";s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-11 18:52:24','2021-11-11 18:52:24',NULL),(24,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:22:\\\"hailu.chemir@ju.edu.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-12 09:56:03','2021-11-12 09:56:03',NULL),(25,'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:28:\\\"App\\\\Message\\\\SendEmailMessage\\\":5:{s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0subject\\\";N;s:32:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0to\\\";a:1:{i:0;s:22:\\\"firew.legese@ju.edu.et\\\";}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0template\\\";s:32:\\\"emails/application_ack.html.twig\\\";s:37:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0content\\\";a:0:{}s:38:\\\"\\0App\\\\Message\\\\SendEmailMessage\\0emailKey\\\";s:18:\\\"SUBMISSION_SUCCESS\\\";}}','[]','default','2021-11-12 09:56:03','2021-11-12 09:56:03',NULL);
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `code` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (3,'Permission add','perm_act','perm_act'),(4,'usrgrp_act add','usrgrp_act','usrgrp_act');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_group`
--

DROP TABLE IF EXISTS `permission_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_group` (
  `permission_id` int NOT NULL,
  `group_id` int NOT NULL,
  PRIMARY KEY (`permission_id`,`group_id`),
  KEY `IDX_BB4729B6FED90CCA` (`permission_id`),
  KEY `IDX_BB4729B6FE54D947` (`group_id`),
  CONSTRAINT `FK_BB4729B6FE54D947` FOREIGN KEY (`group_id`) REFERENCES `group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_BB4729B6FED90CCA` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_group`
--

LOCK TABLES `permission_group` WRITE;
/*!40000 ALTER TABLE `permission_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_user_group`
--

DROP TABLE IF EXISTS `permission_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permission_user_group` (
  `permission_id` int NOT NULL,
  `user_group_id` int NOT NULL,
  PRIMARY KEY (`permission_id`,`user_group_id`),
  KEY `IDX_CB2465C0FED90CCA` (`permission_id`),
  KEY `IDX_CB2465C01ED93D47` (`user_group_id`),
  CONSTRAINT `FK_CB2465C01ED93D47` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_CB2465C0FED90CCA` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_user_group`
--

LOCK TABLES `permission_user_group` WRITE;
/*!40000 ALTER TABLE `permission_user_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `permission_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proposal`
--

DROP TABLE IF EXISTS `proposal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proposal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `abstract` longtext COLLATE utf8mb4_unicode_ci,
  `date_sent` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFE59472F675F31B` (`author_id`),
  CONSTRAINT `FK_BFE59472F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proposal`
--

LOCK TABLES `proposal` WRITE;
/*!40000 ALTER TABLE `proposal` DISABLE KEYS */;
/*!40000 ALTER TABLE `proposal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `published_research`
--

DROP TABLE IF EXISTS `published_research`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `published_research` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title_id` int NOT NULL,
  `irb_clearance` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allotted_budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` datetime DEFAULT NULL,
  `final_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci,
  `successfully_completed` tinyint(1) DEFAULT NULL,
  `submission_id` int DEFAULT NULL,
  `user_info_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EA05D8B0E1FD4933` (`submission_id`),
  KEY `IDX_EA05D8B0586DFF2` (`user_info_id`),
  KEY `IDX_EA05D8B0A9F87BD` (`title_id`),
  CONSTRAINT `FK_EA05D8B0586DFF2` FOREIGN KEY (`user_info_id`) REFERENCES `user_info` (`id`),
  CONSTRAINT `FK_EA05D8B0A9F87BD` FOREIGN KEY (`title_id`) REFERENCES `published_topic` (`id`),
  CONSTRAINT `FK_EA05D8B0E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `published_research`
--

LOCK TABLES `published_research` WRITE;
/*!40000 ALTER TABLE `published_research` DISABLE KEYS */;
INSERT INTO `published_research` VALUES (5,76,NULL,'2000000','2021-06-21 00:00:00',NULL,NULL,1,NULL,15),(6,77,NULL,'1572220','2021-11-29 00:00:00',NULL,NULL,1,NULL,15);
/*!40000 ALTER TABLE `published_research` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `published_submission`
--

DROP TABLE IF EXISTS `published_submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `published_submission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `attachement_type_id` int DEFAULT NULL,
  `published_date` datetime DEFAULT NULL,
  `final_report` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` tinyint(1) DEFAULT NULL,
  `feedback_from_director` longtext COLLATE utf8mb4_unicode_ci,
  `is_approved_publication` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_256FF77BE1FD4933` (`submission_id`),
  KEY `IDX_256FF77BFA11F126` (`attachement_type_id`),
  CONSTRAINT `FK_256FF77BE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`),
  CONSTRAINT `FK_256FF77BFA11F126` FOREIGN KEY (`attachement_type_id`) REFERENCES `attachement_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `published_submission`
--

LOCK TABLES `published_submission` WRITE;
/*!40000 ALTER TABLE `published_submission` DISABLE KEYS */;
INSERT INTO `published_submission` VALUES (3,6,NULL,NULL,NULL,1,NULL,NULL);
/*!40000 ALTER TABLE `published_submission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `published_submission_attachment`
--

DROP TABLE IF EXISTS `published_submission_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `published_submission_attachment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attachment_type_id` int DEFAULT NULL,
  `data_source_id` int DEFAULT NULL,
  `published_submission_id` int DEFAULT NULL,
  `attachment_file` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(1500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT NULL,
  `dataset_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sample_size` int DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codebook` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `study_region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7CB49D3DD9D915` (`attachment_type_id`),
  KEY `IDX_7CB49D31A935C57` (`data_source_id`),
  KEY `IDX_7CB49D3B8154917` (`published_submission_id`),
  CONSTRAINT `FK_7CB49D31A935C57` FOREIGN KEY (`data_source_id`) REFERENCES `data_source` (`id`),
  CONSTRAINT `FK_7CB49D3B8154917` FOREIGN KEY (`published_submission_id`) REFERENCES `published_submission` (`id`),
  CONSTRAINT `FK_7CB49D3DD9D915` FOREIGN KEY (`attachment_type_id`) REFERENCES `attachement_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `published_submission_attachment`
--

LOCK TABLES `published_submission_attachment` WRITE;
/*!40000 ALTER TABLE `published_submission_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `published_submission_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `published_topic`
--

DROP TABLE IF EXISTS `published_topic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `published_topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `published_topic`
--

LOCK TABLES `published_topic` WRITE;
/*!40000 ALTER TABLE `published_topic` DISABLE KEYS */;
INSERT INTO `published_topic` VALUES (1,'ghgjhgjh',NULL,NULL,NULL),(3,'I want to validate the phone nummer in a form. I would like to check so number and the \"(\" and \")\" char are valid only. So user can fill in +31(0)600000000. The +31 is already preset in the form. The number only is possible with the code below, only how to add the two chars? ','I want to validate the phone nummer in a form. I would like to check so number and the \"(\" and \")\" char are valid only. So user can fill in +31(0)600000000. The +31 is already preset in the form. The number only is possible with the code below, only how to add the two chars? ',NULL,NULL),(4,' Not the answer you\'re looking for? Browse other questions tagged javascript or ask your own question. ',' Not the answer you\'re looking for? Browse other questions tagged javascript or ask your own question. ',NULL,NULL),(5,'ghgjhgjh',NULL,NULL,NULL),(6,'Evaluation of Adolescent Reproductive and Sexual Health Services of Health Extention Program in Rural Kebeles of JimmaZones,\n','Evaluation of Adolescent Reproductive and Sexual Health Services of Health Extention Program in Rural Kebeles of JimmaZones,\n',NULL,NULL),(7,'Epidemiology of food-borne pathogens among food handlers from hotels and restaurants in Jimma town, Ethiopia','Epidemiology of food-borne pathogens among food handlers from hotels and restaurants in Jimma town, Ethiopia',NULL,NULL),(8,'Sero-epdemiological study of TORCH infectious among pregnant women in Jimma Zone, southwest Ethiopia','Sero-epdemiological study of TORCH infectious among pregnant women in Jimma Zone, southwest Ethiopia',NULL,NULL),(9,'Molecular Epidemiology of High Risk Human Papilloma virus and abnormal cervical cytology among women in Jimma Town','Molecular Epidemiology of High Risk Human Papilloma virus and abnormal cervical cytology among women in Jimma Town',NULL,NULL),(10,'The status of Monitoring and Evaluation in the Ethiopian Health Sector at the beginning of “information Revolution”','The status of Monitoring and Evaluation in the Ethiopian Health Sector at the beginning of “information Revolution”',NULL,NULL),(11,'Social Supports during perinatal period and the utilization of maternity waiting home: Efforts to tackle maternal and child morbidity and mortality during pregnancy and beyond in Jimma Zone, Southwest Ethiopia.','Social Supports during perinatal period and the utilization of maternity waiting home: Efforts to tackle maternal and child morbidity and mortality during pregnancy and beyond in Jimma Zone, Southwest Ethiopia.',NULL,NULL),(12,'Effect of chronic exposure to fluoride on soft tissue organs and on cognitive ability, and protective effect of Moringa stenopetala crud extract against tissue injury and cognitive deficit associated with fluorosis in mice','Effect of chronic exposure to fluoride on soft tissue organs and on cognitive ability, and protective effect of Moringa stenopetala crud extract against tissue injury and cognitive deficit associated with fluorosis in mice',NULL,NULL),(13,'Risk assessment of coffee processing Effluent on Human, Cattle, and Aquatic Biota in the receiving water bodies: a one health approach','Risk assessment of coffee processing Effluent on Human, Cattle, and Aquatic Biota in the receiving water bodies: a one health approach',NULL,NULL),(14,'Using theory of planned behavior to explain predictors of exclusive breastfeeding intention and practice among women in Jimma Zone, southwest Ethiopia.','Using theory of planned behavior to explain predictors of exclusive breastfeeding intention and practice among women in Jimma Zone, southwest Ethiopia.',NULL,NULL),(15,'Laboratory reference intervals for South-western Ethiopians','Laboratory reference intervals for South-western Ethiopians',NULL,NULL),(16,'Cervical cancer prevention in Jimma Zone in 2016/ 2017','Cervical cancer prevention in Jimma Zone in 2016/ 2017',NULL,NULL),(17,'Evaluation of Adolescent Reproductive and Sexual Health Services of Health Extention Program in Rural Kebeles of JimmaZones,\n','Evaluation of Adolescent Reproductive and Sexual Health Services of Health Extention Program in Rural Kebeles of JimmaZones,\n',NULL,NULL),(18,'Quality of maternal and child health services provided by health extension workers in Jimma zone, south west Ethiopia: using Lost quality assurance sampling','Quality of maternal and child health services provided by health extension workers in Jimma zone, south west Ethiopia: using Lost quality assurance sampling',NULL,NULL),(19,'Universal health coverage: Access to essential health care  and financial risk protection in Jimma Zone, Southwest Ethiopia','Universal health coverage: Access to essential health care  and financial risk protection in Jimma Zone, Southwest Ethiopia',NULL,NULL),(20,'Improving the outpatient medication adherence towards the chronic diseases by sending SMS to remind the dosing instructions attending at JUMC','Improving the outpatient medication adherence towards the chronic diseases by sending SMS to remind the dosing instructions attending at JUMC',NULL,NULL),(21,'A life course and Bayesian approaches to Helicobacter pylori infection, diagnostic methods and its nutrition and health outcomes in Ethiopia: Longitudinal study','A life course and Bayesian approaches to Helicobacter pylori infection, diagnostic methods and its nutrition and health outcomes in Ethiopia: Longitudinal study',NULL,NULL),(22,'Implementing antimicrobial stewardship program at Jimma university medical center: an operational research project to improve antibiotic utilization and prevent the occurrence of antimicrobial resistance','Implementing antimicrobial stewardship program at Jimma university medical center: an operational research project to improve antibiotic utilization and prevent the occurrence of antimicrobial resistance',NULL,NULL),(23,'Economic evaluation of Neonatal health service in Jimma zone, Southwest Ethiopia','Economic evaluation of Neonatal health service in Jimma zone, Southwest Ethiopia',NULL,NULL),(24,'A Randomized controlled Trial of cognitive Behavioral Therapy outcome for Adherence and depression (CBT-AD) among people living with HIV/AIDS who have been on Anti retro viral therapy (ART) follow up at Jimma University Medical Center (JUMC)','A Randomized controlled Trial of cognitive Behavioral Therapy outcome for Adherence and depression (CBT-AD) among people living with HIV/AIDS who have been on Anti retro viral therapy (ART) follow up at Jimma University Medical Center (JUMC)',NULL,NULL),(25,'Effectiveness of non-pharmacological intervention for chronic pain management: Moving from only statistical significance to also clinical significance','Effectiveness of non-pharmacological intervention for chronic pain management: Moving from only statistical significance to also clinical significance',NULL,NULL),(26,'Substance use disorder and its effect on quality of life, mental health  and adherence to anti-TB medication among tuberculosis patients in Southwest Ethiopia','Substance use disorder and its effect on quality of life, mental health  and adherence to anti-TB medication among tuberculosis patients in Southwest Ethiopia',NULL,NULL),(27,'Knowledge, attitude and practices associated with chronic kidney disease and organ donation and renal function screening among community residents, patients, health professionals and health science students in Jimma town, southwest Ethiopia','Knowledge, attitude and practices associated with chronic kidney disease and organ donation and renal function screening among community residents, patients, health professionals and health science students in Jimma town, southwest Ethiopia',NULL,NULL),(28,'Risk assessment of microbial contamination and animal drug residues in raw meat and milk along the Agro-Food value chain in Jimma zone, Southwest Ethiopia.','Risk assessment of microbial contamination and animal drug residues in raw meat and milk along the Agro-Food value chain in Jimma zone, Southwest Ethiopia.',NULL,NULL),(29,'Pharmaceutical excipient and drug development from Boswellia spp indigenous to Ethiopia','Pharmaceutical excipient and drug development from Boswellia spp indigenous to Ethiopia',NULL,NULL),(30,'Multifaceted Health and Well-being Implications of Violence against Children in Jimma Town.','Multifaceted Health and Well-being Implications of Violence against Children in Jimma Town.',NULL,NULL),(31,'Ultrasonographic Organometry  of South West Ethiopian adult population and its correlates','Ultrasonographic Organometry  of South West Ethiopian adult population and its correlates',NULL,NULL),(32,'predictors of nutritional status of adult PLWHA in Jimma Zone Public hospitals, Southwest Ethiopia','predictors of nutritional status of adult PLWHA in Jimma Zone Public hospitals, Southwest Ethiopia',NULL,NULL),(33,'Effect of Organized Clinical Mentoring on Missed Nursing Care Among Nurses and Hospitalized Patient in Public Hospitals of South Ethiopia','Effect of Organized Clinical Mentoring on Missed Nursing Care Among Nurses and Hospitalized Patient in Public Hospitals of South Ethiopia',NULL,NULL),(34,'Exploring Neglected and Underutilized root and tuber crops (Dioscorea prehensilis, Dioseorea alata and Manihot esculenta Crantz)   from Nutritional and Medicinal value analysis to link Agriculture, Nutrition, and Health in  Ethiopia','Exploring Neglected and Underutilized root and tuber crops (Dioscorea prehensilis, Dioseorea alata and Manihot esculenta Crantz)   from Nutritional and Medicinal value analysis to link Agriculture, Nutrition, and Health in  Ethiopia',NULL,NULL),(35,'Pattern of cardiovascular disease and drug compliance among adults in Jimma zone: an echocardiographic study','Pattern of cardiovascular disease and drug compliance among adults in Jimma zone: an echocardiographic study',NULL,NULL),(36,'Assessment of bioethical scandals, toxicological risks of anatomy labs of Ethiopian medical schools','Assessment of bioethical scandals, toxicological risks of anatomy labs of Ethiopian medical schools',NULL,NULL),(37,'Citizens’ charter implementation status in Jimma University Medical center','Citizens’ charter implementation status in Jimma University Medical center',NULL,NULL),(38,'Chromic Non-communicable disease(s) co-morbidity related clinical care & treatment outcomes among people living with HIV/AIDS: A comparative prospective cohort study','Chromic Non-communicable disease(s) co-morbidity related clinical care & treatment outcomes among people living with HIV/AIDS: A comparative prospective cohort study',NULL,NULL),(39,'Impact of chronic Khat chewing on cognitive, treatment outcome among type II diabetes and HIV/AIDS patients, attending Jimma University Medical Center Jimma town, south west Ethiopia','Impact of chronic Khat chewing on cognitive, treatment outcome among type II diabetes and HIV/AIDS patients, attending Jimma University Medical Center Jimma town, south west Ethiopia',NULL,NULL),(40,'Mental and reproductive health among adolescents and young adults in Jimma Zone, Ethiopia: Determinates and inter-relationships','Mental and reproductive health among adolescents and young adults in Jimma Zone, Ethiopia: Determinates and inter-relationships',NULL,NULL),(41,'Prehospital Emergency care: Determining burdens emergencies, estimating demands of care, evaluating existing activities, and ways for better service delivery system in Jimma town','Prehospital Emergency care: Determining burdens emergencies, estimating demands of care, evaluating existing activities, and ways for better service delivery system in Jimma town',NULL,NULL),(42,'Anti-quorum sensing potential of peptides from natural and other endemic sources in Ethiopia: the solution to antimicrobial resistance','Anti-quorum sensing potential of peptides from natural and other endemic sources in Ethiopia: the solution to antimicrobial resistance',NULL,NULL),(43,'Co-infection of  Schistosoma mansion  and Soil transmitted helminthes: impact on nutritional status, hematological profile and the comparison of laboratory diagnostic methods in school children of Manna district, Southwest Ethiopia','Co-infection of  Schistosoma mansion  and Soil transmitted helminthes: impact on nutritional status, hematological profile and the comparison of laboratory diagnostic methods in school children of Manna district, Southwest Ethiopia',NULL,NULL),(44,'Electrolyte disorder and its association with disease outcome among patients admitted to JUMC, South West Ethiopia','Electrolyte disorder and its association with disease outcome among patients admitted to JUMC, South West Ethiopia',NULL,NULL),(45,'Improving antenatal, delivery and postnatal care among health care professionals in public hospitals of Jimma Zone, south west Ethiopia','Improving antenatal, delivery and postnatal care among health care professionals in public hospitals of Jimma Zone, south west Ethiopia',NULL,NULL),(46,'Mental Health among internally displaced, returnee and Host community adults in Oromia-Somali Regions :A multicenter study','Mental Health among internally displaced, returnee and Host community adults in Oromia-Somali Regions :A multicenter study',NULL,NULL),(47,'Immune response and the emergence of drug resistance among adult HIV/AIDS patients in Southwest Ethiopia','Immune response and the emergence of drug resistance among adult HIV/AIDS patients in Southwest Ethiopia',NULL,NULL),(48,'Current status of liver disease and its endocrine, cardiovascular, nutritional, metabolic and glycemic effects among liver patients in some selected hospitals in Ethiopia: a prospective observational study','Current status of liver disease and its endocrine, cardiovascular, nutritional, metabolic and glycemic effects among liver patients in some selected hospitals in Ethiopia: a prospective observational study',NULL,NULL),(49,'Trajectories of Skilled Delivery Service Utilization among pregnant mother who received innovative M Health intervention, Jimma Zone, Ethiopia 2018','Trajectories of Skilled Delivery Service Utilization among pregnant mother who received innovative M Health intervention, Jimma Zone, Ethiopia 2018',NULL,NULL),(50,'Diagnostic, prognostic and treatment outcome indication of peripheral biomarkers among patients with major psychiatric disorders in Jimma University Psychiatric clinic, South West Ethiopia','Diagnostic, prognostic and treatment outcome indication of peripheral biomarkers among patients with major psychiatric disorders in Jimma University Psychiatric clinic, South West Ethiopia',NULL,NULL),(51,'Determining the possibility to integrate Mental Health into rural and urban health extension package','Determining the possibility to integrate Mental Health into rural and urban health extension package',NULL,NULL),(52,'Albuminuria among adults in Jimma Town and patients with chronic non-communicable diseases on follow up in Jimma Universe medical center','Albuminuria among adults in Jimma Town and patients with chronic non-communicable diseases on follow up in Jimma Universe medical center',NULL,NULL),(53,'Lesson from the 1977 E.C great Ethiopian famine: effects of prenatal starvation on adulthood metabolic, cognitive and anthropometric profile of survived infants and adolescents of the great Ethiopian famine (Kifu Qen). A historical cohort study, Wollo providence, northeast Ethiopia','Lesson from the 1977 E.C great Ethiopian famine: effects of prenatal starvation on adulthood metabolic, cognitive and anthropometric profile of survived infants and adolescents of the great Ethiopian famine (Kifu Qen). A historical cohort study, Wollo providence, northeast Ethiopia',NULL,NULL),(54,'Are the change agent changed? Exploring health risk and behavior disparity, needs, competencies, performance and network of community health workers in promoting maternal and child health Jimma zone, Ethiopia','Are the change agent changed? Exploring health risk and behavior disparity, needs, competencies, performance and network of community health workers in promoting maternal and child health Jimma zone, Ethiopia',NULL,NULL),(55,'Dysglycemia in critically ill children: Prevalence and outcome-a prospective observational study','Dysglycemia in critically ill children: Prevalence and outcome-a prospective observational study',NULL,NULL),(56,'Multiple Dimensions of Organizational Justice climate and counter productivity among Health-Care professionals in Jimma Zone Public Health Facilities','Multiple Dimensions of Organizational Justice climate and counter productivity among Health-Care professionals in Jimma Zone Public Health Facilities',NULL,NULL),(57,'Evaluation of radiation risk from medical imaging. Dose measurements and strategies for patient dose reduction','Evaluation of radiation risk from medical imaging. Dose measurements and strategies for patient dose reduction',NULL,NULL),(58,'Relation between maternal and child mental health with food security, nutritional status and diet among households of Jimma Town, Southwest Ethiopia: community based longitudinal (Cohort) study','Relation between maternal and child mental health with food security, nutritional status and diet among households of Jimma Town, Southwest Ethiopia: community based longitudinal (Cohort) study',NULL,NULL),(59,'Patterns of Drive related causes of Road traffic accidents and their association with near miss accidents in Jimma Zone commercial drivers','Patterns of Drive related causes of Road traffic accidents and their association with near miss accidents in Jimma Zone commercial drivers',NULL,NULL),(60,'’Detection of Unrecognized Common Non-Communicable Diseases and Standardizing Cutoff Points of their Biomarkers and Physical  measurement among Jimma Town Population, 2018','’Detection of Unrecognized Common Non-Communicable Diseases and Standardizing Cutoff Points of their Biomarkers and Physical  measurement among Jimma Town Population, 2018',NULL,NULL),(61,'Development, validation and performance of patient education scale, empowerment and framework in resource limited  settings of Ethiopia: An effort of translate patient education and communication  theories  into practice','Development, validation and performance of patient education scale, empowerment and framework in resource limited  settings of Ethiopia: An effort of translate patient education and communication  theories  into practice',NULL,NULL),(62,'Biomedical waste management in public hospitals existing in Jimma zone and its impacts on nearby communities','Biomedical waste management in public hospitals existing in Jimma zone and its impacts on nearby communities',NULL,NULL),(63,'Chronic non communicable disease, adult anthropometry, substance use disorders, and suicidal behavior among adult population with common mental disorder in Jimma town: Community based study.','Chronic non communicable disease, adult anthropometry, substance use disorders, and suicidal behavior among adult population with common mental disorder in Jimma town: Community based study.',NULL,NULL),(64,'Morbidity pattern, outcome of pediatric admissions and assessment of caregivers satisfaction in Jimma Medical Center, a prospective descriptive study','Morbidity pattern, outcome of pediatric admissions and assessment of caregivers satisfaction in Jimma Medical Center, a prospective descriptive study',NULL,NULL),(65,'Lower Back Pain among Three Wheels Drivers, Health Impact and Future Direction','Lower Back Pain among Three Wheels Drivers, Health Impact and Future Direction',NULL,NULL),(66,'Immune responses to measles and rotavirus vaccination for under-five children at Jimma Medical Center, Southwest Ethiopia','Immune responses to measles and rotavirus vaccination for under-five children at Jimma Medical Center, Southwest Ethiopia',NULL,NULL),(67,'Evaluation of Extemporaneous Antimicrobial Preparation and Its Contribution for Antimicrobial Resistance Development','Evaluation of Extemporaneous Antimicrobial Preparation and Its Contribution for Antimicrobial Resistance Development',NULL,NULL),(68,'The link between chronic physical diseases and selected mental illnesses, and help seeking behavior among children and adolescents in Jimma University Medical Center and Jimma town','The link between chronic physical diseases and selected mental illnesses, and help seeking behavior among children and adolescents in Jimma University Medical Center and Jimma town',NULL,NULL),(69,'Respiratory, Cardiovascular, and Visual Health impacts of household energy use among Women and Children:  indicators of exposure to indoor air pollution and associated risks factors in Jimma Zone, South West of Ethiopia','Respiratory, Cardiovascular, and Visual Health impacts of household energy use among Women and Children:  indicators of exposure to indoor air pollution and associated risks factors in Jimma Zone, South West of Ethiopia',NULL,NULL),(70,'Dimensions of Wok place spirituality among Health-Care Professionals in Jimma zone public Health facilities, South West Ethiopia, 2020','Dimensions of Wok place spirituality among Health-Care Professionals in Jimma zone public Health facilities, South West Ethiopia, 2020',NULL,NULL),(71,'Promoting respectful maternity care services in public health facilities of jimma zone','Promoting respectful maternity care services in public health facilities of jimma zone',NULL,NULL),(72,'Iatrogenic breach of patient safety practices in use of multi-dose parenteral containers & infusion bags as unrevealed hot beds for super bugs: a mixed design study','Iatrogenic breach of patient safety practices in use of multi-dose parenteral containers & infusion bags as unrevealed hot beds for super bugs: a mixed design study',NULL,NULL),(73,'Optimization and Validation of International consensus group criteria for slide review following automated CBC: Improving efficiency of hematology laboratory at JMC\n','Optimization and Validation of International consensus group criteria for slide review following automated CBC: Improving efficiency of hematology laboratory at JMC\n',NULL,NULL),(74,'Spatio-temporal analysis of HIV patient treatment outcomes and epidemiological characterization of geographical clusters in Jimma zone, oromia region, Southwest Ethiopia','Spatio-temporal analysis of HIV patient treatment outcomes and epidemiological characterization of geographical clusters in Jimma zone, oromia region, Southwest Ethiopia',NULL,NULL),(75,'Assessment of the types of food, its bacteriological quality and associated factors in selected Hospital’s in Jimma zone.','Assessment of the types of food, its bacteriological quality and associated factors in selected Hospital’s in Jimma zone.',NULL,NULL),(76,'Etiology, risk factors, antimicrobial susceptibility pattern and treatment outcomes of musculoskeletal infections in patients admitted to Jimma Medical Center (JUMC)','Etiology, risk factors, antimicrobial susceptibility pattern and treatment outcomes of musculoskeletal infections in patients admitted to Jimma Medical Center (JUMC)',NULL,NULL),(77,'Nursing Education Quality and Its Challenges in Ethiopian Public universities','Nursing Education Quality and Its Challenges in Ethiopian Public universities',NULL,NULL),(78,'The Effect of “Tech-Ad./Health Intervention” on life skill Development among adolescent in pastoral community of Guji Zone; South Ethiopia','The Effect of “Tech-Ad./Health Intervention” on life skill Development among adolescent in pastoral community of Guji Zone; South Ethiopia',NULL,NULL);
/*!40000 ALTER TABLE `published_topic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_time_table`
--

DROP TABLE IF EXISTS `research_time_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research_time_table` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int NOT NULL,
  `task` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci,
  `is_accomplished` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_77416852E1FD4933` (`submission_id`),
  CONSTRAINT `FK_77416852E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_time_table`
--

LOCK TABLES `research_time_table` WRITE;
/*!40000 ALTER TABLE `research_time_table` DISABLE KEYS */;
INSERT INTO `research_time_table` VALUES (1,6,'lowiddaanna caabbiyyelowiddaanna caabbiyye','2021-11-17','2021-11-23',NULL,NULL),(2,6,'lowiddaansasna caabbiyye','2021-11-23','2021-11-17',NULL,NULL),(3,7,'determine whether the manuscript conclusion is consistent with the results','2021-11-26','2021-11-25',NULL,NULL),(4,7,'evaluate the risk of bias of the trial,','2021-11-25','2021-11-16',NULL,NULL),(5,7,'evaluate the adequacy of the statistical analyses,','2021-11-25','2021-11-17',NULL,NULL),(6,7,'evaluate whether the control group is appropriate,','2021-11-26','2021-11-24',NULL,NULL),(7,8,'determine whether the','2022-11-10','2021-12-09',NULL,NULL),(8,8,'lowiddaansasna caabbiyye','2021-11-09','2021-11-18',NULL,NULL),(10,10,'WORK','2021-11-29','2021-12-24',NULL,NULL);
/*!40000 ALTER TABLE `research_time_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reset_password_request`
--

DROP TABLE IF EXISTS `reset_password_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reset_password_request` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `selector` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hashed_token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requested_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `expires_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_7CE748AA76ED395` (`user_id`),
  CONSTRAINT `FK_7CE748AA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reset_password_request`
--

LOCK TABLES `reset_password_request` WRITE;
/*!40000 ALTER TABLE `reset_password_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `reset_password_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `review_assignment_id` int DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reviewed_by_id` int DEFAULT NULL,
  `submission_id` int NOT NULL,
  `allow_to_view` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C6FBA5E497` (`review_assignment_id`),
  KEY `IDX_794381C6FC6B21F1` (`reviewed_by_id`),
  KEY `IDX_794381C6E1FD4933` (`submission_id`),
  CONSTRAINT `FK_794381C6E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`),
  CONSTRAINT `FK_794381C6FBA5E497` FOREIGN KEY (`review_assignment_id`) REFERENCES `review_assignment` (`id`),
  CONSTRAINT `FK_794381C6FC6B21F1` FOREIGN KEY (`reviewed_by_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (2,13,'d6bf679bff753bf733fd9fd1c487d1af.docx','<div class=\"D6j0vc\">\r\n<div class=\"gXmnc s6JM6d\" id=\"center_col\">\r\n<div id=\"taw\">\r\n<div>&nbsp;</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div id=\"tvcap\">&nbsp;</div>\r\n</div>\r\n\r\n<div class=\"eqAnXb\" id=\"res\">\r\n<div id=\"topstuff\">&nbsp;</div>\r\n\r\n<div id=\"search\">\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"g\">&nbsp;</div>\r\n\r\n<div class=\"tF2Cxc\">\r\n<div class=\"yuRUbf\">&nbsp;\r\n<h3><a href=\"https://techcommunity.microsoft.com/t5/microsoft-forms-blog/manage-your-forms-with-collections/ba-p/2758921\">Manage your forms with Collections - Microsoft Tech Community</a></h3>\r\n\r\n<div class=\"NJjxre TbwUpd\"><a href=\"https://techcommunity.microsoft.com/t5/microsoft-forms-blog/manage-your-forms-with-collections/ba-p/2758921\"><cite>https://techcommunity.microsoft.com &rsaquo; ba-p</cite></a></div>\r\n\r\n<div class=\"B6fmyf\">\r\n<div class=\"TbwUpd\">&nbsp;</div>\r\n\r\n<div class=\"eFM0qc\">&nbsp;</div>\r\n\r\n<div class=\"csDOgf\">\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div>\r\n<div class=\"GUHazd eY4mx iTPLzd lUn2nc\" style=\"padding-bottom:20px; padding-right:5px; position:absolute\">&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"yuRUbf\">\r\n<div class=\"B6fmyf\">\r\n<div class=\"csDOgf\">\r\n<div>\r\n<div>\r\n<div>&nbsp;</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n\r\n<div class=\"IsZvec\">\r\n<div class=\"MUxGbd VwiC3b lEBKkf lyLwlc yDYNvb yXK7lf\" style=\"-webkit-line-clamp:2\">Sep 27, 2021 &mdash; Today we&#39;re announcing <em>Forms Collections</em>, a new feature that enables you to create and manage online archives for your Microsoft <em>Forms</em>&nbsp;...</div>\r\n</div>','2021-11-10 18:21:42','Accepted with minor revision',4,10,NULL),(3,15,'2adebdec1fd62e61b9b0044b40110170.docx','<div class=\"IsZvec\">\r\n<div class=\"MUxGbd VwiC3b lEBKkf lyLwlc yDYNvb yXK7lf\" style=\"-webkit-line-clamp:2\">Sep 27, 2021 &mdash; Today we&#39;re announcing <em>Forms Collections</em>, a new feature that enables you to create and manage online archives for your Microsoft <em>Forms</em>&nbsp;...</div>\r\n</div>','2021-11-10 18:22:59','Accepted',4,10,NULL),(4,NULL,'',NULL,'2021-11-11 18:26:11','Declined',4,15,1),(5,NULL,'','<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].</span></span></span></p>','2021-11-11 18:56:54','Accepted with minor revision',7,16,1);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_assignment`
--

DROP TABLE IF EXISTS `review_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_assignment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `reviewer_id` int DEFAULT NULL,
  `duedate` datetime DEFAULT NULL,
  `invitation_sent_at` datetime DEFAULT NULL,
  `declined` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invitation_due_date` date NOT NULL,
  `status` int NOT NULL,
  `accepted_at` datetime DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `external_reviewer_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `external_reviewer_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `closed` tinyint(1) DEFAULT NULL,
  `inactive_assignment` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_475585B7E1FD4933` (`submission_id`),
  KEY `IDX_475585B770574616` (`reviewer_id`),
  CONSTRAINT `FK_475585B770574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_475585B7E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_assignment`
--

LOCK TABLES `review_assignment` WRITE;
/*!40000 ALTER TABLE `review_assignment` DISABLE KEYS */;
INSERT INTO `review_assignment` VALUES (18,16,7,'2021-11-25 00:00:00','2021-11-11 18:50:45',NULL,'2021-11-17',1,'2021-11-13 10:37:19',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `review_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_interest`
--

DROP TABLE IF EXISTS `review_interest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review_interest` (
  `id` int NOT NULL AUTO_INCREMENT,
  `researcher_id` int DEFAULT NULL,
  `interest` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4F7C936CC7533BDE` (`researcher_id`),
  CONSTRAINT `FK_4F7C936CC7533BDE` FOREIGN KEY (`researcher_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_interest`
--

LOCK TABLES `review_interest` WRITE;
/*!40000 ALTER TABLE `review_interest` DISABLE KEYS */;
/*!40000 ALTER TABLE `review_interest` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scholarship`
--

DROP TABLE IF EXISTS `scholarship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scholarship` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `deadline` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scholarship`
--

LOCK TABLES `scholarship` WRITE;
/*!40000 ALTER TABLE `scholarship` DISABLE KEYS */;
INSERT INTO `scholarship` VALUES (1,'European Government Scholarships for Non-EU Students','https://www.scholars4dev.com/15082/holland-scholarship-for-non-eu-international-students/','2021-11-05 14:14:44','Holland','<h2><span style=\"font-size:16px\">African Economic Research Consortium Awards&raquo;Masters Scholarships in Africa &raquo; PhD Scholarships in Africa &raquo; African Scholarships &amp; Grants</span></h2>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>African Economic Research Consortium Awards; MSc scholarships in Africa. PhD scholarships in Africa. MSc &amp; PhD scholarships for African residents studying in African universities. Africa scholarships. African Economic Research Consortium Awards</p>\r\n\r\n<p>African Economic Research Consortium Awards MSc &amp; PhD Fellowships.</p>\r\n\r\n<p>The African Economic Research Consortium (AERC) was established in 1988 as a public not-for-profit organization devoted to the advancement of economic policy research and training in Africa.</p>\r\n\r\n<p>The Consortium&rsquo;s mandate and strategic intent is built on the basis that sustained development in sub-Saharan Africa requires well-trained, locally based professional economists.</p>\r\n\r\n<p>AERC agitates the provision of capacity building in economic policy in Francophone and Anglophone African countries through provision of support in the areas of policy research and graduate training.</p>\r\n\r\n<p>AERC has placed a call for applications for MSc scholarships and Ph.D. scholarships for applicants from Francophone and Anglophone sub-Saharan African Countries.</p>\r\n\r\n<p>The scholarships will be offered in collaboration with the following universities across the Region, with whom AERC has partnerships:</p>\r\n\r\n<p>&bull; University of Cape Town, South Africa<br />\r\n&bull; University of Ibadan, Nigeria<br />\r\n&bull; University of Benin, Nigeria<br />\r\n&bull; University of Dar es Salaam, Tanzania<br />\r\n&bull; University of Nairobi, Kenya<br />\r\n&bull; Egerton University - Kenya<br />\r\n&bull; University of the Witwatersrand, South Africa<br />\r\n&bull; University of Zimbabwe - Zimbabwe<br />\r\n&bull; University of Pretoria - South Africa<br />\r\n&bull; Sokoine University - Tanzania<br />\r\n&bull; Makerere University - Uganda<br />\r\n&bull; Lilongwe University of Agriculture and Natural Resources &ndash; Bunda Campus, Malawi<br />\r\n&bull; Haramaya University - Ethiopia<br />\r\n&bull; University of Yaound&eacute; II, Cameroon<br />\r\n&bull; University of Cocody, Cote D&rsquo;Ivoire</p>\r\n\r\n<p>(The list changes from year to year. Be sure to check that the institution you are applying to is on the current list from the links below.)</p>\r\n\r\n<p><strong>Announcement for African Economic Research Consortium Awards - Requirements &amp; Qualifications </strong></p>\r\n\r\n<p>(a) An applicant must be admitted to any of the collaborating or partner university above</p>\r\n\r\n<p>(b) Applicant must have attained at least a Second Class Honours(Upper Division) or equivalent in Agricultural Economics, Agribusiness Mgt, Agricultural Sciences, Economics or related field</p>\r\n\r\n<p>Interested applicants must submit their applications for admission directly to the respective universities (application procedure can be obtained from the respective university&rsquo;s website).</p>\r\n\r\n<p>Upon receipt of an admission letter from specific university, the applicants shall submit the following documents for scholarship to AERC Programme Manager on cmaae@aercafrica.org.</p>\r\n\r\n<p>1. Application cover letter</p>\r\n\r\n<p>2. Curriculum Vitae</p>\r\n\r\n<p>3. Evidence of admission at any of the universities listed above and</p>\r\n\r\n<p>4. Certified copies of transcripts and certificates</p>\r\n\r\n<p><strong>Study in Africa - PhD Fellowship Requirements</strong></p>\r\n\r\n<p>To qualify, an applicant must:</p>\r\n\r\n<p>(a) Have applied and been admitted to any one of the listed partner universities;</p>\r\n\r\n<p>(b) Have attained at least a Second Class Honours (Upper Division) or equivalent in Economics or related field from an accredited university;</p>\r\n\r\n<p>(c) Have a Masters Degree (with coursework and thesis component) in Economics, Agricultural Economics or related fields from a recognized University. The coursework should have covered microeconomics, macroeconomics and quantitative methods. Interested candidates must submit their applications for ad</p>\r\n\r\n<p>Interested candidates must submit their applications for admission directly to the respective universities (application procedure can be obtained from the respective universities&rsquo; websites).</p>\r\n\r\n<p>Upon receipt of an admission letter from the specific university, the applicant should submit his or her application for scholarship to AERC and attach a copy of the admission letter.</p>\r\n\r\n<p>In addition, candidates should attach their curriculum vitae and certified copies of their academic certificates and transcripts.</p>\r\n\r\n<p>African Economic Research Consortium Awards</p>\r\n\r\n<p>For more information and scholarship application details, see; <a href=\"http://www.aercafrica.org/\" rel=\"noopener\" style=\"TEXT-DECORATION: NONE\" target=\"_blank\">African Economic Research Consortium Awards; Study in Africa - MSc &amp; PhD Fellowships in Africa </a></p>\r\n\r\n<p>Also see; <a href=\"http://aercafrica.org/images/announcements/AERC%20Call%20for%20Applications%20for%20Masters%20and%20PhD%20Bridging%20Programme%20Fellowships.pdf\" rel=\"noopener\" style=\"TEXT-DECORATION: NONE\" target=\"_blank\">African Economic Research Consortium MSc &amp; PhD Fellowships in Africa Applications </a></p>\r\n\r\n<p>More: <a href=\"https://www.advance-africa.com/PhD-and-Masters-by-Research-Scholarships.html\" style=\"TEXT-DECORATION: NONE\" target=\"_blank\">Africa Masters Scholarships &raquo; Africa PhD Scholarships &raquo; Africa Research Awards &raquo; Africa PhD Awards &raquo; Africa Graduate Awards &raquo; Africa Masters Scholarships in Africa &raquo; PhD Scholarships in Africa </a></p>','2021-11-30 00:00:00');
/*!40000 ALTER TABLE `scholarship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `site_setting`
--

DROP TABLE IF EXISTS `site_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `site_setting` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_address` longtext COLLATE utf8mb4_unicode_ci,
  `about` longtext COLLATE utf8mb4_unicode_ci,
  `privacy_statement` longtext COLLATE utf8mb4_unicode_ci,
  `app_description` longtext COLLATE utf8mb4_unicode_ci,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `app_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `corporate_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `motto` longtext COLLATE utf8mb4_unicode_ci,
  `copyright` longtext COLLATE utf8mb4_unicode_ci,
  `site_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `navbar_background` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acronym` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `site_setting`
--

LOCK TABLES `site_setting` WRITE;
/*!40000 ALTER TABLE `site_setting` DISABLE KEYS */;
INSERT INTO `site_setting` VALUES (1,'JU- Research Portal','RMS','<p>JU- Research Portal</p>','<p>JU- Research Portal</p>','<p>JU- Research Portal</p>','<p>JU- Research Portal</p>',NULL,'research.ju.edu.et','#54b4','We are in the community','<p>JU- Research Portal</p>',NULL,'dark',NULL,NULL);
/*!40000 ALTER TABLE `site_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `specific_objective`
--

DROP TABLE IF EXISTS `specific_objective`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `specific_objective` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int DEFAULT NULL,
  `objective` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D7CADC3FE1FD4933` (`submission_id`),
  CONSTRAINT `FK_D7CADC3FE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `specific_objective`
--

LOCK TABLES `specific_objective` WRITE;
/*!40000 ALTER TABLE `specific_objective` DISABLE KEYS */;
INSERT INTO `specific_objective` VALUES (1,6,'sagale ikkitannonsa gede lattino hayissonna haqqe baala oommonsa» yii'),(2,6,'lubbo afi\'rinohu baalu aana roorre afidhe» yee maassi\'rinsa.Maganuno,'),(3,6,'agintaabbine higgine cuuamme!» yee lallawanni halalla leelli.'),(4,6,'baattote aana heedhanno saada duuchantera,'),(5,6,'Maganu manna, «Ille ilamme, sirchi\'ne baatto wo\'mo;'),(6,7,'sagale ikkitannonsa gede lattino hayissonna haqqe baala'),(7,7,'lubbo afi\'rinohu baalu aana roorre afidhe» yee maassi\'rinsa.Maganuno,'),(8,7,'Maganu kalaqinoha baala lai; lowo geeshsha dancha ikkinota lai. Barru hashshi'),(9,7,'baattote aana heedhanno saada duuchantera,'),(10,7,'You don’t need to download the Dompdf library separately'),(11,8,'sagale ikkitannonsa gede lattino hayissonna haqqe baala'),(12,8,'objective2'),(13,8,'agintaabbine higgine cuuamme!» yee lallawanni halalla leelli.'),(14,8,'baattote aana heedhanno saada duuchantera,'),(15,8,'Maganu manna, «Ille ilamme, sirchi\'ne baatto wo\'mo;'),(16,10,'metabolic, and signaling pathway aberrations'),(17,10,'name given to a group of diseases comprising aathway aberrations'),(18,10,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations'),(19,10,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations'),(20,10,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations'),(21,15,'metabolic, and signaling pathway aberrations'),(22,15,'name given to a group of diseases comprising aathway aberrations'),(23,15,'Cancer is the name given to a group of diseases comprising a combination of genetic, m'),(24,16,'metabolic, and signaling pathway aberrations'),(25,16,'name given to a group of diseases comprising aathway aberrations'),(26,16,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations'),(27,16,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations'),(28,17,'Malaria 1'),(29,18,'dfgdfgdfgdf'),(30,18,'dfgdfgdfg'),(31,18,'fgfdgdfgdf');
/*!40000 ALTER TABLE `specific_objective` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission`
--

DROP TABLE IF EXISTS `submission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `call_for_proposal_id` int DEFAULT NULL,
  `thematic_area_id` int DEFAULT NULL,
  `abstract` longtext COLLATE utf8mb4_unicode_ci,
  `sub_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `round` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `uidentifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `complete` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `submission_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_plan` longtext COLLATE utf8mb4_unicode_ci,
  `funding_organization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_start_at` date DEFAULT NULL,
  `project_end_at` date DEFAULT NULL,
  `progress` int DEFAULT NULL,
  `is_author_pi` tinyint(1) DEFAULT NULL,
  `copyedit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `terminalreport` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `step` int NOT NULL,
  `research_outcome` longtext COLLATE utf8mb4_unicode_ci,
  `background_and_rationale` longtext COLLATE utf8mb4_unicode_ci,
  `methodology` longtext COLLATE utf8mb4_unicode_ci,
  `general_objective` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference` longtext COLLATE utf8mb4_unicode_ci,
  `budget_and_time_schedule` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_DB055AF3F675F31B` (`author_id`),
  KEY `IDX_DB055AF3D95E2AAD` (`call_for_proposal_id`),
  KEY `IDX_DB055AF3328F8B8E` (`thematic_area_id`),
  CONSTRAINT `FK_DB055AF3328F8B8E` FOREIGN KEY (`thematic_area_id`) REFERENCES `thematic_area` (`id`),
  CONSTRAINT `FK_DB055AF3D95E2AAD` FOREIGN KEY (`call_for_proposal_id`) REFERENCES `call_for_proposal` (`id`),
  CONSTRAINT `FK_DB055AF3F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission`
--

LOCK TABLES `submission` WRITE;
/*!40000 ALTER TABLE `submission` DISABLE KEYS */;
INSERT INTO `submission` VALUES (16,19,9,27,'<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].</span></span></span></p>','Cancer is the metabolic, and signaling pathway aberrations',NULL,'Cancer is the name given to a group of diseases comprising a combination of genetic, metabolic, and signaling pathway aberrations','2021-11-11 18:49:10','1744ffcdbd5b3d4cd4e254e42029e2cd','completed',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,'dsgsdg,ghjgfk,vbxfds,mgf,ggtu',10,'<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].</span></span></span></p>','<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].</span></span></span></p>','<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].Chemotherapy was developed and used since World War I from the chemical weapons program of the United States of America (USA). Since then, chemotherapy has become one of the most important and significant treatments of cancer. Its main mechanism of action is by killing the cancer cells which are characterized by their high multiplication and growth rate. It also kills all cancer cells that have split from the main tumor and spread to the blood or lymph system or any part of the body. This killing process of cells affects the factors involved in mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy drugs may completely cure certain types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have many side effects. However, when comparing chemotherapy with other types of therapies, it still has a potentially high risk and has many side effects that are difficult to control. The chemotherapy used requires the participation of various clinical professionals at all stages of its administration and requires a large amount of patient care to overcome its side effects [187,190].</span></span></span></p>','Cancer is the name given to a group of diseases','<p>.A. Chouliaras, V.M. Dwyer, S. Agha, J.L. Nunez-Yanez, D. Reisis, K. Nakos, et al., &quot;Customization of an embedded RISC CPU with SIMD extensions for video encoding: A case study&quot;,&nbsp;<em>Elsevier Press Integration: The VLSI Journal</em>.</p>\r\n\r\n<p>Show in Context<a href=\"https://doi.org/10.1016/j.vlsi.2007.02.003\" target=\"_blank\">&nbsp;CrossRef&nbsp;</a><a href=\"https://scholar.google.com/scholar?as_q=Customization+of+an+embedded+RISC+CPU+with+SIMD+extensions+for+video+encoding%3A+A+case+study&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>2.</strong>V. A. Chouliaras, J. A. Flint and Y. Li, &quot;A Transmission Line Modelling VLSI processor designed with a novel Electronic System Level Methodology&quot;,&nbsp;<em>ICECS2007</em>.</p>\r\n\r\n<p>Show in Context<a href=\"https://ieeexplore.ieee.org/document/4510995\" target=\"_self\">&nbsp;View Article&nbsp;</a><a href=\"https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&amp;arnumber=4510995\">Full Text: PDF&nbsp;</a>(1305KB)<a href=\"https://scholar.google.com/scholar?as_q=A+Transmission+Line+Modelling+VLSI+processor+designed+with+a+novel+Electronic+System+Level+Methodology&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>3.</strong><em>C2R Compiler product brief</em>, [online] Available: www.cebatech.com.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=C2R+Compiler+product+brief&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>4.</strong><em>Synopsys SystemC compiler product brief</em>, [online] Available: www.synopsys.com.</p>\r\n\r\n<p><a href=\"https://scholar.google.com/scholar?as_q=Synopsys+SystemC+compiler+product+brief&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>5.</strong><em>Agility Compiler Product brief</em>, [online] Available: http://www.celoxica.com/products/agility/default.asp.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=Agility+Compiler+Product+brief&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>6.</strong>&nbsp;[online] Available: http://www.forteds.com/products/cynthesizer.asp.</p>\r\n\r\n<p>Show in Context</p>\r\n\r\n<p><strong>7.</strong><em>ImpulseC Compiler</em>, [online] Available: http://www.impulsec.com/C_to_fpga.htm.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=ImpulseC+Compiler&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>8.</strong><em>DK Design Suite</em>, [online] Available: http://www.celoxica.com/products/dk/default.asp.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=DK+Design+Suite&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>9.</strong>R. Thomson, V. Chouliaras and D. Mulvaney, &quot;From UML to structural hardware designs&quot; in Accepted for presentation at DAC 2007, San Diego, California, USA.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=From+UML+to+structural+hardware+designs&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>10.</strong>A. Dellson, &quot;Progamming FPGAs for High Perfomracnce Computing Acceleration&quot;,&nbsp;<em>Xilinx XCELL Journal</em>, [online] Available: http://www.xilinx.com/publications/xcellonline/xcell_55/xc_pdf/xc_;mitrion55.pdf.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=Progamming+FPGAs+for+High+Perfomracnce+Computing+Acceleration&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>11.</strong><em>PICO Express product brief</em>, [online] Available: http://www.synfora.com/products/picoexpress.html.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=PICO+Express+product+brief&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>12.</strong>S. Gupta, N.D. Dutt, R.K. Gupta and A. Nicolau, &quot;SPARK: A High-Level Synthesis Framework For Applying Parallelizing Compiler Transformations&quot;,&nbsp;<em>International Conference on VLSI Design</em>, January 2003.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=SPARK%3A+A+High-Level+Synthesis+Framework+For+Applying+Parallelizing+Compiler+Transformations&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>13.</strong>J.L. Tripp, K.D. Peterson, C. Ahrens, J.D. Poznanovic and M.B Gokhale, &quot;Trident: an FPGA compiler framework for floating-point algorithms&quot;,&nbsp;<em>Field Programmable Logic and Applications 2005. International Conference on</em>, pp. 24-26, Aug. 2005.</p>\r\n\r\n<p>Show in Context<a href=\"https://ieeexplore.ieee.org/document/1515741\" target=\"_self\">&nbsp;View Article&nbsp;</a><a href=\"https://ieeexplore.ieee.org/stamp/stamp.jsp?tp=&amp;arnumber=1515741\">Full Text: PDF&nbsp;</a>(173KB)<a href=\"https://scholar.google.com/scholar?as_q=Trident%3A+an+FPGA+compiler+framework+for+floating-point+algorithms&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>14.</strong><em>Catapult Compiler Product brief</em>, [online] Available: http://www.mentor.com/products/esl/high_level_synthesis/catapult_synthesis/index.cfm.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=Catapult+Compiler+Product+brief&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>15.</strong><em>Softfloat release 2b</em>, [online] Available: http://www.jhauser.us/arithmetic/SoftFloat.html.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=Softfloat+release+2b&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>16.</strong><em>Floating Point Unit project</em>, [online] Available: http://www.opencores.org/projects.cgi/web/fpu/overview.</p>\r\n\r\n<p>Show in Context<a href=\"https://scholar.google.com/scholar?as_q=Floating+Point+Unit+project&amp;as_occt=title&amp;hl=en&amp;as_sdt=0%2C31\" target=\"_blank\">&nbsp;Google Scholar&nbsp;</a></p>\r\n\r\n<p><strong>17.</strong>D. Burger and T. Austin, &quot;Evaluating Future Microprocessors: The SimpleScalar Tool Set&quot;, [online] Available: http://www.simplescalar.com.</p>','<table cellspacing=\"0\" class=\"MsoTableGrid\" style=\"border-collapse:collapse; border:none\">\r\n	<tbody>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">types of cancer, or may inhibit the growth of other types of cancer, or may prevent it from spreading to other parts of the body. In the past 20 years, many types of new therapies have emerged. Some of them are simple and clear, effective and safe, and some have</span></span></span></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:1px solid black; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\">&nbsp;</p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n		</tr>\r\n		<tr>\r\n			<td style=\"border-bottom:1px solid black; border-left:1px solid black; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\">&nbsp;</p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n			<td style=\"border-bottom:1px solid black; border-left:none; border-right:1px solid black; border-top:none; vertical-align:top; width:160px\">\r\n			<p style=\"text-align:justify\"><span style=\"font-size:11pt\"><span style=\"font-family:Calibri,&quot;sans-serif&quot;\"><span style=\"font-family:&quot;Times New Roman&quot;,&quot;serif&quot;\">mitosis by directly acting on deoxyribonucleic acid (DNA) or by inhibiting its synthesis or production or use [187-189]. Chemotherapy</span></span></span></p>\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>'),(17,20,9,22,'<p>qfafdsagfdsgdwgv</p>','malaria sub',NULL,'Malaria','2021-11-12 09:56:03','a5f3dd8754d6c5ce771ecc50e2384932','completed',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'asas,scsc,xcsd',10,'<p>ADSDsD</p>','<p>adgdsgsdgsf</p>','<p>sdfsafdafdsafdsf</p>','Malaria Control','<p>SDSAFDSADFAF</p>','<p>DFDSFDSFSDF</p>'),(18,21,9,16,'<p>ladkhfas</p>',NULL,NULL,'dfgdfg',NULL,'8850b0e75a4d1ca9d2df1901ecc25884',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,'sflkskjjfdsd ,sdfsdlkfn,dsljfsd',2,'<p>lsdjjflksdjflk</p>','<p>skfnlsdddf</p>','<p>sjdjflsjdjlj</p>','fgfdgdfgd','<p>sldjflsdkjflkja</p>','<p>sldjfjlsdjf</p>\r\n\r\n<p>lkjsdlkjflsdkjflkj</p>');
/*!40000 ALTER TABLE `submission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_attachement`
--

DROP TABLE IF EXISTS `submission_attachement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_attachement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_id` int NOT NULL,
  `submission_id` int DEFAULT NULL,
  `file` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_17D8067B71179CD6` (`name_id`),
  KEY `IDX_17D8067BE1FD4933` (`submission_id`),
  CONSTRAINT `FK_17D8067B71179CD6` FOREIGN KEY (`name_id`) REFERENCES `attachement_type` (`id`),
  CONSTRAINT `FK_17D8067BE1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_attachement`
--

LOCK TABLES `submission_attachement` WRITE;
/*!40000 ALTER TABLE `submission_attachement` DISABLE KEYS */;
INSERT INTO `submission_attachement` VALUES (5,3,5,'application-letter-for-abay-bank-61868872b27b7490899025.docx'),(6,2,6,'2014-mega-proposal-call-1-1-6188d94fb42b1440305348.doc'),(7,4,6,'sources-6188d94fb4b5f871451318.csv'),(8,3,7,'2014-mega-proposal-call-1-1-6188e81aac481757320280.doc'),(9,4,7,'nlp-course-env-6188e81aaca4a535106507.yml'),(10,3,8,'2014-mega-proposal-call-1-1-61893c17ca383900723309.doc'),(11,4,8,'2014-mega-proposal-call-1-1-61893c17ca7d0382277261.doc'),(12,2,10,'2014-mega-proposal-call-1-1-618bddcf108a1924838909.doc'),(13,3,15,'2014-mega-proposal-call-1-1-618d3093ecc9c047340645.doc'),(14,3,16,'2014-mega-proposal-call-1-1-618d3b6b11e87700390504.doc'),(15,2,17,'sidamolanguagelisting-618e0fc961ae1671263675.csv');
/*!40000 ALTER TABLE `submission_attachement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_budget`
--

DROP TABLE IF EXISTS `submission_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_budget` (
  `id` int NOT NULL AUTO_INCREMENT,
  `submission_id` int NOT NULL,
  `cost` double NOT NULL,
  `quantity` int NOT NULL,
  `remark` longtext COLLATE utf8mb4_unicode_ci,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4BF7AAC5E1FD4933` (`submission_id`),
  KEY `IDX_4BF7AAC512469DE2` (`category_id`),
  CONSTRAINT `FK_4BF7AAC512469DE2` FOREIGN KEY (`category_id`) REFERENCES `submission_budget_category` (`id`),
  CONSTRAINT `FK_4BF7AAC5E1FD4933` FOREIGN KEY (`submission_id`) REFERENCES `submission` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_budget`
--

LOCK TABLES `submission_budget` WRITE;
/*!40000 ALTER TABLE `submission_budget` DISABLE KEYS */;
INSERT INTO `submission_budget` VALUES (4,5,200,100,NULL,'Data acollection',3),(5,5,2000,2,NULL,'Mobility from Jimma to Addis ababa',4),(6,5,2000,12,NULL,'Machinery purchase',5),(7,6,100,32,NULL,'lowiddaanna caabbiyye',4),(8,6,323,324,NULL,'lowiddaanna caabbiyyelowiddaanna caabbiyye',3),(9,7,21,212,NULL,'You don’t need to',3),(10,7,1000,22,NULL,'You don’t need to download the Dompdf library separately',3),(11,8,2000,45,NULL,'If the Editor does not immediately reject the',3),(12,8,56,4,NULL,'If the Editor does not immediately reject the',4),(14,10,200,4,NULL,'PAYMNET',3);
/*!40000 ALTER TABLE `submission_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_budget_category`
--

DROP TABLE IF EXISTS `submission_budget_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_budget_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_budget_category`
--

LOCK TABLES `submission_budget_category` WRITE;
/*!40000 ALTER TABLE `submission_budget_category` DISABLE KEYS */;
INSERT INTO `submission_budget_category` VALUES (3,'Personal free'),(4,'Transpportation'),(5,'Purchase'),(6,'Others');
/*!40000 ALTER TABLE `submission_budget_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_budget_submission_budget_category`
--

DROP TABLE IF EXISTS `submission_budget_submission_budget_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_budget_submission_budget_category` (
  `submission_budget_id` int NOT NULL,
  `submission_budget_category_id` int NOT NULL,
  PRIMARY KEY (`submission_budget_id`,`submission_budget_category_id`),
  KEY `IDX_4E8BA6BB8614A20C` (`submission_budget_id`),
  KEY `IDX_4E8BA6BB397968EA` (`submission_budget_category_id`),
  CONSTRAINT `FK_4E8BA6BB397968EA` FOREIGN KEY (`submission_budget_category_id`) REFERENCES `submission_budget_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4E8BA6BB8614A20C` FOREIGN KEY (`submission_budget_id`) REFERENCES `submission_budget` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_budget_submission_budget_category`
--

LOCK TABLES `submission_budget_submission_budget_category` WRITE;
/*!40000 ALTER TABLE `submission_budget_submission_budget_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `submission_budget_submission_budget_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_status`
--

DROP TABLE IF EXISTS `submission_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `submission_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_status`
--

LOCK TABLES `submission_status` WRITE;
/*!40000 ALTER TABLE `submission_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `submission_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `calls` tinyint(1) DEFAULT NULL,
  `news` tinyint(1) DEFAULT NULL,
  `new_submission` tinyint(1) DEFAULT NULL,
  `announcement` tinyint(1) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A3C664D3A76ED395` (`user_id`),
  CONSTRAINT `FK_A3C664D3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription`
--

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
INSERT INTO `subscription` VALUES (1,4,1,1,1,1,'firew.legese@ju.edu.et');
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suffixe`
--

DROP TABLE IF EXISTS `suffixe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suffixe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suffixe`
--

LOCK TABLES `suffixe` WRITE;
/*!40000 ALTER TABLE `suffixe` DISABLE KEYS */;
INSERT INTO `suffixe` VALUES (1,'Prof.','Proffessor'),(2,'Dr.','Doctor'),(3,'Mr.',NULL),(4,'Mrs.',NULL),(5,'Miss',NULL);
/*!40000 ALTER TABLE `suffixe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thematic_area`
--

DROP TABLE IF EXISTS `thematic_area`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thematic_area` (
  `id` int NOT NULL AUTO_INCREMENT,
  `work_unit_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E1223BFD2D76C82F` (`work_unit_id`),
  KEY `IDX_E1223BFD770124B2` (`college_id`),
  CONSTRAINT `FK_E1223BFD2D76C82F` FOREIGN KEY (`work_unit_id`) REFERENCES `work_unit` (`id`),
  CONSTRAINT `FK_E1223BFD770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thematic_area`
--

LOCK TABLES `thematic_area` WRITE;
/*!40000 ALTER TABLE `thematic_area` DISABLE KEYS */;
INSERT INTO `thematic_area` VALUES (12,NULL,'Resilient health systems (Emerging and re-emerging diseases)','Resilient health systems (Emerging and re-emerging diseases)',11),(13,NULL,'Accidents and injuries (Traffic, violence and trauma)','Accidents and injuries (Traffic, violence and trauma)',11),(14,NULL,'Disaster risk reduction and health emergencies','Disaster risk reduction and health emergencies',11),(15,NULL,'Information and communication technologies for health','Information and communication technologies for health',11),(16,NULL,'Environmental and Occupational health','Environmental and Occupational health',11),(17,NULL,'Infectious and Communicable diseases','Infectious and Communicable diseases',11),(18,NULL,'Non-communicable diseases','Non-communicable diseases',11),(19,NULL,'Antimicrobial drug resistance (AMR) and Infection prevention and control (IPC)','Antimicrobial drug resistance (AMR) and Infection prevention and control (IPC)',11),(20,NULL,'Reproductive,, Adult, Maternal, New-born and child health','Reproductive,, Adult, Maternal, New-born and child health',11),(21,NULL,'Mental health and Substance abuse','Mental health and Substance abuse',11),(22,NULL,'Oral health','Oral health',11),(23,NULL,'Vision health and blindness','Vision health and blindness',11),(24,NULL,'Nutrition, Malnutrition and Dietetics','Nutrition, Malnutrition and Dietetics',11),(25,NULL,'Traditional and complementary medicine','Traditional and complementary medicine',11),(26,NULL,'Determinants of health and Health behaviours','Determinants of health and Health behaviours',11),(27,NULL,'Molecular Biology, diagnostics and Genomics','Molecular Biology, diagnostics and Genomics',11);
/*!40000 ALTER TABLE `thematic_area` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `title`
--

DROP TABLE IF EXISTS `title`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `title` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `title`
--

LOCK TABLES `title` WRITE;
/*!40000 ALTER TABLE `title` DISABLE KEYS */;
  INSERT INTO `title` VALUES (2,'Mr.'),(3,'Dr.'),(4,'Prof'),(5,'Mrs.');
/*!40000 ALTER TABLE `title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviews_id` int DEFAULT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `is_super_admin` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `registered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  KEY `IDX_8D93D6498092D97F` (`reviews_id`),
  CONSTRAINT `FK_8D93D6498092D97F` FOREIGN KEY (`reviews_id`) REFERENCES `review` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (4,NULL,'firew.legese@ju.edu.et',NULL,'[\"ROLE_ADMIN\", \"ROLE_USER\", \"ROLE_EVALUATOR\", \"usrgrp_act\", \"assn_drctr\", \"assn_clg_cntr\", \"ROLE_SUPER_ADMIN\", \"usr_edt\", \"ad_prmsn_to_grp\", \"ad_usr_to_grp\", \"usrgrp_act\", \"perm_act\", \"ROLE_SUPER_ADMIN\"]','$2y$13$InwpFuxwXkEu3uW/Oa9W8eTwALDNbEmV77N9J8bXSetjJXJAEQu.i',0,0,'2021-11-12 20:12:41',1,'2021-09-08 20:07:55'),(5,NULL,'kumediba@gmail.com',NULL,'[]','$2y$13$0p4NJoAiVTYQzU5xAmJpmOBbDF.UNYC6ski3Cmfvm3z9Z9AK7nie6',0,0,'2021-09-13 10:52:57',1,'2021-09-13 10:52:53'),(7,NULL,'henok.gulilat@ju.edu.et',NULL,'[\"ROLE_ADMIN\", \"ROLE_USER\", \"ROLE_EVALUATOR\", \"usrgrp_act\", \"assn_drctr\", \"assn_clg_cntr\", \"ROLE_SUPER_ADMIN\", \"usr_edt\", \"ad_prmsn_to_grp\", \"ad_usr_to_grp\", \"usrgrp_act\"]','$2y$13$iZZyau4QW0bf7s7EJDlepeh/dTtKleSTIIUd9W5cdX/riRtJPXMUm',0,0,'2021-11-13 10:18:52',1,'2021-11-05 15:01:12'),(19,NULL,'henoksheba@gmail.com',NULL,'[]','$2y$13$pPgW2R8yB0UW/KFPklGx/OkAGvUXQWDlkjeGmKl594Wb3AFEjJuAC',0,0,'2021-11-11 18:57:55',1,'2021-11-11 18:44:33'),(20,NULL,'hailu.chemir@ju.edu.et',NULL,'[]','$2y$13$q/gPjh8le96rUd/47HkWZ.suHr0.hDlZXkW4bxb0qKHzBKtE0F16.',0,0,'2021-11-12 09:34:45',1,'2021-11-12 09:34:41'),(21,NULL,'esmael.kedir@ju.edu.et',NULL,'[]','$2y$13$wRlt04iCgyO/hbgiZBpLz..qEY2BqynWE4q5hTB6ybbyG/WUN/yE.',0,0,'2021-11-12 10:36:18',1,'2021-11-12 10:36:13');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group` (
  `id` int NOT NULL AUTO_INCREMENT,
  `registered_by_id` int NOT NULL,
  `updated_by_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8F02BF9D27E92E18` (`registered_by_id`),
  KEY `IDX_8F02BF9D896DBBDE` (`updated_by_id`),
  CONSTRAINT `FK_8F02BF9D27E92E18` FOREIGN KEY (`registered_by_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_8F02BF9D896DBBDE` FOREIGN KEY (`updated_by_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (3,4,4,'College Coordinator','College Coordinators','2021-11-05 14:08:25','2021-11-09 18:08:36',1);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group_permission`
--

DROP TABLE IF EXISTS `user_group_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_group_permission` (
  `user_group_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`user_group_id`,`permission_id`),
  KEY `IDX_4A91B1C51ED93D47` (`user_group_id`),
  KEY `IDX_4A91B1C5FED90CCA` (`permission_id`),
  CONSTRAINT `FK_4A91B1C51ED93D47` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_4A91B1C5FED90CCA` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group_permission`
--

LOCK TABLES `user_group_permission` WRITE;
/*!40000 ALTER TABLE `user_group_permission` DISABLE KEYS */;
INSERT INTO `user_group_permission` VALUES (3,3),(3,4);
/*!40000 ALTER TABLE `user_group_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `college_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci,
  `midle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `affiliation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `has_complete_profile` tinyint(1) DEFAULT NULL,
  `education_level_id` int DEFAULT NULL,
  `academic_rank_id` int DEFAULT NULL,
  `alternative_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suffix_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_B1087D9EA76ED395` (`user_id`),
  KEY `IDX_B1087D9E770124B2` (`college_id`),
  KEY `IDX_B1087D9EAE80F5DF` (`department_id`),
  KEY `IDX_B1087D9ED7A5352E` (`education_level_id`),
  KEY `IDX_B1087D9EF398AD29` (`academic_rank_id`),
  KEY `IDX_B1087D9E5EF560BF` (`suffix_id`),
  CONSTRAINT `FK_B1087D9E5EF560BF` FOREIGN KEY (`suffix_id`) REFERENCES `suffixe` (`id`),
  CONSTRAINT `FK_B1087D9E770124B2` FOREIGN KEY (`college_id`) REFERENCES `college` (`id`),
  CONSTRAINT `FK_B1087D9EA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B1087D9EAE80F5DF` FOREIGN KEY (`department_id`) REFERENCES `department` (`id`),
  CONSTRAINT `FK_B1087D9ED7A5352E` FOREIGN KEY (`education_level_id`) REFERENCES `educational_level` (`id`),
  CONSTRAINT `FK_B1087D9EF398AD29` FOREIGN KEY (`academic_rank_id`) REFERENCES `academic_rank` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_info`
--

LOCK TABLES `user_info` WRITE;
/*!40000 ALTER TABLE `user_info` DISABLE KEYS */;
INSERT INTO `user_info` VALUES (3,11,NULL,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,11,2,4,NULL,'Aman','Legese','Firra','Female','Addis ababa',NULL,'50235e8b9abf10d15fcf0b2c8c7b87df.jpg',NULL,NULL,1,1,1,NULL,NULL),(5,11,2,8,'<p>evaluate whether the control group is appropriate,</p>','Balefoto','Balekezera','sebaaratDilkursu','Male','Addis ababa',NULL,'b84d0776ae7174a5352bcbe6a919b72e.jpg',NULL,NULL,1,1,1,NULL,NULL),(6,NULL,2,9,'','Aman','Yedirosew','',NULL,'Ambo University',NULL,'ab0b96640b2db2e1f68c2ee88da1ee67.jpg',NULL,NULL,1,NULL,NULL,NULL,NULL),(7,NULL,NULL,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,11,2,7,NULL,NULL,NULL,'Hena','Male',NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL),(9,11,2,10,NULL,'zeleke','Azalework','Henok','Male','Jimma University, Institute of Health, Department of Biomedical Sciences','+251948073409',NULL,NULL,NULL,1,1,1,'Jimma university',NULL),(10,11,2,13,'cgg','geta','wprku','Ahmed','Male','Jimma University, Institute of Health, Department of Biomedical Sciences','+251948073409',NULL,NULL,NULL,1,1,1,'Jimma university',NULL),(11,NULL,NULL,14,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(14,11,2,16,'SET FOREIGN_KEY_CHECKS=0;','Aman','Legese','Dsss','Male','Addis ababa dds','+251916780968','b43e7e43fc6cde20c260f3b84ee525de.jpg',NULL,NULL,1,1,1,NULL,NULL),(16,11,2,19,NULL,'zeleke','Azalework','Henok','Male','Jimma University, Institute of Health, Department of Biomedical Sciences','+251948073409',NULL,NULL,NULL,1,1,2,NULL,1),(17,11,2,20,NULL,'Chemir','Menegye','Hailu','Male','rty','+251913711665','9d4226c98110aa41e7d2a9ea0750736a.jpg',NULL,NULL,1,2,4,'hchemir@gmail.com',3),(18,11,2,21,'this is unknown bio\r\nHave you received mega project grants from health insist in the past 4 years?','Kedir','Nida','Esmael','Male','CS','+251932443364',NULL,NULL,NULL,1,2,4,'isma.kedir@gmail.com',3);
/*!40000 ALTER TABLE `user_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permission`
--

DROP TABLE IF EXISTS `user_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_permission` (
  `user_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `IDX_472E5446A76ED395` (`user_id`),
  KEY `IDX_472E5446FED90CCA` (`permission_id`),
  CONSTRAINT `FK_472E5446A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_472E5446FED90CCA` FOREIGN KEY (`permission_id`) REFERENCES `permission` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permission`
--

LOCK TABLES `user_permission` WRITE;
/*!40000 ALTER TABLE `user_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_user_group`
--

DROP TABLE IF EXISTS `user_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_user_group` (
  `user_id` int NOT NULL,
  `user_group_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`user_group_id`),
  KEY `IDX_28657971A76ED395` (`user_id`),
  KEY `IDX_286579711ED93D47` (`user_group_id`),
  CONSTRAINT `FK_286579711ED93D47` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_28657971A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_user_group`
--

LOCK TABLES `user_user_group` WRITE;
/*!40000 ALTER TABLE `user_user_group` DISABLE KEYS */;
INSERT INTO `user_user_group` VALUES (3,3),(4,3),(6,3),(7,3),(8,3),(9,3);
/*!40000 ALTER TABLE `user_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work_unit`
--

DROP TABLE IF EXISTS `work_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work_unit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `principal_contact` longtext COLLATE utf8mb4_unicode_ci,
  `identification_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mission` longtext COLLATE utf8mb4_unicode_ci,
  `objective` longtext COLLATE utf8mb4_unicode_ci,
  `prefix` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work_unit`
--

LOCK TABLES `work_unit` WRITE;
/*!40000 ALTER TABLE `work_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `work_unit` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-13 15:51:46
