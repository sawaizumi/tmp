-- 日本語UTF-8, LF



DROP USER IF EXISTS 'SIMPL-u__test__read'@'localhost';
DROP USER IF EXISTS 'SIMPL-u__test__write'@'localhost';
CREATE USER 'SIMPL-u__test__read'@'localhost';
CREATE USER 'SIMPL-u__test__write'@'localhost';
UPDATE `mysql`.`user` SET `authentication_string` = '*10112474CAA8F934A40E2716A612E966FF835226' WHERE `user` = 'SIMPL-u__test__read';
UPDATE `mysql`.`user` SET `authentication_string` = '*4663EB9E995A25843E48E836F6C2E614A73EC8B4' WHERE `user` = 'SIMPL-u__test__write';
FLUSH PRIVILEGES;

SELECT PASSWORD( 'SIMPL-p__test__read' );
SHOW GRANTS FOR 'SIMPL-u__test__read'@'localhost';
SELECT PASSWORD( 'SIMPL-p__test__write' );
SHOW GRANTS FOR 'SIMPL-u__test__write'@'localhost';
SELECT `user`, `host`, `authentication_string` FROM `mysql`.`user`;



