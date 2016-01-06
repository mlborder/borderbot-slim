CREATE TABLE `event_records` (
  `id` bigint(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `idol_id` int(11) DEFAULT NULL,
  `rank` int(11) NOT NULL,
  `point` decimal(65) NOT NULL,
  `player_id` decimal(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX index_event_idol_player (`event_id`, `idol_id`, `player_id`),
  INDEX index_event (`event_id`),
  INDEX index_player (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
