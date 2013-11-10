<?php !defined('FRAMEWORK_PATH') && exit('Access Denied');?><div class="div">
	<div class="header" style="font-weight: normal;">
		<table width="100%" cellspacing="0" cellpadding="0" style="word-break: break-all" >
			<tr align="left">
				<td width="80" align="center" >回复</td>
				<td valign="middle" class="subject">
				<?php if($fid) { ?>
					<a href="http://127.0.0.1/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>.htm" rel="nofollow" <?php if(!core::gpc('digest')) { ?>class="grey"<?php } ?>>普通主题</a> <span class="grey2">|</span> 
					<a href="http://127.0.0.1/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-digest-1.htm" rel="nofollow" <?php if(core::gpc('digest')) { ?>class="grey"<?php } ?>>精华主题</a>
					
					<?php if(!core::gpc('digest') && !core::gpc('typeid1') && !core::gpc('typeid2') && !core::gpc('typeid3') && !core::gpc('typeid4')) { ?>
					<span id="nav_orderby">
						<a href="http://127.0.0.1/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-page-<?php echo isset($page) ? $page : '';?>.htm" class="icon icon-orderby-0  <?php echo isset($_checked['orderby'][0]) ? $_checked['orderby'][0] : '';?>" title="顶帖时间排序" rel="nofollow" style="vertical-align: top; margin-left: 8px;"></a><a href="http://127.0.0.1/forum-index-fid-<?php echo isset($fid) ? $fid : '';?>-page-<?php echo isset($page) ? $page : '';?>.htm" class="icon icon-orderby-1  <?php echo isset($_checked['orderby'][1]) ? $_checked['orderby'][1] : '';?>" title="发帖时间排序" rel="nofollow" style="vertical-align: top; margin-left: 4px;"></a>
					</span>
					<?php } ?>
				<?php } else { ?>
					标题
				<?php } ?>
					
				</td>
				
				
				<td width="80" class="username">发帖</td>
				<td width="80" class="lastpost">回帖</td>
				<td width="80" class="views" align="center">查看</td>
				
			</tr>
		</table>
	</div>
	<div class="body threadlist" id="threadlist">
	
		
	
		<?php if(!empty($toplist)) { foreach($toplist as &$thread) {?>
			<?php include $this->gettpl('thread_list_line.inc.htm');?>
		<?php }} ?>
		
		<?php if(!empty($toplist)) { ?>
		<div class="bg2" style="line-height: 12px; height: 12px;">
			<div style="width: 56px; float: left;" class="grey"></div>
		</div>
		<hr />
		<?php } ?>
		
		<?php if(!empty($threadlist)) { foreach($threadlist as &$thread) {?>
			<?php include $this->gettpl('thread_list_line.inc.htm');?>
		<?php }} ?>
		
		

	</div>
	<div class="footer"></div>
</div>
<?php if(!empty($pages)) { ?>
<div class="page" style="margin: auto; margin-top: 8px; text-align: center; clear: both;"><?php echo isset($pages) ? $pages : '';?></div>
<?php } ?>


<?php if($fid && $ismod) { ?>
<div style="text-align: center; margin-top: 8px;">
	<input type="checkbox" name="checkall" id="mod_checkall" /><label for="mod_checkall">全选</label>
	<a type="button" class="button smallblue" id="mod_top" value="置顶" href="javascript:void(0)" role="button"><span>置顶</span></a>
	<?php if(!empty($forum['typecates'])) { ?>
	<a type="button" class="button smallblue" id="mod_type" value="主题分类" href="javascript:void(0)" role="button"><span>主题分类</span></a>
	<?php } ?>
	<a type="button" class="button smallblue" id="mod_digest" value="精华" href="javascript:void(0)" role="button"><span>精华</span></a>
	<a type="button" class="button smallblue" id="mod_move" value="移动" href="javascript:void(0)" role="button"><span>移动</span></a>
	
	<a type="button" class="button smallblue" id="mod_delete" value="删除" href="javascript:void(0)" role="button"><span>删除</span></a>
	
</div>
<?php } ?>


