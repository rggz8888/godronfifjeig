<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
	$db = $this->user->db;	// 与 user model 同一台 db
	$tablepre = $db->tablepre;
	$db->query("
	CREATE TABLE IF NOT EXISTS {$tablepre}mycollect (
`id` MEDIUMINT( 5 ) NOT NULL AUTO_INCREMENT ,
`uid` INT( 8 ) NOT NULL DEFAULT '0',
`tid` INT( 8 ) NOT NULL DEFAULT '0',
`fid` INT( 8 ) NOT NULL DEFAULT '0',
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;
");
	
}

?>
