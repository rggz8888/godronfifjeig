<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
  $db->query("CREATE TABLE IF NOT EXISTS `{$tablepre}event` (
  `eid` int(10) unsigned NOT NULL auto_increment,
  `fid` int(10) unsigned NOT NULL default '0',
  `tid` int(10) unsigned NOT NULL default '0',
  `page` int(10) unsigned NOT NULL default '0',
  `pid` int(10) unsigned NOT NULL default '0',
  `uid` int(11) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `golds` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`eid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COLLATE=utf8_general_ci;");
  } catch (Exception $e) {}
}
$event = $this->kv->get('event_setting');
!isset($event['postshow']) && $event['postshow'] = 0;
!isset($event['pmshow']) && $event['pmshow'] = 0;
!isset($event['trigger']) && $event['trigger'] = 50;
!isset($event['probability']) && $event['probability'] = 50;
!isset($event['getevent']) && $event['getevent'] = array("1,5|#username#走在路上，捡到了#golds#个金币。");
!isset($event['loseevent']) && $event['loseevent'] = array("1,5|#username#走在路上，丢失了#golds#个金币。");
$this->kv->set('event_setting', $event);
?>