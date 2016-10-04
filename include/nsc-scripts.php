<?php
// Add Scripts
function nsc_scripts() {
  wp_enque_style('style',plugins_url() . '/movielist/css/style.css');
}
add_action('wp_enque_scripts', 'nsc_add_scripts');
