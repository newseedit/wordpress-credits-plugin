<?php
/*
* Plugin Name: NewSeed Credit Widget
* Description: Show the plugins you are using on your wordpress site or blogg.
* Plugin URI: http://newseed.se/
* Version: 1.0
* Author: Aydin Nalbantov
* Author URI: http://www.aydin.cf/plugins/
* Many thanks to Magnus Nilsson and Emmely Lundberg from NewSeed IT Solutions
* who helped me all the time while I was developing this plugin.
* A big thanks to Magnus Lindgren from NewSeed IT Solutions who gave me an internship and the time to teach me programming.
* License: GPLv2 or later

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

include_once 'install.php';

add_action('admin_menu', 'nsc_admin_meny');
function nsc_admin_meny() {
    include_once 'plugin_options.php';

  add_options_page ('New Seed Credit Settings','New Seed Credit', 'manage_options','new-seed-credit', 'nsc_create_page');
}

add_shortcode( 'newseed', 'displayPluginContent' );
   function displayPluginContent() {

    if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    $i = 0;
    foreach ($plugins as $plugin){
      if(get_option('plugin'.$i) != null){
        echo '<div class="nsc-plugin-name">' . ' ' . $plugin['Name'] . '</div>';
        echo '</br>';
        echo '<div class="nsc-plugin-desc">' . ' ' . $plugin['Description'] . '</div>';
        echo '<div class="nsc-plugin-uri">' . ' ' .$plugin['PluginURI'] . '</div>';
        echo '<div class="nsc-plugin-version">' . ' ' . $plugin['Version'] . '</div>';
        echo '</br>';
      }
      $i++;
    }
  }

  if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
  class wpb_widget extends WP_Widget {

    function __construct() {
      parent::__construct(
      // Base ID of the widget
      'wpb_widget',

      // Widget name will appear in UI
      __('New seed Credit Widget', 'wpb_widget_domain'),

      // Widget description
      array( 'description' => __( 'Shows to the visitors your favorit plugins you love to use', 'wpb_widget_domain' ), )
    );
  }

  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    echo $args['before_widget'];
    if ( ! empty( $title ) ){
      echo $args['before_title'] . $title . $args['after_title'];
    }

    $this->displayContent( $instance);
    echo $args['after_widget'];
  }

  public function displayContent( $instance ) {

    if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    $i = 0;
    foreach ($plugins as $plugin){
      if(isset($instance['plugin'.$i])){
        $plugin = $instance['plugin'.$i];
        $checked = 'checked';

        echo '<div class="nsc-widget-name">' . ' ' . $plugin['Name'] . '</div>';
        echo '</br>';
        echo $plugin['Description'];
        echo '</br>';
        echo ' <a href="' .$plugin['PluginURI'] . '" rel="nofollow">'.$plugin['PluginURI'].'</a>';
        echo '</br>';
        echo $plugin['Version'];
        echo '</br>' . '</br>';
      }
      $i++;
    }
  }
  public function form( $instance ) {
    $plugins = get_plugins();
    $i = 0;
    echo "<table>";

    foreach ($plugins as $plugin){
      $checked="";
      if(isset($instance['plugin'.$i])){
        $checked = 'checked';
      }

      echo "<tr><td>";
      echo $plugin['Name'];
      echo '</br>';
      echo '<div id="nsc-url">URL:</b>' . ' ' . $plugin['PluginURI'];
      echo '</br>';
      echo '<b>Version</b>' . ' ' . $plugin['Version'];
      echo '</br></td><td>';
      echo '<input class="widefat" id="'. $this->get_field_id( 'plugin'.$i ).'" name="'. $this->get_field_name( 'plugin'.$i ).'" type="checkbox" value= "' . $this->get_field_name( 'plugin'.$i ) .'" '. $checked .' />';
      echo "</td></tr>";
      $i++;
    }
    echo "</table>";

    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'wpb_widget_domain' );
      $checkbox = '';
    }
    ?>
    <p>
      <label class="nsc-the-title"form="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="nsc-widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
      <?php
    }

    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
      error_log( print_r( $new_instance, true ) );
      $plugins = get_plugins();
      $i = 0;
      foreach ($plugins as $plugin){
        if(isset($new_instance['plugin'.$i])){
          $instance['plugin'.$i] = $plugin;
        }
        $i++;
      }
      $instance['textarea'] = strip_tags($new_instance['textarea']);
      $instance['checkbox'] = strip_tags($new_instance['checkbox']);
      $instance['select'] = strip_tags($new_instance['select']);
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      return $instance;
    }
  }

  // Register and load the widget
  function wpb_load_widget() {
    register_widget( 'wpb_widget' );
          include_once(plugin_dir_path(__FILE__) . '/include/nsc-scripts.php');
  }
  add_action( 'widgets_init', 'wpb_load_widget' );
  /* Stop Adding Functions Below this Line */
