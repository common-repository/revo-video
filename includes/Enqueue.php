<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class Enqueue
{
    public function enque_css()
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
    }

    // enqueue all our styles & scripts
    public function enqueue()
    {
        $css =  REVO_VIDEO_URL . 'static/css/style.css';
        wp_enqueue_style(REVO_VIDEO_ENQUEUE_STYLE_HANDLE, $css);
    }
}
