var backToTop = {
	conf : {
		topFlag : "#document"
	},
	
	main : function () {
		var x1 = x2 = x3 = 0;
		var y1 = y2 = y3 = 0;
	
		if (document.documentElement) {
			x1 = document.documentElement.scrollLeft || 0;
			y1 = document.documentElement.scrollTop || 0;
		}
	
		if (document.body) {
			x2 = document.body.scrollLeft || 0;
			y2 = document.body.scrollTop || 0;
		}
	
		x3 = window.scrollX || 0;
		y3 = window.scrollY || 0;
	
		var x = Math.max(x1, Math.max(x2, x3));
		var y = Math.max(y1, Math.max(y2, y3));
	
		window.scrollTo(Math.floor(x / 1.3), Math.floor(y / 1.3));
	
		if (x > 0 || y > 0) {
			window.setTimeout("backToTop.main()", 15);
		}
		else if (navigator.userAgent.indexOf("AppleWebKit") == -1){
			location.href = backToTop.conf.topFlag;
		}	
	},
	
	set : function () {
		var a = document.links;
		for(i=0;i<a .length;i++){
			
			if(new RegExp(backToTop.conf.topFlag + "\\b").exec(a[i].href)) {
				a[i].onclick = function(){
					this.removeAttribute("href");
					backToTop.main();
					this.setAttribute("href",backToTop.conf.topFlag);
					return false;
				};
			}
		}
	},
	
	addEvent : function(){
		try {
			window.addEventListener('load', backToTop.set, false);
		} catch (e) {
			window.attachEvent('onload', backToTop.set);
		}
	}
};

backToTop.addEvent();