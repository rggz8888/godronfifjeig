	public function check_sign(&$sign) {
		if(!empty($sign)) {
			core::htmlspecialchars($sign);
			if(utf8::strlen($sign) > 200) {
				return '签名长度不能超过200个字符';
			} 
			/**
			elseif(!check::is_url($homepage)) {
							return '网址格式不正确！';
						}
			*/
		}
		return '';
	}

	public function html_safe($doc) {
		return xn_html_safe::filter($doc);
	}