<?php
/*
  Plugin Name: Give a Beer One
  Plugin URI: http://ciprianturcu.com/give-a-beer-one/
  Description: A plugin that allows user to appreciate the current blog by clicking a beer widget
  Version: 1.0
  Author: ciprianturcu
  Author URI: http://ciprianturcu.com
  License: GPLv2 or later
  Text Domain: countdown-timer-one
 */

 if(!function_exists('gabo_enqueueAll')){
   //Admin scripts and styles
   add_action('wp_enqueue_scripts', 'gabo_enqueueAll');
   //Admin scripts and styles callback
   function gabo_enqueueAll()
   {
     gabo_Exists('gabo_customStyle', 'style.css', 'style',array(),'plugin');
     gabo_Exists('gabo_customStyle', 'style.css', 'style',array(),'plugin');
       gabo_Exists('gabo_customScript', 'script.js', 'script',array(),'plugin');
     }
   }




   if(!function_exists('gabo_Exists')){
     function gabo_Exists($name, $path, $type,$dependencies = array(),$exportType)
     {
       $fileExists = false;

       if($exportType==='theme'){
         $file = get_template_directory_uri().'/'.$path;
       }else{
         $file = plugin_dir_url(__FILE__).$path;
       }
         $plugin_file_headers = @get_headers($file);
         if (!$plugin_file_headers || strpos($plugin_file_headers[0], '404') > 0) {
             //file does not exist
           $fileExists = false;
         } else {
             //file exists if a plugin path
           $fileExists = true;
         }
       //inside theme path file existance ?
       // Custom Script
       if ($fileExists) {
           if ($type === 'style') {
               wp_register_style($name, $file);
               wp_enqueue_style($name);
           } else {
               wp_register_script($name, $file, $dependencies);
               wp_enqueue_script($name);
           }
       }
     }
   }




 /**
  * Adds Foo_Widget widget.
  */
 class Foo_Widget extends WP_Widget {

 	/**
 	 * Register widget with WordPress.
 	 */
 	function __construct() {
 		parent::__construct(
 			'foo_widget', // Base ID
 			esc_html__( 'Countdown Timer One', 'text_domain' ), // Name
 			array( 'description' => esc_html__( 'CTO Widget', 'text_domain' ), ) // Args
 		);
 	}

 	/**
 	 * Front-end display of widget.
 	 *
 	 * @see WP_Widget::widget()
 	 *
 	 * @param array $args     Widget arguments.
 	 * @param array $instance Saved values from database.
 	 */
 	public function widget( $args, $instance ) {
 		echo $args['before_widget'];
 		if ( ! empty( $instance['title'] ) ) {
 			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
 		}

    ?>

    <div id="ctoWidget">
    </div>
    <script type="text/javascript">
    function gabo_getTimeRemaining(endtime){
      var t = Date.parse(endtime) - Date.parse(new Date());
      var seconds = Math.floor( (t/1000) % 60 );
      var minutes = Math.floor( (t/1000/60) % 60 );
      var hours = Math.floor( (t/(1000*60*60)) % 24 );
      var days = Math.floor( t/(1000*60*60*24) );
      return {
        'total': t,
        'days': days,
        'hours': hours,
        'minutes': minutes,
        'seconds': seconds
      };
    }
    function gabo_initializeClock(id, endtime){
  var clock = document.getElementById(id);
  var timeinterval = setInterval(function(){
    var t = gabo_getTimeRemaining(endtime);
    clock.innerHTML = 'days: ' + t.days + '<br>' +
                      'hours: '+ t.hours + '<br>' +
                      'minutes: ' + t.minutes + '<br>' +
                      'seconds: ' + t.seconds;
    if(t.total<=0){
      clearInterval(timeinterval);
    }
  },1000);
}
var hrs = -(new Date().getTimezoneOffset() / 60)
var gabo_Deadline = '<?php echo $instance['gabo_toDate'];?> <?php echo $instance['gabo_toTime'];?> GMT'+hrs;
gabo_initializeClock('ctoWidget', gabo_Deadline);
var d = new Date()
var n = d.getTimezoneOffset();
console.log(n/60);
    </script>
    <?php
 		echo $args['after_widget'];
 	}

 	/**
 	 * Back-end widget form.
 	 *
 	 * @see WP_Widget::form()
 	 *
 	 * @param array $instance Previously saved values from database.
 	 */
 	public function form( $instance ) {

    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
    $gabo_toDate = (! empty( $instance['gabo_toDate'] ) && isset($instance['gabo_toDate'])) ? $instance['gabo_toDate'] : esc_html__( '', 'text_domain' );
 		$gabo_toTime = (! empty( $instance['gabo_toTime'] ) && isset($instance['gabo_toTime'])) ? $instance['gabo_toTime'] : esc_html__( '', 'text_domain' );
 		?>
 		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
 		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'gabo_toDate' ) ); ?>"><?php esc_attr_e( 'End date:', 'text_domain' ); ?></label>
 		    <input class="widefat aBDatepicker" id="<?php echo esc_attr( $this->get_field_id( 'gabo_toDate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gabo_toDate' ) ); ?>" type="text" value="<?php echo esc_attr( $gabo_toDate ); ?>">
        <script type="text/javascript">
        jQuery(document).ready(function($) {
          var aBDatePicker = $('.aBDatepicker');
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
          var aBTimepicker = $('.aBTimepicker');

          if (aBTimepicker[0]) {
              if (typeof aBTimepicker.timepicker == 'function') {
                  aBTimepicker.timepicker({timeFormat: 'h:i A',});
              }
          }
        });
        </script>
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'gabo_toTime' ) ); ?>"><?php esc_attr_e( 'END time:', 'text_domain' ); ?></label>
 		    <input class="widefat aBTimepicker" id="<?php echo esc_attr( $this->get_field_id( 'gabo_toTime' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'gabo_toTime' ) ); ?>" type="text" value="<?php echo esc_attr( $gabo_toTime ); ?>">
 		</p>

 		<?php
 	}

 	/**
 	 * Sanitize widget form values as they are saved.
 	 *
 	 * @see WP_Widget::update()
 	 *
 	 * @param array $new_instance Values just sent to be saved.
 	 * @param array $old_instance Previously saved values from database.
 	 *
 	 * @return array Updated safe values to be saved.
 	 */
 	public function update( $new_instance, $old_instance ) {



 		$instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['gabo_toDate'] = ( ! empty( $new_instance['gabo_toDate'] ) ) ? strip_tags( $new_instance['gabo_toDate'] ) : '';
 		$instance['gabo_toTime'] = ( ! empty( $new_instance['gabo_toTime'] ) ) ? strip_tags( $new_instance['gabo_toTime'] ) : '';

 		return $instance;
 	}

 } // class Foo_Widget

 // register Foo_Widget widget
function gabo_register_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'gabo_register_widget' );
