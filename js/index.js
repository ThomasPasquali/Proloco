$(document).ready(function () {

  'use strict';

   var c, currentScrollTop = 0,
       navbar = $('#menu');

   $(window).scroll(function () {
      var a = $(window).scrollTop();
      var b = navbar.height()/4;

      currentScrollTop = a;

      if (c < currentScrollTop && a > b) {
        navbar.addClass("hide-menu").removeClass("show-menu");
      } else if (c > currentScrollTop && a < b) {
        navbar.removeClass("hide-menu").addClass("show-menu");
      }
      c = currentScrollTop;
  });

});

var content = $('#content');

function show(what='') {
    switch(what) {
        case '':
            break;

        default:
            content.children().each(function(){ $(this).addClass('hidden'); });
            if($('#'+what)) $('#'+what).removeClass('hidden');
            else $('#home').removeClass('hidden');
            break;
    }
}
