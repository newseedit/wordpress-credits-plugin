<?php

function nsc_create_page() {
//include('nsc_admin_page.php');

  if ( !current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  include_once 'nsc_update.php';
echo '<form method="post" class="nsc-admin-form" action=" '. str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) .'">';
echo "<table>" . "<h2>NewSeed Credit Settings</h2>";

if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $plugins = get_plugins();
    $i = 0;

    foreach ($plugins as $plugin){
      $checked="";
      if(get_option('plugin'.$i)!=null){
        $checked = 'checked';
      }
      echo "<tr><td>";
      echo '<div class="nsc-plugin-name-admin">' . ' ' . $plugin['Name'];
      echo '</br>';
      echo '<div class="nsc-plugin-url-admin">' . ' ' . $plugin['PluginURI'];
      echo '</br>';
      echo '<div class="nsc-plugin-version-admin">' . ' ' . $plugin['Version'];
      echo '</br></td><td>';
      echo '<input class="nsc-widefat-admin" id="plugin'.$i.'" name="plugin'.$i.'" type="checkbox" value= "'.$plugin['Name'].'" '. $checked .' />';
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
