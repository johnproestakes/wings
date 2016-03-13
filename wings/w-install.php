<?php

//tables

//build user table
global $wings;
global $mysqli;
$wings->mysqli = new Wings_MySQLi($mysqli);
$wings->mysqli->query('CREATE TABLE `wings_users` (
`user_id` int(11) NOT NULL,
  `user_email` varchar(128) COLLATE utf8_bin NOT NULL,
  `user_password` varchar(128) COLLATE utf8_bin NOT NULL,
  `user_access` varchar(128) COLLATE utf8_bin NOT NULL,
  `user_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;');
$wings->mysqli->query('ALTER TABLE `wings_users` ADD PRIMARY KEY (`user_id`);');
$wings->mysqli->query('ALTER TABLE `wings_users` MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;');
