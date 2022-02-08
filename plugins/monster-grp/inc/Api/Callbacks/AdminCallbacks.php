<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class AdminCallbacks extends BaseController
{
    /**
     * Calls on the leads view 
     * @return
     */
    public function leads()
    {
        return require_once("$this->plugin_path/views/admin.php");
    }
}