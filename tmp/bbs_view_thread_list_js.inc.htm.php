<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><?php if($fid && $ismod) { ?>
<script type="text/javascript">

// 二级置顶，三级置顶，检查 fid，如果fid不等于当前fid，则只能选择一篇
$('#mod_checkall').click(function() {
	$('#body input[name="fid_tid[]"]').attr('checked', this.checked);
});

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
	var url = url_add_arg('http://127.0.0.1/mod-top-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
	return false;
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
	var url = url_add_arg('http://127.0.0.1/mod-digest-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
	return false;
});

// 主题分类 
$('#mod_type').click(function() {
	var other_forum_flag = 0;
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		var currfid = $(this).val().split('_')[0];
		if(currfid != <?php echo isset($fid) ? $fid : '';?>) {
			$(this).attr('checked', '');
			other_forum_flag = 1;
		}
	});
	if(other_forum_flag) {
		alert('批量设置主题分类只能选择当前版块的主题，已经取消了非当前版块的主题（全局置顶主题）');
	}
	
	var fid_tids = '';
	$.each($('#body input[name="fid_tid[]"]:checked'), function(k, v) {
		fid_tids += (fid_tids ? '__' : '') + v.value;
	});
	if(fid_tids == '') {
		alert('请选择主题！');
		return false;
	}
	var url = url_add_arg('http://127.0.0.1/mod-type-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
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
	// 删除 dialog
	var url = url_add_arg('http://127.0.0.1/mod-delete-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
	return false;
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
	var url = url_add_arg('http://127.0.0.1/mod-move-fid-<?php echo isset($fid) ? $fid : '';?>.htm', 'fid_tids', fid_tids);
	ajaxdialog_request(url, function() {
		window.location.reload();
	});
	return false;
});

</script>
<?php } ?>


<script type="text/javascript">

// 鼠标背景变色
$('#threadlist tr').bind('mouseover', function() {$(this).removeClass('bg1').addClass('bg2');});
$('#threadlist tr').bind('mouseout', function() {$(this).removeClass('bg2').addClass('bg1');});

// 最新帖，已读帖，比较最后阅读时间和帖子的最后回复时间
$('#body table.thread').each(function() {
	var tid = intval($(this).attr('tid'));
	var lastpost = intval($(this).attr('lastpost'));
	var k = tid_is_read(tid, lastpost);
	if(tid_is_read(tid, lastpost)) {
		$('.subject_type', this).addClass('read');
		$('a.subject_link', this).addClass('read');
		$('a.thread_icon', this).addClass('xgrey');
	}
});

// 点击服务器，火帖
$.getScript('<?php echo isset($click_server) ? $click_server : '';?>&'+Math.random(), function() {
	if(!xn_json) return;
	var json = xn_json;
	for(tid in json) {
		var viewspan = $('span.views[tid='+tid+']');
		viewspan.html(json[tid]);
		if(json[tid] > <?php echo isset($conf['threadlist_hotviews']) ? $conf['threadlist_hotviews'] : '';?>) {
			viewspan.addClass('red bold');
			//$('table[tid='+tid+'] a.subject_link').after(' <span class="icon icon-post-fire" title="火帖"></span>'); // 根据回复数
			//viewspan.html(viewspan.html() + '<span class="icon icon-post-fire"></span>');
		}
	}
});

// 记录当前页码
<?php if($fid) { ?>
var fid_page = $.parseJSON($.pdata(cookie_pre + 'fid_page'));
if(!fid_page) fid_page = {};
fid_page[''+<?php echo isset($fid) ? $fid : '';?>] = <?php echo isset($page) ? $page : '';?>;
$.pdata(cookie_pre + 'fid_page', $.toJSON(fid_page));

// orderby 切换
$('#nav_orderby a').click(function() {
	// 设置 cookie, 重新刷新页面
	$.cookie('orderby', intval($.cookie('orderby')) == 1 ? 0 : 1);
	window.location.reload();
});
<?php } ?>

$('div.div div.body').find('hr:last').hide();// 隐藏最后一个 hr

// 键盘翻页
bind_document_keyup_page();

</script>

