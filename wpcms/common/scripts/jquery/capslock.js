/**
 * CAPSLOCK detection
 * created 20100816
 * updated 20100826
 * 
 * requires jquery
 */

var capsLock = {
    config : {
        targetFieldClass : 'detectCapsLock',
        notationFieldId : 'capsLockNotation' //注意文の要素のID
    },
    
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
        
    main : function(e)
    {
//        if (!e) {
//            e = arguments[0];
//        }
//        
//        var keycode = e.keyCode ? e.keyCode : e.which;

        var keycode = e.which;
        switch (keycode) {
            case 8:
            case 46:
            case 37:
            case 38:
            case 39:
            case 40:
                return;
                
            default:
                 //do nothing   
        }
        
        var shiftkey = e.shiftKey ? e.shiftKey : ((keycode == 16) ? true : false);
        
        if (((keycode >= 65 && keycode <= 90) && !shiftkey)
         || ((keycode >= 97 && keycode <= 122) && shiftkey)) {
            capsLock.jq('#' + capsLock.config.notationFieldId).css('visibility', 'visible');
        } else {
            capsLock.jq('#' + capsLock.config.notationFieldId).css('visibility', 'hidden');
        }
    },
    
    set : function()
    {
        capsLock.jq("." + capsLock.config.targetFieldClass).keypress(capsLock.main);
    },
    
    addEvent : function()
    {
        this.detectJquery();
        this.jq(document).ready(capsLock.set);
    }
};

capsLock.addEvent();

