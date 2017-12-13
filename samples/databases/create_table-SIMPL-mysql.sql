-- 日本語UTF-8, LF



SHOW DATABASES;
DROP DATABASE IF EXISTS `SIMPL-d__test`;
CREATE DATABASE `SIMPL-d__test` character set utf8;
GRANT SELECT ON `SIMPL-d__test`.* TO 'SIMPL-u__test__read'@'localhost';
GRANT SELECT, INSERT, UPDATE, DELETE ON `SIMPL-d__test`.* TO 'SIMPL-u__test__write'@'localhost';
FLUSH PRIVILEGES;
use `SIMPL-d__test`;
SHOW TABLES;



-- ===================================================================
-- sample
-- -------------------------------------------------------------------

DROP TABLE IF EXISTS `t__sample`;
CREATE TABLE `t__sample` 
( 
	`c__simpl_id` bigint(20) NOT NULL AUTO_INCREMENT, 
	`c__sample` text NOT NULL, 
	PRIMARY KEY ( `c__simpl_id` ) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SHOW CREATE TABLE `t__sample`\G
TRUNCATE TABLE `t__sample`;
INSERT INTO `t__sample` SET `c__simpl_id` = 1, `c__sample` = 'sample';
SELECT COUNT( * ) FROM `t__sample`;
SELECT * FROM `t__sample`;



