SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE `tb_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `tb_images` (
  `id` int(11) NOT NULL,
  `image` longblob NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tb_like` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tb_users` (
  `id` int(11) NOT NULL,
  `email` varchar(125) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `reset` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `tb_users` (`id`, `email`, `pass`, `active`, `reset`) VALUES
(2, 'qwerty@yahoo.com', '$2y$10$B5mehrbdQLM6BNlvH7ntL.8dciXngR93DLwPIieIJ3lakB9/Z04b.', 1, 0)

ALTER TABLE `tb_comments`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tb_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tb_like`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `tb_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_like`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `tb_comments`
  ADD CONSTRAINT `tb_comments_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_comments_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `tb_images` (`id`) 
  ON DELETE CASCADE;
  
  ALTER TABLE `tb_like`
  ADD CONSTRAINT `tb_like_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `tb_users` (`id`) 
  ON DELETE CASCADE,
  ADD CONSTRAINT `tb_like_ibfk_2` 
  FOREIGN KEY (`image_id`) 
  REFERENCES `tb_images` (`id`) 
  ON DELETE CASCADE;

ALTER TABLE `tb_images`
  ADD CONSTRAINT `tb_images_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `tb_users` (`id`) 
  ON DELETE CASCADE;
 