ALTER TABLE `units` ADD `license_number` VARCHAR(20) NOT NULL COMMENT 'ライセンス番号' AFTER `license_id`;
ALTER TABLE `units` ADD `license_type` INT(1) NOT NULL COMMENT '種別' AFTER `license_number`;
ALTER TABLE `units` ADD `expiration_date` TIMESTAMP NULL COMMENT '有効期限' AFTER `license_type`;
ALTER TABLE `units` ADD `place` VARCHAR(60) NULL AFTER `expiration_date`;