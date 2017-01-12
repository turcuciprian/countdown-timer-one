<?php
/*
  Plugin Name: Countdown Timer One
  Plugin URI: http://ciprianturcu.com/countdown-timer-one/
  Description: create a countdown timer widget that's configurable and dynamic so that you can make a countdown timer widget
  Version: 1.0.3
  Author: turcuciprian
  Author URI: http://ciprianturcu.com
  License: GPLv2 or later
  Text Domain: countdown-timer-one
 */

 if(!function_exists('cto_EnqueueAll')){
   //Admin scripts and styles
   add_action('admin_enqueue_scripts', 'cto_EnqueueAll');
   //Admin scripts and styles callback
   function cto_EnqueueAll()
   {
     //*
     // CSS
     //*
     cto_Exists('jQueryUiCore', 'ab-src/css/jquery-ui.css', 'style',array(),'plugin');
     cto_Exists('cto_Timepicker', 'ab-src/css/jquery.timepicker.css', 'style',array(),'plugin');
     cto_Exists('cto_customStyle', 'ab-src/css/abStyle.css', 'style',array(),'plugin');

       //*
       //  Custom JS
       //*
             wp_enqueue_media();
       wp_enqueue_script('jquery-ui-core');
       wp_enqueue_script('jquery-ui-widget', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-mouse', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-datepicker', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-draggable', false, array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'));
       wp_enqueue_script('jquery-ui-slider', false, array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'));
       //*
       //  Custom JS
       //*
       cto_Exists('cto_Timepicker', 'ab-src/js/jquery.timepicker.min.js', 'script',array('jquery-ui-core'),'plugin');
       cto_Exists('cto_CustomScript', 'ab-src/js/abScript.js', 'script',array(),'plugin');
     }
   }




   if(!function_exists('cto_Exists')){
     function cto_Exists($name, $path, $type,$dependencies = array(),$exportType)
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
  * Adds cto_widget widget.
  */
 class CTO_Widget extends WP_Widget {

 	/**
 	 * Register widget with WordPress.
 	 */
 	function __construct() {
 		parent::__construct(
 			'CTO_Widget', // Base ID
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
    function cto_getTimeRemaining(endtime){
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
    function cto_initializeClock(id, endtime){
  var clock = document.getElementById(id);
  var timeinterval = setInterval(function(){

    <?php
    $delimiter = '';
    switch($instance['cto_delimiter']){
      case 1:
        $delimiter = '<br/>';
      break;
      case 2:
        $delimiter = ' - ';
      break;
      case 3:
        $delimiter = ' &sol; ';
      break;
      case 4:
        $delimiter = ' &bsol; ';
      break;
      case 5:
        $delimiter = ' &amp; ';
      break;
      case 6:
        $delimiter = ' &verbar; ';
      break;
      default:
      break;
    }
    ?>
    var delimiter = '<?php echo $delimiter;?>';
    var t = cto_getTimeRemaining(endtime);
    clock.innerHTML =  t.days +' days '+ delimiter +
                      t.hours + ' hours '+ delimiter +
                      t.minutes+' minutes ' + delimiter +
                      t.seconds+' seconds ';
    if(t.total<=0){
      clearInterval(timeinterval);
    }
  },1000);
}
var hrs = -(new Date().getTimezoneOffset() / 60)
var cto_Deadline = '<?php echo $instance['cto_toDate'];?> <?php echo $instance['cto_toTime'];?> GMT'+hrs;
cto_initializeClock('ctoWidget', cto_Deadline);
var d = new Date()
var n = d.getTimezoneOffset();
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
    $cto_toDate = (! empty( $instance['cto_toDate'] ) && isset($instance['cto_toDate'])) ? $instance['cto_toDate'] : esc_html__( '', 'text_domain' );
    $cto_toTime = (! empty( $instance['cto_toTime'] ) && isset($instance['cto_toTime'])) ? $instance['cto_toTime'] : esc_html__( '', 'text_domain' );
 		$cto_delimiter = (! empty( $instance['cto_delimiter'] ) && isset($instance['cto_delimiter'])) ? $instance['cto_delimiter'] : esc_html__( '', 'text_domain' );
 		?>
 		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
 		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>"><?php esc_attr_e( 'End date:', 'text_domain' ); ?></label>
 		    <input class="widefat aBDatepicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toDate' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toDate ); ?>">
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
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>"><?php esc_attr_e( 'End time:', 'text_domain' ); ?></label>
 		    <input class="widefat aBTimepicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toTime' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toTime ); ?>">
 		</p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'cto_delimiter' ) ); ?>"><?php esc_attr_e( 'Delimiter:', 'text_domain' ); ?></label><br/>
      <select class="" name="<?php echo esc_attr( $this->get_field_name('cto_delimiter')); ?>">
        <option value="1" <?php selected($cto_delimiter,1);?>>New Line</option>
        <option value="2" <?php selected($cto_delimiter,2);?>>-</option>
        <option value="3" <?php selected($cto_delimiter,3);?>>/</option>
        <option value="4" <?php selected($cto_delimiter,4);?>>\</option>
        <option value="5" <?php selected($cto_delimiter,5);?>>&amp;</option>
        <option value="6" <?php selected($cto_delimiter,6);?>>|</option>
      </select>
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
    $instance['cto_toDate'] = ( ! empty( $new_instance['cto_toDate'] ) ) ? strip_tags( $new_instance['cto_toDate'] ) : '';
    $instance['cto_toTime'] = ( ! empty( $new_instance['cto_toTime'] ) ) ? strip_tags( $new_instance['cto_toTime'] ) : '';
 		$instance['cto_delimiter'] = ( ! empty( $new_instance['cto_delimiter'] ) ) ? strip_tags( $new_instance['cto_delimiter'] ) : '';

 		return $instance;
 	}

 } // class CTO_Widget

 // register CTO_Widget widget
function cto_register_widget() {
    register_widget( 'CTO_Widget' );
}
add_action( 'widgets_init', 'cto_register_widget' );
