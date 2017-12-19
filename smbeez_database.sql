/*
Navicat MySQL Data Transfer

Source Server         : Laravel
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : smbeez_database

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2017-12-19 03:23:31
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `companies`
-- ----------------------------
DROP TABLE IF EXISTS `companies`;
CREATE TABLE `companies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_description` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_tagline` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `linkedin_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_size` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year_founded` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `companies_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of companies
-- ----------------------------
INSERT INTO `companies` VALUES ('1', 'Company 1', 'company-1', '1', 'Dasdasds', 'asdasdas', 'asdsadsa', 'asda@ddas.com', '5645645465', 'asdas', 'asdasda', '1-10', '21312', 'inc', '2312321', '2000-12-25', 'Cairo Governorate, Egypt', 'images/company/2017/12/1513520038_.png', 'images/company/2017/12/1513520039_.jpg', '1', null, '2017-12-17 14:13:59', '2017-12-17 14:13:59');
INSERT INTO `companies` VALUES ('2', 'asdas', 'asdas', '1', 'asdsad', 'asdsadsa', 'http://asdsa.com', 'asdas@asd.com', '12321312', 'http://asdsa.com', 'casd', '1-10', '213', 'llc', '2131', '2003-12-05', 'Cairo Festival City, Nasr City, Cairo Governorate, Egypt', 'images/company/2017/12/1513525591_.png', 'images/company/2017/12/1513525591_.jpg', '1', null, '2017-12-17 15:46:31', '2017-12-17 15:46:31');
INSERT INTO `companies` VALUES ('3', 'Company New', 'company-new', '1', 'asdsa', 'asdada', 'http://asdsa.com', 'hossam.struggler@hotmail.com', '123213', 'http://asdsa.com', 'sadsadsa', '1-10', '213', 'llc', '31231', '1993-12-05', 'Cairo Governorate, Egypt', 'images/company/2017/12/1513620069.jpg', null, '1', null, '2017-12-18 18:01:10', '2017-12-18 18:01:10');
INSERT INTO `companies` VALUES ('4', 'Company New', 'company-new-1', '1', 'asdsa', 'asdada', 'http://asdsa.com', 'hossam.struggler@hotmail.com', '123213', 'http://asdsa.com', 'sadsadsa', '1-10', '213', 'llc', '31231', '1993-12-05', 'Cairo Governorate, Egypt', 'images/company/2017/12/1513620203.jpg', null, '1', null, '2017-12-18 18:03:23', '2017-12-18 18:03:23');
INSERT INTO `companies` VALUES ('5', 'qwewq', 'qwewq', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620306.png', null, '1', null, '2017-12-18 18:05:06', '2017-12-18 18:05:06');
INSERT INTO `companies` VALUES ('6', 'qwewq', 'qwewq-1', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620345.png', null, '1', null, '2017-12-18 18:05:45', '2017-12-18 18:05:45');
INSERT INTO `companies` VALUES ('7', 'qwewq', 'qwewq-2', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620390.png', null, '1', null, '2017-12-18 18:06:31', '2017-12-18 18:06:31');
INSERT INTO `companies` VALUES ('8', 'qwewq', 'qwewq-3', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620406.png', null, '1', null, '2017-12-18 18:06:46', '2017-12-18 18:06:46');
INSERT INTO `companies` VALUES ('9', 'qwewq', 'qwewq-4', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620488.png', null, '1', null, '2017-12-18 18:08:08', '2017-12-18 18:08:08');
INSERT INTO `companies` VALUES ('10', 'qwewq', 'qwewq-5', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620563.png', null, '1', null, '2017-12-18 18:09:23', '2017-12-18 18:09:23');
INSERT INTO `companies` VALUES ('11', 'qwewq', 'qwewq-6', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620622.png', null, '1', null, '2017-12-18 18:10:23', '2017-12-18 18:10:23');
INSERT INTO `companies` VALUES ('12', 'qwewq', 'qwewq-7', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513620645.png', null, '1', null, '2017-12-18 18:10:45', '2017-12-18 18:10:45');
INSERT INTO `companies` VALUES ('13', 'qwewq', 'qwewq-8', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513621420.png', null, '1', null, '2017-12-18 18:23:40', '2017-12-18 18:23:40');
INSERT INTO `companies` VALUES ('14', 'qwewq', 'qwewq-9', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513621592.png', null, '1', null, '2017-12-18 18:26:33', '2017-12-18 18:26:33');
INSERT INTO `companies` VALUES ('15', 'qwewq', 'qwewq-10', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513621622.png', null, '1', null, '2017-12-18 18:27:02', '2017-12-18 18:27:02');
INSERT INTO `companies` VALUES ('16', 'qwewq', 'qwewq-11', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513621816.png', null, '1', null, '2017-12-18 18:30:16', '2017-12-18 18:30:16');
INSERT INTO `companies` VALUES ('17', 'qwewq', 'qwewq-12', '1', 'adasd', 'asdsad', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '12312', 'http://asdsa.com', 'sadas', '1-10', '123', 'llc', '12321', '1996-12-22', 'asdsadsad, Elyria, OH, United States', 'images/company/2017/12/1513621908.png', null, '1', null, '2017-12-18 18:31:48', '2017-12-18 18:31:48');
INSERT INTO `companies` VALUES ('18', 'adqwe', 'adqwe', '1', 'asdasd', 'awewqe', 'http://asdsa.com', 'hossam.ahmed@macksab.com', '123213', 'http://asdsa.com', 'asdasda', '10-20', '21321', 'llc', '12321321', '1993-12-25', 'asdasdas, Pedro Quintanar, Las Cumbres, Aguascalientes, Mexico', 'images/company/2017/12/1513622966.png', null, '1', null, '2017-12-18 18:49:26', '2017-12-18 18:49:26');
INSERT INTO `companies` VALUES ('19', 'asdasqw', 'asdasqw', '1', 'asdsad', 'awqewq', 'http://asdsa.com', 'hossam.struggler@hotmail.com', '123213', 'http://asdsa.com', 'asdsa', '1-10', '31232', 'llc', '1232', '1993-12-25', 'Cairo Governorate, Egypt', 'images/company/2017/12/1513635544.png', null, '1', null, '2017-12-18 22:19:04', '2017-12-18 22:19:04');

-- ----------------------------
-- Table structure for `company_industry`
-- ----------------------------
DROP TABLE IF EXISTS `company_industry`;
CREATE TABLE `company_industry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL,
  `industry_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of company_industry
-- ----------------------------
INSERT INTO `company_industry` VALUES ('1', '1', '3');
INSERT INTO `company_industry` VALUES ('2', '19', '7');

-- ----------------------------
-- Table structure for `industries`
-- ----------------------------
DROP TABLE IF EXISTS `industries`;
CREATE TABLE `industries` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `industry_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `industry_img_url` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of industries
-- ----------------------------
INSERT INTO `industries` VALUES ('1', 'Industry 1', 'industry-1', 'images/industry/2017/12/1513617735.jpg', '2017-12-18 17:22:15', '2017-12-18 17:22:15');
INSERT INTO `industries` VALUES ('2', 'Industry 1', 'industry-1-1', 'images/industry/2017/12/1513617957.jpg', '2017-12-18 17:25:57', '2017-12-18 17:25:57');
INSERT INTO `industries` VALUES ('3', 'Industry 2', 'industry-2', 'images/industry/2017/12/1513619124.png', '2017-12-18 17:45:25', '2017-12-18 17:45:25');
INSERT INTO `industries` VALUES ('4', 'Industry 3', 'industry-3', 'images/industry/2017/12/1513619300.jpg', '2017-12-18 17:48:20', '2017-12-18 17:48:20');
INSERT INTO `industries` VALUES ('5', 'Industry 4', 'industry-4', 'images/industry/2017/12/1513619316.png', '2017-12-18 17:48:36', '2017-12-18 17:48:36');
INSERT INTO `industries` VALUES ('6', 'Industry 5', 'industry-5', 'images/industry/2017/12/1513619330.jpg', '2017-12-18 17:48:50', '2017-12-18 17:48:50');
INSERT INTO `industries` VALUES ('7', 'Industry 6', 'industry-6', 'images/industry/2017/12/1513619344.png', '2017-12-18 17:49:04', '2017-12-18 17:49:04');

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('12', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('13', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('14', '2017_12_14_002140_laratrust_setup_tables', '1');
INSERT INTO `migrations` VALUES ('15', '2017_12_17_092437_create_companies_table', '1');
INSERT INTO `migrations` VALUES ('16', '2017_12_18_164305_create_industries_table', '2');

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `permission_role_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1');
INSERT INTO `permission_role` VALUES ('1', '2');
INSERT INTO `permission_role` VALUES ('2', '1');
INSERT INTO `permission_role` VALUES ('2', '2');
INSERT INTO `permission_role` VALUES ('3', '1');
INSERT INTO `permission_role` VALUES ('3', '2');
INSERT INTO `permission_role` VALUES ('4', '1');
INSERT INTO `permission_role` VALUES ('4', '2');
INSERT INTO `permission_role` VALUES ('5', '1');
INSERT INTO `permission_role` VALUES ('6', '1');
INSERT INTO `permission_role` VALUES ('7', '1');
INSERT INTO `permission_role` VALUES ('8', '1');
INSERT INTO `permission_role` VALUES ('9', '1');
INSERT INTO `permission_role` VALUES ('9', '2');
INSERT INTO `permission_role` VALUES ('9', '3');
INSERT INTO `permission_role` VALUES ('9', '4');
INSERT INTO `permission_role` VALUES ('10', '1');
INSERT INTO `permission_role` VALUES ('10', '2');
INSERT INTO `permission_role` VALUES ('10', '3');
INSERT INTO `permission_role` VALUES ('10', '4');
INSERT INTO `permission_role` VALUES ('11', '1');
INSERT INTO `permission_role` VALUES ('11', '2');
INSERT INTO `permission_role` VALUES ('11', '3');
INSERT INTO `permission_role` VALUES ('12', '1');
INSERT INTO `permission_role` VALUES ('12', '2');
INSERT INTO `permission_role` VALUES ('12', '3');
INSERT INTO `permission_role` VALUES ('13', '1');
INSERT INTO `permission_role` VALUES ('13', '2');
INSERT INTO `permission_role` VALUES ('13', '3');
INSERT INTO `permission_role` VALUES ('14', '1');
INSERT INTO `permission_role` VALUES ('14', '2');
INSERT INTO `permission_role` VALUES ('14', '3');
INSERT INTO `permission_role` VALUES ('15', '1');
INSERT INTO `permission_role` VALUES ('15', '2');
INSERT INTO `permission_role` VALUES ('15', '4');
INSERT INTO `permission_role` VALUES ('16', '1');
INSERT INTO `permission_role` VALUES ('16', '2');
INSERT INTO `permission_role` VALUES ('16', '3');
INSERT INTO `permission_role` VALUES ('16', '4');
INSERT INTO `permission_role` VALUES ('17', '1');
INSERT INTO `permission_role` VALUES ('17', '2');
INSERT INTO `permission_role` VALUES ('17', '3');
INSERT INTO `permission_role` VALUES ('17', '4');
INSERT INTO `permission_role` VALUES ('18', '1');
INSERT INTO `permission_role` VALUES ('18', '2');
INSERT INTO `permission_role` VALUES ('19', '3');
INSERT INTO `permission_role` VALUES ('19', '4');
INSERT INTO `permission_role` VALUES ('20', '3');
INSERT INTO `permission_role` VALUES ('20', '4');

-- ----------------------------
-- Table structure for `permission_user`
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user` (
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`,`user_type`),
  KEY `permission_user_permission_id_foreign` (`permission_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permission_user
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'create-users', 'Create Users', 'Create Users', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('2', 'read-users', 'Read Users', 'Read Users', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('3', 'update-users', 'Update Users', 'Update Users', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('4', 'delete-users', 'Delete Users', 'Delete Users', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('5', 'create-acl', 'Create Acl', 'Create Acl', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('6', 'read-acl', 'Read Acl', 'Read Acl', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('7', 'update-acl', 'Update Acl', 'Update Acl', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('8', 'delete-acl', 'Delete Acl', 'Delete Acl', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('9', 'read-profile', 'Read Profile', 'Read Profile', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('10', 'update-profile', 'Update Profile', 'Update Profile', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('11', 'create-project', 'Create Project', 'Create Project', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('12', 'read-project', 'Read Project', 'Read Project', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('13', 'update-project', 'Update Project', 'Update Project', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('14', 'delete-project', 'Delete Project', 'Delete Project', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('15', 'create-company', 'Create Company', 'Create Company', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('16', 'read-company', 'Read Company', 'Read Company', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('17', 'update-company', 'Update Company', 'Update Company', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('18', 'delete-company', 'Delete Company', 'Delete Company', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('19', 'create-review', 'Create Review', 'Create Review', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `permissions` VALUES ('20', 'read-review', 'Read Review', 'Read Review', '2017-12-17 10:36:50', '2017-12-17 10:36:50');

-- ----------------------------
-- Table structure for `project_industry`
-- ----------------------------
DROP TABLE IF EXISTS `project_industry`;
CREATE TABLE `project_industry` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `industry_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of project_industry
-- ----------------------------

-- ----------------------------
-- Table structure for `role_user`
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `user_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`,`user_type`),
  KEY `role_user_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES ('1', '1', 'App\\User');
INSERT INTO `role_user` VALUES ('2', '2', 'App\\User');
INSERT INTO `role_user` VALUES ('3', '3', 'App\\User');
INSERT INTO `role_user` VALUES ('4', '4', 'App\\User');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', 'superadmin', 'Superadmin', 'Superadmin', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `roles` VALUES ('2', 'administrator', 'Administrator', 'Administrator', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `roles` VALUES ('3', 'company', 'Company', 'Company', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `roles` VALUES ('4', 'user', 'User', 'User', '2017-12-17 10:36:50', '2017-12-17 10:36:50');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `honeycombs` int(11) DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Superadmin', null, 'superadmin@app.com', '$2y$10$uWEy0n5XCjMEQ2GcqAwA/efSRoyNmCRL9IWSr/SncRxxltLXCc63e', null, null, null, 'SRShmGnje2qq7i9k8N6n4w89WS3h6gbJyi1eOS08aEitFwPZwXEQPU7wr9zM', '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `users` VALUES ('2', 'Administrator', null, 'administrator@app.com', '$2y$10$f1wuIDKwgU.8zoiKiSM0PuSMl1n4eCgKkDwI9nNCdqiDN8prRylFy', null, null, null, null, '2017-12-17 10:36:49', '2017-12-17 10:36:49');
INSERT INTO `users` VALUES ('3', 'Company', null, 'company@app.com', '$2y$10$3rerQIO29hPdoJtdlOgrqO/JRhmWrIphBSHGFsJXwwSJQCobz8QQC', null, null, null, null, '2017-12-17 10:36:50', '2017-12-17 10:36:50');
INSERT INTO `users` VALUES ('4', 'User', null, 'user@app.com', '$2y$10$IPzqQImCx5ruBBArVc7xReP0lcLLREINjIjhLxn00h/Won/nMJf.u', null, null, null, 'BR9FO5Q0tuFoH0ri2LikfwjMjHa7PJMAjeUjw8uls31fE9bZOiGPJ1IpbrNt', '2017-12-17 10:36:50', '2017-12-17 10:36:50');
