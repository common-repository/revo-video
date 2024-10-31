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
                    <p>Please Install woocommerce to do live shows in Revo Video & increase your sales.</p>
                    <?php
                    if (!defined('REVO_VIDEO_REDIRECT_URL')) {
                        echo  '<button class="revovideo-btn revo-video-disable_btn" type="button" disabled>Launch App</button>';
                    } else {
                        echo  '<a class="revovideo-btn" target="_blank" href="https://revovideo.com/auth">Launch App</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
</div>