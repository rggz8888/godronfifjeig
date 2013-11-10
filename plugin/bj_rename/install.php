<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
  $db->query("CREATE TABLE IF NOT EXISTS `{$tablepre}rename` (
  `rid` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL,
  `username` char(16) NOT NULL,
  `newname` char(16) NOT NULL,
  `reason` char(60) NOT NULL,
  `dateline` int(11) unsigned NOT NULL default '0',
  `status` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`rid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COLLATE=utf8_general_ci;");
  } catch (Exception $e) {}
}
$rename = $this->kv->get('rename_setting');
!isset($rename['servicefees']) && $rename['servicefees'] = 10;
!isset($rename['pmmessage']) && $rename['pmmessage'] = 1;
!isset($rename['cleardata']) && $rename['cleardata'] = 0;
$this->kv->set('rename_setting', $rename);
?>