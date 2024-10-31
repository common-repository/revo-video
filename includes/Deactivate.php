<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class Deactivate
{
    public static function deactivate()
    {
        self::dump_table();

        // refreshing flush rewrite rules for database changes
        flush_rewrite_rules();
    }

    private static function dump_table()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . REVO_VIDEO_TABLE_API_KEYS;

        $wpdb->query("DELETE FROM wp_woocommerce_api_keys WHERE key_id IN (SELECT key_id FROM $table_name)");

        $wpdb->query("DROP TABLE IF EXISTS $table_name");

        delete_option("my_plugin_db_version");
    }
}
