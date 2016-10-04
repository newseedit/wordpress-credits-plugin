<?php
    if(isset($_POST['nsc_hidden'])) {
      $plugins = get_plugins();
      $i = 0;
      foreach ($plugins as $plugin){
        if(isset($_POST['plugin'.$i])){
          $nsc_plugin = $_POST['plugin'.$i];
        update_option('plugin'.$i, $nsc_plugin);
        } else {
          delete_option('plugin'.$i);
        }
        $i++;
      }
        //Form data sent

        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
        //Normal page display

    }
?>
