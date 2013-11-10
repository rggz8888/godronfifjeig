
    $event = $this->kv->get('event_setting');
    
    !isset($event['postshow']) && $event['postshow'] = 0;

    if($event['postshow']) {
        $eventdata = $this->event->index_fetch(array('fid'=>$fid, 'tid'=>$tid, 'page'=>$page), array(), 0, $this->conf['pagesize']);
        foreach($eventdata as $event) {
            $eventlist[$event['pid']] = $event['message'];
        }

        $this->view->assign('eventlist', $eventlist);
    }