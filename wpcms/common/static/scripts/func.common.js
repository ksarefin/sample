jQuery.noConflict();
var j$ = jQuery;

j$(function(){
   j$('a[href^=#]').click(function() {
      var speed = 400;// ミリ秒
      var href= j$(this).attr("href");
      var target = j$(href == "#" || href == "" ? 'html' : href);
      var position = target.offset().top;
      j$(j$.browser.safari ? 'body' : 'html').animate({scrollTop:position}, speed, 'swing');
      return false;
   });
});