CREATE TABLE `user_sms` (
  `id` int(11) NOT NULL,
  `sending_number` text NOT NULL,
  `to_number` text NOT NULL,
  `msg` text NOT NULL,
  `time` datetime NOT NULL,
  `status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
