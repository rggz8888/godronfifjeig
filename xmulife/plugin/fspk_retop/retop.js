// JavaScript Document
	jQuery(document).ready(function($){	
		var $backToTopTxt = '<img src="plugin/fspk_retop/retop.png" onmouseover="this.src=\'plugin/fspk_retop/retop.png\'" onmouseout="this.src=\'plugin/fspk_retop/retop.png\'" />', $backToTopEle = $('<div class="backToTop" style="padding:0px;width:38px;position:fixed;_position:absolute;bottom:95px;_bottom:\'auto\';display:none;cursor:pointer"></div>').appendTo($("body"))
			.html($backToTopTxt).attr("title", '返回顶部').click(function() {
				$("html, body").animate({ scrollTop: 0 }, 120);
		}), $backToTopFun = function() {
			var _wt = document.body.clientWidth;
			var _bw = $('div.innerWrapper').width();
			if((_wt-_bw)>40)
			{
				$backToTopEle.css('right', ((_wt-_bw)/2)-530);
				var st = $(document).scrollTop(), winh = $(window).height();
				(st > 0)? $backToTopEle.show(): $backToTopEle.hide();
				//IE6下的定位
				if (!window.XMLHttpRequest) {
					$backToTopEle.css("top", st + winh - 150);
				}
			}
			else
			{
				$backToTopEle.css('display','none');
			}
		};
		$(window).bind("scroll", $backToTopFun).bind('resize', $backToTopFun);
		$(function() { $backToTopFun(); });
	});
	
