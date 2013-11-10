<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><?php if($fid==1) { ?>
<?php include $this->gettpl('pic_thread_list.inc.htm');?>
<?php } else { ?>
  <?php include $this->gettpl('ori_thread_list.inc.htm');?>
 <?php } ?>