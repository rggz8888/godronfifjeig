<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
	$db = $this->user->db;	// 与 user model 同一台 db
	$tablepre = $db->tablepre;
	try {$db->query("ALTER TABLE {$tablepre}post ADD COLUMN xtime varchar(20) NOT NULL default '';");} catch (Exception $e) {}
	try {$db->query("ALTER TABLE {$tablepre}post ADD COLUMN xusername varchar(16) NOT NULL default '';");} catch (Exception $e) {}

}

?>