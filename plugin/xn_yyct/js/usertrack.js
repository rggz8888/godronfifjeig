var UserTrack = {
	send: function( oparam ) {
		var aparam = [],
			odefault = UserTrack._default,
			onosend = UserTrack._nosendParam;
		_hao123_image = new Image( 1, 1 );
		oparam = oparam || odefault;
		//?
		oparam.randnum =  Math.round(Math.random() * 2147483647);
		//??url
		oparam.sendurl = oparam.sendurl || odefault.sendurl;
		//?refer
		oparam.refer = oparam.refer || odefault.refer;
		//??
		oparam.type = oparam.type || odefault.type;
		for ( var key in oparam ) {
			if ( !onosend[key] )
				aparam.push( encodeURIComponent( key ) + "=" + encodeURIComponent( oparam[key] ) );	
		}
		_hao123_image.src = oparam.sendurl + "?" + aparam.join("&");
		_hao123_image.onload = function() {
			_hao123_image.onload = null;
		};
	    
	},
	//???
	click: function( e ) {
		var e = e || window.event,
			op = {type:"click"},
			odom = e.target || e.srcElement || document;
		if ( odom.nodeName.toUpperCase() == "A" ) {
			op.tit = odom.innerText || odom.textContent ;
			op.url = odom.href ;
			UserTrack.send( op );
		}
		
	},
	//??
	_default: {
		sendurl: "http://www.hao123.com/images/track.gif",
		refer: document.referrer,
		type: "access"
	},
	//?????
	_nosendParam:{
		sendurl: true
	}	
}
