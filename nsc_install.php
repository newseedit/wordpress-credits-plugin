<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Handle activation and deactivation of the plugin */

function nsc_activation() {
	add_option( 'nsc_settings', null, '', 'yes' );
}
register_activation_hook( __FILE__, 'nsc_activation' );

function nsc_deactivation() {
	delete_option('nsc_settings');
}
register_deactivation_hook( __FILE__, 'nsc_deactivation' );
