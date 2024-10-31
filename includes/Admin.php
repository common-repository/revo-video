<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class Admin
{
    public function generate_admin_page()
    {
        add_action('admin_menu', array($this, 'add_admin_page'));
    }

    // Create custom admin page
    public function add_admin_page()
    {
        $revo_icon = REVO_VIDEO_URL . 'static/img/logo.jpg';
        add_menu_page('Revo Video', 'Revo Video', 'manage_options', REVO_VIDEO_CUSTOM_ADMIN_PAGE, array($this, 'admin_index'), $revo_icon, 51);
    }

    // render the page for revo admin 
    public function admin_index()
    {
        if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
            require_once REVO_VIDEO_PATH . 'templates/error.php';
        } else {
            require_once REVO_VIDEO_PATH . 'templates/admin.php';
        }
    }
}
