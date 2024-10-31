<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class RevoApiCall
{
    public static function get_token()
    {
        $remote_url = REVO_VIDEO_TOKEN_URL;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD,  'w/j{0tVZ]$w9J2q:Zg2iZP*@)tsHEq|+dV2/P');


        $result = curl_exec($ch);
        $httpCode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err1 = curl_error($ch);

        curl_close($ch);

        if ($err1 || !$httpCode1 || $httpCode1 >= 400) {
            return 400;
        }

        $token = json_decode($result)->token;

        return $token;
    }

    public static function valid_token_exist($token)
    {
        $url3 = REVO_VIDEO_CALLBACK_URL . '?store_url=' . remove_http(site_url());
        $ch3 = curl_init();
        $headers3 = array(
            "Content-Type: application/json",
            "Authorization: $token",
        );
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);

        $result3 = curl_exec($ch3);
        $httpCode3 = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
        $err3 = curl_error($ch3);
        curl_close($ch3);

        $send_token = false;
        if ($err3 || !$httpCode3 || $httpCode3 >= 400) {
            $send_token = false;
        } else {
            $send_token = json_decode($result3)->data->integration_token;
        }

        return $send_token;
    }

    public static function get_brands($token)
    {
        $url3 = REVO_VIDEO_ENDPOINT . '/brand/list?storeUrl=' . remove_http(site_url());
        $ch3 = curl_init();
        $headers3 = array(
            "Content-Type: application/json",
            "Authorization: $token",
        );
        curl_setopt($ch3, CURLOPT_URL, $url3);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers3);

        $result3 = curl_exec($ch3);
        $httpCode3 = curl_getinfo($ch3, CURLINFO_HTTP_CODE);
        $err3 = curl_error($ch3);
        curl_close($ch3);

        if ($err3 || !$httpCode3 || $httpCode3 >= 400) {
            return [];
        }

        $brands = json_decode($result3)->data;
        return $brands;
    }
}
