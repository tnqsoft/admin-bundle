/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.13-MariaDB : Database - lab3
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lab3` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `lab3`;

/*Table structure for table `banner` */

DROP TABLE IF EXISTS `banner`;

CREATE TABLE `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT '#',
  `target` varchar(255) COLLATE utf8_unicode_ci DEFAULT '_self',
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `banner` */

insert  into `banner`(`id`,`position`,`picture`,`ordering`,`url`,`target`,`is_active`,`created_at`,`updated_at`) values (1,'banner-top','7351980238abfbb55323958de586292fdcd4427d.jpeg',3,'#','_self',1,'2016-05-14 09:15:50','2016-06-28 21:25:42'),(2,'banner-top','630e0d4f24ddfc91e927d9191f856e7bdce784f0.jpeg',1,'#','_self',1,'2016-05-14 09:18:01','2016-06-28 21:24:20'),(3,'banner-top','b7984fea2f73993cde1a7a6f782989d27e7865ec.jpeg',2,'#','_self',1,'2016-05-14 09:19:09','2016-06-28 21:25:12'),(5,'banner-top','be96d1f81b4001a955f583a4601f50209b75040f.jpeg',4,'#','_self',1,'2016-06-28 21:26:21',NULL),(6,'banner-top','b672e473860ada137f58f00a075e17af636a0304.jpeg',5,'#','_self',1,'2016-06-28 21:26:32',NULL);

/*Table structure for table `ext_log_entries` */

DROP TABLE IF EXISTS `ext_log_entries`;

CREATE TABLE `ext_log_entries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` datetime NOT NULL,
  `object_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `version` int(11) NOT NULL,
  `data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_class_lookup_idx` (`object_class`),
  KEY `log_date_lookup_idx` (`logged_at`),
  KEY `log_user_lookup_idx` (`username`),
  KEY `log_version_lookup_idx` (`object_id`,`object_class`,`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ext_log_entries` */

/*Table structure for table `ext_translations` */

DROP TABLE IF EXISTS `ext_translations`;

CREATE TABLE `ext_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `locale` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `object_class` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `lookup_unique_idx` (`locale`,`object_class`,`field`,`foreign_key`),
  KEY `translations_lookup_idx` (`locale`,`object_class`,`foreign_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `ext_translations` */

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lft` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `router_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parameters` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_7D053A9379066886` (`root_id`),
  KEY `IDX_7D053A93727ACA70` (`parent_id`),
  CONSTRAINT `FK_7D053A93727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_7D053A9379066886` FOREIGN KEY (`root_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `menu` */

insert  into `menu`(`id`,`root_id`,`parent_id`,`title`,`lft`,`lvl`,`rgt`,`is_active`,`created_at`,`updated_at`,`router_name`,`parameters`) values (1,1,NULL,'Sản phẩm',1,0,14,1,'2016-06-30 17:47:27',NULL,NULL,NULL),(2,2,NULL,'Giới thiệu',15,0,16,1,'2016-06-30 17:48:05','2016-06-30 17:56:55','frontend_page_detail','{\"slug\": \"gioi-thieu\"}'),(3,3,NULL,'Tin tức',17,0,18,1,'2016-06-30 17:48:54','2016-06-30 17:56:55','frontend_news_category','{\"slug\": \"tin-tuc-hoat-dong\"}'),(4,4,NULL,'Tuyển dụng',19,0,20,1,'2016-06-30 17:49:23','2016-06-30 17:56:55','frontend_news_category','{\"slug\": \"tuyen-dung\"}'),(5,5,NULL,'Liên hệ',21,0,22,1,'2016-06-30 17:49:41','2016-06-30 17:56:55','frontend_contact',NULL),(6,1,1,'Sản phẩm Inox',2,1,3,1,'2016-06-30 17:51:23',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"san-pham-inox\"}'),(7,1,1,'Sản phẩm sắt',4,1,5,1,'2016-06-30 17:51:59',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"san-pham-sat\"}'),(8,1,1,'Nhôm kính',6,1,7,1,'2016-06-30 17:53:13',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"nhom-kinh\"}'),(9,1,1,'Giếng trời thông minh',8,1,9,1,'2016-06-30 17:53:42',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"gieng-troi-thong-minh\"}'),(10,1,1,'Mái nhựa thông minh',10,1,11,1,'2016-06-30 17:54:04',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"mai-nhua-thong-minh\"}'),(11,1,1,'Sắt mỹ thuật gia dụng',12,1,13,1,'2016-06-30 17:54:37',NULL,'frontend_product_list_level1','{\"categoryParentSlug\": \"sat-my-thuat-gia-dung\"}');

/*Table structure for table `news` */

DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1DD39950989D9B62` (`slug`),
  KEY `IDX_1DD3995012469DE2` (`category_id`),
  CONSTRAINT `FK_1DD3995012469DE2` FOREIGN KEY (`category_id`) REFERENCES `news_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `news` */

insert  into `news`(`id`,`category_id`,`slug`,`title`,`summary`,`content`,`is_active`,`created_at`,`updated_at`,`thumb`) values (1,2,'tin-tuc-1','Tin tức 1','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p style=\"color: rgb(51, 51, 51);\">Hoil là con út trong gia đình có ba anh chị em. Lớn lên tại Yucatan (Mexico), anh thường xuyên phụ giúp mẹ nấu nướng. Bà là một đầu bếp tuyệt vời và rất khắt khe trong việc lựa chọn nguyên liệu. Khi còn nhỏ, Hoil từng rất ghét việc bị bắt quay trở lại cánh đồng để tìm quả cà chua tươi hơn. Tuy nhiên, giờ anh nhận thấy điều này đã giúp ích cho việc kinh doanh của mình rất nhiều.</p><p style=\"color: rgb(51, 51, 51);\">Sự tươi ngon đã trở thành triết lý kinh doanh của Distric Taco. \"Khả năng lựa chọn thực phẩm chính là những gì tôi học được. Bởi mẹ tôi luôn bắt tôi quay trở lại trang trại để chọn các loại rau củ tươi cho bà nấu nướng\", Holi cho biết.</p><p style=\"color: rgb(51, 51, 51);\">Hoil là con út trong gia đình có ba anh chị em. Lớn lên tại Yucatan (<b>Mexico</b>), anh thường xuyên phụ giúp mẹ nấu nướng. Bà là một đầu bếp tuyệt vời và rất khắt khe trong việc lựa chọn nguyên liệu. Khi còn nhỏ, Hoil từng rất ghét việc bị bắt quay trở lại cánh đồng để tìm quả cà chua tươi hơn. Tuy nhiên, giờ anh nhận thấy điều này đã giúp ích cho việc kinh doanh của mình rất nhiều.</p><p style=\"color: rgb(51, 51, 51);\">Sự tươi ngon đã trở thành triết lý kinh doanh của Distric Taco. \"Khả năng lựa chọn thực phẩm chính là những gì tôi học được. Bởi mẹ tôi luôn bắt tôi quay trở lại trang trại để chọn các loại rau củ tươi cho bà nấu nướng\", Holi cho biết.</p><p style=\"color: rgb(51, 51, 51);\">Hoil là con út trong gia đình có ba anh chị em. Lớn lên tại Yucatan (Mexico), anh thường xuyên phụ giúp mẹ nấu nướng. Bà là một đầu bếp tuyệt vời và rất khắt khe trong việc lựa chọn nguyên liệu. Khi còn nhỏ, Hoil từng rất ghét việc bị bắt quay trở lại cánh đồng để tìm quả cà chua tươi hơn. Tuy nhiên, giờ anh nhận thấy điều này đã giúp ích cho việc kinh doanh của mình rất nhiều.</p><p style=\"color: rgb(51, 51, 51);\">Sự tươi ngon đã trở thành triết lý kinh doanh của Distric Taco. \"Khả năng lựa chọn thực phẩm chính là những gì tôi học được. Bởi mẹ tôi luôn bắt tôi quay trở lại trang trại để chọn các loại rau củ tươi cho bà nấu nướng\", Holi cho biết.</p><p style=\"color: rgb(51, 51, 51);\">Hoil là con út trong gia đình có ba anh chị em. Lớn lên tại Yucatan (Mexico), anh thường xuyên phụ giúp mẹ nấu nướng. Bà là một đầu bếp tuyệt vời và rất khắt khe trong việc lựa chọn nguyên liệu. Khi còn nhỏ, Hoil từng rất ghét việc bị bắt quay trở lại cánh đồng để tìm quả cà chua tươi hơn. Tuy nhiên, giờ anh nhận thấy điều này đã giúp ích cho việc kinh doanh của mình rất nhiều.</p><p style=\"color: rgb(51, 51, 51);\">Sự tươi ngon đã trở thành triết lý kinh doanh của Distric Taco. \"Khả năng lựa chọn thực phẩm chính là những gì tôi học được. Bởi mẹ tôi luôn bắt tôi quay trở lại trang trại để chọn các loại rau củ tươi cho bà nấu nướng\", Holi cho biết.</p>',1,'2016-04-09 04:28:13','2016-06-29 10:37:23','babc33cc89d0ea922353e51e93e85125feb3af59.jpeg'),(2,2,'tin-tuc-2','Tin tức 2','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</span><br></p>',1,'2016-04-09 04:29:25','2016-06-29 10:34:50','5051b559f5e142680255d2075c8ced7a3001939c.jpeg'),(3,2,'tin-tuc-3','Tin tức 3','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.<br></p>',1,'2016-06-29 10:37:47',NULL,'865ca4e2576dbc363d6f111a8ea8a93c26bc39ed.jpeg'),(4,2,'tin-tuc-4','Tin tức 4','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.<br></p>',1,'2016-06-29 10:38:46',NULL,'0cc33168c2805366449f7edbacb8d0bf0c208739.jpeg'),(5,2,'tin-tuc-5','Tin tức 5','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.<br></p>',1,'2016-06-29 10:39:07',NULL,'34fe16618963ba958830e5715c650296c0ee4de2.jpeg'),(6,2,'tin-tuc-6','Tin tức 6','The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.<br></p>',1,'2016-06-29 10:39:27',NULL,'2dfe806559bfc8ea819e26916723b7353009908b.jpeg');

/*Table structure for table `news_category` */

DROP TABLE IF EXISTS `news_category`;

CREATE TABLE `news_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `meta_keywords` mediumtext COLLATE utf8_unicode_ci,
  `meta_description` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4F72BA90989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `news_category` */

insert  into `news_category`(`id`,`slug`,`title`,`is_active`,`created_at`,`updated_at`,`meta_keywords`,`meta_description`) values (2,'tin-tuc-hoat-dong','Tin tức hoạt động',1,'2016-04-07 18:16:41','2016-06-29 15:36:41',NULL,'Tin tức hoạt động của công ty được tổng hợp tại chuyên mục này.'),(3,'tuyen-dung','Tuyển dụng',1,'2016-06-29 11:50:12',NULL,NULL,NULL);

/*Table structure for table `pages` */

DROP TABLE IF EXISTS `pages`;

CREATE TABLE `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2074E575989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `pages` */

insert  into `pages`(`id`,`slug`,`title`,`content`,`is_active`,`created_at`,`updated_at`) values (1,'gioi-thieu','Giới thiệu','<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p><p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br></p>',1,'2016-04-07 16:06:50','2016-06-29 11:47:03'),(2,'dich-vu','Dịch vụ','<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>',1,'2016-05-09 18:55:52','2016-06-29 11:48:09'),(5,'chinh-sach-bao-mat','Chính sách bảo mật','<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>',1,'2016-05-09 18:58:46','2016-06-29 11:56:52'),(6,'dieu-khoan-dich-vu','Điều khoản dịch vụ','<p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.</p><p style=\"margin-bottom: 15px; padding: 0px; text-align: justify; font-family: \'Open Sans\', Arial, sans-serif;\">The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>',1,'2016-05-09 19:00:19','2016-06-29 11:55:45'),(7,'thu-ngo','Thư Ngỏ','<p>Chuyên thiết kế tư vấn và thi công các sản phẩm cơ khí. Với phương trâm an toàn, chất lượng và tiến độ thiết kế gia công của sản phẩm.<br></p>',1,'2016-06-28 21:37:23',NULL);

/*Table structure for table `partner` */

DROP TABLE IF EXISTS `partner`;

CREATE TABLE `partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partner` */

insert  into `partner`(`id`,`name`,`url`,`description`,`picture`,`is_active`,`created_at`,`updated_at`) values (17,'Cơ Khí Trọng Tín','http://cokhitrongtin.vn',NULL,NULL,1,'2016-06-28 21:59:23',NULL);

/*Table structure for table `photo` */

DROP TABLE IF EXISTS `photo`;

CREATE TABLE `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_14B7841812469DE2` (`category_id`),
  CONSTRAINT `FK_14B7841812469DE2` FOREIGN KEY (`category_id`) REFERENCES `photo_category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `photo` */

insert  into `photo`(`id`,`category_id`,`title`,`picture`,`is_active`,`created_at`,`updated_at`,`is_default`) values (2,1,'Thi công 2','bf95b48af0b80643d44681fd6cad5ea4be227a21.jpeg',1,'2016-04-09 05:00:00','2016-06-29 09:44:37',1),(3,2,'Thi công Văn Lê A','fabdf2d3d445d89ca883a98055b11cafffb70031.jpeg',1,'2016-04-09 05:20:54','2016-06-29 09:44:07',1),(5,3,'Title','fd8f2d078d00f1cf4c825858fee0139d1ac3b5f6.jpeg',1,'2016-06-29 09:47:47',NULL,1),(6,4,'Title','9f7313392aba5ef98e11adc1a793901393fc4a80.jpeg',1,'2016-06-29 09:48:10',NULL,1),(7,5,'Title','ef7cc86f9d84b5a0af92e191d1c63310f5729d1b.jpeg',1,'2016-06-29 09:48:29',NULL,1),(8,6,'Title','ff9b5da473a8da3cbe681d40ca9f354fb0f9b38e.jpeg',1,'2016-06-29 09:48:45',NULL,1),(9,7,'Title','67c82f4c74b6b7b42315690badda28d45de0050b.jpeg',1,'2016-06-29 09:49:03',NULL,1),(10,8,'Title','c25fa5f904b9ea77e154e20cf2ae962431cd9bd1.jpeg',1,'2016-06-29 09:49:21',NULL,1);

/*Table structure for table `photo_category` */

DROP TABLE IF EXISTS `photo_category`;

CREATE TABLE `photo_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `summary` mediumtext COLLATE utf8_unicode_ci,
  `meta_keywords` mediumtext COLLATE utf8_unicode_ci,
  `meta_description` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9570064B989D9B62` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `photo_category` */

insert  into `photo_category`(`id`,`slug`,`title`,`is_active`,`created_at`,`updated_at`,`summary`,`meta_keywords`,`meta_description`) values (1,'nha-chung-cu-van-quan','Nhà chung cư Văn Quán',1,'2016-04-09 04:52:33',NULL,NULL,NULL,NULL),(2,'can-ho-lien-ke-la-khe','Căn hộ liền kề La Khê A A',1,'2016-04-09 04:53:03','2016-05-10 08:43:41','<p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Tôi tham khảo trên mạng thấy nói rau mồng tơi có thể giâm bằng cành. Các anh chị hướng dẫn giúp tôi cách chăm như thế nào để cành mau bén rễ.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Việc trồng rau mồng tơi trong thùng xốp có gì cần lưu ý không? Tôi có cần làm giàn, bón phân cho cây không? Tôi xin cảm ơn.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Tôi tham khảo trên mạng thấy nói rau mồng tơi có thể giâm bằng cành. Các anh chị hướng dẫn giúp tôi cách chăm như thế nào để cành mau bén rễ.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Việc trồng rau mồng tơi trong thùng xốp có gì cần lưu ý không? Tôi có cần làm giàn, bón phân cho cây không? Tôi xin cảm ơn.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Tôi tham khảo trên mạng thấy nói rau mồng tơi có thể giâm bằng cành. Các anh chị hướng dẫn giúp tôi cách chăm như thế nào để cành mau bén rễ.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Việc trồng rau mồng tơi trong thùng xốp có gì cần lưu ý không? Tôi có cần làm giàn, bón phân cho cây không? Tôi xin cảm ơn.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Tôi tham khảo trên mạng thấy nói rau mồng tơi có thể giâm bằng cành. Các anh chị hướng dẫn giúp tôi cách chăm như thế nào để cành mau bén rễ.</p><p class=\"Normal\" style=\"margin-bottom: 1em; padding: 0px; line-height: 18px; text-rendering: geometricPrecision; color: rgb(51, 51, 51); font-family: arial;\">Việc trồng rau mồng tơi trong thùng xốp có gì cần lưu ý không? Tôi có cần làm giàn, bón phân cho cây không? Tôi xin cảm ơn.</p>','xxxx','yyyy'),(3,'du-an-demo-3','Dự án demo 3',1,'2016-06-29 09:47:47',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL),(4,'du-an-demo-4','Dự án demo 4',1,'2016-06-29 09:48:10',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL),(5,'du-an-demo-5','Dự án demo 5',1,'2016-06-29 09:48:29',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL),(6,'du-an-demo-6','Dự án demo 6',1,'2016-06-29 09:48:45',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL),(7,'du-an-demo-7','Dự án demo 7',1,'2016-06-29 09:49:03',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL),(8,'du-an-demo-8','Dự án demo 8',1,'2016-06-29 09:49:21',NULL,'<p><strong style=\"margin: 0px; padding: 0px; font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">Lorem Ipsum</strong><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><br></p>',NULL,NULL);

/*Table structure for table `product` */

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `upc` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Universal Product Code',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `summary` mediumtext COLLATE utf8_unicode_ci,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `out_of_stock` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `view_number` int(11) DEFAULT '0',
  `is_new` tinyint(1) NOT NULL,
  `is_special` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D34A04AD56FF3ABD` (`upc`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  KEY `IDX_D34A04AD9393F8FE` (`partner_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`),
  CONSTRAINT `FK_D34A04AD9393F8FE` FOREIGN KEY (`partner_id`) REFERENCES `partner` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product` */

insert  into `product`(`id`,`category_id`,`partner_id`,`upc`,`title`,`summary`,`content`,`price`,`out_of_stock`,`is_active`,`created_at`,`updated_at`,`view_number`,`is_new`,`is_special`) values (5,29,17,'sp01','Sản phẩm 1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p><span style=\"font-family: \'Open Sans\', Arial, sans-serif; text-align: justify;\">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</span><br></p>',1000000.00,1,1,'2016-06-29 11:22:20','2016-07-12 23:51:43',NULL,0,0),(6,29,17,'sp02','Sản phẩm 2','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>',0.00,1,1,'2016-06-29 11:23:24','2016-07-12 23:51:43',2,0,0),(7,29,17,'sp03','Sản phẩm 3','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>',500000.00,1,1,'2016-06-29 11:25:10','2016-07-12 23:43:09',4,0,0),(8,38,17,'sp04','Sản phẩm 4','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>',2000000.00,1,0,'2016-06-29 11:26:14','2016-07-10 14:02:00',NULL,0,0),(9,38,17,'sp05','Sản phẩm 5','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>',1500000.00,1,0,'2016-06-29 11:26:47','2016-07-10 14:02:00',5,0,0),(10,21,17,'sp06','Sản phẩm 6','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.','<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br></p>',1000000.00,1,1,'2016-06-29 11:29:42','2016-07-12 23:43:09',2,1,1);

/*Table structure for table `product_category` */

DROP TABLE IF EXISTS `product_category`;

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `root_id` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lft` int(11) NOT NULL,
  `lvl` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `meta_keywords` mediumtext COLLATE utf8_unicode_ci,
  `meta_description` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_CDFC7356989D9B62` (`slug`),
  KEY `IDX_CDFC735679066886` (`root_id`),
  KEY `IDX_CDFC7356727ACA70` (`parent_id`),
  CONSTRAINT `FK_CDFC7356727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_CDFC735679066886` FOREIGN KEY (`root_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_category` */

insert  into `product_category`(`id`,`root_id`,`parent_id`,`slug`,`title`,`lft`,`lvl`,`rgt`,`picture`,`is_active`,`created_at`,`updated_at`,`meta_keywords`,`meta_description`) values (19,19,NULL,'san-pham-inox','Sản phẩm Inox',1,0,14,'d70ab09ca4109259d80dcb142863059d9455d918.jpeg',1,'2016-06-28 22:04:55',NULL,NULL,'Chuyên cung cấp các sản phẩm Inox chất lượng.'),(20,19,19,'cua-inox','Cửa Inox',2,1,3,NULL,1,'2016-06-28 22:05:17',NULL,NULL,NULL),(21,19,19,'cau-thang-inox','Cầu thang Inox',4,1,5,NULL,1,'2016-06-28 22:05:36',NULL,NULL,NULL),(22,19,19,'cong-inox','Cổng Inox',6,1,7,NULL,1,'2016-06-28 22:06:20',NULL,NULL,NULL),(23,19,19,'hang-rao-inox','Hàng rào Inox',8,1,9,NULL,1,'2016-06-28 22:06:36',NULL,NULL,NULL),(24,19,19,'lan-can-inox','Lan Can Inox',10,1,11,NULL,1,'2016-06-28 22:06:52',NULL,NULL,NULL),(25,19,19,'xen-hoa-cua-so-inox','Xen hoa cửa sổ Inox',12,1,13,NULL,1,'2016-06-28 22:07:27',NULL,NULL,NULL),(26,26,NULL,'san-pham-sat','Sản phẩm sắt',1,0,14,'14300b924a6574ad7064b62ef7cbb7b031ffeb5f.jpeg',1,'2016-06-28 22:07:49','2016-06-28 22:13:34',NULL,NULL),(27,26,26,'cua-sat','Cửa sắt',2,1,3,NULL,1,'2016-06-28 22:08:07',NULL,NULL,NULL),(28,26,26,'cau-thang-sat','Cầu thang sắt',4,1,5,NULL,1,'2016-06-28 22:08:26',NULL,NULL,NULL),(29,26,26,'cong-sat','Cổng sắt',6,1,7,NULL,1,'2016-06-28 22:08:44',NULL,NULL,NULL),(30,26,26,'hang-rao-sat','Hàng rào sắt',8,1,9,NULL,1,'2016-06-28 22:09:01',NULL,NULL,NULL),(31,26,26,'lan-can-sat','Lan Can sắt',10,1,11,NULL,1,'2016-06-28 22:09:39',NULL,NULL,NULL),(32,26,26,'xen-hoa-cua-so-sat','Xen hoa cửa sổ sắt',12,1,13,NULL,1,'2016-06-28 22:10:00',NULL,NULL,NULL),(33,33,NULL,'nhom-kinh','Nhôm kính',1,0,4,'9e07b6b4462d96c389a089735880276c7acb7c48.jpeg',1,'2016-06-28 22:10:45',NULL,NULL,NULL),(34,33,33,'cua-nhom','Cửa nhôm',2,1,3,NULL,1,'2016-06-28 22:11:05',NULL,NULL,NULL),(35,35,NULL,'gieng-troi-thong-minh','Giếng trời thông minh',1,0,2,'519ffed8fede12808490803bad1e43fc65076244.jpeg',1,'2016-06-28 22:12:04',NULL,NULL,NULL),(36,36,NULL,'mai-nhua-thong-minh','Mái nhựa thông minh',1,0,2,'01a3be1d8bcf7bbe8892ce04bf2b6f699c3bd2da.jpeg',1,'2016-06-28 22:12:21',NULL,NULL,NULL),(37,37,NULL,'sat-my-thuat-gia-dung','Sắt mỹ thuật gia dụng',1,0,4,'6d68d979a8e321a30a01f3ce2eb68e318fa2f5ba.jpeg',1,'2016-06-28 22:12:44',NULL,NULL,NULL),(38,37,37,'ban-sat-my-thuat','Bàn sắt mỹ thuật',2,1,3,NULL,1,'2016-06-29 11:32:52',NULL,NULL,NULL);

/*Table structure for table `product_img` */

DROP TABLE IF EXISTS `product_img`;

CREATE TABLE `product_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5BED9CB34584665A` (`product_id`),
  CONSTRAINT `FK_5BED9CB34584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_img` */

insert  into `product_img`(`id`,`product_id`,`title`,`picture`,`is_default`,`is_active`,`created_at`,`updated_at`) values (1,5,'Title','4fe2c315e10ed6152ef137a00d3f5a6be512e9a4.jpeg',1,1,'2016-06-29 11:22:20',NULL),(2,5,'Title','ec6099538b91df40ed1b5438404b4b9707130c83.jpeg',0,1,'2016-06-29 11:22:20',NULL),(3,6,'Title','a267bfdf33aecf2ea6b0b6d3dcad2fc915d890ca.jpeg',1,1,'2016-06-29 11:23:24',NULL),(4,7,'Title','3de33b9b5f169cafef4c899521609c6393bad288.jpeg',0,1,'2016-06-29 11:25:10',NULL),(5,7,'Title','273adda99c20d6819b9f0eef846ba1791ad80852.jpeg',1,1,'2016-06-29 11:25:10',NULL),(6,8,'Title','c090ac2a23aacbb5a5c02814cd72c49fd283b4f8.jpeg',1,1,'2016-06-29 11:26:14','2016-06-29 11:30:04'),(7,8,'Title','30176bbd5af01a645d675ec73193a9bc26307e27.jpeg',0,1,'2016-06-29 11:26:14',NULL),(8,9,'Title','174f54dc0ab2da51ed42631c0781819810c25c8a.jpeg',1,1,'2016-06-29 11:26:47',NULL),(9,10,'Title','e719ddb0b238f3ece13786a4849d04f731478b08.jpeg',1,1,'2016-06-29 11:29:42',NULL),(10,10,'Title','3a9205beadaeb105f5346455774552813e87904d.jpeg',0,1,'2016-06-29 11:29:42',NULL),(11,10,'Title','c3162957bbef96e5e5bd08e694cde20c981e66d6.jpeg',0,1,'2016-06-29 11:29:42',NULL);

/*Table structure for table `product_sale` */

DROP TABLE IF EXISTS `product_sale`;

CREATE TABLE `product_sale` (
  `product_id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`,`sale_id`),
  KEY `IDX_68A3E2A44584665A` (`product_id`),
  KEY `IDX_68A3E2A44A7E4868` (`sale_id`),
  CONSTRAINT `FK_68A3E2A44584665A` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_68A3E2A44A7E4868` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `product_sale` */

insert  into `product_sale`(`product_id`,`sale_id`) values (10,1);

/*Table structure for table `sale` */

DROP TABLE IF EXISTS `sale`;

CREATE TABLE `sale` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percentage` int(11) NOT NULL,
  `begin_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sale` */

insert  into `sale`(`id`,`title`,`percentage`,`begin_date`,`end_date`,`description`,`created_at`,`updated_at`,`is_active`) values (1,'Khuyễn mại mùa hè',10,'2016-07-11 22:40:00','2016-07-17 22:40:00','<p>Khuyến mại dịp mùa hè.</p>','2016-07-11 22:42:43','2016-07-13 00:06:09',1);

/*Table structure for table `testimonial` */

DROP TABLE IF EXISTS `testimonial`;

CREATE TABLE `testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jobtitle` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `message` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `picture` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `testimonial` */

insert  into `testimonial`(`id`,`firstname`,`lastname`,`jobtitle`,`company`,`message`,`picture`,`is_active`,`created_at`,`updated_at`) values (1,'Nguyễn','Văn Gái','Công nhân','TNHH ABC','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','008445fc846bd558783e700bee5be38707ebd90f.jpeg',1,'2016-04-09 09:27:12','2016-06-29 10:52:27'),(2,'Lý','Tử Long','Diễn Viên','Hollywood','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','33b48039b117d7d5db3ea40d44e6c15213306ecf.jpeg',1,'2016-04-09 09:29:38','2016-06-29 10:53:33'),(3,'Nguyễn','Văn Test 1','Tự do',NULL,'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','becc90a1b4fd7041cf19b9ef581f8563dc383086.jpeg',1,'2016-06-29 11:07:16',NULL),(4,'Nguyễn','Văn Test 2','Tự do',NULL,'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','8a26330e54c878ee6a6f542b632c9714b7b3ff26.jpeg',1,'2016-06-29 11:07:39',NULL),(5,'Nguyễn','Văn Test 3','Kế toán',NULL,'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','9eeef0c0cd4a1dd200b85ca245a2e1b57bc0fd36.jpeg',1,'2016-06-29 11:07:59',NULL),(6,'Nguyễn','Văn Test 4','Võ Sĩ',NULL,'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.','351ce8989fbe58e35066dea9a3cd6ba7dbdc161f.jpeg',1,'2016-06-29 11:08:30',NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`username`,`password`,`email`,`is_active`,`created_at`,`updated_at`) values (1,'admin','$2y$13$/ahp6XbT1a13OeS/6ekE/.urmkHXZwQunw3JmLkY/df784maQlTma','tuanquynh0508@gmail.com',1,'2016-06-28 20:43:45',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
