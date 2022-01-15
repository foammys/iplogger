CREATE TABLE `banned` (
  `id` int(255) NOT NULL,
  `ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ip_logger` (
  `identify` int(12) NOT NULL,
  `id` varchar(128) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `system` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `user_agent` mediumtext NOT NULL,
  `date` varchar(128) NOT NULL,
  `proxy` varchar(128) NOT NULL,
  `isp` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `banned`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `banned`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
