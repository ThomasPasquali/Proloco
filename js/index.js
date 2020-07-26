$(function () { $('[data-toggle="tooltip"]').tooltip(); });

window.addEventListener("beforeunload", function() { alert('dfssdfdfs');location.replace("/"); })

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

  

  /************ASYNC IMAGES*************/
  [].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
    img.setAttribute('src', img.getAttribute('data-src'));
    img.onload = function() {
       img.removeAttribute('data-src');
    };
  });

  /*************COLLAPSIBLES*************/
  var coll = document.getElementsByClassName("collapsible");
  var i;
  for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
      this.classList.toggle("active");
      console.log(this);
      var content = this.nextElementSibling;
      if (content.style.maxHeight){
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      } 
    });
  }

});

function show(what='') {
	switch(what) {
        case '':
            break;
            
        case 'estate-inverno':
        	$('#content').children().each(function(){ $(this).css('display', 'none'); });
        	$('#'+what).css('display', 'grid');
            break;

        default:
        	if($('#'+what)) {
        		$('#content').children().each(function(){ $(this).css('display', 'none'); });
                $('#'+what).css('display', 'block');
        	}
            break;
    }
}

function hide(elem) {
	$(elem).css('display', 'none');
}

/************HOME*************/
function estate() {
	hide('#estate-inverno');
	show('home-estate');
}

function inverno() {
	hide('#estate-inverno');
	show('home-inverno');
}
