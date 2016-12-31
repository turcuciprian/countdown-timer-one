<?php
/*
  Plugin Name: Countdown Timer One
  Plugin URI: http://ciprianturcu.com
  Description: create a countdown timer widget that's configurable and dynamic so that you can make many countdown timer widgets
  Version: 1.0.0
  Author: ciprianturcu
  Author URI: http://admin-builder.com
  License: GPLv2 or later
  Text Domain: countdown-timer-one
 */

 if(!function_exists('abEnqueueAll')){
   //Admin scripts and styles
   add_action('admin_enqueue_scripts', 'abEnqueueAll');
   //Admin scripts and styles callback
   function abEnqueueAll()
   {
     //*
     // CSS
     //*
     abExists('bootstrapFontIcons', 'ab-src/css/bootstrap.min.css', 'style',array(),'plugin');
     abExists('jQueryUiCore', 'ab-src/css/jquery-ui.css', 'style',array(),'plugin');
     abExists('abIris', 'ab-src/css/iris.min.css', 'style',array(),'plugin');
     abExists('abMagnificPopup', 'ab-src/css/magnific-popup.css', 'style',array(),'plugin');
     abExists('abTimepicker', 'ab-src/css/jquery.timepicker.css', 'style',array(),'plugin');
     //--
     abExists('customAbStyle', 'ab-src/css/abStyle.css', 'style',array(),'plugin');

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
       abExists('abColor', 'ab-src/js/color.js', 'script',array(),'plugin');
       abExists('abIris', 'ab-src/js/iris.js', 'script',array('jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-slider'),'plugin');
       abExists('abTimepicker', 'ab-src/js/jquery.timepicker.min.js', 'script',array('jquery-ui-core'),'plugin');
       abExists('abBootstrapJs', 'ab-src/js/bootstrap.min.js', 'script',array('jquery', 'jquery-ui-core'),'plugin');
       abExists('abMagnificPopup', 'ab-src/js/jquery.magnific-popup.min.js', 'script',array('jquery', 'jquery-ui-core'),'plugin');
       //--
       abExists('abCustomScript', 'ab-src/js/abScript.js', 'script',array(),'plugin');
     }
   }




   if(!function_exists('abExists')){
     function abExists($name, $path, $type,$dependencies = array(),$exportType)
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
 		echo esc_html__( 'Hello, World!', 'text_domain' );
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
    $cto_toDate = ! empty( $instance['cto_toDate'] ) ? $instance['cto_toDate'] : esc_html__( '', 'text_domain' );
 		$cto_toTime = ! empty( $instance['cto_toTime'] ) ? $instance['cto_toTime'] : esc_html__( '', 'text_domain' );
 		?>
 		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
 		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
 		</p>
    <p>
      <script type="text/javascript">
      var aBDatePicker = jQuery('.aBDatepicker');

      aBDatePicker.datepicker({
          dateFormat: jQuery(self).attr('data-dateformat')
      });
      </script>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>"><?php esc_attr_e( 'To date:', 'text_domain' ); ?></label>
 		    <input class="widefat aBDatepicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toDate' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toDate ); ?>">
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>"><?php esc_attr_e( 'To time:', 'text_domain' ); ?></label>
 		    <input class="widefat aBTimepicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toTime' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toTime ); ?>">
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

 		return $instance;
 	}

 } // class Foo_Widget

 // register Foo_Widget widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );
