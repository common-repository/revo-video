<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class RevoLink
{
    private $plugin;
    private $revo_page;

    public function __construct()
    {
        $this->plugin = REVO_VIDEO_PLUGIN_BASE_NAME;
        $this->revo_page = REVO_VIDEO_CUSTOM_ADMIN_PAGE;
    }

    public function generate_revo_link()
    {
        add_filter("plugin_action_links_$this->plugin", array($this, 'revo_video_admin_link'));
    }

    // generating the Revo link in active page
    function revo_video_admin_link($links)
    {
        $new_link = "<a href='admin.php?page=$this->revo_page' >Revo</a>";
        array_push($links, $new_link);
        return $links;
    }
}
