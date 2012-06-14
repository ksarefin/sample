/*====================================================================================================
//////////////////////////////////////////////////////////////////////////////////////////////////////

 Author : http://www.yomotsu.net
 created: 2007/03/13
 update : 2008/01/21
 Licensed under the GNU Lesser General Public License version 2.1

//////////////////////////////////////////////////////////////////////////////////////////////////////
====================================================================================================*/
var yomotsuRollover = {
	
	main : function() {
		var img = document.images, ipt = document.getElementsByTagName('input'), i, preLoadImg = [];

		// img elements
		for (i = 0; i <img.length; i++) {
			if ((img[i].src.match(/.*_n\./))||(img[i].style.filter)){
				preLoadImg[preLoadImg.length] = new Image;
				preLoadImg[preLoadImg.length-1].src = img[i].src.replace('_n.', '_r.');

				img[i].onmouseover = yomotsuRollover.over;
				img[i].onmouseout  = yomotsuRollover.out;
				try {img[i].addEventListener('click', yomotsuRollover.click, false);}
				catch(e){img[i].attachEvent('onclick', (function(el){return function(){yomotsuRollover.click.call(el);};})(img[i]));}
			}
		}
		// input[image] elements
		for (i = 0; i <ipt.length; i++) {
			if ((ipt[i].src.match(/.*_n\./))&&(ipt[i].getAttribute('type')=='image')){
				preLoadImg[preLoadImg.length] = new Image;
				preLoadImg[preLoadImg.length-1].src = ipt[i].src.replace('_n.', '_r.');
				ipt[i].onmouseover = yomotsuRollover.over;
				ipt[i].onmouseout  = yomotsuRollover.out;
				try {ipt[i].addEventListener('click', yomotsuRollover.click, false);}
				catch(e){ipt[i].attachEvent('onclick', (function(el){return function(){yomotsuRollover.click.call(el);};})(ipt[i]));}
			}

		}
	}
	,
	
	over : function() {
		var imgSrc, preLoadImgSrc;
		if((this.style.filter)&&(this.style.filter.match(/_n\.png/)))//(IE5.5-6 && png)
			this.style.filter = this.style.filter.replace('_n.png', '_r.png');
		else
			this.src = this.src.replace('_n.', '_r.');
	},

	out : function(){
		if((this.style.filter)&&(this.style.filter.match(/_r\.png/)))//(IE5.5-6 && png)
			this.style.filter = this.style.filter.replace('_r.png', '_n.png');
		else
			this.src = this.src.replace('_r.', '_n.');
	},
	
	click : function(){
		if((this.style.filter)&&(this.style.filter.match(/_r\.png/)))//(IE5.5-6 && png)
			this.style.filter = this.style.filter.replace('_r.png', '_n.png');
		else
			this.src = this.src.replace('_r.', '_n.');
	},

	addEvent : function(){
		try {
			window.addEventListener('load', this.main, false);
		} catch (e) {
			window.attachEvent('onload', this.main);
		}
	}
}

yomotsuRollover.addEvent();