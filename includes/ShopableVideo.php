<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class ShopableVideo
{
    public  function add_header_script()
    {
        add_action('wp_head', array($this, 'header_scripts'));
    }

    public function header_scripts()
    {
        echo '<script src="https://assets.revovideo.com/v1.0/embed.js" defer></script>';
    }
}
