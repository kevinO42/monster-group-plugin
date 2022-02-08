<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class Enqueue extends BaseController
{
    /**
     * Registers class and calls on enqueue function
     * @return
     */
    public function register()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    /**
     * Calls on css and javascript for admin on assets directory
     * @return
     */
    public function enqueue()
    {
        // enqueue all our scripts
		wp_enqueue_style( 'mglstyle', $this->plugin_url . 'assets/admin/style.css' );
		wp_enqueue_script( 'mglscript', $this->plugin_url . 'assets/admin/script.js' );
    }
}