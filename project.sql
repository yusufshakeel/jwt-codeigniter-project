CREATE DATABASE mysql_proj_db;

USE mysql_proj_db;

CREATE TABLE `user` (
  `id` varchar(64) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `lastmodified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `user` (`id`, `email`, `password`, `firstname`, `lastname`, `lastmodified`, `created`) VALUES
('15236424895340', 'yusufshakeel@example.com', '$2y$12$3PfY4lNCR62/HH9aNGZFcebloX1gACQIbWeHfTwb8hKhMXfymiNLq', 'Yusuf', 'Shakeel', '2018-04-13 23:31:29', '2018-04-13 23:31:29');