CREATE TABLE `players` (
  `id` decimal(30) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX index_name (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
