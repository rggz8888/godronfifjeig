<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?>		
		</div>
		
	</div>
	
</div>




<div id="footer" role="contentinfo">
	
	<table class="width">
		<tr>
			<td class="left">
				<?php echo isset($conf['app_copyright']) ? $conf['app_copyright'] : '';?><a target="_blank" href="http://sighttp.qq.com/authd?IDKEY=a42910c890c06e93dea1b01d3d344461f658a367e80e9e4f"><img border="0"  src="http://wpa.qq.com/imgd?IDKEY=a42910c890c06e93dea1b01d3d344461f658a367e80e9e4f&pic=41" alt="和团队交流" title="和团队交流"/></a><br />
				Powered by  <a href="http://bbs.xiuno.com" target="_blank" class="grey">Xiuno BBS <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></a>
				
			</td>
			<td class="right">
				<?php echo isset($conf['china_icp']) ? $conf['china_icp'] : '';?><br />
				<?php echo isset($_SERVER['time_fmt']) ? $_SERVER['time_fmt'] : '';?>, 耗时:<?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>s
				<script language="javascript" type="text/javascript" src="http://xmulife.u.qiniudn.com/myjs/16432044.js"></script>
<noscript><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/16432044.asp" style="border:none" /></noscript>
			</td>
		</tr>
	</table>
	
</div>

<?php include $this->gettpl('footer_debug.htm');?>

<?php if(DEBUG) { ?>
<script src="http://xmulife.u.qiniudn.com/view/js/jquery-1.4.full.js" type="text/javascript" ></script>
<?php } else { ?>
<script src="http://xmulife.u.qiniudn.com/view/js/jquery-1.4.min.js" type="text/javascript" ></script>
<?php } ?>

<script src="http://xmulife.u.qiniudn.com/view/js/common.js" type="text/javascript"></script>

<script src="http://xmulife.u.qiniudn.com/view/js/dialog.js" type="text/javascript"></script>

<script type="text/javascript">

$('#search input').focus(function() {$('#search').addClass('hover');});
$('#search input').blur(function() {$('#search').removeClass('hover');});
$('#search input').keyup(function(e) {
	if(e.which == 13 || e.which == 10) {
		var val = encodeURIComponent($(this).val());
		$('#search_form').attr('action', 'http://127.0.0.1/search-index-keyword-'+val+'.htm');
		$('#search_form').submit();
		return false;
	}
});

// 登陆后才能发帖
$('#create_thread').click(function() {
	if(g_uid == 0) {
		ajaxdialog_request('http://127.0.0.1/user-login.htm', function() {
			$('#create_thread').unbind('click');
			ajaxdialog_request($('#create_thread').attr('href'));
			$('#create_thread').click(function() {
				ajaxdialog_request($('#create_thread').attr('href'));
			});
		}, {fullicon: 1});
		return false;
	} else {
		ajaxdialog_request($('#create_thread').attr('href'), null);
		return false;
	}
});

$('a.ajaxdialog, input.ajaxdialog').die('click').live('click', ajaxdialog_click);
$('a.ajaxtoggle').die('click').live('click', ajaxtoggle_event);

//$('div.list .table tr:odd').not('tr.header').addClass('odd');	/* 奇数行的背景色 */
//$('div.list .table tr:last').addClass('last');	/* 奇数行的背景色 */

<?php if($_user['uid']) { ?>
// ------------------------> 短消息 start
	
	function userlist_to_html(userlist) {
		var s = '<div id="pm_userlist">';
		for(k in userlist) {
			var user = userlist[k];
			s += '<a href="http://127.0.0.1/pm-ajaxlist-uid-'+user.uid+'-ajax-1.htm" uid="'+user.uid+'" class="ajaxdialog" ajaxdialog="{position: \'center\', modal: false, cache: false}"><span class="avatar_small" style="'+(user.avatar_small ? 'background-image: url('+user.avatar_small+')' : '')+'"></span> '+user.username+' (<b class="red">'+user.newpms+'</b>)</a>';
		}
		s += '</div>';
		return s;
	}
	
	// 如果有新短消息，除了全局提示以外，再做一个全局标记，实现模拟即时聊天。
	var g_newpm_userlist = null;	// 全局变量
	
	// 心跳频率  根据负载来调整，如果PV <10W: 1秒, <100w 2秒, <600w 3秒, 600w+, 5秒
	var g_newpm_delay = <?php echo isset($pm_delay) ? $pm_delay : '';?>;
	
	function newpm() {
		var _this = this;
		_this.delay = g_newpm_delay;
		_this.t = null;
		_this.stop = function() {
			if(_this.t) clearTimeout(_this.t);
		};
		_this.run = function() {
			_this.stop();
			_this.t = setTimeout(function() {
				//print_r('http://127.0.0.1/pm-new-ajax-1.htm');
				$.get('http://127.0.0.1/pm-new-ajax-1.htm', function(s) {
					var json = json_decode(s);
					if(error = json_error(json)) {return false;}
					// alert(error);
					
					if(json.status == 1) {
						

						
						var userlist = json.message;
						g_newpm_userlist = userlist;
						var s = userlist_to_html(userlist);
						$('#pm a.pm').hide();
						$('#pm a.newpm').show().unbind('mouseover').mouseover(function() {
							$('#pm a.newpm').alert(s, {"width": 150, "pos": 7, "delay": 1000, "alerticon": 0});
						});
						_this.delay = g_newpm_delay;
						_this.run();
					} else if(json.status == 2) {
						g_newpm_userlist = null;
						_this.delay = _this.delay * 2;
						_this.run();
					} else if(json.status == -1) {
						// 退出登录，什么都不做
					} else {
						// 发生错误，不提示，否则太频繁，影响用户体验。可以在后台查看PHP错误日志
						// alert(json.message);
					}
				});
			}, _this.delay);
		};
		return this;
	}
	
	
	var newpm_instance = new newpm(); 
	newpm_instance.run();
	
	<?php if(DEBUG == 2) { ?>
	//newpm_instance.stop();
	<?php } ?>
	// ----------------> 短消息 end
	
	// 鼠标放在上面，显示最后联系的5个人。

<?php } ?>

</script>

<?php echo isset($conf['footer_js']) ? $conf['footer_js'] : '';?>

<?php if(isset($thread)) { ?>
<script>
$('#button_collect').click(function(){
	$.get('http://127.0.0.1/my-addcollect-fid-<?php echo isset($thread['fid']) ? $thread['fid'] : '';?>-tid-<?php echo isset($thread['tid']) ? $thread['tid'] : '';?>-ajax-1.htm', function(s) {
			var json = json_decode(s);
			if(error = json_error(json)) {alert(error); return false;}
			if(json.status <= 0) {alert(json.message); return false;}
			json = json.message;
			//alert(json);
			$('#collect_notice').html(json);
	});	
})
</script>
<?php } ?>
<script type="text/javascript" src="<?php echo isset($conf['static_url']) ? $conf['static_url'] : '';?>plugin/UpMenuDown/UpMenuDown.js"></script>
<link href="<?php echo isset($conf['static_url']) ? $conf['static_url'] : '';?>plugin/UpMenuDown/updown.css" type="text/css" rel="stylesheet" />
<div class="TopBottomMenu" style="display: none;">
<ul>
		<li>
		<b><font size="2" color="red">欢迎光临厦大生活网，意见、建议、合作、加入我们请联系底部QQ</font></b>
		</li>
	</ul>
</div>
<script type="text/javascript">$(document).ready(function(){$(this).dwseeTopBottomMenu()})</script>
