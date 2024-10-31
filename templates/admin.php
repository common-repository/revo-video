<?php

use RevoVideo\RevoApiCall;

$token = \RevoVideo\RevoApiCall::get_token();
$revo_url = REVO_VIDEO_LOGIN_URL;
$brand = \RevoVideo\RevoApiCall::get_brands($token);

$brand_name = '';
foreach ($brand as $s) {
    $brand_name = $brand_name . ", " . $s->handle;
}
$brand_name = trim($brand_name, ", ");

$valid_token_exist  = \RevoVideo\RevoApiCall::valid_token_exist($token);
$brand_count =  sizeof($brand);

if ($brand_count == 0 && str_contains($_SERVER['QUERY_STRING'], 'user_id') && str_contains($_SERVER['QUERY_STRING'], 'success') && $_GET['user_id'] && $_GET['success'] && defined('REVO_VIDEO_REDIRECT_URL')) {
    header("Location: " . REVO_VIDEO_REDIRECT_URL);
    exit();
}

?>

<div class="revovideo-contailer">
    <h2 class="revovideo-header">Welcome to Revo App</h1>

        <div class="revovideo-child revovideo-child-exception">
            <div class="revovideo-left">
                <h2 class="revovideo-sub-title">
                    Revo Account
                </h2>
                <p class="revovideo-paragraph">
                    Connect your shop to start selling on our marketplace.
                </p>
            </div>
            <div class="revovideo-right">
                <div class="revovideo-sub-contailer revovideo-sub-contailer-lauchapp">

                    <?php
                    if ($brand_count > 0 && $valid_token_exist) {
                        echo "<p>Your Woocommerce store is connected to <b>'$brand_name'</b> Revo account.</p>";
                    } else {
                        echo '<p>Please connect your Woocommerce store to a Revo account.</p>';
                    }
                    ?>

                    <?php

                    if ($brand_count > 0 && $valid_token_exist) {
                        echo '<button class="revovideo-btn revo-video-disable_btn" type="button" disabled>Connected</button>';
                    } else if ($brand_count == 0 && $valid_token_exist) {
                        $params = [
                            'group-id' => remove_http(site_url()),
                            'to-connect' => true,
                            'token' => $valid_token_exist,
                            'store_type' => 'woocommerce'
                        ];
                        $query_string = http_build_query($params);

                        $api_endpoint = REVO_VIDEO_LOGIN_URL . '?' . $query_string;

                        echo "<a class='revovideo-btn' href='$api_endpoint'>Connect</a>";
                    } else {
                        echo '<a class="revovideo-btn" href="' . REVO_VIDEO_API_PERMISSION . '">Connect</a>';
                    }

                    ?>
                </div>
            </div>
        </div>

        <div class="revovideo-child revovideo-child-exception">
            <div class="revovideo-left">
                <h2 class="revovideo-sub-title">
                    Revo Account
                </h2>
                <p class="revovideo-paragraph">
                    Connect your shop to start selling on our marketplace.
                </p>
            </div>
            <div class="revovideo-right">
                <div class="revovideo-sub-contailer revovideo-sub-contailer-lauchapp">
                    <p>Create an event and invite users to your live show. By clicking on create event you are agreeing to the <a href="https://revovideo.com/terms" target="_blank">Terms and Conditions</a>.</p>
                    <?php

                    if ($brand_count > 0 && $valid_token_exist) {
                        echo  "<a class='revovideo-btn' target='_blank' href='$revo_url'>Launch App</a>";
                    } else {
                        echo  '<button class="revovideo-btn revo-video-disable_btn" type="button" disabled>Launch App</button>';
                    }

                    ?>

                </div>
            </div>
        </div>

        <div class="revovideo-child">
            <div class="revovideo-left">
                <h2 class="revovideo-sub-title">
                    Terms and Conditions
                </h2>
                <p class="revovideo-paragraph">
                    The terms and conditions for selling products on Revo.
                </p>
            </div>
            <div class="revovideo-right">
                <div class="revovideo-sub-contailer">
                    <ul class="revovideo-ul">
                        <li class="revovideo-li">
                            <a href="https://revovideo.com/terms" target="_blank">Terms and Conditions</a>
                        </li>
                        <li class="revovideo-li">
                            <a href="https://revovideo.com/privacy" target="_blank">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="revovideo-child">
            <div class="revovideo-left revovideo-left-price">
                <h2 class="revovideo-sub-title">
                    Subscription and Commission Rate
                </h2>
                <p class="revovideo-paragraph">
                    Details of subscription and commission from Revo App.
                </p>
            </div>
            <div class="revovideo-right">
                <div class="revovideo-sub-contailer">
                    Comming Soon.....
                </div>
            </div>
        </div>
</div>