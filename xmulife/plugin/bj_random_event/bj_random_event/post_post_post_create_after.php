
    $event = $this->kv->get('event_setting');
    
    !isset($event['pmshow']) && $event['pmshow'] = 0;
    !isset($event['trigger']) && $event['trigger'] = 100;
    !isset($event['probability']) && $event['probability'] = 50;
    !isset($event['getevent']) && $event['getevent'] = '';
    !isset($event['loseevent']) && $event['loseevent'] = '';

    $triggerRom = rand(1, 100); //触发随机数

    if($event['trigger'] >= $triggerRom && $event['getevent'] != '' && $event['getevent'] != ''){
        $probabilityRom = rand(1, 100); //获取失去随机数
        $eventRom = "";
        if($event['probability'] >= $probabilityRom){
            $type = 1;
            $eventRom = $event['getevent'];
        }else{
            $type = 0;
            $eventRom = $event['loseevent'];
        }

        $eventRomNum = rand(0, count($eventRom) - 1); //触发随机数

        $eventTmp = $eventRom[$eventRomNum];
        $eventTmp = explode("|", $eventTmp);

        $myfile = 'D:/wechatDebug.txt';
        $file_pointer = @fopen($myfile,"a");
        @fwrite($file_pointer, $eventRom[$eventRomNum].'===');
        @fwrite($file_pointer, $eventRom.'===');
        @fwrite($file_pointer, count($eventRom).'===');
        @fwrite($file_pointer, $eventRomNum);
        @fwrite($file_pointer, $event['pmshow']);
        @fclose($file_pointer);

        $goldsStr = $eventTmp[0];
        $eventStr = $eventTmp[1];

        if(stripos($goldsStr,",")){
            $goldsStr = explode(",", $goldsStr);
            $golds = rand($goldsStr[0], $goldsStr[1]);
        }else{
            $golds = $goldsStr;
        }

        $eventStr = str_replace(array('#username#', '#golds#'),array($username, $golds), $eventStr);

        if($type){
            $user['golds'] += $golds;
        }else{
            $user['golds'] -= $golds;
        }
        $this->user->update($user);
        
        $eventObj = array (
            'fid'=>$post['fid'],
            'tid'=>$post['tid'],
            'page'=>$post['page'],
            'pid'=>$pid,
            'uid'=>$uid,
            'type'=>$type,
            'golds'=>$golds,
            'message'=>$eventStr.$eventTmp,
            'dateline'=>$_SERVER['time'],
        );

        $this->event->create($eventObj);

        // 发送系统消息：
        if($event['pmshow']) {
            $pmmessage = str_replace(array('#username#', '#golds#'),array('您', $golds), $eventTmp[1]);
            $pmmessage = $pmmessage.'【<a href="?thread-index-fid-'.$post['fid'].'-tid-'.$post['tid'].'-page-'.$event['page'].'.htm#message_'.$pid.'" target="_blank">事件现场</a>】';
            $this->pm->system_send($user['uid'], $user['username'], $pmmessage);
        }
    }