<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><?php include $this->gettpl('header.htm');?>



<div class="width">

	
	
	<table id="nav" cellpadding="0" cellspacing="0" style="margin-bottom: 4px;">
		<tr>
			<td class="left"></td>
			<td class="center">
				<a class="icon icon-home" href="./"></a>
				<span class="sep"></span>
				
				<span>最新帖</span>
				
<a target="_blank" href="http://wp.qq.com/wpa/qunwpa?idkey=629b5c396e691f8e4ae984faf19f31e3bcb13b4c8e568b3831df62f76da1ca4e" ><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="厦大生活网" title="厦大生活网" "></a>
<iframe width="63" height="22" align="top" frameborder="0" allowtransparency="true" marginwidth="0" marginheight="0" scrolling="no" border="0" src="http://widget.weibo.com/relationship/followbutton.php?language=zh_cn&uid=3280708304&style=1&btn=red&dpc=1"></iframe>

			</td>
			<td class="center2">
				<?php include $this->gettpl('header_user.inc.htm');?>
				<a href="http://127.0.0.1/post-thread-fid-<?php echo isset($fid) ? $fid : '';?>-ajax-1.htm" target="_blank" onclick="return false;" id="create_thread"  rel="nofollow"><span class="icon icon-post-newthread"></span> 发新帖</a>
			</td>
			<td class="right"></td>
		</tr>
	</table>
	
	
	
	<?php include $this->gettpl('thread_list.inc.htm');?>
	
	
	
	<div class="div">
		<div class="header"><span class="icon icon-stat"></span> 站点统计</div>
		<div class="body">
			<div style="margin-top: 8px; line-height: 12px; margin-bottom: 4px;">
				
				<span class="grey">帖子：</span><span><?php echo isset($conf['posts']) ? $conf['posts'] : '';?></span> <span class="small grey2">|</span>
				<span class="grey">会员：</span><span><?php echo isset($conf['users']) ? $conf['users'] : '';?></span>
				<?php if($conf['todayposts']) { ?>
				<span class="small grey2">|</span>
				<span class="grey">今日发帖：</span><span class="new bold"><?php echo isset($conf['todayposts']) ? $conf['todayposts'] : '';?></span>
				<?php } ?>
				<?php if($conf['todayusers']) { ?>
				<span class="small grey2">|</span>
				<span class="grey">今日注册：</span><span class="new bold"><?php echo isset($conf['todayusers']) ? $conf['todayusers'] : '';?></span>
				<?php } ?>
				<?php if($conf['newusername']) { ?>
				<span class="small grey2">|</span>
				<span class="grey">新会员:</span> <a href="http://127.0.0.1/you-profile-uid-<?php echo isset($conf['newuid']) ? $conf['newuid'] : '';?>-ajax-1.htm" target="_blank" class="ajaxdialog" ajaxdialog="{position: 6, modal: false}" rel="nofollow"><?php echo isset($conf['newusername']) ? $conf['newusername'] : '';?></a>
				<?php } ?>
				<span class="small grey2">|</span>
				<span class="grey">在线：</span><span class="new bold"><a href="http://127.0.0.1/online-list-ajax-1.htm" class="ajaxdialog" onclick="return false;"><?php echo isset($conf['onlines']) ? $conf['onlines'] : '';?></a></span>
				
			</div>
		</div>
		<div class="footer"></div>
	</div>
	
	<div class="div">
	<div class="header">友情链接</div>
	<div class="body grey">
		<?php if($friendlinklist[1]) { ?>
		<div id="friendlink_img">
			<?php if(!empty($friendlinklist[1])) { foreach($friendlinklist[1] as &$friendlink) {?>
			<a href="<?php echo isset($friendlink['url']) ? $friendlink['url'] : '';?>" target="_blank" title="<?php echo isset($friendlink['sitename']) ? $friendlink['sitename'] : '';?>"><img src="<?php echo isset($friendlink['logourl']) ? $friendlink['logourl'] : '';?>" width="88" height="31" class="xgrey" /></a>
			<?php }} ?>
		</div>
		<?php } ?>
		
		<?php if($friendlinklist[0]) { ?>
		<div id="friendlink_text">
			<?php if(!empty($friendlinklist[0])) { foreach($friendlinklist[0] as &$friendlink) {?>
			<a href="<?php echo isset($friendlink['url']) ? $friendlink['url'] : '';?>" target="_blank" class="grey2"><?php echo isset($friendlink['sitename']) ? $friendlink['sitename'] : '';?></a>
			<?php }} ?>
		</div>
		<?php } ?>
		&nbsp;
	</div>
	<div class="footer"></div>
</div>
	
</div>



<?php include $this->gettpl('footer.htm');?>

<?php include $this->gettpl('thread_list_js.inc.htm');?>

<script type="text/javascript">
$('#friendlink_img img').hover(function() {$(this).removeClass('xgrey')}, function() {$(this).addClass('xgrey')});
$('div.div div.body').find('div.hr:last').hide();// 隐藏最后一个 hr

// 鼠标背景变色
$('table.forum').bind('mouseover', function() {$('td:gt(0)', this).removeClass('bg1').addClass('bg2');});
$('table.forum').bind('mouseout', function() {$('td:gt(0)', this).removeClass('bg2').addClass('bg1');});

</script>



</body>
</html>