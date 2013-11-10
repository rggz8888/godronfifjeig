<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

$config = $this->kv->get('bank_config');
!isset($config['cleardata']) && $config['cleardata'] = 0;
// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb' && $config['cleardata']) {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
    $db->query("DROP TABLE `{$tablepre}bank_data`, `{$tablepre}bank_logs`;");
    $db->query("ALTER TABLE `bbs_user` DROP `bank_status`, DROP `bank_deposit`, DROP `bank_opentime`, DROP `bank_begintime`;");
  } catch (Exception $e) {}
  $this->kv->delete('bank_config');
}
?>