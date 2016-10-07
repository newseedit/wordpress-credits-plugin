<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function nsc_create_page() {

  if ( !current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }

  $plugins = get_plugins();
  $settings = get_option('nsc_settings');

  /* if it is a post to this page */
  if ( isset( $_POST['nsc_hidden'] ) ) {
    $i = 0;
    foreach ($plugins as $plugin){
      if ( isset( $_POST['plugin_'.$i] ) ) {
        $settings['plugin_'.$i] = true;
      }
      else {
        unset( $settings['plugin_'.$i] );
      }
      $i++;
    }
    update_option('nsc_settings',$settings);
    //Form data sent
    ?>
    <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
    <?php
  } else {
      //Normal page display
  }


echo '<form method="post" class="nsc-admin-form" action=" '. str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) .'">';
echo "<table>" . "<h2>NewSeed Credit Settings</h2>";


if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $i = 0;

    foreach ($plugins as $plugin){
      $checked="";
      if($settings['plugin_'.$i]!=null){
        $checked = 'checked';
      }
      echo "<tr><td>";
      echo '<div class="nsc-plugin-name-admin">' . ' ' . $plugin['Name'];
      echo '</br>';
      echo '<div class="nsc-plugin-url-admin">' . ' ' . $plugin['PluginURI'];
      echo '</br>';
      echo '<div class="nsc-plugin-version-admin">' . ' ' . $plugin['Version'];
      echo '</br></td><td>';
      echo '<input class="nsc-widefat-admin" name="plugin_'. $i .'" type="checkbox" value= "1" '. $checked .' />';
      echo "</td></tr>";
      $i++;
    }
echo "</table>";
?>
    <p class="nsc-submit">
    <input type="hidden" name="nsc_hidden" value="Y">
      <input type="submit" class="nsc-save-btn" name="Submit" value="<?php _e('Save Options', '' ) ?>" />
    </p>
    <a class="nsc-powered-by" target="_blank" href="http://newseed.se"/>powered by New Seed</a>
  </form>
<hr>
<?php }
