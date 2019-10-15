jQuery(document).ready(function ($) {

  var jssor_options = {
    $AutoPlay: 1,
    $SlideshowOptions: {
      $Class: $JssorSlideshowRunner$,
      $Transitions: [ {$Duration:800,$Opacity:2} ],
      $TransitionsOrder: 1
    },
    $ArrowNavigatorOptions: {
      $Class: $JssorArrowNavigator$
    },
    $BulletNavigatorOptions: {
      $Class: $JssorBulletNavigator$
    }
  };

  var jssor_v_d_b = new $JssorSlider$("jssor_v_d_b", jssor_options);
  var jssor_home = new $JssorSlider$("jssor_home", jssor_options);
  var jssor_v_d_g = new $JssorSlider$("jssor_v_d_g", jssor_options);
  
});


/*#region responsive code begin

  var MAX_WIDTH = 700;

  function ScaleSlider() {
      var containerElement = jssor_1_slider.$Elmt.parentNode;
      var containerWidth = containerElement.clientWidth;

      if (containerWidth) {

          var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

          jssor_1_slider.$ScaleWidth(expectedWidth);
      }
      else {
          window.setTimeout(ScaleSlider, 30);
      }
  }

  ScaleSlider();

  $(window).bind("load", ScaleSlider);
  $(window).bind("resize", ScaleSlider);
  $(window).bind("orientationchange", ScaleSlider);
  /*#endregion responsive code end*/