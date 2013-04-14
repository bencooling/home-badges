<?php
/*
Plugin Name: Home Badges
Plugin URI: 
Description: Menu shortcuts & listing badges to easily edit and identify home and front pages.
Version: 0.6
Author: Ben Cooling
Author URI: http://bcooling.com.au
License: GPLv2 or later
*/

/**
 * 
 * Bootstrap file for home_badges
 * 
 */

// Plugin Constants
define('HOBADGES_PREFIX', 'hob_');
define('HOBADGES_FILE', __FILE__);
define('HOBADGES_DIR_PATH', plugin_dir_path(__FILE__));

// admin-only context
if ( is_admin() ) {
  if ( defined('DOING_AJAX') && DOING_AJAX ){
    $file = false;
  }
  else {
    $file = 'Admin';
  }
}
else {
  $file = false;
}

if ($file){

  function uniqueInstantiation($file){
    $className = HOBADGES_PREFIX . $file;
    if (! class_exists($className) ){
      require( HOBADGES_DIR_PATH . $file . '.php');
      return new $className;
    }
  }

  // Instantiate required plugin controller and generic class
  $specific = uniqueInstantiation($file);

}