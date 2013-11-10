
    public function on_rename() {
        $error = array();
        $msg = array();
        $uid = $this->_user['uid'];
        $config = $this->kv->get('rename_setting');
        $user = $this->user->get($uid);
        if(!$this->form_submit()) {
            if(core::gpc('ajax')) {
                $renamelist = $this->rename->get_rename_by_uid($uid);
                $renameObj = array();
                foreach($renamelist as $rename) {
                    $renameObj = $rename;
                }
                $msg['newname'] = '';
                $msg['reason'] = '';
                $msg['status'] = '';
                $msg['servicefees'] = 0;
                $msg['golds'] = $user['golds'];
                if($renameObj){
                    if($renameObj['status'] == '0'){
                        $this->_checked['readonly'] = ' readonly="true"';
                        $msg['newname'] = $renameObj['newname'];
                        $msg['reason'] = $renameObj['reason'];
                        $msg['status'] = $renameObj['status_str'];
                    }else{
                        $msg['servicefees'] = $config['servicefees'];
                    }
                }else{
                    $msg['servicefees'] = $config['servicefees'];
                }

                $this->view->assign('msg', $msg);
                $this->view->display('user_rename_ajax.htm');
            } else {
                $referer = $this->get_referer();
                $this->view->assign('referer', $referer);
                $this->view->display('user_rename.htm');
            }
        }else{
            $newname = core::gpc('newname', "P");
            $reason = core::gpc('reason', "P");
            $name = $this->_user['username'];

            $error['username'] = $this->user->check_username($newname);
            $error['username_exists'] = $this->user->check_username_exists($newname);
            $error['reason'] = utf8::strlen($reason) > 60 ? '理由太长！60/'.utf8::strlen($reason) : '';
            $error['servicefees'] = $user['golds'] < $config['servicefees'] ? '帐户余额不足以支付改名费用！' : '';

            if(!array_filter($error)) {
                $renameObj = array (
                    'uid'=>$uid,
                    'username'=>$name,
                    'newname'=>$newname,
                    'reason'=>$reason,
                    'dateline'=>$_SERVER['time'],
                );

                $this->rename->create($renameObj);
                
                if($config['servicefees']){
                    $user['golds'] -= $config['servicefees'];
                    $this->user->update($user);
                }
            }
            $this->message($error);
        }
    }