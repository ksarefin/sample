/**
 * buttonActionConfirm
 * created 2009-12-16 nagai
 * updated 2010-08-17 nagai
 * script Licence: LGPL
 *
 * requires jquery
 */

var buttonActionConfirm = {

    conf : {
        validClassNames : [
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
            'logOut',
            
            'delPdfFile',
            'addYear',
            'editForm',
            'reject-cancel', //否承認キャンセル
            'open-now', //強制公開
            'logout', //ログアウト
            'backup',
            'vacuum'
        ],

        
        avoidClassNames : [
            'login', //loginformは除く
            // 'preview', //preview実装後に削除
            'viewAmount',
            'linkCheck',
            'noConfirm'
        ]
    },


    getMessage : function(_className)
    {
        // var _className = buttonActionConfirm.isValidClass(this.className);
        var _confirmMessage = null;

        switch (_className) {
            case 'open' :
                _confirmMessage = 'コンテンツを公開します。\nよろしいですか？';
                break;

            case 'delete' :
                _confirmMessage = 'コンテンツ削除します。\nよろしいですか？';
                break;

            case 'close' :
                _confirmMessage = 'コンテンツを非公開にします。\nよろしいですか？';
                break;

            case 'rollback' :
                _confirmMessage = '巻き戻しを実行します。\n（編集中のデータは公開中のデータで上書きされます。）\nよろしいですか？';
                break;

            case 'applicate' :
                _confirmMessage = '申請します。\nよろしいですか？';
                break;

            case 'applicate-cancel' :
                _confirmMessage = '申請を取り消します。\nよろしいですか？';
                break;
                
            case 'preview' :
                _confirmMessage = 'プレビューします。\n';
                break;

            case 'accept':
                _confirmMessage = '承認します。\nよろしいですか？';
                break;

            case 'reject':
                _confirmMessage = '否承認します。\nよろしいですか？';
                break;

            case 'accept-cancel' :
                _confirmMessage = '承認を取り消します。\nよろしいですか？';
                break;

            case 'reject-cancel' :
                _confirmMessage = '否承認を取り消します。\nよろしいですか？';
                break;
                
            case 'open-now' :
                _confirmMessage = '直ちに公開します。\nよろしいですか？';
                break;

            case 'logout' :
                _confirmMessage = 'ログアウトします。\nよろしいですか？';
                break;

            
            case 'delPdfFile' :
                _confirmMessage = 'PDFファイルを削除します。\nよろしいですか?';
                break;

            case 'delFile' :
                _confirmMessage = 'ファイルを削除します。\nよろしいですか?';
                break;
            
            case 'editForm' :
                _confirmMessage = new Array();
                _confirmMessage['submit'] = '保存します。\nよろしいですか?';
                _confirmMessage['reset'] = '変更を破棄します。\nよろしいですか?';
                break;
                
                
            case 'backup' :
                _confirmMessage = 'バックアップを作成します。\n※バックアップには最大30秒程度時間がかかる場合があります。\nバックアップを開始してよろしいですか?';
                break;
                
            case 'vacuum' :
                _confirmMessage = 'SQLite::vacuumを実行しデータベースのサイズを最適化します。\n実行してよろしいですか？';
                break;

            default :
               // _confirmMessage = '保存します。\nよろしいですか？';
        }

        return _confirmMessage;
    },
    
    
    setAction : function(confirmMessage)
    {
        var assignFunction = function() {
            if (!busyScreen) {
                alert('busyScreen is required');
                return false;
            }

            var result = window.confirm(confirmMessage);
//window.alert(result);
            if (result) {
                busyScreen.set();
                
                return true;

            } else {
                busyScreen.unset(this);
//                try {
//                    this.removeEventListener('click', busyScreen.set, false);
//                } catch (e) {
//                    this.detachEvent('onclick', busyScreen.set);
//                } finally {
//                    //window.alert(e);
//                    window.alert('finally' + this.className + this.tagName);
//                    //this.onclick = null;
//                }
                //window.alert('false');
                //busyScreen.test();
                //busyBackScreen.remove();
                //document.location.reload();
                window.location.reload();
                return false;
            }
        };

        return assignFunction;
    },


    /**
     * 適用するクラスか否か
     */
    isValidClass : function(classNameString)
    {
        if (!classNameString) {
            return false;
        }

        var _classNames;
        var _refClassNames;
        var i, j;
        var regex;
        _refClassNames = buttonActionConfirm.conf.validClassNames;

        _classNames = classNameString.split(/\s/);
        
        
//        for (i = 0; i < buttonActionConfirm.conf.validClassNames.length; i++) {
//            regex = new RegExp(buttonActionConfirm.conf.validClassNames[i]);
//            if (classNameString.match(regex)) {
//                
//            }
//        }
        
        for (i = 0; i < _classNames.length; i ++) {
            for (j = 0; j < _refClassNames.length; j ++) {
                if (_classNames[i] == _refClassNames[j]) {
                    
                    return _classNames[i];
                }
            }
        }

        return false;
    },


    /**
     * 適用するクラスか否か
     */
    isAvoidClass : function(classNameString)
    {
        if (!classNameString) {
            return false;
        }

        var _classNames;
        var _refClassNames;
        var i, j;

        _refClassNames = buttonActionConfirm.conf.avoidClassNames;

        _classNames = classNameString.split(/\s/);
        for (i = 0; i < _classNames.length; i ++) {
            for (j = 0; j < _refClassNames.length; j ++) {
                if (_classNames[i] == _refClassNames[j]) {
                    return _classNames[i];
                }
            }
        }

        return false;
    },



    main : function()
    {
        var _anchors = document.getElementsByTagName("a");
        var _className;
        
        var _confirmMessage;

        for (var i = 0; i < _anchors.length; i ++) {
            _className = buttonActionConfirm.isValidClass(_anchors[i].className);
            if (_className) {
                _confirmMessage = buttonActionConfirm.getMessage(_className);

                try {
                    //_anchors[i].addEventListener('click', buttonActionConfirm.TEST, false);
                    _anchors[i].onclick = buttonActionConfirm.setAction(_confirmMessage);
                } catch (e) {
                    _anchors[i].onclick = buttonActionConfirm.setAction(_confirmMessage);
                    //_anchors[i].attachEvent('onclick',  buttonActionConfirm.TEST);
                }
            }
        }
        
        
        _className = false;
        var _bool;
        var _forms = document.getElementsByTagName("form");

        for (i = 0; i < _forms.length; i ++) {
            _bool = buttonActionConfirm.isAvoidClass(_forms[i].className);
            _className = buttonActionConfirm.isValidClass(_forms[i].className);
            
            if (!_bool && _className) {
                _confirmMessage = buttonActionConfirm.getMessage(_className);
                
                try {
                    _forms[i].onsubmit = buttonActionConfirm.setAction(_confirmMessage['submit']);
                    _forms[i].onchange = buttonActionConfirm.onchangeConfirm;
                    //_forms[i].onchange = function() { window.alert('bababa'); };
                } catch (e) {
                    
                }
            }
        }
    },

    
    _onchancgeFlg : false,
    
    onchangeConfirm : function()
    {
        if (buttonActionConfirm._onchancgeFlg) {
            return;
        }
        
        objRegex = new RegExp('back');
        
        var attachFunction = function() {
                               
                                var result = window.confirm('変更は保存されていません。\n変更を破棄してもよろしいですか?');
                                if (result) { busyScreen.set(); }
                                return result;
                             };
        
        var anchors = document.getElementsByTagName('a');
//        window.alert('form content changed!');
        for (var i = 0; i < anchors.length; i++) {
            if (anchors[i].className.match(objRegex)) {
                
                anchors[i].onclick = attachFunction;
                busyScreen.unset(anchors[i]);
            }
        }
        buttonActionConfirm._onchancgeFlg = true;
    },

    addEvent : function()
    {
//        try {
//            window.addEventListener('load', this.main, false);
//        } catch (e) {
//            window.attachEvent('onload', this.main);
//        }
        if (typeof j$ != 'undefined') {
            j$(document).ready(buttonActionConfirm.main);
        } else if (typeof $ != 'undefined') {
            $(document).ready(buttonActionConfirm.main);
        } else {
            window.alert('buttonActionConfirm:initialize failed.');
        }
    }
};


buttonActionConfirm.addEvent();
