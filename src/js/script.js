jQuery(document).ready(function($) {
  var aBDatePicker = $('.aBDatepicker');
  var aBTimepicker = $('.aBTimepicker');
  var ctoColorPicker = $('.ctoColorPicker');

  
  aBDatePicker.on('hover',function(){
    if (aBDatePicker[0]) {
        //check if datepicker exists as a function
        if (typeof aBDatePicker.datepicker == 'function') {
          aBDatePicker.datepicker({
              dateFormat: $(self).attr('data-dateformat')
          });
        }
    }
  });


  //Timepicker
  if (aBTimepicker[0]) {
      if (typeof aBTimepicker.timepicker == 'function') {
          aBTimepicker.timepicker({timeFormat: 'h:i A',});
      }
  }

  if (ctoColorPicker[0]) {
      if (typeof ctoColorPicker.iris == 'function') {
          ctoColorPicker.iris({
              hide: true
          });
      }
  }
});
