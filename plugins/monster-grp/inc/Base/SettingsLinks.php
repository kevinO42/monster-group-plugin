<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Base;

use Inc\Base\BaseController;

class SettingsLinks extends BaseController
{
    /**
     * Creates a menu link to add on the installed plugins page
     * @return
     */
    public function register()
    {
        add_filter("plugin_action_links_$this->plugin", array($this, 'settings_link'));
    }

    /**
     * Instantiate settings link in installed plugin page
     * @return array Link created along with all the links
     */
    public function settings_link($links)
    {
        $settings_link = '<a href="admin.php?page=monster_grp">Leads</a>';
        array_push($links, $settings_link);
        
        return $links;
    }
}