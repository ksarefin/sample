
j$(document).ready(function(){
    var ua = j$.browser;
    var html = "/common/dashboard/introduction.html #includeArea";
    
    if (ua.msie) {
        var filterFunc = function() { this.style.removeAttribute("filter"); };
        j$("#feedArea").hide(0, filterFunc).load(html).slideDown('slow', filterFunc);
    } else {
        j$("#feedArea").hide(0).load(html).slideDown('slow');
    }
});
