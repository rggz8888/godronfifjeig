<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
	$db = $this->user->db;	// 与 user model 同一台 db
	$tablepre = $db->tablepre;
	$db->query("CREATE TABLE IF NOT EXISTS {$tablepre}thread_jubao (
  `fid` int(8) NOT NULL default '0',
  `pid` int(8) NOT NULL default '0',
  `subject` char(100) NOT NULL,
  `message` char(200) NOT NULL,
  `dateline` int(10) NOT NULL default '0',
  `url` char(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
");
	
}

?>
