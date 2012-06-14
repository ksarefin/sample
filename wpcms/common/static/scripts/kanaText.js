/*@cc_on 
var doc = document;
eval('var document = doc');
@*/
//******************************
// 定数（編集不可）
//******************************

var ktxConstant = {
	// フリガナ文字種
	letterType : { hiragana : 0, katakana : 1 },
	// 挿入形式
	insertType : { auto : 0, check : 1, checked : 2, button : 3 }
}


//alert(target_array);

//******************************
// 処理
//******************************
var kanaTextExtension = {
	
	//-----------------------------------------
	//対象要素
	// target_array generate from html code class
	//-----------------------------------------
	target : target_array,
	
	//-----------------------------------------
	// 設定値
	//-----------------------------------------
	conf : {
		labelStrHiragana : 'ふりがなを自動挿入する',
		labelStrKatakana : 'フリガナを自動挿入する',
		buttonStrHiragana : '名前からふりがなを挿入する',
		buttonStrKatakana : '名前からフリガナを挿入する',
		// 以下 編集不可
		idBaseStr : 'kanaTextExtension_',
		timer : null,
		elmName : null,
		elmKana : null,
		convertFlag : false,
		baseKana : '',
		ignoreString : '',
		input : '',
		values : [],
		active : true,
		kanaExtractionPattern : new RegExp('[^ 　ぁあ-んー]', 'g'),
		kanaCompactingPattern : new RegExp('[ぁぃぅぇぉっゃゅょ]', 'g')
	},
	//-----------------------------------------
	// 初期処理
	//-----------------------------------------
	init : function() {
		var len = kanaTextExtension.target.length;
		for ( var i = 0; i < len; i++ ) {
			// 対象要素を取得
			var nameStr = kanaTextExtension.target[i][0];
			var kanaStr = kanaTextExtension.target[i][1];
			var name = document.getElementById(nameStr);
			var kana = document.getElementById(kanaStr);
			
			// 挿入形式によって分岐
			if ( kanaTextExtension.target[i][3] == ktxConstant.insertType.check ) {
				// チェックボックス生成
				kanaTextExtension.createCheckBox(name[0],false);
			} else if ( kanaTextExtension.target[i][3] == ktxConstant.insertType.checked ) {
				// チェックボックス（デフォルトチェック）生成
				kanaTextExtension.createCheckBox(name[0],true);
			} else if ( kanaTextExtension.target[i][3] == ktxConstant.insertType.button ) {
				// ボタン生成
				kanaTextExtension.createButton(name[0]);
			}
			
			kanaTextExtension.addEvent( name, 'focus', kanaTextExtension.ktxFocus );
			kanaTextExtension.addEvent( name, 'keydown', kanaTextExtension.ktxKeyDown );
			kanaTextExtension.addEvent( name, 'blur', kanaTextExtension.ktxBlur );
			
		}
	},
	//-----------------------------------------
	// focus処理
	//-----------------------------------------
	ktxFocus : function( event ) {
		//alert(event);
		// 対象要素を取得
		kanaTextExtension.conf.elmName = kanaTextExtension.getEventTarget(event);
		//alert(kanaTextExtension.conf.elmName);
		kanaTextExtension.conf.elmKana = kanaTextExtension.getCorrespondingElement();
		//alert(kanaTextExtension.conf.elmKana);
		// 入力監視の設定
		kanaTextExtension.stateInput();
		// 入力値の監視を開始
		kanaTextExtension.ktxSetInterval();
	},
	//-----------------------------------------
	// keyDown処理
	//-----------------------------------------
	ktxKeyDown : function() {
		if ( kanaTextExtension.conf.convertFlag ) {
			kanaTextExtension.stateInput();
		}
	},
	//-----------------------------------------
	// blur処理
	//-----------------------------------------
	ktxBlur : function() {
		// 入力値の監視を終了
		kanaTextExtension.ktxClearInterval();
	},
	//-----------------------------------------
	// インターバル設定
	//-----------------------------------------
	ktxSetInterval : function() {
		// 30ミリ秒毎に入力値チェックを実行
		kanaTextExtension.conf.timer = setInterval( kanaTextExtension.checkValue, 30 );
	},
	//-----------------------------------------
	// インターバル解除
	//-----------------------------------------
	ktxClearInterval : function() {
		// 入力値チェックを解除
		clearInterval(kanaTextExtension.conf.timer);
	},

	//-----------------------------------------
	// 入力監視の設定（未変換）
	//-----------------------------------------
	stateInput : function() {
		//alert(kanaTextExtension.conf.elmKana);
		if ( kanaTextExtension.getInsertType() != ktxConstant.insertType.button ) {
			kanaTextExtension.conf.baseKana = kanaTextExtension.conf.elmKana.value;
		}
		kanaTextExtension.conf.convertFlag = false;
		kanaTextExtension.conf.ignoreString = kanaTextExtension.conf.elmName.value;
		if ( kanaTextExtension.getInsertType() == ktxConstant.insertType.check || kanaTextExtension.getInsertType() == ktxConstant.insertType.checked ) {
			var checkbox = document.getElementById(kanaTextExtension.conf.idBaseStr + kanaTextExtension.conf.elmName.name);
			if ( checkbox && checkbox.checked ) {
				kanaTextExtension.conf.active = true;
			} else {
				kanaTextExtension.conf.active = false;
			}
		} else if ( kanaTextExtension.getInsertType() == ktxConstant.insertType.button ) {
			kanaTextExtension.conf.active = false;
		} else {
			kanaTextExtension.conf.active = true;
		}
	},
	//-----------------------------------------
	// 入力監視の設定（変換済み）
	//-----------------------------------------
	stateConvert : function() {
		kanaTextExtension.conf.baseKana = kanaTextExtension.conf.baseKana + kanaTextExtension.conf.values.join('');
		kanaTextExtension.conf.convertFlag = true;
		kanaTextExtension.conf.values = [];
	},
	//-----------------------------------------
	// 入力監視の設定をクリア
	//-----------------------------------------
	stateClear : function() {
		kanaTextExtension.conf.baseKana = '';
		kanaTextExtension.conf.convertFlag = false;
		kanaTextExtension.conf.ignoreString = '';
		kanaTextExtension.conf.input = '';
		kanaTextExtension.conf.values = [];
	},
	//-----------------------------------------
	// 入力値チェック
	//-----------------------------------------
	checkValue : function() {
		// 入力値を取得
		var newInput = kanaTextExtension.conf.elmName.value
		if ( newInput == '' ) {
			// 入力値が空の場合はリセット
			kanaTextExtension.stateClear();
			kanaTextExtension.setKana();
		} else {
			// 入力値から変換非対称の文字列を除いた値を取得
			newInput = kanaTextExtension.removeString(newInput);
			if ( kanaTextExtension.conf.input == newInput ) {
				// 前回の入力値と同じなら返す
				return;
			} else {
				// 入力値の履歴として保持
				kanaTextExtension.conf.input = newInput;
				if ( !kanaTextExtension.conf.convertFlag ) {
					// 未変換なら変換処理を行う
					var newValues = newInput.replace(kanaTextExtension.conf.kanaExtractionPattern,'').split('');
					kanaTextExtension.checkConvert(newValues);
					kanaTextExtension.setKana(newValues);
				}
			}
		}
	},
	//-----------------------------------------
	// 変換チェック
	//-----------------------------------------
	checkConvert : function( newValues ) {
		if ( !kanaTextExtension.conf.convertFlag ) {
			if ( Math.abs(kanaTextExtension.conf.values.length - newValues.length) > 1 ) {
				var tmpValues = newValues.join('').replace(kanaTextExtension.conf.kanaCompactingPattern,'').split('');
				if ( Math.abs(kanaTextExtension.conf.values.length - tmpValues.length) > 1 ) {
					kanaTextExtension.stateConvert();
				}
			} else {
				if ( kanaTextExtension.conf.values.length == kanaTextExtension.conf.input.length && kanaTextExtension.conf.values.join('') != kanaTextExtension.conf.input ) {
					kanaTextExtension.stateConvert();
				}
			}
		}
	},
	//-----------------------------------------
	// カナinput要素に値を挿入
	//-----------------------------------------
	setKana : function( newValues ) {
		if ( !kanaTextExtension.conf.convertFlag ) {
			if( newValues ) {
				//alert(newValues);
				//document.getElementById(kanaTextExtension.conf.elmKana.id).classList.remove('em');
				kanaTextExtension.conf.values = newValues;
			}
			if( kanaTextExtension.conf.active ) {
				kanaTextExtension.conf.elmKana.value = kanaTextExtension.toKatakana( kanaTextExtension.conf.baseKana + kanaTextExtension.conf.values.join('') );
			}
		}
		
		if (kanaTextExtension.conf.elmKana.value != ''){
			document.getElementById(kanaTextExtension.conf.elmKana.id).classList.remove('em');
		}else{
			document.getElementById(kanaTextExtension.conf.elmKana.id).classList.add('em');
		}
		
	},
	//-----------------------------------------
	// 入力値をカタカナに変換する
	//-----------------------------------------
	toKatakana : function( src ) {
		if ( kanaTextExtension.getLetterType() == ktxConstant.letterType.katakana ) {
			var str = new String;
			for( var i=0; i<src.length; i++ ) {
				var c = src.charCodeAt(i);
				if ( kanaTextExtension.isHiragana(c) ) {
					str += String.fromCharCode(c + 96);
				} else {
					str += src.charAt(i);
				}
			}
			return str;
		} else {
			return src;
		}
	},
	//-----------------------------------------
	// ひらがな判定
	//-----------------------------------------
	isHiragana : function( char ) {
		return ((char >= 12353 && char <= 12435) || char == 12445 || char == 12446);
	},
	//-----------------------------------------
	// 文字列から変換非対称の値を削除して返す
	//-----------------------------------------
	removeString : function( newInput ) {
		if ( newInput.match(kanaTextExtension.conf.ignoreString) ) {
			return newInput.replace(kanaTextExtension.conf.ignoreString,'');
		} else {
			var ignoreArray = kanaTextExtension.conf.ignoreString.split('');
			var inputArray = newInput.split('');
			var len = ignoreArray.length;
			for( var i=0; i<len; i++ ) {
				if ( ignoreArray[i] == inputArray[i] ) {
					inputArray[i] = '';
				}
			}
			return inputArray.join('');
		}
	},
	//-----------------------------------------
	// 対象input要素の横にチェックボックスを追加する
	//-----------------------------------------
	createCheckBox: function( element, flag ) {
		var parent = element.parentNode;
		var div = kanaTextExtension.createBlock();
		var checkbox = kanaTextExtension.createInputCheckbox(element, flag);
		var label = kanaTextExtension.createLabel(element);
		parent.replaceChild(div, element);
		div.appendChild(element);
		div.appendChild(checkbox);
		div.appendChild(label);
	},
	//-----------------------------------------
	// ブロックを生成する
	//-----------------------------------------
	createBlock : function() {
		var div = document.createElement('div');
		div.style.margin = '0px';
		div.style.padding = '0px';
		div.style.display = 'inline';
		return div;
	},
	//-----------------------------------------
	// チェックボックスを生成する
	//-----------------------------------------
	createInputCheckbox: function( element, flag ) {
		var input = document.createElement('input');
		input.type = 'checkbox';
		if ( element.id ) {
			input.id = element.id;
		} else {
			input.id = kanaTextExtension.conf.idBaseStr + element.name;
		}
		input.checked = flag;
		input.style.border = 'none';
		input.style.background = 'transparent';
		input.style.cursor = 'pointer';
		input.style.marginLeft = '5px';
		return input;
	},
	//-----------------------------------------
	// ラベルを生成する
	//-----------------------------------------
	createLabel: function( element ) {
		var label = document.createElement('label');
		if ( element.id ) {
			label.htmlFor = element.id;
		} else {
			label.htmlFor = kanaTextExtension.conf.idBaseStr + element.name;
		}
		label.style.cursor = 'pointer';
		if ( !kanaTextExtension.getLetterType(element) ) {
			label.innerHTML = kanaTextExtension.conf.labelStrHiragana;
		} else {
			label.innerHTML = kanaTextExtension.conf.labelStrKatakana;
		}
		return label;
	},
	//-----------------------------------------
	// 対象input要素の横にボタンを追加する
	//-----------------------------------------
	createButton: function( element ) {
		var parent = element.parentNode;
		var div = kanaTextExtension.createBlock();
		var button = kanaTextExtension.createInputButton(element);
		parent.replaceChild(div, element);
		div.appendChild(element);
		div.appendChild(button);
	},
	//-----------------------------------------
	// ボタンを生成する
	//-----------------------------------------
	createInputButton: function( element ) {
		var input = document.createElement('input');
		input.type = 'button';
		if ( element.id ) {
			input.id = element.id;
		} else {
			input.id = kanaTextExtension.conf.idBaseStr + element.name;
		}
		input.style.margin = '0px';
		input.style.marginLeft = '5px';
		if ( !kanaTextExtension.getLetterType(element) ) {
			input.value = kanaTextExtension.conf.buttonStrHiragana;
		} else {
			input.value = kanaTextExtension.conf.buttonStrKatakana;
		}
		input.onclick = function() {
			if ( kanaTextExtension.conf.elmName ) {
				if ( this.id == (kanaTextExtension.conf.idBaseStr + kanaTextExtension.conf.elmName.name) ) {
					kanaTextExtension.conf.elmKana.value = kanaTextExtension.toKatakana( kanaTextExtension.conf.baseKana + kanaTextExtension.conf.values.join('') );
				}
			}
		};
		return input;
	},
	//-----------------------------------------
	// 名前input要素に対応するカナinput要素を返す
	//-----------------------------------------
	getCorrespondingElement : function() {
		var result = null;
		var element = kanaTextExtension.conf.elmName;
		//alert(element);
		if ( element ) {
			var len = kanaTextExtension.target.length;
			for ( var i = 0; i < len; i++ ) {
				if ( element.id.match(kanaTextExtension.target[i][0]) ) {
					//result = document.getElementsByName(kanaTextExtension.target[i][1]);
					result = document.getElementById(kanaTextExtension.target[i][1]);
					//result = result[0];
					break;
				}
			}
		}
		//alert(result);
		return result;
	},
	//-----------------------------------------
	// 名前input要素に対応する文字種を返す
	//-----------------------------------------
	getLetterType : function( element ) {
		var result = 0;
		if ( !element ) {
			element = kanaTextExtension.conf.elmName;
		}
		var len = kanaTextExtension.target.length;
		for ( var i = 0; i < len; i++ ) {
			if ( element.id.match(kanaTextExtension.target[i][0]) ) {
				result = kanaTextExtension.target[i][2];
				break;
			}
		}
		return result;
	},
	//-----------------------------------------
	// 名前input要素に対応する入力形式を返す
	//-----------------------------------------
	getInsertType : function( element ) {
		var result = 0;
		if ( !element ) {
			element = kanaTextExtension.conf.elmName;
		}
		var len = kanaTextExtension.target.length;
		for ( var i = 0; i < len; i++ ) {
			if ( element.id.match(kanaTextExtension.target[i][0]) ) {
				result = kanaTextExtension.target[i][3];
				break;
			}
		}
		return result;
	},
	//-----------------------------------------
	// イベント発生元の要素を取得
	//-----------------------------------------
	getEventTarget : function( event ) {
		
		var element = null;
		if ( event && event.target ) {
			element = event.target;
		} else if ( window.event && window.event.srcElement ) {
			element = window.event.srcElement;
		}
		
		return element;
	},
	//-----------------------------------------
	// ターゲットタグを取得する
	//-----------------------------------------
	getTargetElements : function( tag, cls ) {
		var elements = new Array();
		var targetElements = document.getElementsByTagName(tag.toUpperCase());
		var len = targetElements.length;
		for ( var i = 0; i < len; i++ ) {
			if ( targetElements[i].className.match(cls) ) {
				elements[elements.length] = targetElements[i];
			}
		}
		return elements;
	},
	//-----------------------------------------
	// イベントに関数を付加する
	//-----------------------------------------
	addEvent : function( target, event, func ) {
		//alert(event); alert(func);
		try {
			target.addEventListener(event, func, false);
		} catch (e) {
			target.attachEvent('on' + event, func);
		}
	}
}




// 実行
kanaTextExtension.addEvent( window, 'load', kanaTextExtension.init );