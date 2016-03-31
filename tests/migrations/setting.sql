SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (`name` varchar(255) NOT NULL, `value` text ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO `setting` (`name`, `value`) VALUES ('name_1', 'http://google.com'), ('name_2', '/path/to/some/directory'), ('name with spaces', 'de9f2c7fd25e1b3afad3e85a0bd17d9b100db4b3'), ('verylongnamhahahahahaha_banana_cucmber', 'The quick brown fox jumps over the lazy cog'), ('special#chars', '?…¬∆ˆ†∑∫˜∑∑ø∑˜˚˙∂˜'), ('0', 'Sun is shining in the sky'), ('name_4', 'Danger, Will Robinson!');
ALTER TABLE `setting` ADD PRIMARY KEY (`name`);
SET FOREIGN_KEY_CHECKS=1;