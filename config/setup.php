<?php
if (readline ("verify: ") == "qwertybase") {
    include_once("database.php");

    try {
        $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->query("DROP TABLE IF EXISTS `tb_comments`, `tb_like`, `tb_images`, `tb_users`;");
        $pdo->query("DROP DATABASE IF EXISTS db_camagru;");
        $pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru;");
        $pdo->query("
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


CREATE TABLE `db_camagru`.`tb_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `db_camagru`.`tb_images` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_camagru`.`tb_like` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_camagru`.`tb_users` (
  `id` int(11) NOT NULL,
  `email` varchar(125) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `reset` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `db_camagru`.`tb_users` (`id`, `email`, `pass`, `active`, `reset`) VALUES
(2, 'qwerty@yahoo.com', '$2y$10$B5mehrbdQLM6BNlvH7ntL.8dciXngR93DLwPIieIJ3lakB9/Z04b.', 1, 0);

ALTER TABLE `db_camagru`.`tb_comments`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `db_camagru`.`tb_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `db_camagru`.`tb_like`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `db_camagru`.`tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `db_camagru`.`tb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_comments`
  ADD CONSTRAINT `tb_comments_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_comments_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `db_camagru`.`tb_images` (`id`) 
  ON DELETE CASCADE;
  
  ALTER TABLE `db_camagru`.`tb_like`
  ADD CONSTRAINT `tb_like_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_like_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `db_camagru`.`tb_images` (`id`) 
  ON DELETE CASCADE;

ALTER TABLE `db_camagru`.`tb_images`
  ADD CONSTRAINT `tb_images_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE;");
    } catch (PDOException $e) {
        try {
            $pdo = new PDO($DB_DS, $DB_USER, $DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->query("CREATE DATABASE IF NOT EXISTS db_camagru;");
            $pdo->query("
SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";
SET time_zone = \"+00:00\";


CREATE TABLE `db_camagru`.`tb_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `db_camagru`.`tb_images` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_camagru`.`tb_like` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `db_camagru`.`tb_users` (
  `id` int(11) NOT NULL,
  `email` varchar(125) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `reset` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `db_camagru`.`tb_users` (`id`, `email`, `pass`, `active`, `reset`) VALUES
(2, 'qwerty@yahoo.com', '$2y$10$B5mehrbdQLM6BNlvH7ntL.8dciXngR93DLwPIieIJ3lakB9/Z04b.', 1, 0);

ALTER TABLE `db_camagru`.`tb_comments`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `db_camagru`.`tb_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `db_camagru`.`tb_like`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `db_camagru`.`tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `db_camagru`.`tb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `db_camagru`.`tb_comments`
  ADD CONSTRAINT `tb_comments_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_comments_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `db_camagru`.`tb_images` (`id`) 
  ON DELETE CASCADE;
  
  ALTER TABLE `db_camagru`.`tb_like`
  ADD CONSTRAINT `tb_like_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_like_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `db_camagru`.`tb_images` (`id`) 
  ON DELETE CASCADE;

ALTER TABLE `db_camagru`.`tb_images`
  ADD CONSTRAINT `tb_images_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `db_camagru`.`tb_users` (`id`) 
  ON DELETE CASCADE;");
        } catch (PDOException $e) {
            echo "setup failure\n";
            echo $e->getMessage();
        }
    }
}