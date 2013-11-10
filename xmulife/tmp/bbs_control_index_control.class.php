<?php

/*
 * Copyright (C) xiuno.com
 */

!defined('FRAMEWORK_PATH') && exit('FRAMEWORK_PATH not defined.');
	include 'D:/Program Files (x86)/phpnow/htdocs/xmulife/tmp/control_common_control.class.php';

class index_control extends common_control {
	
	function __construct(&$conf) {
		parent::__construct($conf);
		$this->_checked['bbs'] = ' class="checked"';
		$this->_title[] = $this->conf['seo_title'] ? $this->conf['seo_title'] : $this->conf['app_name'];
		$this->_seo_keywords = $this->conf['seo_keywords'];
		$this->_seo_description = $this->conf['seo_description'];
	}
	
	// 给插件预留个位置
	public function on_index() {


		
		$this->on_bbs();
	}
	
	// 首页
	public function on_bbs() {
		$this->_checked['index'] = ' class="checked"';
		

		$friendlinklist = array();
		$friendlinklist[0] = $this->friendlink->index_fetch(array('type'=>0), array('rank'=>1), 0, 1000);
		foreach($friendlinklist[0] as &$friendlink) {
			$this->friendlink->format($friendlink);
		}
		
		$friendlinklist[1] = $this->friendlink->index_fetch(array('type'=>1), array('rank'=>1), 0, 1000);
		foreach($friendlinklist[1] as &$friendlink) {
			$this->friendlink->format($friendlink);
		}
		
		$this->view->assign('friendlinklist', $friendlinklist);
		
		$pagesize = 30;
		$toplist = array(); // only top 3
		$readtids = '';
		$page = misc::page();
		$start = ($page -1 ) * $pagesize;
		$threadlist = $this->thread->get_newlist($start, $pagesize);
		foreach($threadlist as $k=>&$thread) {
			$this->thread->format($thread);
			
			// 去掉没有权限访问的版块数据
			$fid = $thread['fid'];
			
			// 那就多消耗点资源吧，谁让你不听话要设置权限。
			if(!empty($this->conf['forumaccesson'][$fid])) {
				$access = $this->forum_access->read($fid, $this->_user['groupid']); // 框架内部有变量缓存，此处不会重复查表。
				if($access && !$access['allowread']) {
					unset($threadlist[$k]);
					continue;
				}
			}
			
			$readtids .= ','.$thread['tid'];
			if($thread['top'] == 3) {
				unset($threadlist[$k]);
				$toplist[] = $thread;
				continue;
			}
		}
		
		$toplist = $page == 1 ? $this->get_toplist() : array();
		$toplist = array_filter($toplist);
		foreach($toplist as $k=>&$thread) {
			$this->thread->format($thread);
                        $readtids .= ','.$thread['tid'];
                }
                
		$readtids = substr($readtids, 1); 
		$click_server = $this->conf['click_server']."?db=tid&r=$readtids";
		
		$pages = misc::simple_pages('http://127.0.0.1/index-index.htm', count($threadlist), $page, $pagesize);

		// 在线会员
		$ismod = ($this->_user['groupid'] > 0 && $this->_user['groupid'] <= 4);
		$fid = 0;
		$this->view->assign('ismod', $ismod);
		$this->view->assign('fid', $fid);
		$this->view->assign('threadlist', $threadlist);
		$this->view->assign('toplist', $toplist);
		$this->view->assign('click_server', $click_server);
		$this->view->assign('pages', $pages);
		

		if($this->qh_mobile) {
			$this->view->display('mobile_index_index.htm');
			return;
		}

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

		
		$this->view->display('index_index.htm');
	}
	
	public function on_test() {
		$this->view->display('test_drag.htm');
	}
	
	private function get_toplist($forum = array()) {
		$fidtids = array();
		// 3 级置顶
		$fidtids = $this->get_fidtids($this->conf['toptids']);
		
		// 1 级置顶
		if($forum) {
			$fidtids += $this->get_fidtids($forum['toptids']);
		}
		
		$toplist = $this->thread->mget($fidtids);
		return $toplist;
	}
	
	private function get_fidtids($s) {
		$fidtids = array();
		if($s) {
			$fidtidlist = explode(' ', trim($s));
			foreach($fidtidlist as $fidtid) {
				if(empty($fidtid)) continue;
				$arr = explode('-', $fidtid);
				list($fid, $tid) = $arr;
				$fidtids["$fid-$tid"] = array($fid, $tid);
			}
		}
		return $fidtids;
	}
	public function on_yyct() {
		$this->_checked['forum_yyct'] = 'class="checked"';
		$this->view->display('plugin_yyct.htm');
	}
}

?>