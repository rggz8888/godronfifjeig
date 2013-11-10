<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb') {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
  $db->query("CREATE TABLE IF NOT EXISTS `{$tablepre}bank_logs` (
  `lid` int(10) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `golds` int(10) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`lid`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COLLATE=utf8_general_ci;");
  $db->query("CREATE TABLE IF NOT EXISTS `{$tablepre}bank_data` (
  `did` int(10) unsigned NOT NULL auto_increment,
  `uid` int(11) unsigned NOT NULL default '0',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `money` int(10) unsigned NOT NULL default '0',
  `credit` int(10) unsigned NOT NULL default '0',
  `day` int(10) unsigned NOT NULL default '0',
  `rate` float unsigned NOT NULL default '0',
  `status` int(1) unsigned NOT NULL default '0',
  `begintime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`did`)
  ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 COLLATE=utf8_general_ci;");
  $db->query("ALTER TABLE  `{$tablepre}user` 
  ADD `bank_status` tinyint( 1 ) UNSIGNED NOT NULL DEFAULT  '0',
  ADD `bank_deposit` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0',
  ADD `bank_opentime` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0',
  ADD `bank_begintime` INT( 11 ) UNSIGNED NOT NULL DEFAULT  '0';");
  } catch (Exception $e) {}
}
/** 后台设置 **/
$config = $this->kv->get('bank_config');
!isset($config['close']) && $config['close'] = 0;
!isset($config['closemessage']) && $config['closemessage'] = '站长贪污，关门调查中...';
!isset($config['notice']) && $config['notice'] = '中央银行正式开业，目前正在营业中...';
!isset($config['poundage']) && $config['poundage'] = 10;
!isset($config['current']) && $config['current'] = 0.3;
!isset($config['fixed']) && $config['fixed'] = 0.5;
!isset($config['minfixed']) && $config['minfixed'] = 30;
!isset($config['loan']) && $config['loan'] = 1;
!isset($config['jfconvert']) && $config['jfconvert'] = 1;
!isset($config['jbconvert']) && $config['jbconvert'] = 100;
!isset($config['transfer']) && $config['transfer'] = 0.8;
!isset($config['mintransfer']) && $config['mintransfer'] = 100;
!isset($config['pmtransfer']) && $config['pmtransfer'] = 10;
!isset($config['cleardata']) && $config['cleardata'] = 0;
$this->kv->set('bank_config', $config);
?>