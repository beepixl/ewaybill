
//08-02-23
ALTER TABLE `invoices` CHANGE `supplyType` `supplyType` VARCHAR(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, CHANGE `subSupplyType` `subSupplyType` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL, CHANGE `docType` `docType` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `docNo` `docNo` VARCHAR(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `docDate` `docDate` DATE NULL, CHANGE `toGstin` `toGstin` VARCHAR(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `toTrdName` `toTrdName` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL, CHANGE `toPincode` `toPincode` INT(11) NULL, CHANGE `cgstValue` `cgstValue` DECIMAL(18,2) NULL, CHANGE `sgstValue` `sgstValue` DECIMAL(18,2) NULL, CHANGE `igstValue` `igstValue` DECIMAL(18,2) NULL, CHANGE `transMode` `transMode` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL;

//09-02-23
ALTER TABLE `settings` CHANGE `invPrefix` `invPrefix` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `settings` CHANGE `fromPincode` `fromPincode` VARCHAR(250) NULL DEFAULT NULL;
ALTER TABLE `customers` CHANGE `toPincode` `toPincode` VARCHAR(250) NULL DEFAULT NULL;
ALTER TABLE `settings` CHANGE `actFromStateCode` `actFromStateCode` VARCHAR(250) NULL DEFAULT NULL, CHANGE `fromStateCode` `fromStateCode` VARCHAR(250) NULL DEFAULT NULL;
ALTER TABLE `invoices` CHANGE `fromPincode` `fromPincode` VARCHAR(100) NULL DEFAULT NULL, CHANGE `actFromStateCode` `actFromStateCode` VARCHAR(100) NULL DEFAULT NULL, CHANGE `fromStateCode` `fromStateCode` VARCHAR(100) NULL DEFAULT NULL, CHANGE `toPincode` `toPincode` VARCHAR(100) NULL DEFAULT NULL, CHANGE `actToStateCode` `actToStateCode` VARCHAR(100) NULL DEFAULT NULL, CHANGE `toStateCode` `toStateCode` VARCHAR(100) NULL DEFAULT NULL;
ALTER TABLE `customers` CHANGE `actToStateCode` `actToStateCode` VARCHAR(250) NULL DEFAULT NULL, CHANGE `toStateCode` `toStateCode` VARCHAR(250) NULL DEFAULT NULL;




