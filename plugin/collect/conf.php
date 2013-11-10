<?php

return 	array (
	'name' => '帖子收藏',		// 插件名
	'brief' => '收藏帖子到个人中心',
	'version' => '1.0.0',		// 插件版本
	'bbs_version' => '2.0.3',		// 插件支持的 Xiuno BBS 版本
	'cateid' => 2,
	'pluginid' =>0
);
/*
CREATE TABLE `bbs`.`bbs_mycollect` (
`id` MEDIUMINT( 5 ) NOT NULL AUTO_INCREMENT ,
`uid` INT( 8 ) NOT NULL DEFAULT '0',
`tid` INT( 8 ) NOT NULL DEFAULT '0',
`fid` INT( 8 ) NOT NULL DEFAULT '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;
*/
?>
