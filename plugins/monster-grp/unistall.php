<?php
/**
 * @package  MonsterGroup
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

// truncates the custom table
global $wpdb;

$table = $wpdb->prefix . 'mg_leads';
$wpdb->query("DELETE FROM $table");