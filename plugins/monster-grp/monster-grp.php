<?php
/**
 * @package MonsterGroup
 */
/*
PLUGIN NAME: Monster Group Leads
DESCRIPTION: Code task for Monster Group application
VERSION: 1.0.0
AUTHOR: Kevin Kristoffer Oporto
*/

defined('ABSPATH') or die('You are not welcome here silly human!');

if (file_exists( dirname( __FILE__ ) . '/vendor/autoload.php')) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * Will execute during plugin activation
 */
function plugin_activation() 
{
    // create wp_mg_leads table during activation
    Inc\Base\Activate::start();
}

register_activation_hook(__FILE__, 'plugin_activation');

/**
 * Will execute during plugin deactivation
 */
function plugin_deactivation() 
{
    // empty function for structure purposes only
    Inc\Base\Deactivate::stop();
}

register_deactivation_hook(__FILE__, 'plugin_deactivation');

/**
 * Initialize all the core classes of the plugin
 */
if (class_exists('Inc\\Service')) {
	Inc\Service::register_services();
}

// temporary fix
// require_once plugin_dir_path( __FILE__ ).'shortcodes/CustomerForm.php';