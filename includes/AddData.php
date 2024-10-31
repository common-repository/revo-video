<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class AddData
{
    public static function add($key_id, $user_id, $consumer_key, $consumer_secret, $key_permissions, $callback_url)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . REVO_VIDEO_TABLE_API_KEYS;

        self::create_table($table_name);

        $wpdb->insert($table_name, array('key_id' => $key_id, 'user_id' => $user_id, 'consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret, 'key_permissions' => $key_permissions, 'callback_url' => $callback_url));
    }

    private static function create_table($table_name)
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
          id mediumint(9) NOT NULL AUTO_INCREMENT,
          key_id int(11) NOT NULL,
          user_id text NOT NULL,
          consumer_key text NOT NULL,
          consumer_secret text NOT NULL,
          key_permissions text NOT NULL,
          callback_url text NOT NULL,
          PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
