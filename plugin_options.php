<?php

function nsc_create_page() {
//include('nsc_admin_page.php');

  if ( !current_user_can( 'manage_options' ) ) {
    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
  }
  include_once 'nsc_update.php';
echo '<form method="post" action=" '. str_replace( '%7E', '~', $_SERVER['REQUEST_URI']) .'">';
echo "<table>";

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
      echo '<b style >Name:</b>' . ' ' . $plugin['Name'];
      echo '</br>';
      echo '<b>URL:</b>' . ' ' . $plugin['PluginURI'];
      echo '</br>';
      echo '<b>Version</b>' . ' ' . $plugin['Version'];
      echo '</br></td><td>';
      echo '<input class="widefat" id="plugin'.$i.'" name="plugin'.$i.'" type="checkbox" value= "'.$plugin['Name'].'" '. $checked .' />';
      echo "</td></tr>";
      $i++;
    }
echo "</table>";
?>
    <p class="submit">
    <input type="hidden" name="nsc_hidden" value="Y">
      <input type="submit" name="Submit" value="<?php _e('Save Options', '' ) ?>" />
    </p>
    <a class="powered-by" target="_blank" href="http://newseed.se"/>powered by New Seed</a>

    </form>
<hr>
<?php }
