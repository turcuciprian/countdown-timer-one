jQuery(document).ready(function($) {
  var ctoColorPicker = $('.ctoColorPicker');
  if (ctoColorPicker[0]) {
      if (typeof ctoColorPicker.iris == 'function') {
          ctoColorPicker.iris({
              hide: true
          });
      }
  }
});
