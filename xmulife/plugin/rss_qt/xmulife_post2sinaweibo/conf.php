<?php

// 帖子同步至新浪微博
// 2013-10-10 -----  容神
// http://www.xmulife.com
// 演示： http://www.weibo.com/xmulife
// 到新浪微博开放平台创建应用，获取APPkey等，不需实名认证，不需提交应用。
// 修改部分：

return 	array (
	'enable' => 1,			// 是否启用?
	'installed' => 1,		// 已经安装?
	'name'=>'发帖同步至新浪微博',		// 插件名
	'brief'=>'新浪微博同步插件',
	'version'=>'1.0',		// 插件版本
	'bbs_version'=>'2.*',		// 插件支持的 Xiuno BBS 版本
	'icon'=>'',			// 插件的LOGO
	'icon_big'=>'',			// 插件的LOGO
	'author'=>'容神',		// 插件的作者
	'author_homepage'=>'http://www.xmulife.com',	// 插件作者的主页
	'email'=>'yzhaorong@gmail.com',	// 插件的联系EMAIL
	'stars' => 1,			// 官方对插件的评级，1-5星级。
	'verify_code' => '',		// 经过官方安全认证的标志。
);

?>
