ALTER TABLE `users` ADD `notification` TINYINT(4) NOT NULL COMMENT '1:通知する; 2:通知しないの' AFTER `unit_id`;