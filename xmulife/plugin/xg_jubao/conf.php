<?php

return 	array (
	'name' => '帖子举报',		// 插件名
	'brief' => '帖子举报-xgcms',
	'version' => '1.0.0',		// 插件版本
	'bbs_version' => '2.0.3',		// 插件支持的 Xiuno BBS 版本
);
/*

CREATE TABLE `bbs`.`bbs_thread_jubao` (
`id` INT( 8 ) NOT NULL AUTO_INCREMENT ,
`fid` INT( 8 ) NOT NULL DEFAULT '0',
`pid` INT( 8 ) NOT NULL DEFAULT '0',
`subject` CHAR( 100 ) NOT NULL ,
`message` CHAR( 200 ) NOT NULL ,
`dateline` INT( 10 ) NOT NULL DEFAULT '0',
`url` CHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `id` ) 
) ENGINE = MYISAM ;




*/
?>
