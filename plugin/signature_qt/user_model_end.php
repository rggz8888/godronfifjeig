	public function check_sign($groupid,&$sign) {
		if(!empty($sign)) {
			if($groupid==11||$groupid==5||$groupid==6)
			core::htmlspecialchars($sign);
			if(utf8::strlen($sign) > 200) {
				return '签名长度不能超过200个字符';
			} 
		}
		return '';
	}

	public function html_safe($doc) {
		return xn_html_safe::filter($doc);
	}