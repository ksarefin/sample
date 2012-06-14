/**
 * busyScreen from modalWindow By YOMOTSU
 * reCreated 2009-12-10 nagai
 * modified  2010-08-17 nagai
 * Script Licence : LGPL
 * requires jquery
 */


var busyScreen = {
    conf :
    {
		// triggerClassName       : "lightbox", // クリックしたときウインドウを開く a 要素につける class 属性
        avoidClassName : [ //除外するクラス名 a|form 要素につける class 属性
            'lightbox',
            'noBusy',
            'pdf',
            'ext',
            'zip',
            'xls',
            'mgrPreview',
            'preview',
            //tinyMCE
            'mceResize',
            'mceClose',
            'mceButton',
            'mceText',
            'mceTitle',
            'mceOpen',
            'mceAction',
            
            'applicate',       //公開申請
            'open',                //公開
            'delete',              //削除（記事）
            'close',               //非公開
            'rollback',
            'applicate-cancel',
            'delFile',             //file削除ボタン
            // 'decide',              //確定
            // 'preview', //完成次第enableする
            'accept',
            'reject',
            'accept-cancel',
            'logout',            
            'delPdfFile',
            'addYear',
            'editForm',
            'backup',
            'vacuum'
            

            //'save' - editForm
        ],

        elvButtonClassName : 'elvBtn',
        
        displayBasePositionTop : 0, // ( px )　
		displayBaseMaxWidth    : 500, // ( px )　
		backgroundMaxOpacity   : 0.30, // [ 0.00 ~ 1.00 ]
        loadingImage : '/common/scripts/jquery/busyScreen/loading.gif', //くるくる画像path

        cursorSetting : 'wait' // wait, default, url(),
	},
	
	test : function()
    {
	    window.alert('hoge!');
	    
    },

    alerter : function()
    {
        //alert('ローディング中・・・');
        busyScreen.set();
        // busyBackScreen.set();
    },

    /**
     * 適用しないクラスか否か
     */
    isAvoidClass : function(classNameString)
    {
        if (!classNameString) {
            return false;
        }

        var i, j;
        var regex;
        var classNames;
        
        classNames = classNameString.replace(/^\s+|\s+$/g, "").split(/[\s,]+/);
        
        for (j = 0; j < classNames.length; j++) {
            for (i = 0; i < busyScreen.conf.avoidClassName.length; i ++) {
                if (!busyScreen.conf.avoidClassName[i]) { continue; }
                
                regex = new RegExp(busyScreen.conf.avoidClassName[i]);
                if (classNames[j].match(regex)) {
                    //window.alert(classNames[j] + ':' + busyScreen.conf.avoidClassName[i]);
                    return true;
                }
            }
        }
        
        return false;
    },

    init : function()
    {
        var _anchors = document.getElementsByTagName("a");
        var regex = new RegExp(busyScreen.conf.elvButtonClassName);


        for (var i = 0; i < _anchors.length; i++) {
            if (busyScreen.isAvoidClass(_anchors[i].className)) {
                //window.alert(_anchors[i].className);
                continue;
            }
            
            if (_anchors[i].href.match(/\#/) && !_anchors[i].className) {
                //window.alert(_anchors[i].className);
                continue;
            }
            
//            if (_anchors[i].href.match(/\#/) && !_anchors[i].className.match(regex)) {
//                continue;
//            }
            
//            if (busyScreen.isAvoidClass(_anchors[i].className)
//            || _anchors[i].href.match(/\#/)
//            || _anchors[i].href.match(/^javascript/i)) {
//                if (!_anchors[i].className.match(regex)) {
//                    continue;
//                }
//            }
            
            
            //window.alert(i + 'class:' + _anchors[i].className);
            
            try {
                _anchors[i].addEventListener('click', busyScreen.set, false);
            } catch (e) {
                _anchors[i].attachEvent('onclick', busyScreen.set);
            }
        }

        var _forms = document.getElementsByTagName("form");
        for (i = 0; i < _forms.length; i++) {
            if (busyScreen.isAvoidClass(_forms[i].className)) {
                continue;
            }
            
            //window.alert(_forms[i].className);
            try {
                _forms[i].addEventListener('submit', busyScreen.set, false);
            } catch (e) {
                _forms[i].attachEvent('onsubmit', busyScreen.set);
            }
        }

        var _img01 = new Image();
        _img01.src = busyScreen.conf.loadingImage; //画像を先読み

        //busyScreen.resetCursor();
        // busyScreen.resetLayer();
    },


    resetLayer : function()
    {
        //reset-screen
        var layerId = "reset-screen";
        if (document.getElementById(layerId)) { return; }

        var resetLayer = document.createElement("div");
        resetLayer.id = layerId;
        resetLayer.style.position = "absolute";
        resetLayer.style.left = 0;
		resetLayer.style.top  = 0;
        resetLayer.style.zIndex   = 1300;
        resetLayer.style.cursor   = 'default';
        // resetLayer.style.width    = 0;
        resetLayer.style.width    = Math.max(busyGetPageSize().width, busyScreen.conf.displayBaseMaxWidth) + "px";
		resetLayer.style.height   = busyGetPageSize().height + "px";
        //resetLayer.style.background = '#550022';
        document.body.appendChild(resetLayer);
        document.body.removeChild(resetLayer);

    },


    set : function()
    {
    	if (document.getElementById("display-base")) { return; }

		var displayBase = document.createElement("div");
		displayBase.id = "display-base";
		displayBase.style.position = "absolute";
		displayBase.style.zIndex   = "1100";
        //displayBase.style.cursor   = busyScreen.conf.loadingImage;
		displayBase.style.width    = busyScreen.conf.displayBaseMaxWidth + "px";
		//displayBase.style.width    = 300 + "px";
		displayBase.style.top      = busyGetPageOffset().yOffset + busyScreen.conf.displayBasePositionTop + "px";
		displayBase.style.left     = busyGetPageSize().width / 2 - ( busyScreen.conf.displayBaseMaxWidth / 2) + "px";

        displayBase.style.cursor   = busyScreen.conf.cursorSetting;
        //displayBase.style.cursor   = 'wait';

		document.body.appendChild(displayBase);
		busyBackScreen.set();

		// this.getHTMLSrc(URI);
	},



    unset : function(_elem)
    {
        try {
            _elem.removeEventListener('click', busyScreen.set, false);
        } catch (e) {
            _elem.detachEvent('onclick', busyScreen.set);
        } finally {
            //window.alert('イベント消去に失敗しました。' + _elem.className);
        }

        try {
            _elem.removeEventListener('submit', busyScreen.set, false);
        } catch (e) {
            _elem.detachEvent('onsubmit', busyScreen.set);
        } finally {
            //window.alert('イベント消去に失敗しました。' + _elem.className);
        }
    },

    resetCursor : function()
    {
        //ポインタをデフォルトに
        var displayBase = document.getElementById("display-base");
        if (displayBase) { displayBase.style.cursor = 'default'; }

        var backScreen = document.getElementById("back-screen");
        if (backScreen) { backScreen.style.cursor = 'default'; }
        
        document.body.style.cursor = 'default';
        
        //document.style.cursor = 'default';
        // window.alert("cursor を reset しました。");
    },

    addEvent : function()
    {
//		try {
//			window.addEventListener('load', this.init, false);
//		} catch (e) {
//			window.attachEvent('onload', this.init);
//		}
        
        if (typeof j$ != 'undefined') {
            j$(document).ready(busyScreen.init);
        } else if (typeof $ != 'undefined') {
            $(document).ready(busyScreen.init);
        }

        try {
            window.addEventListener('unload', this.resetCursor, false);
		} catch (e) {
            window.attachEvent('onunload', this.resetCursor);
		}
	}
};


var busyBackScreen = {
	alpha : 0,
	
	set : function()
    {
		this.hideSelectElements(); // for IE 6 select-zIndex BUG
		var busyBackScreen = document.createElement("div");

		busyBackScreen.id = "back-screen";
		busyBackScreen.style.position   = "absolute";
		busyBackScreen.style.left       = 0;
		busyBackScreen.style.top        = 0;
		busyBackScreen.style.zIndex     = 1099;
		busyBackScreen.style.width      = Math.max(busyGetPageSize().width, busyScreen.conf.displayBaseMaxWidth) +"px";
		busyBackScreen.style.height     = busyGetPageSize().height +"px";
		busyBackScreen.style.filter     = "alpha(opacity="+this.alpha*100+")";
		busyBackScreen.style.MozOpacity = this.alpha;
		busyBackScreen.style.opacity    = this.alpha;

        busyBackScreen.style.backgroundImage = 'url(' + busyScreen.conf.loadingImage + ')';
        busyBackScreen.style.backgroundRepeat = 'no-repeat';
	    busyBackScreen.style.backgroundPosition = 'center center';

        busyBackScreen.style.cursor = busyScreen.conf.cursorSetting;

        var _innerX = null;
        var _innerY = null;

        if (window.innerWidth) {
            _innerX = window.innerWidth / 2;
            _innerY = window.innerHeight / 2;
            

        } else if (document.documentElement && document.documentElement.clientWidth) {
            _innerX = document.documentElement.clientWidth / 2;
            _innerY = document.documentElement.clientHeight / 2;
            
        } else if (document.body.clientWidth) {
            _innerX = document.body.clientWidth / 2;
            _innerY = document.body.clientHeight / 2;
            
        }

        if (_innerX) {
            _innerX = Math.floor(_innerX);
            _innerY = Math.floor(_innerY);
            busyBackScreen.style.backgroundPosition = _innerX + 'px ' + _innerY + 'px';
        }

        // alert(busyBackScreen.style.backgroundPosition);
        // alert(window.innerWidth);

		document.body.appendChild(busyBackScreen);

		this.alpha = 0;
		this.fadeIn();
	},

	fadeIn : function()
	{
		var busyBackScreen = document.getElementById("back-screen");
		this.alpha += 0.1;
		if(busyBackScreen.style.opacity)        	busyBackScreen.style.opacity    = this.alpha;
		else if(busyBackScreen.style.MozOpacity)	busyBackScreen.style.MozOpacity = this.alpha;
		else if(busyBackScreen.style.filter)	    busyBackScreen.style.filter     = "alpha(opacity="+this.alpha*100+")";

        if (this.alpha < busyScreen.conf.backgroundMaxOpacity ) {
			busyBackScreen.onclick = function() { return; };
			window.setTimeout("busyBackScreen.fadeIn()", 10);
		}

		else {
			//busyBackScreen.onclick = busyScreen.remove;
            busyBackScreen.onclick = function() { return; };
		}
	},

	fadeOut : function()
	{
		var busyBackScreen = document.getElementById("back-screen");
		busyBackScreen.onclick = function(){return;};
		this.alpha -= 0.1;
		if(busyBackScreen.style.opacity)        	busyBackScreen.style.opacity    = this.alpha;
		else if(busyBackScreen.style.MozOpacity)	busyBackScreen.style.MozOpacity = this.alpha;
		else if(busyBackScreen.style.filter)	    busyBackScreen.style.filter     = "alpha(opacity="+this.alpha*100+")";
		if (this.alpha > 0.05) {
			window.setTimeout("busyBackScreen.fadeOut()", 10);
		}
		else{
			document.body.removeChild(busyBackScreen);
			this.alpha = 0;
		}
	},

	remove : function()
    {
		var busyBackScreen = document.getElementById("back-screen");
		if (busyBackScreen) {
			this.fadeOut();
        }
		this.showSelectElements(); // for IE 6 select-zIndex BUG
        // busyBackScreen.style.cursor = 'default';
	},

	fix : function()
    {
		var busyBackScreen = document.getElementById("back-screen");
		if (busyBackScreen){
			busyBackScreen.style.width  = busyGetPageSize().width  +"px";
			busyBackScreen.style.height = busyGetPageSize().height +"px";
		}
	},

	//-----------------------------------------------------
	//  select elements z-index BUG ( IE 6 )
	//-----------------------------------------------------

	hideSelectElements : function()
	{
        var i;
		if ((typeof document.documentElement.style.zoom != "undefined")&&(typeof document.documentElement.style.msInterpolationMode == "undefined")){
			var selectEle = document.getElementsByTagName("select");
			for(i = 0; i < selectEle.length; i++){
				selectEle[i].style.visibility = "hidden";
			}

			var selectEle2 = document.getElementById("display-base").getElementsByTagName("select");
			for(i=0;i<selectEle2.length;i++){
				selectEle[i].selectEle2.visibility = "visible";
			}
		}
	},
	
	

	showSelectElements : function ()
	{
        var i;
		if ((typeof document.documentElement.style.zoom != "undefined") && (typeof document.documentElement.style.msInterpolationMode == "undefined")){
			var selectEle = document.getElementsByTagName("select");
			for(i = 0; i < selectEle.length; i++){
				selectEle[i].style.visibility = "visible";
			}
		}
	}
};




//-----------------------------------------------------
//  get page size
//-----------------------------------------------------

var busyGetPageSize = function() {
	var w1, w2, h1, h2;
    w1 = 0;
    w2 = 0;
    h1 = 0;
    h2 = 0;

	if (document.documentElement) {
		w1 = document.documentElement.scrollWidth;
		h1 = document.documentElement.scrollHeight;
	}

	if (document.body) {
		w2 = document.body.scrollWidth;
		h2 = document.body.scrollHeight;
	}

	var width  = Math.max(w1, w2);
	var height = Math.max(h1, h2);

	return {width: width, height: height};
};

//---------------------------

var busyGetPageOffset = function() {
	var xOffset  = document.body.scrollLeft || document.documentElement.scrollLeft;
	var yOffset  = document.body.scrollTop  || document.documentElement.scrollTop;
	return {xOffset: xOffset, yOffset: yOffset};
};


//-----------------------------------------------------
//  busyBackScreen
//-----------------------------------------------------





busyScreen.addEvent();