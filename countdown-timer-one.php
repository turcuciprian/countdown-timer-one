<?php
/*
  Plugin Name: Countdown Timer One
  Plugin URI: http://ciprianturcu.com/countdown-timer-one/
  Description: create a countdown timer widget that's configurable and dynamic so that you can make a countdown timer widget
  Version: 1.0.6
  Author: turcuciprian
  Author URI: http://ciprianturcu.com
  License: GPLv2 or later
  Text Domain: countdown-timer-one
 */

 if(!function_exists('cto_AdminEnqueueAll')){
   //Admin scripts and styles
   add_action('admin_enqueue_scripts', 'cto_AdminEnqueueAll');
   //Admin scripts and styles callback
   function cto_AdminEnqueueAll()
   {
     //*
     // CSS
     //*
     cto_Exists('jQueryUiCore', 'src/css/jquery-ui.css', 'style',array(),'plugin');
     cto_Exists('cto_Timepicker', 'src/css/jquery.timepicker.css', 'style',array(),'plugin');
     cto_Exists('cto_iris', 'src/css/iris.min.css', 'style',array(),'plugin');
     cto_Exists('cto_customStyle', 'src/css/abStyle.css', 'style',null,'plugin');

       //*
       //  Custom JS
       //*
       wp_enqueue_media();
       wp_enqueue_script('jquery-ui-core');
       wp_enqueue_script('jquery-ui-draggable');
       wp_enqueue_script('jquery-ui-slider');
       wp_enqueue_script('jquery-ui-widget', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-mouse', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-datepicker', false, array('jquery-ui-core'));
       wp_enqueue_script('jquery-ui-draggable', false, array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'));
       wp_enqueue_script('jquery-ui-slider', false, array('jquery-ui-core', 'jquery-ui-widget', 'jquery-ui-mouse'));
       //*
       //  Custom JS
       //*
       cto_Exists('cto_color', 'src/js/color.js', 'script',array('jquery'),'plugin');
       cto_Exists('cto_iris', 'src/js/iris.js', 'script',array('jquery-ui-core', 'jquery-ui-draggable', 'jquery-ui-slider'),'plugin');
       cto_Exists('cto_Timepicker', 'src/js/jquery.timepicker.min.js', 'script',array('jquery-ui-core'),'plugin');
       cto_Exists('cto_CustomScript', 'src/js/script.js', 'script',array(),'plugin');
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



require_once 'widget.php';
