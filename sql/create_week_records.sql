CREATE TABLE `week_records` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `week_id` int(11) NOT NULL,
  `idol_id` int(11) NOT NULL,
  `player_id` decimal(30) NOT NULL,
  `fan_count` decimal(65) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX index_week_idol_player (`week_id`, `idol_id`, `player_id`),
  INDEX index_week_idol (`week_id`, `idol_id`),
  INDEX index_week_player (`week_id`, `player_id`),
  INDEX index_week (`week_id`),
  INDEX index_idol (`idol_id`),
  INDEX index_player (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
