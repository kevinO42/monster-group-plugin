<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Api;

class SettingsApi 
{
    public $admin_pages = array();

    /**
     * Creates a new admin page
     * @return
     */
    public function register() 
    {
        if (!empty($this->admin_pages)) {
			add_action('admin_menu', array( $this, 'add_admin_menu'));
		}
    }

    /**
     * Instatntiate admin_page
     * @return
     */
    public function add_pages(array $pages)
	{
		$this->admin_pages = $pages;

		return $this;
	}

    /**
     * Add new page on admin menu
     * @return
     */
    public function add_admin_menu()
	{
		foreach ($this->admin_pages as $page) {
			add_menu_page(
                $page['page_title'], 
                $page['menu_title'], 
                $page['capability'], 
                $page['menu_slug'], 
                $page['callback'], 
                $page['icon_url'], 
                $page['position'] 
            );
		}
	}
}