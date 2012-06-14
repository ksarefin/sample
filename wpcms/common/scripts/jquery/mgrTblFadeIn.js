/**
 * mgrTblFadeIn.js
 * nagai.kiwami.com
 * created 2010-07-30
 * modfied 2010-08-17
 * 
 * requires jquery
 */


var mgrTblFadeIn = {
    /**
     * @var object jquery
     */
    jq: null,
        
    detectJquery: function()
    {
        if (typeof j$ != 'undefined') {
            this.jq = j$;
        } else if (typeof $ != 'undefined') {
            this.jq = $;
        } else {
            window.alert('jquery detection failed.');
        }
    },
        
    tableShow: function()
    {
        try {
            mgrTblFadeIn.jq('.admTblType01').fadeOut(0, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.admTblType01').fadeIn(300, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.admTblType02').fadeOut(0, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.admTblType02').fadeIn(300, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.admTblType03').fadeOut(0, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.admTblType03').fadeIn(300, mgrTblFadeIn.removeFilter);
        } catch (e) {
            // do nothing
        }
        
        try {
            mgrTblFadeIn.jq('.stgTblType01').fadeOut(0, mgrTblFadeIn.removeFilter);
            mgrTblFadeIn.jq('.stgTblType01').fadeIn(300, mgrTblFadeIn.removeFilter);
        } catch (e) {
            // do nothing
        }
    },
    
//    main: function()
//    {
//        //コンテンツローディングメッセージを使用する場合
//        //$('#processMessage').fadeOut(10, mgrTblFadeIn.tableShow);
//        
//        mgrTblFadeIn.tableShow();
//    },
    
    /**
     * 
     * IE限定：フィルター解除
     */
    removeFilter : function()
    {
        var ua = mgrTblFadeIn.jq.browser;
        if (ua.msie) {
            this.style.removeAttribute('filter');
        }
    },
        
    addEvent : function()
    {
//        try {
//            window.addEventListener('load', this.main, false);
//        } catch (e) {
//            window.attachEvent('onload', this.main);
//        }
//        if (typeof $j != 'undefined') {
//            $j(document).ready(mgrTblFadeIn.main);
//        } else if (typeof $ != 'undefined') {
//            $(document).ready(mgrTblFadeIn.main);
//        }
        this.detectJquery();
        this.jq(document).ready(mgrTblFadeIn.tableShow);
    }
};

mgrTblFadeIn.addEvent();
