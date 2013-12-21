<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
	$db = $this->user->db;	// 与 user model 同一台 db
	$tablepre = $db->tablepre;
	try {$db->query("ALTER TABLE {$tablepre}post ADD column coverimg varchar(128) NOT NULL DEFAULT '0'");} catch (Exception $e) {}
	try {$db->query("ALTER TABLE {$tablepre}post ADD INDEX coverimg(coverimg)");} catch (Exception $e) {}

}

// 开始初始化数据
?>