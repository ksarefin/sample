if (typeof j$ != 'undefined') {
    j$(document).ready(function() {
        j$('textarea.resizable:not(.processed)').TextAreaResizer(); 
        j$('iframe.resizable:not(.processed)').TextAreaResizer();
    });
} else if (typeof $ != 'undefined') {
    $(document).ready(function() {
        $('textarea.resizable:not(.processed)').TextAreaResizer(); 
        $('iframe.resizable:not(.processed)').TextAreaResizer();
    });
}
