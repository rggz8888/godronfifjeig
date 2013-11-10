<?php

	public $qh_mobile = FALSE;

	private function qh_ismobile() {

		/*COOKIE的值：
			1:手机版
			2:电脑版
			*/
		$cookievar = $this->conf['cookie_pre'].'qh_mobile';
		$qh_mobile = core::gpc($cookievar,'C');
		if($qh_mobile==1) {
			return true;
		}

		if($qh_mobile==2) {
			return false;
		}else{
			$cookietime = $_SERVER['time'] + 2592000;
		
			static $mobilebrowser_list =array('iphone', 'android', 'phone', 'mobile', 'wap', 'netfront', 'java', 'opera mobi', 'opera mini',
				'ucweb', 'windows ce', 'symbian', 'series', 'webos', 'sony', 'blackberry', 'dopod', 'nokia', 'samsung',
				'palmsource', 'xda', 'pieplus', 'meizu', 'midp', 'cldc', 'motorola', 'foma', 'docomo', 'up.browser',
				'up.link', 'blazer', 'helio', 'hosin', 'huawei', 'novarra', 'coolpad', 'webos', 'techfaith', 'palmsource',
				'alcatel', 'amoi', 'ktouch', 'nexian', 'ericsson', 'philips', 'sagem', 'wellcom', 'bunjalloo', 'maui', 'smartphone',
				'iemobile', 'spice', 'bird', 'zte-', 'longcos', 'pantech', 'gionee', 'portalmmm', 'jig browser', 'hiptop',
				'benq', 'haier', '^lct', '320x320', '240x320', '176x220');

			$useragent = strtolower(core::gpc('HTTP_USER_AGENT', 'S'));

			if(($v = $this->qh_dstrpos($useragent, $mobilebrowser_list, true))) {
				//保存30天
				misc::setcookie($cookievar,1, $cookietime, $this->conf['cookie_path'], $this->conf['cookie_domain'], TRUE);
				return true;
			}

			//$webbrower = array('pad', 'gt-p1000','mozilla', 'chrome', 'safari', 'opera', 'm3gate', 'winwap', 'openwave', 'myop');
		
			misc::setcookie($cookievar,2, $cookietime, $this->conf['cookie_path'], $this->conf['cookie_domain'], TRUE);
			return false;
		}
	}

	private function qh_dstrpos($string, &$arr, $returnvalue = false) {
		if(empty($string)) return false;
		foreach((array)$arr as $v) {
			if(strpos($string, $v) !== false) {
				$return = $returnvalue ? $v : true;
				return $return;
			}
		}
		return false;
	}

	private function qh_mobile_islogin() {
		if(empty($this->_user['uid']) || $this->_user['groupid']==6) {
			return false;
		}
		return true;
	}
?>