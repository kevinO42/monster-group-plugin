<?php
/**
 * @package MonsterGroup
 */
namespace Inc\Base;

class Activate
{
    /**
     * Activates plugin and creates a new table
     * @return
     */
    public static function start() 
    {
        global $wpdb;

        // set new database table name
        $table = $wpdb->prefix . 'mg_leads';
        $charset_collate = $wpdb->get_charset_collate();

        // create database table during activation
        $sql = "CREATE TABLE $table (
            id bigint(20) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            email tinytext NOT NULL,
            phone_number varchar(50) NOT NULL,
            service tinytext NOT NULL,
            created_at timestamp DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY  (id)
        ) $charset_collate";

        // examines the current table structure
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}