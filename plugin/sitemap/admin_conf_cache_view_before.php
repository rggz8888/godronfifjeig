<?php
$sitemap = core::gpc('sitemap', 'P');
if($sitemap && file_exists( $this->conf['upload_path'].'sitemap.xml' ) ){
	unlink( $this->conf['upload_path'].'sitemap.xml' );
}
?>