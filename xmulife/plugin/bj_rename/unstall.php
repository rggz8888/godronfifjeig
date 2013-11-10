<?php
!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');

$event = $this->kv->get('rename_setting');
!isset($event['cleardata']) && $event['cleardata'] = 0;
// 改文件会被 include 执行。
if($this->conf['db']['type'] != 'mongodb' && $event['cleardata']) {
  $db = $this->user->db;	// 与 user model 同一台 db
  $tablepre = $db->tablepre;
  try {
    $db->query("DROP TABLE  `{$tablepre}rename`");
  } catch (Exception $e) {}
  $this->kv->delete('rename_setting');
}
?>