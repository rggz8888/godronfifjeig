<?php
if( !file_exists( $this->conf['upload_path'].'sitemap.xml' )){
	$sitamap_db = $this->thread->db;
	$sitamap_table = $sitamap_db->tablepre . $this->thread->table;
	$sitemap_threadlist = $sitamap_db->fetch_all( "SELECT fid,tid FROM $sitamap_table ORDER BY tid DESC LIMIT 0,50000" );
	$sitemap_tpl = '<?xml version="1.0" encoding="UTF-8"?><urlset>';
		$sitemap_tpl .= '<url>';
		$sitemap_tpl .= '<loc>'.$this->conf['app_url'].'</loc>';
		$sitemap_tpl .= '<lastmod>'.date('Y-m-d').'</lastmod>';
		$sitemap_tpl .= '<changefreq>always</changefreq>';
		$sitemap_tpl .= '<priority>1.0</priority>';
		$sitemap_tpl .= '</url>';
		foreach ($sitemap_threadlist as $sitemap_thread) {
			$sitemap_tpl .= '<url>';
			$sitemap_tpl .= '<loc>'.$this->conf['app_url'].'thread-index-fid-'.$sitemap_thread['fid'].'-tid-'.$sitemap_thread['tid'].'.htm</loc>';
			$sitemap_tpl .= '<lastmod>'.date('Y-m-d').'</lastmod>';
			$sitemap_tpl .= '<changefreq>always</changefreq>';
			$sitemap_tpl .= '<priority>1.0</priority>';
			$sitemap_tpl .= '</url>';
		}
	$sitemap_tpl.= '</urlset>';
	file_put_contents( $this->conf['upload_path'].'sitemap.xml' , $sitemap_tpl );
}
?>