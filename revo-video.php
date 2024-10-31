<?php

/**
 * @package RevoVideo
 */

/*
Plugin Name: Revo Video
Description: This plugin helps you connect your store to Revo Video
Version:     2.0.0
Author:      Revo Video
Author URI:  https://revovideo.com/
Text Domain: revo-video
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Require once the Composer Autoload
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

// Define CONSTANTS
define("REVO_VIDEO_CUSTOM_POST_TYPE", 'revo_video_feed');
define("REVO_VIDEO_CUSTOM_ADMIN_PAGE", 'revo_video_admin_page');
define('REVO_VIDEO_PATH', plugin_dir_path(__FILE__));
define('REVO_VIDEO_URL', plugin_dir_url(__FILE__));
define('REVO_VIDEO_ENQUEUE_STYLE_HANDLE', 'revo_video_enqueue_style_handle');
define('REVO_VIDEO_ENQUEUE_SCRIPT_HANDLE', 'revo_video_enqueue_script_handle');
define('REVO_VIDEO_PLUGIN_BASE_NAME', plugin_basename(__FILE__));


define('REVO_VIDEO_LOGIN_URL', 'https://revovideo.com/auth');
define('REVO_VIDEO_TOKEN_URL', 'https://shop-prod-api.revo.video/token?userType=app');
define('REVO_VIDEO_CALLBACK_URL', 'https://shop-prod-api.revo.video/integration/plugin/woocommerce');
define('REVO_VIDEO_ENDPOINT',  'https://shop-prod-api.revo.video');

define('REVO_VIDEO_TABLE_API_KEYS', 'revo_video_api_keys');

/**
 * The code that runs during plugin activation
 */
function activate_revo_video()
{
    RevoVideo\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_revo_video');

/**
 * The code that runs during plugin deactivation
 */
function deactivate_revo_video()
{
    RevoVideo\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_revo_video');

/**
 * Enqueue custom css for revo video page
 */
$enqueue  = RevoVideo\Enqueue::class;
(new $enqueue())->enque_css();

/**
 * Adding Shoapable Video Header Script
 */
$shopableVideo = RevoVideo\ShopableVideo::class;
(new $shopableVideo())->add_header_script();

/**
 * Generate launch page for revo video
 */
$admin  = RevoVideo\Admin::class;
(new $admin())->generate_admin_page();

/**
 * Generate link for for revo
 */
$revoLink  = RevoVideo\RevoLink::class;
(new $revoLink())->generate_revo_link();

/**
 * Run the integration handle server
 */
$integration  = RevoVideo\Integration::class;
(new $integration())->generate_integration();

/**
 * Generating the link for api key permission
 */
$store_url = site_url();  //website url
$endpoint = '/wc-auth/v1/authorize';

if (get_current_user_id()) {
    $login_user_id = get_current_user_id();
} else {
    $login_user_id = 1;
}

$params = [
    'app_name' => 'Revo Video',
    'scope' => 'read_write',
    'user_id' => $login_user_id,
    'return_url' => $store_url . '/wp-admin/admin.php?page=' . REVO_VIDEO_CUSTOM_ADMIN_PAGE,
    'callback_url' => $store_url . '/wp-json/revo-video/v1/auth',
];
$query_string = http_build_query($params);

$api_endpoint = $store_url . $endpoint . '?' . $query_string;

define('REVO_VIDEO_API_PERMISSION', $api_endpoint);


global $wpdb;
$table_name = $wpdb->prefix . REVO_VIDEO_TABLE_API_KEYS;

/**
 *  If permission granted / generating the redirect link to revo log in page
 */
if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name) {
    $table_name = $wpdb->prefix . REVO_VIDEO_TABLE_API_KEYS;
    $sql_data = $wpdb->get_results("SELECT * FROM $table_name");

    $key = 0;
    $callback_url = 'null';
    foreach ($sql_data as $single_data) {
        if ($single_data->id > $key) {
            $key = $single_data->id;
            $callback_url = $single_data->callback_url;
        }
    }

    define('REVO_VIDEO_REDIRECT_URL', $callback_url);
}

function  remove_http($url)
{
    $disallowed = array('http://', 'https://');
    foreach ($disallowed as $d) {
        if (strpos($url, $d) === 0) {
            return str_replace($d, '', $url);
        }
    }
    return $url;
}
