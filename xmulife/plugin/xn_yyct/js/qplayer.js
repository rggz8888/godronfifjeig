;(function(){window.jQuery=window.jQuery||($={extend:function(){var args=arguments,len=arguments.length,i=1,target=args[0],opts,src,copy;if(typeof target!=="object"&&typeof target!=="function"){target={};}
if(len===i){target=this;--i;}
for(;i<len;i++){if((opts=arguments[i])!=null){for(var name in opts){src=target[name];copy=opts[name];if(target===copy){continue;}
if(copy!==undefined){target[name]=copy;}}}}
return target;}});})();;(function($){$.qPlayer=$.qPlayer||{};var o={};$.extend($.qPlayer,{on:function(ev,callback){var calls=o._callbacks||(o._callbacks={});(o._callbacks[ev]||(o._callbacks[ev]=[])).push(callback);return this;},off:function(ev){(o._callbacks)&&(o._callbacks[ev])&&(o._callbacks[ev]=[]);return this;},trigger:function(){var args=Array.prototype.slice.call(arguments,0);var ev=args.shift();var list,calls;if(!(calls=o._callbacks)||!(list=o._callbacks[ev])){return this;}
for(var i=0,l=list.length;i<l;i++){list[i].apply(this,args);}
return this;}});})(jQuery);;(function($){$.qPlayer=$.qPlayer||{};$.extend($.qPlayer,{jsLoader:function(src,charset){charset=charset||"utf-8";var _js=document.createElement('script');_js.setAttribute("src",src);_js.setAttribute("charset",charset);document.getElementsByTagName("head")[0].appendChild(_js);}});})(jQuery);;(function($){$.qPlayer=$.qPlayer||{};$.extend($.qPlayer,{addEvent:function(oTarget,sEventType,fnHandler){if(oTarget.attachEvent){oTarget.attachEvent(sEventType,fnHandler);}else if(oTarget.addEventListener){oTarget.addEventListener(sEventType,fnHandler,false);}else{oTarget[sEventType]=fnHandler;}},removeEvent:function(oTarget,sEventType,fnHandler){if(oTarget.detachEvent){oTarget.detachEvent(sEventType,fnHandler);}else if(oTarget.removeEventListener){oTarget.removeEventListener(sEventType,fnHandler,false);}else{oTarget[sEventType]=null;}},cookie:{set:function(name,value,domain,path,hour){if(hour){var expire=new Date();expire.setTime(expire.getTime()+3600000*hour);}
document.cookie=name+"="+value+"; "+(hour?("expires="+expire.toGMTString()+"; "):"")+(path?("path="+path+"; "):"path=/; ")+(domain?("domain="+domain+";"):("domain=qq.com;"));return true;},get:function(name){var r=new RegExp("(?:^|;+|\\s+)"+name+"=([^;]*)"),m=document.cookie.match(r);return(!m?"":m[1]);},del:function(name,domain,path){document.cookie=name+"=; expires=Mon, 26 Jul 1997 05:00:00 GMT; "+(path?("path="+path+"; "):"path=/; ")+(domain?("domain="+domain+";"):("domain=qq.com;"));}}});})(jQuery);;(function($){$.qPlayer=$.qPlayer||{};$.qPlayer.on("qplayer:play",function(){$.qPlayer.stoped(false);$.qPlayer.trigger("play");});$.qPlayer.on("qplayer:ended",function(){$.qPlayer.stoped(true);$.qPlayer.autoNext();});$.qPlayer.on("qplayer:playbegin",function(playInfo){$.qPlayer.trigger("playbegin",playInfo);});$.qPlayer.on("qplayer:playend",function(playInfo){$.qPlayer.stoped(true);$.qPlayer.trigger("playend",playInfo);});$.qPlayer.on("qplayer:playing",function(){$.qPlayer.stoped(false);$.qPlayer.trigger("playing");});$.qPlayer.on("qplayer:pause",function(){$.qPlayer.trigger("pause");});$.qPlayer.on("qplayer:stop",function(){$.qPlayer.stoped(true);$.qPlayer.trigger("stop");});$.qPlayer.on("qplayer:progress",function(){$.qPlayer.trigger("progress");});$.qPlayer.on("qplayer:downloadprogress",function(progressInfo){$.qPlayer.trigger("downloadprogress",progressInfo);$.qPlayer.downloadProgress(progressInfo.nProgress);});$.qPlayer.on("qplayer:timeupdate",function(timeinfo){$.qPlayer.trigger("timeupdate",timeinfo);$.qPlayer.curTime(timeinfo.currentTime);$.qPlayer.duration(timeinfo.totalTime);$.qPlayer.stoped(false);$.qPlayer.watch.add(new Date());});$.qPlayer.on("qplayer:init",function(msg){$.qPlayer.trigger("init");$.qPlayer.off("init");$.qPlayer.isLoading=false;if(!!msg){$.qPlayer.playerType(msg.plugin||"");$.qPlayer.watch.setPlugin(msg.plugin||"");$.qPlayer.watch.add(new Date());}});$.qPlayer.on("qplayer:qzonemusic",function(){$.qPlayer.player=$.qPlayer.player||{};var qqplayer=null;var plv="0";var mPlayerSource="",mCurPlaySrc="";var mQQPlayerConfig={REP_PLAYURL_IP_ARRAY:["121.14.73.62","121.14.73.48","58.60.9.178","58.61.165.54"],REP_PLAYURL_PORT:17785,P2P_UDP_SVR_IP_ARRAY:["119.147.65.30","58.61.166.180","pdlmusic.p2p.qq.com"],P2P_UDP_SVR_PORT:8000,P2P_TCP_SVR_IP_ARRAY:["119.147.65.30","58.61.166.180","pdlmusic.p2p.qq.com"],P2P_TCP_SVR_PORT:433,P2P_STUN_SVR_IP:"stun-a1.qq.com",P2P_STUN_SVR_PORT:8000,P2P_TORRENT_URL:"http://219.134.128.55/",P2P_CACHE_SPACE:100,STAT_REPORT_SVR_IP:"219.134.128.41",STAT_REPORT_SVR_PORT:17653,REP_PLAYSONG_IP_ARRAY:["58.60.11.85","121.14.96.113","58.61.165.50","121.14.95.82"],REP_PLAYSONG_PORT:8000,REP_SONGLIST_IP_ARRAY:["121.14.94.181","121.14.94.183"],REP_SONGLIST_PORT:8000};function insertQQPlayer(args){var params={};var objAttrs={};for(var k in args)
{switch(k)
{case"classid":case"style":case"name":case"height":case"width":case"id":objAttrs[k]=args[k];break;default:params[k]=args[k];}}
var str=[];str.push('<object ');for(var i in objAttrs){str.push(i);str.push('="');str.push(objAttrs[i]);str.push('" ');}
str.push('>');for(var i in params){str.push('<param name="');str.push(i);str.push('" value="');str.push(params[i]);str.push('" /> ');}
str.push('</object>');var div=document.createElement('div');document.body.appendChild(div);div.innerHTML=str.join('');qqplayer=div.firstChild;}
function createPlayer(){var oPlayerCtrl=new ActiveXObject("QzonePlayer.PlayerCtrl");plv=oPlayerCtrl.GetPlayerSvrVersion();oPlayerCtrl.Uninitialize();var ttii=(parseInt(Math.random()*1000))%mQQPlayerConfig.REP_PLAYSONG_IP_ARRAY.length;var ttii2=(parseInt(Math.random()*1000))%mQQPlayerConfig.REP_SONGLIST_IP_ARRAY.length;var ttii3=(parseInt(Math.random()*1000))%mQQPlayerConfig.REP_PLAYURL_IP_ARRAY.length;var ttii4=(new Date()).getTime()%2;if(plv>="3.2"){ttii4=2;}
insertQQPlayer({classid:'CLSID:E05BC2A3-9A46-4A32-80C9-023A473F5B23',id:'QzonePlayer',height:0,width:0,PlayerType:2,CacheSize:mQQPlayerConfig.P2P_CACHE_SPACE,ValidDomain:'qq.com',EnableSyncListen:1,UploadStatCount:10,ExitDelayTime:5,UsedWhirl:0,RestrictHttpStartInterval:1,RestrictHttpStopInterval:100,P2PUDPServ_IP:mQQPlayerConfig.P2P_UDP_SVR_IP_ARRAY[ttii4],P2PUDPServ_Port:mQQPlayerConfig.P2P_UDP_SVR_PORT,P2PTCPServ_IP:mQQPlayerConfig.P2P_TCP_SVR_IP_ARRAY[ttii4],P2PTCPServ_Port:mQQPlayerConfig.P2P_TCP_SVR_PORT,P2PStunServ_IP:mQQPlayerConfig.P2P_STUN_SVR_IP,P2PStunServ_Port:mQQPlayerConfig.P2P_STUN_SVR_PORT,RepPlaySong_IP:mQQPlayerConfig.REP_PLAYSONG_IP_ARRAY[ttii],RepPlaySong_Port:mQQPlayerConfig.REP_PLAYSONG_PORT,RepSongList_IP:mQQPlayerConfig.REP_SONGLIST_IP_ARRAY[ttii2],RepSongList_Port:mQQPlayerConfig.REP_SONGLIST_PORT,RepPlayURL_IP:mQQPlayerConfig.REP_PLAYURL_IP_ARRAY[ttii3],RepPlayURL_Port:mQQPlayerConfig.REP_PLAYURL_PORT});}
var OnInitialized=function(){};var OnUninitialized=function(){};var OnStateChanged=function(newState){switch(newState){case 0:break;case 1:$.qPlayer.trigger("qplayer:stop");break;case 2:$.qPlayer.trigger("qplayer:pause");break;case 3:$.qPlayer.trigger("qplayer:playing");break;case 4:$.qPlayer.trigger("qplayer:progress");break;case 5:$.qPlayer.trigger("qplayer:play");break;case 6:$.qPlayer.trigger("qplayer:ended");break;default:break;};};var OnPlayProgress=function(currentTime,duration){$.qPlayer.trigger("qplayer:timeupdate",{currentTime:currentTime,totalTime:duration});};var OnPlayError=function(lErrCode,sErrDesc){$.qPlayer.trigger("qplayer:error",{code:lErrCode,msg:sErrDesc});};var OnDnldProgress=function(curPos,downloadProgress){$.qPlayer.trigger("qplayer:downloadprogress",{nProgress:downloadProgress});};var OnPlaySrcChanged=function(sNewPlaySrc,sOldPlaySrc){mCurPlaySrc=sNewPlaySrc;if(mCurPlaySrc!=mPlayerSource){$.qPlayer.trigger("qplayer:pause");qqplayer.Pause();}};function initEvent(){qqplayer.attachEvent("OnInitialized",OnInitialized);qqplayer.attachEvent("OnUninitialized",OnUninitialized);qqplayer.attachEvent("OnStateChanged",OnStateChanged);qqplayer.attachEvent("OnPlayProgress",OnPlayProgress);qqplayer.attachEvent("OnPlayError",OnPlayError);qqplayer.attachEvent("OnDnldProgress",OnDnldProgress);qqplayer.attachEvent("OnPlaySrcChanged",OnPlaySrcChanged);qqplayer.Initialize();qqplayer.Volume=75;mPlayerSource="web_player_"+new Date().getTime();mCurPlaySrc=mPlayerSource;qqplayer.PlaySrc=mPlayerSource;window.attachEvent("onunload",unInitEvent);}
function unInitEvent(){try
{qqplayer.detachEvent("OnInitialized",OnInitialized);qqplayer.detachEvent("OnUninitialized",OnUninitialized);qqplayer.detachEvent("OnStateChanged",OnStateChanged);qqplayer.detachEvent("OnPlayProgress",OnPlayProgress);qqplayer.detachEvent("OnPlayError",OnPlayError);qqplayer.detachEvent("OnDnldProgress",OnDnldProgress);qqplayer.detachEvent("OnPlaySrcChanged",OnPlaySrcChanged);if(qqplayer.Uninitialize()){return true;}}
catch(e)
{return false;}}
$.extend($.qPlayer.player,{playUrl:function(songurl){if(/stream\d+\.qqmusic\.qq\.com\/(\d+)\.([^#$]*)/.test(songurl)){var sid=parseInt(RegExp.$1);if(RegExp.$2=="mp3"){sid-=30000000;}else{sid-=12000000;}
var tptUrl=['http://tpt.music.qq.com/',sid+30000000,'.tpt'].join('');qqplayer.SetCookie("qqmusic_uin","12345678");qqplayer.SetCookie("qqmusic_key","12345678");qqplayer.SetCookie("qqmusic_fromtag","29");qqplayer.SetCookie("qqmusic_musicid",sid+"");qqplayer.SetCookie("qqmusicchkkey_key","12345678");qqplayer.SetCookie("qqmusicchkkey_url",songurl);qqplayer.SetPlayURL(sid,songurl,tptUrl);}else{var sid=0;qqplayer.SetCookie("qqmusic_uin","12345678");qqplayer.SetCookie("qqmusic_key","12345678");qqplayer.SetCookie("qqmusic_fromtag","29");qqplayer.SetCookie("qqmusic_musicid",sid+"");qqplayer.SetCookie("qqmusicchkkey_key","12345678");qqplayer.SetCookie("qqmusicchkkey_url",songurl);qqplayer.SetPlayURL(sid,songurl,"");}},play:function(){qqplayer.Play();},pause:function(){qqplayer.Pause();},stop:function(){qqplayer.Stop();},setVolume:function(vol){if(vol>100){vol=100;}
if(vol<0){vol=0;}
if(vol>=0&&vol<=100){qqplayer.volume=vol;}},getVolume:function(){return qqplayer.volume;},setMute:function(mute){if(mute==true){qqplayer.Mute=1;}else{qqplayer.Mute=0;}
return!!qqplayer.Mute;},setCurrentTime:function(curtime){if(curtime<=0){curtime=0;}
qqplayer.CurPos=curtime;},init:function(){if(!!qqplayer){qqplayer.removeNode?qqplayer.removeNode(true):(qqplayer.parentNode&&qqplayer.parentNode.removeChild(qqplayer));qqplayer=null;}
createPlayer();initEvent();$.qPlayer.trigger("qplayer:init",{plugin:"qzonemusic"});}});$.qPlayer.player.init();});})(jQuery);;(function($){$.extend(String.prototype,{trim:function(){return this.replace(/(^\s*)|(\s*$)/g,"");},escapeHTML:function(){var div=document.createElement('div');var text=document.createTextNode(this);div.appendChild(text);return div.innerHTML;},unescapeHTML:function(){var div=document.createElement('div');div.innerHTML=this;return div.innerText||div.textNode||'';},cut:function(bitLen,tails){str=this;bitLen-=0;tails=tails||'...';if(isNaN(bitLen)){return str;}
var len=str.length,i=Math.min(Math.floor(bitLen/2),len),cnt=MUSIC.string.getRealLen(str.slice(0,i));for(;i<len&&cnt<bitLen;i++){cnt+=1+(str.charCodeAt(i)>255);}
return str.slice(0,cnt>bitLen?i-1:i)+(i<len?tails:'');},jstpl_format:function(ns){function fn(w,g){if(g in ns)
return ns[g];return'';};return this.replace(/%\(([A-Za-z0-9_|.]+)\)/g,fn);},myEncode:function(){return this.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\\/g,"＼").replace(/\'/g,"’").replace(/\"/g,"“").replace(/&#39;/g,"’").replace(/&quot;/g,"“").replace(/&acute;/g,"’").replace(/\%/g,"％").replace(/\(/g,"（").replace(/\)/g,"）").replace(/\n/g,"");},entityReplace:function(){return this.replace(/&#38;?/g,"&amp;").replace(/&amp;/g,"&").replace(/&#(\d+);?/g,function(a,b){return String.fromCharCode(b)}).replace(/´/g,"'").replace(/&lt;/g,"<").replace(/&gt;/g,">").replace(/&quot;/g,"\"").replace(/&acute;/gi,"'").replace(/&nbsp;/g," ").replace(/&#13;/g,"\n").replace(/(&#10;)|(&#x\w*;)/g,"").replace(/&amp;/g,"&");}});})(jQuery);(function($){var ua=$.ua={},agent=navigator.userAgent,nv=navigator.appVersion,r,m,optmz;if(window.ActiveXObject){ua.ie=6;(window.XMLHttpRequest||(agent.indexOf('MSIE 7.0')>-1))&&(ua.ie=7);(window.XDomainRequest||(agent.indexOf('Trident/4.0')>-1))&&(ua.ie=8);(agent.indexOf('Trident/5.0')>-1)&&(ua.ie=9);(agent.indexOf('Trident/6.0')>-1)&&(ua.ie=10);ua.isBeta=navigator.appMinorVersion&&navigator.appMinorVersion.toLowerCase().indexOf('beta')>-1;}else if(document.getBoxObjectFor||typeof(window.mozInnerScreenX)!='undefined'){r=/(?:Firefox|GranParadiso|Iceweasel|Minefield).(\d+\.\d+)/i;ua.firefox=parseFloat((r.exec(agent)||r.exec('Firefox/3.3'))[1],10);}else if(!navigator.taintEnabled){m=/AppleWebKit.(\d+\.\d+)/i.exec(agent);ua.webkit=m?parseFloat(m[1],10):(document.evaluate?(document.querySelector?525:420):419);if((m=/Chrome.(\d+\.\d+)/i.exec(agent))||window.chrome){ua.chrome=m?parseFloat(m[1],10):'2.0';}else if((m=/Version.(\d+\.\d+)/i.exec(agent))||window.safariHandler){ua.safari=m?parseFloat(m[1],10):'3.3';}
ua.air=agent.indexOf('AdobeAIR')>-1?1:0;ua.isiPod=agent.indexOf('iPod')>-1;ua.isiPad=agent.indexOf('iPad')>-1;ua.isiPhone=agent.indexOf('iPhone')>-1;}else if(window.opera){ua.opera=parseFloat(window.opera.version(),10);}else{ua.ie=6;}
if(!(ua.macs=agent.indexOf('Mac OS X')>-1)){ua.windows=((m=/Windows.+?(\d+\.\d+)/i.exec(agent)),m&&parseFloat(m[1],10));ua.linux=agent.indexOf('Linux')>-1;ua.android=agent.indexOf('Android')>-1;}
ua.iOS=agent.indexOf('iPhone OS')>-1;!ua.iOS&&(m=/OS (\d+(?:_\d+)*) like Mac OS X/i.exec(agent),ua.iOS=m&&m[1]?true:false);})(jQuery);;(function($){$.qPlayer=$.qPlayer||{};var config={fromTag:0,statFromtag:0,mp3url_tpl:'http://stream%(stream).qqmusic.qq.com/%(sid).mp3',wmaurl_tpl:'http://stream%(stream).qqmusic.qq.com/%(sid).wma',tpturl_tpl:'http://tpt.music.qq.com/%(sid).tpt'};var playerType=0;var curTime=0;var duration=0;var dProgress=0;var stoped=true;var version="1.0.0";$.extend($.qPlayer,{init:function(options){$.extend(config,options);},fromTag:function(){return config.fromTag;},statFromtag:function(){return config.statFromtag;},playerType:function(type){if(typeof type!='undefined'){if(type=="qzonemusic"){playerType=1;}else if(type=="audio"){playerType=2;}else if(type=="flash"){playerType=3;}}else{return playerType;}},curTime:function(time){if(typeof time!='undefined'){curTime=time;}else{return curTime;}},duration:function(time){if(typeof(time)!=="undefined"){duration=time;}else{return duration;}},downloadProgress:function(nprogress){if(typeof(nprogress)!=="undefined"){dProgress=nprogress;}else{return dProgress;}},stoped:function(isstoped){if(typeof(isstoped)!=="undefined"){stoped=isstoped;}else{return stoped;}},isLoading:false,playList:null,isLoadPlugin:function(){return false;},loadPlugin:function(){},getVersion:function(){return version;}});$.qPlayer.isLoading=false;$.qPlayer.isQQDomain=document.domain.indexOf("qq.com")>-1;function initMusic(callback){$.qPlayer.on("init",callback);if($.qPlayer.isLoading){return;}
$.qPlayer.isLoading=true;if(!!$.qPlayer.player){$.qPlayer.trigger("qplayer:init");return;}
$.qPlayer.watch.add(new Date());var isQzoneMusic=true,isSupportedUa=(!!$.ua.ie||$.ua.firefox),isSupportedUaForAudio=!(!!$.ua.ie||$.ua.firefox);if($.qPlayer.isQQDomain&&isSupportedUa){try{new ActiveXObject("QzonePlayer.PlayerCtrl");}catch(e){isQzoneMusic=false;}}
if($.qPlayer.isQQDomain&&isSupportedUa&&isQzoneMusic){$.qPlayer.trigger("qplayer:qzonemusic");}else{var audio=document.createElement('audio');if($.qPlayer.isQQDomain&&isSupportedUaForAudio&&!!audio.canPlayType){$.qPlayer.jsLoader("http://imgcache.qq.com/music/js/module/qplayer_audio.js?max_age=2592000&ver=20130515","utf-8");}else{$.qPlayer.jsLoader("http://imgcache.qq.com/music/js/module/qplayer_flash.js?max_age=2592000&ver=20130515","utf-8");}}}
function playListSong(){var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();if(!!songInfo.songurl){initMusic(function(){$.qPlayer.trigger("qplayer:playbegin",{songInfo:songInfo,index:index,total:total});$.qPlayer.player.playUrl(songInfo.songurl);$.qPlayer.stat.add(songInfo);});}}
$.extend($.qPlayer,{play:function(options){if(typeof options=='undefined'){if(!!$.qPlayer.player&&!$.qPlayer.stoped()){$.qPlayer.player.play();}else if(!!$.qPlayer.playList){playListSong();}}else{if(!options.list||!options.list.length){return;}
if(!$.qPlayer.playList){$.qPlayer.playList=playerList();}
$.qPlayer.playList.setSongList(options.list);if(!!options.mode){$.qPlayer.playList.setMode(options.mode);}
if(typeof(options.isPlay)==="undefined"||options.isPlay==false){if($.ua.android||$.ua.isiPhone){var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();if(!!songInfo.songurl){initMusic(function(){$.qPlayer.trigger("qplayer:playbegin",{songInfo:songInfo,index:index,total:total});});}}
return;}
playListSong();}},pause:function(){if(!!$.qPlayer.player){$.qPlayer.player.pause();}},stop:function(){if(!!$.qPlayer.player){$.qPlayer.player.stop();}},volume:function(vol){if(!$.qPlayer.player){return;}
if(typeof vol=='undefined'){return $.qPlayer.player.getVolume();}else{$.qPlayer.player.setVolume(vol);}},mute:function(mute){if(!!$.qPlayer.player){return $.qPlayer.player.setMute(!!mute);}},next:function(){if(!!$.qPlayer.player&&!!$.qPlayer.playList){var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();$.qPlayer.trigger("qplayer:playend",{songInfo:songInfo,index:index,total:total});$.qPlayer.playList.nextPostion();playListSong();}},prev:function(){if(!!$.qPlayer.player&&!!$.qPlayer.playList){var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();$.qPlayer.trigger("qplayer:playend",{songInfo:songInfo,index:index,total:total});$.qPlayer.playList.lastPostion();playListSong();}},autoNext:function(){if(!!$.qPlayer.player&&!!$.qPlayer.playList){var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();$.qPlayer.trigger("qplayer:playend",{songInfo:songInfo,index:index,total:total});if($.qPlayer.playList.autoNextPostion()){playListSong();}else{this.stop();}}},playAnyPos:function(pos){if(!!$.qPlayer.playList){if($.qPlayer.playList.getCount()<=0){return false;}
var songInfo=$.qPlayer.playList.getSongInfoObj();var index=$.qPlayer.playList.getPostion();var total=$.qPlayer.playList.getCount();$.qPlayer.trigger("qplayer:playend",{songInfo:songInfo,index:index,total:total});$.qPlayer.playList.setPostion(pos);playListSong();}}});var playerList=function(){var mPostion=-1;var mMode=2;var mpList=[];return{setMode:function(mode){if(mode<1||mode>5){mode=1;}
mMode=mode;},getCount:function(){return mpList.length;},setPostion:function(pos){if(pos>=0&&pos<mpList.length){mPostion=pos;}},getPostion:function(){return mPostion;},isLastPlayer:function(){return(mPostion+1)==mpList.length;},lastPostion:function(){mPostion=(mPostion-1+mpList.length)%mpList.length;return mPostion;},nextPostion:function(){if(mMode==4){var rnd=parseInt(Math.random()*100000)%this.getCount();if(rnd==mPostion){rnd=(rnd+1)%this.getCount();}
mPostion=rnd;}else{mPostion=(mPostion+1)%this.getCount();}
return mPostion;},autoNextPostion:function(){if(mMode==1){if(mPostion<0||mPostion>=this.getCount()){mPostion=0;}}else if(mMode==2){if(this.isLastPlayer()){return false;}
mPostion=(mPostion+1)%this.getCount();}else if(mMode==3){mPostion=(mPostion+1)%this.getCount();}else if(mMode==4){var rnd=parseInt(Math.random()*100000)%this.getCount();if(rnd==mPostion){rnd=(rnd+1)%this.getCount();}
mPostion=rnd;}
return true;},getSongInfoObj:function(){return mpList[mPostion];},setSongList:function(list){this.clearPlayerList();this.addSongList(list);this.setPostion(0);},addSongList:function(list){for(var i=0,len=list.length;i<len;i++){if(typeof list[i]=="object"){mpList.push(list[i]);}}},delSong:function(pos){if(pos>=0&&pos<mpList.length){mpList.splice(pos,1);}
if(pos<mPostion){mPostion--;}
if(mPostion>=mpList.length){mPostion=mpList.length-1;}
if(mpList.length==0){mPostion=-1;}},insertSong:function(pos,songinfo){if(pos>=0&&pos<mpList.length){mpList.splice(pos,0,songinfo);}
if(pos<=mPostion){mPostion++;}},clearPlayerList:function(){for(var i=0,len=mpList.length;i<len;i++){delete mpList[i];}
mpList=[];mPostion=-1;}};};})(jQuery);;(function($){var flag1=170,flag2=111,flag3={"qzonemusic":20,"audio":21,"flash":22},plugin="",sended=false,timers=[],timerlen=3;$.qPlayer.watch=$.qPlayer.watch||{};$.extend($.qPlayer.watch,{setPlugin:function(plu){plugin=plu;var _flag3=flag3[plugin]||0;if(_flag3==0){sended=true;}},add:function(time){if(sended){return false;}
timers.push(time);if(timers.length==timerlen){this.send();}},send:function(){var _flag3=flag3[plugin]||0;if(_flag3==0){return false;}
var url=['http://isdspeed.qq.com/cgi-bin/r.cgi?flag1=',flag1,'&flag2=',flag2,'&flag3=',_flag3];for(var i=1;i<timerlen;i++){url.push(["&",i,"=",timers[i]-timers[i-1]].join(''));}
setTimeout(function(){new Image().src=url.join('');},2000);sended=true;}});})(jQuery);;(function($){var _fromtag1=0,_num=5,_guid="",_statList=[];function getCookie(name){var r=new RegExp("(?:^|;+|\\s+)"+name+"=([^;]*)"),m=document.cookie.match(r);return(!m?"":m[1]);}
function getUin(){var _puin=getCookie("uin"),_uin=0;if(_puin==""){return _uin;}
if(_puin.indexOf('o')==0){_uin=parseInt(_puin.substring(1,_puin.length),10);}else{_uin=parseInt(_puin,10);}
return _uin;}
function _getGuid(){if(_guid.length>0){return _guid;}
var u=getCookie("pgv_pvid");if(!!u&&u.length>0)
{_guid=u;return _guid;}
var curMs=(new Date()).getUTCMilliseconds();_guid=(Math.round(Math.random()*2147483647)*curMs)%10000000000;document.cookie="pgv_pvid="+_guid+"; Expires=Sun, 18 Jan 2038 00:00:00 GMT; PATH=/; DOMAIN=qq.com;";return _guid;}
function add(songobj){var o={id:0,type:0,playtime:0,starttime:0,fromtag2:0};var len=_statList.length;if(len>0){var ptime=$.qPlayer.curTime();_statList[len-1].playtime=parseInt(ptime);}
if(typeof(songobj)=="object"&&songobj!=null){if(len>=_num){submit();}
o.id=songobj.mid;o.fromtag2=songobj.msource||$.qPlayer.statFromtag()*100;if(!!songobj.mid&&!!songobj.mstream){o.type=3;}else{o.type=1;}
o.starttime=parseInt((new Date()).getTime()/1000,10);_statList.push(o);}else{submit(true);}}
function statImgSend(url,t)
{if(!window.tmpMusicStat)
{window.tmpMusicStat=[];}
var l=window.tmpMusicStat.length;window.tmpMusicStat[l]=new Image();with(window.tmpMusicStat[l])
{onload=onerror=new Function('this.ready=true;this.onload=this.onerror=null;$.qPlayer.stat.statImgClean();');}
window.setTimeout("window.tmpMusicStat["+l+"].src = '"+url+"';",t);}
function statImgClean()
{for(var i=0,l=window.tmpMusicStat.length;i<l;i++)
{if(!!window.tmpMusicStat[i]&&!!window.tmpMusicStat[i].ready)
{delete window.tmpMusicStat[i];}}}
function submit(noTimeout){noTimeout=noTimeout||false;var o=null,id=[],type=[],playtime=[],starttime=[],fromtag2=[];_playerType=$.qPlayer.playerType();_fromtag1=$.qPlayer.statFromtag();var count=_statList.length;for(var i=0;i<count;i++){o=_statList[i];id.push((parseInt(o.id)<1?0:o.id));type.push(o.type||0);playtime.push(o.playtime||0);starttime.push(o.starttime||0);fromtag2.push(o.fromtag2||0);}
if(count>0){var statUrl='http://pt.music.qq.com/fcgi-bin/cgi_music_webreport.fcg?Count='+count
+'&Fqq='+getUin()+'&Fguid='+_getGuid()
+'&Ffromtag1='+_fromtag1+'&Ffromtag2='+fromtag2.join(",")
+'&Fsong_id='+id.join(",")+'&Fplay_time='+playtime.join(",")
+'&Fstart_time='+starttime.join(",")+'&Ftype='+type.join(",")
+'&Fversion='+_playerType;if(noTimeout){_img=new Image();_img.src=statUrl;}else{statImgSend(statUrl,0);}}
id=null;type=null;playtime=null;starttime=null;fromtag2=null;_statList=[];}
$.qPlayer.stat=$.qPlayer.stat||{};$.extend($.qPlayer.stat,{add:add,statImgClean:statImgClean});})(jQuery);/*  |xGv00|03eb2eb4e817689d9057c4893f65e9aa */