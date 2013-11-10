<?php 
session_start();

include_once( 'config.php' );
include_once( 'saetv2.ex.class.php' );
$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
$o->update('测试');



?>