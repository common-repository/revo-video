<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class Activate
{
    public static function activate()
    {
        // refreshing flush rewrite rules for database changes
        flush_rewrite_rules();
    }
}
