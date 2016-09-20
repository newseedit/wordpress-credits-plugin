<?php
/*
 * Plugin Name: NewSeed Credit Widget
 * Description: Show the other plugins you are using on your wordpress site or blogg.
 * Plugin URI: http://newseed.se/
 * Version: 1.0
 * Author: Aydin Nalbantov
 * Author URI: http://www.aydin.cf/plugins/
 * License: GPLv2
 */

/* Start Adding Functions Below this Line */

// Creating the widget
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

  // Creating widget front-end
  // This is where the action happens
  public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) ){
      echo $args['before_title'] . $title . $args['after_title'];
    }

    // This is where the code runs and displays the output
    //echo __( 'Hello, World!', 'wpb_widget_domain', 'Name', 'PluginURI', 'Version'  );
    $this->displayContent( $instance);
    echo $args['after_widget'];
  }

  // Widget Backend
  public function displayContent( $instance ) {
    // Check if get_plugins() function exists. This is required on the front end of the
    // site, since it is in a file that is normally only loaded in the admin.
    if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    $i = 0;
    foreach ($plugins as $plugin){
      if(isset($instance['plugin'.$i])){
        $plugin = $instance['plugin'.$i];
        echo '<b>Name:</b>' . ' ' . $plugin['Name'];
        echo '</br>';
        echo '<b>URL:</b>' . ' ' . $plugin['PluginURI'];
        echo '</br>';
        echo '<b>Version</b>' . ' ' . $plugin['Version'];
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
    echo '<b style >Name:</b>' . ' ' . $plugin['Name'];
    echo '</br>';
    echo '<b>URL:</b>' . ' ' . $plugin['PluginURI'];
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

// Widget admin form
?>
<p>
<label form="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

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
} // Class wpb_widget ends here

// Register and load the widget
function wpb_load_widget() {
  register_widget( 'wpb_widget' );
  wp_enqueue_style( 'style', plugins_url( 'css/style.css', __FILE__ ), false, 'v1', $media = 'all' );
}
add_action( 'widgets_init', 'wpb_load_widget' );
/* Stop Adding Functions Below this Line */
?>
