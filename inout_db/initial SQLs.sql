INSERT INTO  `myinout_azure`.`lookups`
(`id`, `name`, `type`, `meta1`, `meta2`, `display_order`)
VALUES
(10, 'Active', 'activity_status', '', '', 1);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(11,'Completed','activity_status','','',2);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(12,'Overdue','activity_status','','',3);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(30,'Annual Leave','activity_type','','',1);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(31,'Work Site','activity_type','','',2);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(32,'Meeting','activity_type','','',3);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(33,'Sick Leave','activity_type','','',4);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(34,'Travelling','activity_type','','',5);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(35,'Others','activity_type','','',6);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(50,'Days','repeat_unit','','',1);
INSERT INTO  `myinout_azure`.`lookups`
(`id`,`name`,`type`,`meta1`,`meta2`,`display_order`)
VALUES
(51,'Weeks','repeat_unit','','',2);



INSERT INTO `myinout_azure`.`users`
(`name`,`email`,`created_by`,`contact`,`password`,`status`,`remember_token`,`created_at`)
VALUES
('Ben','ben@mail.com',1,'123456','admin',1,'',now());


INSERT INTO `myinout_azure`.`groups`
(`group_name`)
VALUES
('dev group');

INSERT INTO `myinout_azure`.`groups`
(`group_name`)
VALUES
('testing group');


INSERT INTO `myinout_azure`.`groups`
(`group_name`)
VALUES
('maintenance group');

INSERT INTO `myinout_azure`.`user_groups`
(`user_id`,`group_id`)
VALUES
(1,1);

INSERT INTO `myinout_azure`.`user_groups`
(`user_id`,`group_id`)
VALUES
(1,11);
INSERT INTO `myinout_azure`.`user_groups`
(`user_id`,`group_id`)
VALUES
(1,21);



