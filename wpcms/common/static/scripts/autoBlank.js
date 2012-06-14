/**
 * autoBlank
 * created: 20091125 nagai
 * updated: 20100617 nagai
 */

var autoBlank = {
    windowParam     : 'menubar=yes, resizable=yes, toolbar=yes, location=yes, status=yes, scrollbars=yes, directories=yes',
    targetClassName : 'ext',
    newWindowName   : 'smartpagesNewWin',

    main : function() {
        var _objAnchor = document.getElementsByTagName('a');
        var _tagClassName;
        var _classNames;

        for (var i = 0; i < _objAnchor.length; i++) {
            _tagClassName = _objAnchor[i].className;
            _classNames = _tagClassName.split(" ");

            classNamesLoop:
            for (var j = 0; j < _classNames.length; j++) {
                if (_classNames[j] == autoBlank.targetClassName) {
                    _objAnchor[i].onclick = autoBlank.openWin;
                    break classNamesLoop;
                }
            }
        }
    },


    openWin : function() {
        var newWin = window.open(this.getAttribute('href'), autoBlank.newWindowName, autoBlank.windowParam);
        newWin.focus();
        return false;
    },

    

    addEvent : function() {
		try {
			window.addEventListener('load', this.main, false);
		} catch (e) {
			window.attachEvent('onload', this.main);
		}
	}
};


autoBlank.addEvent();
