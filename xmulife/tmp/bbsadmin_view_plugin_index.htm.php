<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><!DOCTYPE html>
<head>   
	<title><?php if(!empty($_title)) { foreach($_title as &$title) {?><?php echo isset($title) ? $title : '';?><?php }} ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="MSSmartTagsPreventParsing" content="True" />
	<meta http-equiv="MSThemeCompatible" content="Yes" />
	<link href="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/common.css" type="text/css" rel="stylesheet" />
	<style>
		#body {margin: 0px;}
		/* accordion 仅后台使用 */
		#accordion h3, #accordion ul {padding:0px;margin:0px;}
		#accordion h3 {font-size:12px; color:#FFFFFF; line-height: 20px; height: 20px; text-indent: 4px; padding:0px; cursor:pointer; background:url('../view/image/page.gif') repeat-x;}
		#accordion h3 a {color:#FFFFFF;}
		#accordion ul {padding-bottom:2px; border-left:1px #CCCCCC solid; border-right:1px #CCCCCC solid;}
		#accordion li {font-size:12px; padding-left:10px; list-style-type:none; background-color:#FFFFFF; line-height:1.8;}
		.width {width: 800px; margin: auto; overflow: hidden;}
	</style>
	<script type="text/javascript">
	var cookie_pre = '<?php echo isset($conf['cookie_pre']) ? $conf['cookie_pre'] : '';?>';
	</script>
</head>
<body>
<div id="body">
<div class="width">
	<form action="http://www.xmulife.com/admin/user-list-page-<?php echo isset($page) ? $page : '';?>.htm" method="post" id="pluginform">
		<input type="hidden" name="FORM_HASH" value="<?php echo FORM_HASH;?>" />
		<h2>本地插件列表  <span class="clear">当前论坛版本: <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></span></h2>
		
		<?php if(!$installlist && !$disablelist && !$unstalllist) { ?>
		<div class="box bg2 border shadow">没有安装过插件，您可以尝试浏览“线上插件”。</div>
		<?php } ?>
		
		<div class="list">
			
			<?php if($installlist) { ?>
			<table class="table">
				<tr class="header">
					<td colspan="4">已安装插件</td>
				</tr>
				<?php if(!empty($installlist)) { foreach($installlist as $dir=>&$pconf) {?>
				<tr valign="top" plugindir="<?php echo isset($dir) ? $dir : '';?>">
					<td width="54"><a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><img src="<?php echo isset($pconf['icon_url']) ? $pconf['icon_url'] : '';?>" width="54" height="54" /></a></td>
					<td width="140">
						<a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><b><?php echo isset($pconf['name']) ? $pconf['name'] : '';?> </b></a>v<?php echo isset($pconf['version']) ? $pconf['version'] : '';?>
						<?php if($pconf['have_new_version']) { ?><a href="http://www.xmulife.com/admin/plugin-upgrade-dir-<?php echo isset($dir) ? $dir : '';?>.htm" target="_blank" title="点击升级"><span class="red small bold">(NEW! v<?php echo isset($pconf['official_version']) ? $pconf['official_version'] : '';?>)</span></a><?php } ?>
						<br /><span class="small"><?php echo isset($dir) ? $dir : '';?></span>
						<br /><img src="http://xmulife.u.qiniudn.com/admin/view/image/star_<?php echo isset($pconf['stars']) ? $pconf['stars'] : '';?>.gif" width="63" height="11" align="middle" />
					</td>
					<td>
						<p class="grey"><?php echo isset($pconf['brief']) ? $pconf['brief'] : '';?></p>
						<?php echo isset($pconf['username']) ? $pconf['username'] : '';?>
						<br /><span class="grey"><?php echo isset($pconf['email']) ? $pconf['email'] : '';?></span>
					</td>
					<td width="200">
						<a type="button" class="button smallblue" onclick="window.location='http://www.xmulife.com/admin/plugin-disable-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="禁用" href="javascript:void(0)" role="button"><span>禁用</span></a>
						<a type="button" class="button smallgrey" onclick="if(window.confirm('删除操作不可逆！您确定删除该插件吗？'))window.location='http://www.xmulife.com/admin/plugin-unstall-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="删除" href="javascript:void(0)" role="button"><span>删除</span></a>
						<?php if($pconf['have_setting']) { ?>
						<a type="button" class="button smallblue" onclick="window.location='http://www.xmulife.com/admin/plugin-setting-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="设置" href="javascript:void(0)" role="button"><span>设置</span></a>
						<?php } ?>
					</td>
				</tr>
				<?php }}?>
			</table>
			<?php } ?>
			
			<?php if($disablelist) { ?>
			<table class="table">
				<tr class="header">
					<td colspan="4">未启用的插件</td>
				</tr>
				<?php if(!empty($disablelist)) { foreach($disablelist as $dir=>&$pconf) {?>
				<tr valign="top" plugindir="<?php echo isset($dir) ? $dir : '';?>">
					<td width="54"><a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><img src="<?php echo isset($pconf['icon_url']) ? $pconf['icon_url'] : '';?>" width="54" height="54" /></a></td>
					<td width="140">
						<a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><b><?php echo isset($pconf['name']) ? $pconf['name'] : '';?> </b></a>v<?php echo isset($pconf['version']) ? $pconf['version'] : '';?>
						<?php if($pconf['have_new_version']) { ?><a href="http://www.xmulife.com/admin/plugin-upgrade-dir-<?php echo isset($dir) ? $dir : '';?>.htm" target="_blank" title="点击升级"><span class="red small bold">(NEW! v<?php echo isset($pconf['official_version']) ? $pconf['official_version'] : '';?>)</span></a><?php } ?>
						<br /><span class="small"><?php echo isset($dir) ? $dir : '';?></span>
						<br /><img src="http://xmulife.u.qiniudn.com/admin/view/image/star_<?php echo isset($pconf['stars']) ? $pconf['stars'] : '';?>.gif" width="63" height="11" align="middle" />
					</td>
					<td>
						<p class="grey"><?php echo isset($pconf['brief']) ? $pconf['brief'] : '';?></p>
						<?php echo isset($pconf['author']) ? $pconf['author'] : '';?>
						<br /><span class="grey"><?php echo isset($pconf['email']) ? $pconf['email'] : '';?></span>
					</td>
					<td width="200">
						<a type="button" class="button smallblue" onclick="window.location='http://www.xmulife.com/admin/plugin-enable-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="启用" href="javascript:void(0)" role="button"><span>启用</span></a>
						<a type="button" class="button smallgrey" onclick="if(window.confirm('删除操作不可逆！确定删除?'))window.location='http://www.xmulife.com/admin/plugin-unstall-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="删除" href="javascript:void(0)" role="button"><span>删除</span></a>
					
						<?php if(!empty($pconf['have_setting'])) { ?>
						<a type="button" value="设置" class="button smallblue setting" onclick="window.location='http://www.xmulife.com/admin/plugin-setting-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" href="javascript:void(0)" role="button"><span>设置</span></a>
						<?php } ?>
					</td>
				</tr>
				<?php }}?>
			</table>
			<?php } ?>
			
			<?php if($unstalllist) { ?>
			<table class="table">
				<tr class="header">
					<td colspan="4">未安装的插件</td>
				</tr>
				<?php if(!empty($unstalllist)) { foreach($unstalllist as $dir=>&$pconf) {?>
				<tr valign="top" plugindir="<?php echo isset($dir) ? $dir : '';?>">
					<td width="54"><a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><img src="<?php echo isset($pconf['icon_url']) ? $pconf['icon_url'] : '';?>" width="54" height="54" /></a></td>
					<td width="140">
						<a href="http://www.xmulife.com/admin/plugin-read-dir-<?php echo isset($dir) ? $dir : '';?>.htm"><b><?php echo isset($pconf['name']) ? $pconf['name'] : '';?> </b>v<?php echo isset($pconf['version']) ? $pconf['version'] : '';?></a>
						<?php if($pconf['have_new_version']) { ?><span class="red small bold">(NEW! v<a href="http://www.xmulife.com/admin/plugin-upgrade-dir-<?php echo isset($dir) ? $dir : '';?>.htm" target="_blank"><?php echo isset($pconf['official_version']) ? $pconf['official_version'] : '';?></a>)</span><?php } ?>
						<br /><span class="small"><?php echo isset($dir) ? $dir : '';?></span>
						<br /><img src="http://xmulife.u.qiniudn.com/admin/view/image/star_<?php echo isset($pconf['stars']) ? $pconf['stars'] : '';?>.gif" width="63" height="11" align="middle" />
					</td>
					<td>
						<p class="grey"><?php echo isset($pconf['brief']) ? $pconf['brief'] : '';?></p>
						<?php echo isset($pconf['author']) ? $pconf['author'] : '';?>
						<br /><span class="grey"><?php echo isset($pconf['email']) ? $pconf['email'] : '';?></span></td>
					<td width="200">
						<a type="button" class="button smallblue" onclick="window.location='http://www.xmulife.com/admin/plugin-install-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="安装" href="javascript:void(0)" role="button"><span>安装</span></a>
						<a type="button" class="button smallgrey" onclick="if(window.confirm('确定删除?'))window.location='http://www.xmulife.com/admin/plugin-unstall-dir-<?php echo isset($dir) ? $dir : '';?>.htm';return false;" value="删除" href="javascript:void(0)" role="button"><span>删除</span></a>
					</td>
				</tr>
				<?php }}?>
			</table>
			<?php } ?>
		</div>
		<br />
		<?php if(!IN_SAE) { ?>
		<p>
			【注意】：为了安全，插件安装完毕以后请修改 conf/conf.php 中的 plugin_on 为 0 （请使用 UTF-8 文本编辑器，不要使用 Windows 记事本）。
		<p>
		<?php } else { ?>
		<p>
			【注意】：SAE 环境需要下载 TMP 包才能使新安装设置的插件生效！点击<a type="button" class="button smallblue" onclick="window.location='http://www.xmulife.com/admin/plugin-saetmp.htm';return false;" value="下载 TMP 包" href="javascript:void(0)" role="button"><span>下载 TMP 包</span></a>
		<p>
		<?php } ?>
	</form>
</div>

</div>
<div id="footer">

	<div style="height: 35px; padding: 8px;">
		<div style="width: 40%; float: left;">
			<?php echo isset($conf['app_copyright']) ? $conf['app_copyright'] : '';?><br />
			Powered by  <a href="http://www.xiuno.com" target="_blank" class="grey">Xiuno BBS <b><?php echo isset($conf['version']) ? $conf['version'] : '';?></b></a>
		</div>
		<div style="width: 60%; float: right; text-align: right;">
			<?php echo isset($conf['china_icp']) ? $conf['china_icp'] : '';?><br />
			<?php echo isset($_SERVER['time_fmt']) ? $_SERVER['time_fmt'] : '';?>, 耗时:<?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>s
		</div>
	</div>

	<?php if(DEBUG) { ?>

<div class="box">
<h3>Debug Information: </h3>
<pre>

<b>Memory</b> = <?php echo memory_get_usage();?>

<b>Processtime</b> = <?php echo number_format(microtime(1) - $_SERVER['starttime'], 4);?>

<b>REQUEST_URI:</b> = <a href="<?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?>" target="_blank" style="color: #888888"><?php echo isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';?></a>

<b>_GET</b> = <?php echo htmlspecialchars(print_r($_GET, 1));?>

<b>_POST</b> = <?php echo htmlspecialchars(print_r($_POST, 1));?>

<b>_COOKIE</b> = <?php echo htmlspecialchars(print_r($_COOKIE, 1));?>

<b>SQL:</b> = <?php isset($_SERVER['sqls']) && print_r($_SERVER['sqls']);?>

<b>_user</b> = <?php print_r($_user);?>

<b>include:</b> = <?php print_r(get_included_files());?>

</pre>
	
</div>

<?php } ?>
</div>

<?php if(DEBUG) { ?>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/jquery-1.4.full.js" type="text/javascript" ></script>
<?php } else { ?>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/jquery-1.4.min.js" type="text/javascript" ></script>
<?php } ?>

<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/dialog.js" type="text/javascript"></script>
<script src="<?php echo isset($bbsconf['static_url']) ? $bbsconf['static_url'] : '';?>view/js/common.js" type="text/javascript"></script>

<script type="text/javascript">

$('a.ajaxdialog, input.ajaxdialog').die('click').live('click', ajaxdialog_click);
$('a.ajaxtoggle').die('click').live('click', ajaxtoggle_event);

$('div.list .table tr:odd').not('tr.header').addClass('odd');	/* 奇数行的背景色 */
$('div.list .table tr:last').addClass('last');	/* 奇数行的背景色 */


</script>

</body>
</html>