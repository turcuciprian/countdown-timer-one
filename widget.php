<?php

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

private function returnDelimiter($del){
  switch($del){
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
    $delimiter = '<br/>';
    break;
  }
  return $delimiter;
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
    $cto_NumbersFontSize = (! empty( $instance['cto_NumbersFontSize'] ) && isset($instance['cto_NumbersFontSize'])) ? $instance['cto_NumbersFontSize'] : esc_html__( '', 'text_domain' );
    $cto_boldNumbers = (! empty( $instance['cto_boldNumbers'] ) && isset($instance['cto_boldNumbers'])) ? $instance['cto_boldNumbers'] : esc_html__( '', 'text_domain' );
    $cto_colorPicker = (! empty( $instance['cto_colorPicker'] ) && isset($instance['cto_colorPicker'])) ? $instance['cto_colorPicker'] : esc_html__( '', 'text_domain' );

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
    $delimiter = $this->returnDelimiter($instance['cto_delimiter']);
    ?>
    var delimiter = '<?php echo $delimiter;?>';
    var t = cto_getTimeRemaining(endtime);
    clock.innerHTML =  '<span  style="font-size:<?php echo $cto_NumbersFontSize; ?>">'+t.days +'</span> days '+ delimiter +
                      '<span  style="font-size:<?php echo $cto_NumbersFontSize; ?>">'+t.hours +'</span> hours '+ delimiter +
                      '<span  style="font-size:<?php echo $cto_NumbersFontSize; ?>">'+t.minutes +'</span> minutes ' + delimiter +
                      '<span  style="font-size:<?php echo $cto_NumbersFontSize; ?>">'+t.seconds +'</span> seconds ';
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
 		$cto_NumbersFontSize = (! empty( $instance['cto_NumbersFontSize'] ) && isset($instance['cto_NumbersFontSize'])) ? $instance['cto_NumbersFontSize'] : esc_html__( '', 'text_domain' );
    $cto_boldNumbers = (! empty( $instance['cto_boldNumbers'] ) && isset($instance['cto_boldNumbers'])) ? $instance['cto_boldNumbers'] : esc_html__( '', 'text_domain' );
    $cto_colorPicker = (! empty( $instance['cto_colorPicker'] ) && isset($instance['cto_colorPicker'])) ? $instance['cto_colorPicker'] : esc_html__( '', 'text_domain' );
 		?>
 		<p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'text_domain' ); ?></label>
 		    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>"><?php esc_attr_e( 'End date:', 'text_domain' ); ?></label>
 		    <input class="widefat ctoDatePicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toDate' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toDate' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toDate ); ?>">
        <script type="text/javascript">
        jQuery(document).ready(function($) {
          var ctoDatePicker = $('.ctoDatePicker');
          ctoDatePicker.on('hover',function(){
            if (ctoDatePicker[0]) {
                //check if datepicker exists as a function
                if (typeof ctoDatePicker.datepicker == 'function') {
                  ctoDatePicker.datepicker({
                      dateFormat: $(self).attr('data-dateformat')
                  });
                }
            }
          });


          //Timepicker
          var ctoTimepicker = $('.ctoTimepicker');
          if (ctoTimepicker[0]) {
              if (typeof ctoTimepicker.timepicker == 'function') {
                  ctoTimepicker.timepicker({timeFormat: 'h:i A',});
              }
          }
          var ctoColorPicker = $('.ctoColorPicker');
          if (ctoColorPicker[0]) {
              if (typeof ctoColorPicker.iris == 'function') {
                  ctoColorPicker.iris({
                      hide: true
                  });
              }
          }
        });

        </script>
 		</p>
    <p>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>"><?php esc_attr_e( 'End time:', 'text_domain' ); ?></label>
 		    <input class="widefat ctoTimepicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_toTime' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_toTime' ) ); ?>" type="text" value="<?php echo esc_attr( $cto_toTime ); ?>">
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
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'cto_NumbersFontSize' ) ); ?>"><?php esc_attr_e( 'Numbers Font Size:', 'text_domain' ); ?></label><br/>
      <select class="" name="<?php echo esc_attr( $this->get_field_name('cto_NumbersFontSize')); ?>">
        <option value="11px" <?php selected($cto_NumbersFontSize,'11px',true);?>>Tiny (11px)</option>
        <option value="14px" <?php selected($cto_NumbersFontSize,'14px',true);?>>Small(14px)</option>
        <option value="16px" <?php selected($cto_NumbersFontSize,'16px',true);?>>Normal (16px)</option>
        <option value="24px" <?php selected($cto_NumbersFontSize,'24px',true);?>>Big (24px)</option>
        <option value="36px" <?php selected($cto_NumbersFontSize,'36px',true);?>>Large (36px)</option>
        <option value="42px" <?php selected($cto_NumbersFontSize,'42px',true);?>>Huge (42px)</option>
      </select>
    </p>
    <p>
        <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'cto_boldNumbers' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'cto_boldNumbers' ) ); ?>" type="checkbox" value="true" <?php checked($cto_boldNumbers,'true'); ?>>
        <label for="<?php echo esc_attr( $this->get_field_id( 'cto_boldNumbers' ) ); ?>"><?php esc_attr_e( ' - Bold Numbers:', 'text_domain' ); ?></label>

 		</p>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'cto_colorPicker' ) ); ?>"><?php esc_attr_e( 'Text Color:', 'text_domain' ); ?></label>
        <input class="ctoColorPicker" id="<?php echo esc_attr( $this->get_field_id( 'cto_colorPicker' ) ); ?>" readonly name="<?php echo esc_attr( $this->get_field_name( 'cto_colorPicker' ) ); ?>" type="textbox" value="<?php echo $cto_colorPicker; ?>" size="10">

 		</p>

    <?php
      $delimiter = $this->returnDelimiter($cto_delimiter);
      $cto_boldNumbersString = 'normal';
      if($cto_boldNumbers==='true'){
        $cto_boldNumbersString = 'bold';
      }
    ?>
    <style media="screen">
      .ctoNumbers{
        font-size:<?php echo $cto_NumbersFontSize; ?>;
        font-weight:<?php echo $cto_boldNumbersString;?>;
        color:<?php echo $cto_colorPicker;?>;
      }
    </style>
    <h3>Result Preview:</h3>
<p class="preview">
  <span class="ctoNumbers day" style="">99</span>
  <span class="dayText">Days</span><?php echo $delimiter; ?>

  <span class="ctoNumbers hour">24</span>
  <span class="dayText">Hours</span><?php echo $delimiter; ?>

  <span class="ctoNumbers minute">59</span>
  <span class="dayText">Minutes</span><?php echo $delimiter; ?>

  <span class="ctoNumbers second">59</span>
  <span class="dayText">Seconds</span>
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
    $instance['cto_NumbersFontSize'] = ( ! empty( $new_instance['cto_NumbersFontSize'] ) ) ? strip_tags( $new_instance['cto_NumbersFontSize'] ) : '';
    $instance['cto_boldNumbers'] = ( ! empty( $new_instance['cto_boldNumbers'] ) ) ? strip_tags( $new_instance['cto_boldNumbers'] ) : '';
 		$instance['cto_colorPicker'] = ( ! empty( $new_instance['cto_colorPicker'] ) ) ? strip_tags( $new_instance['cto_colorPicker'] ) : '';

 		return $instance;
 	}

 } // class CTO_Widget

 // register CTO_Widget widget
function cto_register_widget() {
    register_widget( 'CTO_Widget' );
}
add_action( 'widgets_init', 'cto_register_widget' );
