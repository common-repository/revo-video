<?php

/**
 * @package RevoVideo
 */

namespace RevoVideo;

class Integration
{
    public function generate_integration()
    {
        add_action('rest_api_init', array($this, 'connect_with_revo'));
    }

    /**
     *  Called after woocommerce rest api approve
     * 
     *  @param \WP_REST_Request Core class used to implement a REST request object.
     *  @param $request
     */

    public function connect_with_revo($request)
    {
        register_rest_route('revo-video/v1', 'auth', array(
            'methods' => 'POST',
            'callback' => function (\WP_REST_Request $request) {
                $request_body = json_decode($request->get_body());

                $key_id = $request_body->key_id;
                $user_id = $request_body->user_id;
                $consumer_key = $request_body->consumer_key;
                $consumer_secret = $request_body->consumer_secret;
                $key_permissions = $request_body->key_permissions;

                $url = $this->send_data_to_revo($request_body);

                // send the data to qa env to
                $this->send_data_to_revo_qa($request_body);

                if ($url == 400) {
                    return new \WP_Error('error', __('Error while sending data to revo'), array('status' => 400));
                }

                \RevoVideo\AddData::add($key_id, $user_id, $consumer_key, $consumer_secret, $key_permissions, $url);

                echo json_encode(['status' => 'success']);
                exit;
            },
            'permission_callback' => '__return_true',
        ));
    }

    private function send_data_to_revo($data)
    {
        /**
         * Calling token
         */
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

        /**
         * Sending data
         */
        $url = REVO_VIDEO_CALLBACK_URL;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: $token",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $arr = array('key_id' => $data->key_id, 'user_id' => $data->user_id, 'consumer_key' => $data->consumer_key, 'consumer_secret' => $data->consumer_secret, 'key_permissions' => $data->key_permissions, 'store_type' => 'woocommerce', 'store_url' => $this->remove_http(site_url()));

        $json_data = json_encode($arr);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

        $resp = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err || !$httpCode || $httpCode >= 400) {
            return 400;
        }

        $send_token = json_decode($resp)->data->integration_token;

        $params = [
            'group-id' =>  $this->remove_http(site_url()),
            'to-connect' => true,
            'token' => $send_token,
            'store_type' => 'woocommerce'
        ];
        $query_string = http_build_query($params);

        $api_endpoint = REVO_VIDEO_LOGIN_URL . '?' . $query_string;

        return $api_endpoint;
    }

    private function  remove_http($url)
    {
        $disallowed = array('http://', 'https://');
        foreach ($disallowed as $d) {
            if (strpos($url, $d) === 0) {
                return str_replace($d, '', $url);
            }
        }
        return $url;
    }

    private function send_data_to_revo_qa($data)
    {
        /**
         * Calling token
         */
        $remote_url = 'https://pm28n2uufj.execute-api.us-east-1.amazonaws.com/qa/token?userType=app';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD,  'wapp:w&QhVc(4^m@<');


        $result = curl_exec($ch);
        $httpCode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err1 = curl_error($ch);

        curl_close($ch);

        if ($err1 || !$httpCode1 || $httpCode1 >= 400) {
            return 400;
        }

        $token = json_decode($result)->token;

        /**
         * Sending data
         */
        $url = 'https://pm28n2uufj.execute-api.us-east-1.amazonaws.com/qa/integration/plugin/woocommerce';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Content-Type: application/json",
            "Authorization: $token",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $arr = array('key_id' => $data->key_id, 'user_id' => $data->user_id, 'consumer_key' => $data->consumer_key, 'consumer_secret' => $data->consumer_secret, 'key_permissions' => $data->key_permissions, 'store_type' => 'woocommerce', 'store_url' => $this->remove_http(site_url()));

        $json_data = json_encode($arr);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

        $resp = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err || !$httpCode || $httpCode >= 400) {
            return 400;
        }

        $send_token = json_decode($resp)->data->integration_token;

        $params = [
            'group-id' =>  $this->remove_http(site_url()),
            'to-connect' => true,
            'token' => $send_token,
            'store_type' => 'woocommerce'
        ];
        $query_string = http_build_query($params);

        $api_endpoint = REVO_VIDEO_LOGIN_URL . '?' . $query_string;

        return $api_endpoint;
    }
}
