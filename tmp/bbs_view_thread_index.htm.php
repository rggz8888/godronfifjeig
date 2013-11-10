<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><?php include $this->gettpl('header.htm');?>



<div class="width">

	
	<table id="nav" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">
		<tr>
			<td class="left"></td>
			<td class="center" style="white-space:nowrap; overflow: hidden;">
				<a class="icon icon-home" href="./"></a>
				<span class="sep"></span>
				
				<span><a href="http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-page-1.htm" id="forum_link"><?php echo isset($forum['name']) ? $forum['name'] : '';?></a></span>
				<span class="sep"></span>
				
				<span><a href="http://127.0.0.1/xmulife/thread-index-fid-<?php echo isset($fid) ? $fid : '';?>-tid-<?php echo isset($tid) ? $tid : '';?>.htm"><?php echo isset($thread['subject_substr']) ? $thread['subject_substr'] : '';?></a></span>
				
			</td>
			<td class="center2">
				<?php include $this->gettpl('header_user.inc.htm');?>
				<a href="http://127.0.0.1/xmulife/post-thread-fid-<?php echo isset($fid) ? $fid : '';?>-typeid1-<?php echo isset($thread['typeid1']) ? $thread['typeid1'] : '';?>-typeid2-<?php echo isset($thread['typeid2']) ? $thread['typeid2'] : '';?>-typeid3-<?php echo isset($thread['typeid3']) ? $thread['typeid3'] : '';?>-typeid4-<?php echo isset($thread['typeid4']) ? $thread['typeid4'] : '';?>-ajax-1.htm" target="_blank" onclick="return false;" id="create_thread" rel="nofollow"><span class="icon icon-post-newthread"></span> 发新帖</a>
			</td>
			<td class="right"></td>
		</tr>
	</table>
	
	
	
	<?php if(!empty($postlist)) { foreach($postlist as &$post) {?>
	<?php $u = isset($userlist[$post['uid']]) ? $userlist[$post['uid']] : array();?>
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="post_table">
		<tr>
			<td width="70" valign="top">
				<div>
					<a href_real="http://127.0.0.1/xmulife/you-index-uid-<?php echo isset($u['uid']) ? $u['uid'] : '';?>.htm" target="_blank" href="http://127.0.0.1/xmulife/you-profile-uid-<?php echo isset($u['uid']) ? $u['uid'] : '';?>-ajax-1.htm" class="ajaxdialog_hover" ajaxdialog="{position: 5, modal: false, timeout: 1000, showtitle: false}" onclick="return false;" style="display: block" rel="nofollow" aria-label="<?php echo isset($u['username']) ? $u['username'] : '';?> <?php echo isset($post['floor']) ? $post['floor'] : '';?>楼">
						<span class="avatar_middle border bg1" <?php if(!empty($u['avatar_middle'])) { ?>style="background-image: url(<?php echo isset($u['avatar_middle']) ? $u['avatar_middle'] : '';?>)"<?php } ?>></span>
					</a>
				</div>
				<div style="word-break:break-all;"><?php echo isset($u['username']) ? $u['username'] : '';?></div>
				
			</td>
			<td width="15"></td>
			<td class="post_td" valign="top">
				<span class="icon icon-left-arrow" style="position: absolute; z-index: 9; float: left; margin-left: -9px; margin-top: 10px;"></span>
				<div class="bg1 border post">
				
					
					
					<?php if($thread['firstpid'] == $post['pid']) { ?>
					<h2 id="subject_<?php echo isset($tid) ? $tid : '';?>">
					
						<?php if($thread['top']) { ?><span class="icon icon-top-<?php echo isset($thread['top']) ? $thread['top'] : '';?>" style="margin-right: 2px;" title="置顶主题"></span><?php } ?>
									
					<?php if(!empty($forum['types'])) { foreach($forum['types'] as $cateid=>&$types) {?>
						<?php if($cateid == 1 && $thread['typeid1']) { ?><a href="http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-typeid1-<?php echo isset($thread['typeid1']) ? $thread['typeid1'] : '';?>.htm" target="_blank" rel="nofollow">[<?php echo isset($thread['typename1']) ? $thread['typename1'] : '';?>]</a><?php } ?>
						<?php if($cateid == 2 && $thread['typeid2']) { ?><a href="http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-typeid2-<?php echo isset($thread['typeid2']) ? $thread['typeid2'] : '';?>.htm" target="_blank" rel="nofollow">[<?php echo isset($thread['typename2']) ? $thread['typename2'] : '';?>]</a><?php } ?>
						<?php if($cateid == 3 && $thread['typeid3']) { ?><a href="http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-typeid3-<?php echo isset($thread['typeid3']) ? $thread['typeid3'] : '';?>.htm" target="_blank" rel="nofollow">[<?php echo isset($thread['typename3']) ? $thread['typename3'] : '';?>]</a><?php } ?>
						<?php if($cateid == 4 && $thread['typeid4']) { ?><a href="http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-typeid4-<?php echo isset($thread['typeid4']) ? $thread['typeid4'] : '';?>.htm" target="_blank" rel="nofollow">[<?php echo isset($thread['typename4']) ? $thread['typename4'] : '';?>]</a><?php } ?>
					<?php }}?>
					
						<?php echo isset($thread['subject']) ? $thread['subject'] : '';?>
						
						<?php if($thread['firstpid'] == $post['pid']) { ?>&nbsp;<a href="javascript:;" id="button_collect"><img src="<?php echo isset($conf['plugin_url']) ? $conf['plugin_url'] : '';?>collect/collect.gif" /></a><span id="collect_notice"></span><br/><br/><!-- Baidu Button BEGIN -->
<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
<a class="bds_tsina"></a>
<a class="bds_sqq"></a>
<a class="bds_qzone"></a>
<a class="bds_renren"></a>
<a class="bds_tqq"></a>
<a class="bds_tieba"></a>
<a class="bds_youdao"></a>
<a class="bds_douban"></a>
<span class="bds_more"></span>
<a class="shareCount"></a>
</div>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6833441" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
var bds_config={"snsKey":{'tsina':'2453695664','tqq':'','t163':'','tsohu':''}}
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
<!-- Baidu Button END --><br/><br/><?php } ?>
					</h2>
					<?php } ?>
					
					
					
					<div id="message_<?php echo isset($post['pid']) ? $post['pid'] : '';?>" class="message"><?php echo isset($post['message']) ? $post['message'] : '';?><?php if($thread['firstpid'] == $post['pid']) { ?>
<!-- 将此标记放在您希望显示like按钮的位置 -->
<br/><br/>
<div class="bdlikebutton"></div>

<!-- 将此代码放在适当的位置，建议在body结束前 -->
<script id="bdlike_shell"></script>
<script>
var bdShare_config = {
	"type":"large",
	"color":"blue",
	"uid":"6833441"
};
document.getElementById("bdlike_shell").src="http://bdimg.share.baidu.com/static/js/like_shell.js?t=" + Math.ceil(new Date()/3600000);
</script>
<?php } ?></div>
					
					
					
					<?php if(!empty($post['attachlist'])) { ?>
					<br />
					<div class="attachlist">
						<table width="100%" cellpadding="2" class="noborder">
							<tr>
								<td class="bold"><span class="red" style="font-size: 18px"><?php echo isset($post['attachnum']) ? $post['attachnum'] : '';?> </span>个附件</td>
								<td width="70" class="grey">售价</td>
								<td width="70" class="grey">大小</td>
								<td width="70" class="grey">下载</td>
								<td width="70" class="grey">时间</td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php if(!empty($post['attachlist'])) { foreach($post['attachlist'] as &$attach) {?>
							<tr>
								<td>
									<a href="http://127.0.0.1/xmulife/attach-dialog-fid-<?php echo isset($fid) ? $fid : '';?>-aid-<?php echo isset($attach['aid']) ? $attach['aid'] : '';?>-ajax-1.htm" class="ajaxdialog" ajaxdialog="{showtitle: false, cache: true, position: 6, modal: false}" onclick="return false;" target="_blank" rel="nofollow"><img src="http://xmulife.u.qiniudn.com/view/image/filetype/<?php echo isset($attach['filetype']) ? $attach['filetype'] : '';?>.gif" width="16" height="16" /><?php echo isset($attach['orgfilename']) ? $attach['orgfilename'] : '';?></a>
								</td>
								<td class="red"><?php echo isset($attach['golds']) ? $attach['golds'] : '';?> 金币</td>
								<td class="grey"><?php echo isset($attach['filesize_fmt']) ? $attach['filesize_fmt'] : '';?></td>
								<td><?php echo isset($attach['downloads']) ? $attach['downloads'] : '';?> 次</td>
								<td class="grey"><?php echo isset($attach['dateline_fmt']) ? $attach['dateline_fmt'] : '';?></td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php }} ?>
						</table>
					</div>
					<?php } ?>
					
					<?php if($ismod && $thread['firstpid'] == $post['pid'] && $thread['modnum'] > 0) { ?>
					<br />
					<div class="modlist">
						<table width="100%" cellpadding="2" class="noborder">
							<tr>
								<td width="100" class="bold"><span class="red" style="font-size: 18px"><?php echo isset($thread['modnum']) ? $thread['modnum'] : '';?> </span>条管理记录</td>
								<td width="50" class="grey">操作</td>
								<td width="50" class="grey">积分</td>
								<td width="50" class="grey">金币</td>
								<td class="grey">备注</td>
								<td width="70" class="grey">时间</td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php if(!empty($modlist)) { foreach($modlist as &$mod) {?>
							<tr>
								<td>
									<a href_real="http://127.0.0.1/xmulife/you-index-uid-<?php echo isset($mod['user']['uid']) ? $mod['user']['uid'] : '';?>.htm" target="_blank" href="http://127.0.0.1/xmulife/you-profile-uid-<?php echo isset($mod['user']['uid']) ? $mod['user']['uid'] : '';?>-ajax-1.htm" class="ajaxdialog" ajaxdialog="{position: 5, modal: false, timeout: 1000, showtitle: false}" onclick="return false;" style="display: block" rel="nofollow">
										<span class="avatar_small bg1" <?php if($mod['user']['avatar_small']) { ?>style="background-image: url(<?php echo isset($mod['user']['avatar_small']) ? $mod['user']['avatar_small'] : '';?>)"<?php } ?>></span>
										<span><?php echo isset($mod['user']['username']) ? $mod['user']['username'] : '';?></span>
									</a>
								</td>
								<td class="grey"><?php echo isset($mod['action_fmt']) ? $mod['action_fmt'] : '';?></td>
								<td><?php echo isset($mod['credits_fmt']) ? $mod['credits_fmt'] : '';?></td>
								<td class="red"><?php echo isset($mod['golds_fmt']) ? $mod['golds_fmt'] : '';?></td>
								<td class="grey"><?php echo isset($mod['comment']) ? $mod['comment'] : '';?></td>
								<td class="grey"><?php echo isset($mod['dateline_fmt']) ? $mod['dateline_fmt'] : '';?></td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php }} ?>
						</table>
					</div>
					<?php } ?>
					
					<?php if($post['rates'] > 0) { ?>
					<br />
					<div class="ratelist">
						<table width="100%" cellpadding="2" class="noborder">
							<tr>
								<td width="100" class="bold"><span class="red" style="font-size: 18px"><?php echo isset($post['rates']) ? $post['rates'] : '';?> </span>条评分记录</td>
								<td width="50" class="grey">操作</td>
								<td width="50" class="grey">积分</td>
								<td width="50" class="grey">金币</td>
								<td class="grey">点评</td>
								<td width="70" class="grey">时间</td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php if(!empty($post['ratelist'])) { foreach($post['ratelist'] as &$rate) {?>
							<tr>
								<td>
									<a href_real="http://127.0.0.1/xmulife/you-index-uid-<?php echo isset($rate['user']['uid']) ? $rate['user']['uid'] : '';?>.htm" target="_blank" href="http://127.0.0.1/xmulife/you-profile-uid-<?php echo isset($rate['user']['uid']) ? $rate['user']['uid'] : '';?>-ajax-1.htm" class="ajaxdialog" ajaxdialog="{position: 5, modal: false, timeout: 1000, showtitle: false}" onclick="return false;" style="display: block" rel="nofollow">
										<span class="avatar_small bg1" <?php if($rate['user']['avatar_small']) { ?>style="background-image: url(<?php echo isset($rate['user']['avatar_small']) ? $rate['user']['avatar_small'] : '';?>)"<?php } ?>></span>
										<span class=""><?php echo isset($rate['user']['username']) ? $rate['user']['username'] : '';?></span>
									</a>
								</td>
								<td class="grey">评分</td>
								<td><?php echo isset($rate['credits_fmt']) ? $rate['credits_fmt'] : '';?></td>
								<td class="red"><?php echo isset($rate['golds_fmt']) ? $rate['golds_fmt'] : '';?></td>
								<td class="grey"><?php echo isset($rate['comment']) ? $rate['comment'] : '';?></td>
								<td class="grey"><?php echo isset($rate['dateline_fmt']) ? $rate['dateline_fmt'] : '';?></td>
							</tr>
							<tr><td colspan="6"><hr /></td></tr>
							<?php }} ?>
						</table>
					</div>
					<?php } ?>
					
					
					
					<div class="grey mod" pid="<?php echo isset($post['pid']) ? $post['pid'] : '';?>" style="zoom: 1;">
						<div>
							<?php if($thread['firstpid'] != $post['pid']) { ?>
							<span style="width: 150px; float: left; text-align: left;" class="small"><?php echo isset($post['dateline_fmt']) ? $post['dateline_fmt'] : '';?></span>
							<?php } ?>
							
							<?php if($_user['uid']) { ?>
							<a href="http://127.0.0.1/xmulife/post-post-fid-<?php echo isset($fid) ? $fid : '';?>-tid-<?php echo isset($post['tid']) ? $post['tid'] : '';?>-pid-<?php echo isset($post['pid']) ? $post['pid'] : '';?>.htm" class="ajaxdialog" ajaxdialog="{cache: true}" onclick="return false;">引用</a>
							<?php } ?>
							
							<?php if($ismod) { ?>	
							<a href="http://127.0.0.1/xmulife/mod-rate-fid-<?php echo isset($fid) ? $fid : '';?>-pid-<?php echo isset($post['pid']) ? $post['pid'] : '';?>.htm" class="ajaxdialog" ajaxdialog="{position: 1, modal: false, cache: false}">评分</a>
							<?php } ?>
							
							<?php if($ismod || $_user['uid'] == $post['uid']) { ?>	
							<a href="http://127.0.0.1/xmulife/post-update-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>-pid-<?php echo isset($post['pid']) ? $post['pid'] : '';?>-ajax-1.htm" class="ajaxdialog" ajaxdialog="{modal: false, cache: false}" onclick="return false;">编辑</a>
							<a href="http://127.0.0.1/xmulife/post-delete-fid-<?php echo isset($fid) ? $fid : '';?>-pid-<?php echo isset($post['pid']) ? $post['pid'] : '';?>.htm" class="ajaxconfirm" ajaxconfirm="{message: '确定删除吗？'}" onclick="return false;">删除</a>
							<?php } ?>
							
							#<?php echo isset($post['floor']) ? $post['floor'] : '';?>楼
						</div>
					</div>
				</div>
			</td>
		</tr>
		<?php if($thread['firstpid'] == $post['pid']) { ?>
		<tr>
			<td></td>
			<td></td>
			<td>
				<div class="bg2 border" style="margin-top: 1px; padding: 8px;">
					<span class="grey">发帖时间：</span><b><?php echo isset($post['dateline_fmt']) ? $post['dateline_fmt'] : '';?></b> &nbsp; <span class="grey2">|</span> &nbsp; 
					<span class="grey">查看数：</span><span id="thread_views" class="bold"><?php echo isset($thread['views']) ? $thread['views'] : '';?></span> &nbsp; <span class="grey2">|</span> &nbsp; 
					<span class="grey">回复数：</span><b><?php echo isset($thread['posts_fmt']) ? $thread['posts_fmt'] : '';?></b>
				</div>
			</td>
		</tr>
		<?php } ?>
	</table>
	
	<?php }} ?>
	
	
	<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="margin-top: 4px;" class="post_table">
		<tr>
			<td width="70" valign="top">
				<div>
					<?php if($_user['uid']) { ?><a href_real="http://127.0.0.1/xmulife/you-index-uid-<?php echo isset($_user['uid']) ? $_user['uid'] : '';?>.htm" target="_blank" href="http://127.0.0.1/xmulife/you-profile-uid-<?php echo isset($_user['uid']) ? $_user['uid'] : '';?>-ajax-1.htm" class="ajaxdialog_hover" ajaxdialog="{position: 5, modal: false, timeout: 1000, showtitle: false}" onclick="return false;" style="display: block" rel="nofollow"><?php } ?>
						<span class="avatar_middle border bg1" <?php if(!empty($_user['avatar_middle'])) { ?>style="background-image: url(<?php echo isset($_user['avatar_middle']) ? $_user['avatar_middle'] : '';?>)"<?php } ?>></span>
					<?php if($_user['uid']) { ?></a><?php } ?>
				</div>
				<div style="word-break:break-all;"><?php echo isset($_user['username']) ? $_user['username'] : '';?></div>
				<div class="grey small"><?php echo isset($_user['groupname']) ? $_user['groupname'] : '';?></div>
			</td>
			<td width="15"></td>
			<td class="post_td" valign="top">
				<span class="icon icon-left-arrow" style="position: absolute; z-index: 9; float: left; margin-left: -9px; margin-top: 10px;"></span>
				<div class="bg1 border shadow" style="padding: 8px;">
					<form action="http://127.0.0.1/xmulife/post-post-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>-tid-<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>-ajax-1-quickpost-1.htm" method="post" id="quick_post_form" target="_blank">
						<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
						
						<textarea name="message" id="quick_message" style="width: 100%; height: 60px; font-size: 14px; overflow: hidden;" aria-label="快速回复内容"></textarea>
						<div style="margin-top: 4px;">
							<div style="width: 50%; float: left;">
								<a type="submit" class="button smallblue" id="quick_post_submit" value="快速回复" href="javascript:void(0)" role="button"><span>快速回复</span></a>
								
							</div>
							<div style="width: 50%; float: left; text-align: right;">
								<a href="http://127.0.0.1/xmulife/post-post-fid-<?php echo isset($fid) ? $fid : '';?>-tid-<?php echo isset($tid) ? $tid : '';?>-ajax-1.htm" class="grey ajaxdialog" ajaxdialog="{cache: true}" onclick="return false;" id="create_post" >高级回复</a>
							</div>
						</div>
					</form>
				</div>
			</td>
		</tr>
	</table>
	
	
	<div class="box">
		<div class="page" style="text-align: center;"><?php echo isset($pages) ? $pages : '';?></div>
		<?php if($ismod) { ?>
		<div style="text-align: center;">
			<input type="checkbox" name="fid_tid[]" value="<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>_<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>" checked="checked" style="display: none;" />
			<a type="button" class="button smallblue" id="mod_top" value="置顶" href="javascript:void(0)" role="button"><span>置顶</span></a>
			<?php if($forum['typecates']) { ?>
			<a type="button" class="button smallblue" id="mod_type" value="主题分类" href="javascript:void(0)" role="button"><span>主题分类</span></a>
			<?php } ?>
			<a type="button" class="button smallblue" id="mod_digest" value="精华" href="javascript:void(0)" role="button"><span>精华</span></a>
			<a type="button" class="button smallblue" id="mod_move" value="移动" href="javascript:void(0)" role="button"><span>移动</span></a>
			
			<a type="button" class="button smallblue" id="mod_delete" value="删除" href="javascript:void(0)" role="button"><span>删除</span></a>
			
		</div>
		<?php } ?>
		<p style="text-align: center; padding: 8px;">
			<?php if(!empty($referer_other)) { ?>
			<a type="button" value=" 返回上一页" class="button bigblue" onclick="window.location='<?php echo isset($referer_other) ? $referer_other : '';?>';return false;" href="javascript:void(0)" role="button"><span> 返回上一页</span></a>
			<?php } ?>
			<a type="button" value=" 返回【<?php echo isset($forum['name']) ? $forum['name'] : '';?>】" class="button bigblue" id="return_back" href="javascript:void(0)" role="button"><span> 返回【<?php echo isset($forum['name']) ? $forum['name'] : '';?>】</span></a>
		</p>
	</div>
	
	
	
</div>

<?php include $this->gettpl('footer.htm');?>

<?php if($ismod) { ?>
<script type="text/javascript">
// copy from forum_index.htm
// 置顶 弹出 dialog 设置为置顶
$('#mod_top').click(function() {
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/xmulife/mod-top-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
});

// 主题分类 
$('#mod_type').click(function() {
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/xmulife/mod-type-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
});

// 精华
$('#mod_digest').click(function() {
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/xmulife/mod-digest-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
	return false;
});

// 删除
$('#mod_delete').click(function() {
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/xmulife/mod-delete-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location = 'http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>.htm';
	});
});

// 移动
$('#mod_move').click(function() {
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/xmulife/mod-move-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location = 'http://127.0.0.1/xmulife/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>.htm';
	});
});

</script>
<?php } ?>

<script type="text/javascript">

tid_add_read(<?php echo isset($tid) ? $tid : '';?>, <?php echo isset($_SERVER['time']) ? $_SERVER['time'] : '';?>);

$('#create_post').click(function() {
	if(g_uid == 0) {
		ajaxdialog_request('http://127.0.0.1/xmulife/user-login.htm', function() {
			$('#create_post').unbind('click');
			ajaxdialog_request($('#create_post').attr('href'));
			$('#create_post').click(function() {
				ajaxdialog_request($('#create_post').attr('href'));
			});
		});
		return false;
	} else {
		return true;
	}
});

// 点击数服务器
$.getScript('<?php echo isset($click_server) ? $click_server : '';?>&'+Math.random(), function() {
	if(typeof xn_json == 'undefined') return;
	var json = xn_json;
	$('#thread_views').html(json['<?php echo isset($tid) ? $tid : '';?>']);
});

// 自动伸缩，自动提交
$('#quick_message').keyup(function(e) {
	if((e.ctrlKey && (e.which == 13 || e.which == 10)) || (e.altKey && e.which == 83)) {
		$('#quick_post_submit').trigger('click');
		return false;
	}
        
	var h = $(this)[0].scrollHeight;
	if(h <= 100) {
		return true;
	} else {
		$(this).height($(this)[0].scrollHeight);
		return true;
	}
});

// 快速回复
$('#quick_post_submit').click(function() {
	if(!$('#quick_message').val()) {
		$('#quick_message').alert('请填写内容！', {width: 150, delay: 3000}).focus();
		return false;
	}
	$('#quick_post_submit').disable();
	
	function quick_post_submit_func() {
		var postdata = $("#quick_post_form").serialize();
		$.post($('#quick_post_form').attr('action'), postdata,  function(s){
			var json = json_decode(s);
			if(error = json_error(json)) {alert(error); return false;}
			if(json.status <= 0) {
				alert(json.message);
				return false;
			} else {
				json = json.message;
				if(json.message) {
					$('#quick_message').alert(json.message, {width:250, delay: 3000}).focus();
					return false;
				}

				
				//var page = Math.max(1, intval(json.page));
				//window.location= 'http://127.0.0.1/xmulife/thread-index-fid-<?php echo isset($fid) ? $fid : '';?>-tid-<?php echo isset($tid) ? $tid : '';?>-page-'+page+'-scrollbottom-1.htm';
				
				var post = json.post;
				// 结果直接显示在上面，不再跳转
				var s = '<table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" class="post_table">\
					<tr>\
						<td width="70" valign="top">\
							<div>\
								<a href_real="http://127.0.0.1/xmulife/you-index-uid-<?php echo isset($_user['uid']) ? $_user['uid'] : '';?>.htm" target="_blank" href="http://127.0.0.1/xmulife/you-profile-uid-<?php echo isset($_user['uid']) ? $_user['uid'] : '';?>-ajax-1.htm" class="ajaxdialog_hover" ajaxdialog="{position: 5, modal: false, timeout: 1000, showtitle: false}" onclick="return false;" style="display: block" rel="nofollow">\
									<span class="avatar_middle border bg1" <?php if(!empty($_user['avatar_middle'])) { ?>style="background-image: url(<?php echo isset($_user['avatar_middle']) ? $_user['avatar_middle'] : '';?>)"<?php } ?>></span>\
								</a>\
							</div>\
							<div style="word-break:break-all;" aria-label="'+post.username+' '+post.posts+'楼">'+post.username+'</div>\
						</td>\
						<td width="15"></td>\
						<td class="post_td" valign="top">\
							<span class="icon icon-left-arrow" style="position: absolute; z-index: 9; float: left; margin-left: -9px; margin-top: 10px;"></span>\
							<div class="bg1 border post">\
								<div id="message_'+post.pid+'" class="message">'+post.message+'</div>\
							</div>\
						</td>\
					</tr>\
				</table>';
				var jtable = $(s);
				$('table.post_table:last').before(jtable);
				//jtable.message = post.message;
				$('#quick_message').val('').focus();
				
				$('#quick_post_submit').enable();
			}
		});
	}

	if(g_uid == 0) {
		ajaxdialog_request('http://127.0.0.1/xmulife/user-login.htm', function() {
			quick_post_submit_func();
			return false;
		});
	} else {
		quick_post_submit_func();
		return false;
	}
});

// 滚动回复的到最底部
<?php if($scrollbottom) { ?>
var offset = $('#quick_message').offset();
document.documentElement.scrollTop = offset.top - 300;
$('#quick_message').focus();
<?php } ?>

// 记录当前页码
var fid_page = $.parseJSON($.pdata(cookie_pre + 'fid_page'));
var page = fid_page ? fid_page[''+<?php echo isset($fid) ? $fid : '';?>] : 1;
var href = $('#forum_link').attr('href').replace(/page-1/ig, "page-"+page);
$('#forum_link').attr('href', href);
$('#return_back').click(function() {
	window.location = href;
});

// 鼠标放在头像上弹出用户信息 ajaxdialog_hover
var jajaxdialoglinks = $('a.ajaxdialog_hover');
jajaxdialoglinks.die('click').live('click', function() {window.open($(this).attr('href_real'))});
jajaxdialoglinks.die('mouseover').live('mouseover', ajaxdialog_mouseover);
jajaxdialoglinks.die('mouseout').live('mouseout', ajaxdialog_mouseout);
$('a.ajaxconfirm').die('click').live('click', ajaxdialog_confirm);

// post_td 下的图片调整大小
$(function() {
	var td_width = $('td.post_td').width() - 28;
	td_width = Math.min($('#body').width() - 170, td_width);
	$('td.post_td img').each(function() {
		if($(this).width() > td_width) {
			this.height = Math.ceil((this.height /this.width) * td_width);
			this.width = Math.ceil(td_width);
			
			this.style.cursor = 'pointer';
			this.onclick = function() {
				window.open(this.src);
			}
		}
	});
});

// 快捷键翻页
bind_document_keyup_page();
$('div.post').each(function(i) {
	var _this = this;
	$(_this).hover(
		function() {
			$(_this).find('div.mod div').show().css('opacity', 0).stop().animate({opacity:1}, 500);
		},
		function() {
			$(_this).find('div.mod div').animate({opacity:0}, 500);
		}
	)
});
</script>



</body>

</html>