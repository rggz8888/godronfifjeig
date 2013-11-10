<?php

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
    $db->query("ALTER TABLE  `{$tablepre}user` ADD  `quickreply` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  ''");
  } catch (Exception $e) {}
  }
?>