/**
 * mail address docoder 0.25
 * License : LGPL
 * re-created 2009-12-28
 * updated    2010-01-07
 */


var mailAddrDecoder = {
    conf : {
        targetHtmlTagName   : "span",         //対象HTMLタグ default = span
        targetCssClassName  : "encodedAddr",  //対象クラス名
        targetAttributeName : "title",        //対象属性名称
        jammerString        : "fjack@ibhsampolefw.com@jfandon.com@ankghu.com.sd@nkougue.to.tv.co.gov@cermi.com", //jammer string
        commentString       : " The quick brown fox jumps over the lazy dog. 1234567890 ", //comment string

        MIN_VALUE           : 0x0020,
        MAX_VALUE           : 0x007E,
        NUM_ADD_VALUE       : 0x0030,
        STR_MAX_VALUE       : 0x007E - 0x0020,
        // SKIP_VALUE          : 0x005C,
        QUOTE               : '"',
        ESCAPE              : "\\",
        SEP                 : "~"
    },

    orgTable : '',

    main : function() {
        var targetElement;
        var classNames;

        var encodedAddr;
        var i, j;

        //create orgTable
        mailAddrDecoder.orgTable = mailAddrDecoder.makeOrgTable();

        targetElement = document.getElementsByTagName(mailAddrDecoder.conf.targetHtmlTagName);

        for (i = 0; i< targetElement.length; i++) {
            classNames = targetElement[i].className.split(/\s/);

            searchCssLoop :
            for (j = 0; j < classNames.length; j++) {
                if (classNames[j] == mailAddrDecoder.conf.targetCssClassName) {
                    encodedAddr = decodeURIComponent(targetElement[i].getAttribute(mailAddrDecoder.conf.targetAttributeName));
                    targetElement[i].removeAttribute(mailAddrDecoder.conf.targetAttributeName);
                    targetElement[i].innerHTML = '';
                    targetElement[i].appendChild(mailAddrDecoder.createNode(encodedAddr));

                    break searchCssLoop;
                }
            }
        }
    },


    createNode : function(encodedAddr) {
        var commentNode = document.createComment(mailAddrDecoder.conf.commentString);

        var jamNode = document.createElement('span');
        jamNode.innerHTML = mailAddrDecoder.conf.jammerString;
        jamNode.style.display = "none";

        var printAddrs = mailAddrDecoder.decode(encodedAddr).split('');

        var element = document.createElement('a');

        var tmpNode;
        // 任意のテキストにする場合
        /*
        for (var i = 0; i < 1; i ++) {
            tmpNode = document.createElement('span');
            tmpNode.innerHTML = 'こちら';

            element.appendChild(commentNode.cloneNode(true));
            element.appendChild(jamNode.cloneNode(true));

            element.appendChild(tmpNode);
            element.appendChild(commentNode.cloneNode(true));
            element.appendChild(jamNode.cloneNode(true));
        }
        */
        // メールアドレスの表示はこれ
        for (var i = 0; i < printAddrs.length; i ++) {
            tmpNode = document.createElement('span');
            tmpNode.innerHTML = printAddrs[i];

            element.appendChild(commentNode.cloneNode(true));
            element.appendChild(jamNode.cloneNode(true));

            element.appendChild(tmpNode);
            element.appendChild(commentNode.cloneNode(true));
            element.appendChild(jamNode.cloneNode(true));
        }
       
        element.setAttribute('href', 'javascript:void(0);');
        element.onclick = mailAddrDecoder.getLinkAction(encodedAddr);

        return element;
    },


    getLinkAction : function(encodedAddr) {
        return function() {
            location.href = 'mailto:' + mailAddrDecoder.decode(encodedAddr);
        };
    },


    makeOrgTable : function() {
        var result = "";
        for (var i = mailAddrDecoder.conf.MIN_VALUE; i < mailAddrDecoder.conf.MAX_VALUE; i++) {
            result += String.fromCharCode(i);
        }
        return result;
    },


    makeShiftTable: function(s, val) {
        var shiftTable = null;
        shiftTable = s.slice(val, s.length+1) + s.slice(0, val);
        return shiftTable;
    },


    decode : function(stringEncoded) {
        var ebase  = mailAddrDecoder.decodeBase(stringEncoded.slice(stringEncoded.lastIndexOf(mailAddrDecoder.conf.SEP) + 1, stringEncoded.length));
		
        var shiftTable = mailAddrDecoder.makeShiftTable(mailAddrDecoder.orgTable, ebase);

        var separetedString = stringEncoded.slice(0, stringEncoded.lastIndexOf(mailAddrDecoder.conf.SEP));

        var plainAddr = mailAddrDecoder.decodeString(
            separetedString,
            mailAddrDecoder.orgTable,
            shiftTable
        );

        return plainAddr;
    },


    decodeBase : function(val) {
        var flag = false;
        var result = null;

        if (val.length >= 2) {
            if (val.substr(0, 1) == "1") {
                flag = true;
            }
            result = val.substr(1, 1);
        } else {
            result = val.substr(0, 1);
        }


        if (isNaN(result)) {
            result = result.charCodeAt(result.substr(0, 1)) - mailAddrDecoder.conf.MIN_VALUE;
        } else {
            result -= mailAddrDecoder.conf.MIN_VALUE;
            result += mailAddrDecoder.conf.NUM_ADD_VALUE;
        }


        if (flag) {
            result += (mailAddrDecoder.conf.STR_MAX_VALUE - mailAddrDecoder.conf.MIN_VALUE);
        }

        return result;
    },


    decodeString : function(separetedString, org, shift) {
        var result = "";
        for (var i = (separetedString.length-1); i >= 0 ; i--) {
            result += org.substr((shift.indexOf(separetedString.substr(i, 1))), 1);
        }
        return result;
    },


    addEvent : function() {
        try {
            window.addEventListener('load', mailAddrDecoder.main, false);
        } catch (e) {
            window.attachEvent('onload', mailAddrDecoder.main);
        }
    }
};

mailAddrDecoder.addEvent();