/*====================================================================================================
//////////////////////////////////////////////////////////////////////////////////////////////////////

 created: 2007/11/01
 update : 2010/06/12

//////////////////////////////////////////////////////////////////////////////////////////////////////
====================================================================================================*/

var jsloader = {

    conf : {
        loader : 'jsloader.js',
        loadJS : [
                 'jquery/autoBlank.js',
                 'jquery/busyScreen/busyScreen.js',
                 'jquery/buttonActionConfirm.js',
                 'jquery/selectAction.js',
                 'jquery/checkAction.js',
                 'rollover.js',
                 'scrolltotop.js'
              ]
    },
    
    main : function() {
        var script = document.getElementsByTagName("script");
        for (var i = 0; i < script.length; i++){
            if (script[i].getAttribute("src") && script[i].getAttribute("src").match(jsloader.conf.loader)){
                
                locationStr = window.location + '';
                var DirArray = new Array();
                var N=0;
                while (true) { 
                	DirArray[N] = locationStr.slice(0,locationStr.indexOf("/"));
                	locationStr = locationStr.slice(locationStr.indexOf("/")+1,locationStr.length);
                	N++;
                	if (locationStr.indexOf("/") == -1) {
                		break;
                	}
                }
                
                var scriptSrc = script[i].getAttribute("src");
                scriptSrc     = scriptSrc.replace(/\.\.\//g, "");
                
                var loaderDir = "";
                if (scriptSrc.match(/^http\:|^https\:|^file\:|^\//)) {
                    loaderDir = scriptSrc.replace(jsloader.conf.loader,"");
                }
                else {
                    var upperDirLength = script[i].getAttribute("src").match(/\.\.\//g) ? script[i].getAttribute("src").match(/\.\.\//g).length : 0 ;
                    var dirDiff = DirArray.length - upperDirLength;
                    for(j = 0; j < dirDiff; j++){
                        loaderDir += DirArray[j]+'/';
                    }
                    loaderDir = loaderDir.slice(0, -1) + '/' + scriptSrc ;
                    loaderDir = loaderDir.slice(0,-1 * jsloader.conf.loader.length);
                }                
        
                for (j = 0; j < jsloader.conf.loadJS.length;j++) {
                    
                    if (!jsloader.conf.loadJS[j].match(/^\/|^http\:|^https\:|^\.\.\//)) {
                        jsloader.setJS(loaderDir+jsloader.conf.loadJS[j]);
                    }
                    else if (jsloader.conf.loadJS[j].match(/^\/|^http\:|^https\:/)) {
                        jsloader.setJS(jsloader.conf.loadJS[j]);
                    }
                    else if (jsloader.conf.loadJS[j].match(/^\.\.\//)) {
                        var setDirArray = new Array();
                        
                        setDir = loaderDir;
                        N = 0;
                        while (true) { 
                            setDirArray[N] = setDir.slice(0,setDir.indexOf("/"));
                            setDir = setDir.slice(setDir.indexOf("/")+1,setDir.length);
                            N++;
                            if (setDir.indexOf("/") == -1) {
                                break;
                            }
                        }
                        
                        upperDirArray = jsloader.conf.loadJS[j].match(/\.\.\//g);
                        var dir = '';
                        var diff = setDirArray.length - upperDirArray.length;
                        for(k = 0; k < diff; k++){
                            dir += setDirArray[k]+'/';
                        }

                        // remove "../"
                        jsloader.conf.loadJS[j] = dir + jsloader.conf.loadJS[j].replace(/\.\.\//g, "");
                        jsloader.setJS(jsloader.conf.loadJS[j]);
                    }
                }
                
            break;
            }
        }
    },
    
    
    setJS : function(filePath) {
        script = document.createElement("script");
        script.setAttribute("src",filePath);
        script.setAttribute("type","text/javascript");
        document.getElementsByTagName("head")[0].appendChild(script);
    }
    
};

jsloader.main();
