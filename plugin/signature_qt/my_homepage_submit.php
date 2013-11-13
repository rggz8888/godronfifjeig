			$sign = core::gpc('sign', 'P');
			$sign = $this->user->html_safe($sign);
			$error['sign'] = $this->user->check_sign($sign);
			if(!array_filter($error)) {
				$user = $this->user->read($uid);
				$user['sign'] = $sign;
				$this->user->update($user);
				$error = array();
			}
