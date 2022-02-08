<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
    public $settings;
    public $callbacks;
    public $pages = array();

    /**
     * Builds admin pages
     * @return
     */
    public function __construct()
    {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->set_pages();
        $this->settings->add_pages($this->pages)->register();
		
    }

    /**
     * Defines menu page information and store to array
     * @return
     */
    public function set_pages()
    {
        $this->pages = array(
			array(
                'page_title' => 'Monster Group Plugin', 
				'menu_title' => 'Leads', 
				'capability' => 'manage_options', 
				'menu_slug' => 'monster_grp', 
				'callback' => array($this->callbacks, 'leads'), 
				'icon_url' => 'dashicons-media-spreadsheet', 
				'position' => 90
            )
		);
    }

    /**
     * Registers menu page information and creates menu 
     */
    public function register() 
	{
		$this->settings->add_pages($this->pages)->register();
	}
}