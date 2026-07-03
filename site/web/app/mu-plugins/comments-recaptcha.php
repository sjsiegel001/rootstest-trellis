<?php
/**
 * Plugin Name: Comment reCAPTCHA
 * Description: Protects the WordPress comment form with reCAPTCHA v3, reusing the
 *   keys already configured for Contact Form 7. (CF7's script only guards CF7
 *   forms; this wires the same reCAPTCHA into comment submissions.)
 */

if (! defined('ABSPATH')) {
    exit;
}

function rt_comment_recaptcha_keys(): ?array
{
    if (! class_exists('WPCF7')) {
        return null;
    }

    $recaptcha = (array) WPCF7::get_option('recaptcha');

    if (empty($recaptcha)) {
        return null;
    }

    $sitekey = (string) array_key_first($recaptcha);

    return ['sitekey' => $sitekey, 'secret' => (string) $recaptcha[$sitekey]];
}

// Make sure the reCAPTCHA API is available on comment pages.
add_action('wp_enqueue_scripts', function () {
    if (! is_singular() || ! comments_open()) {
        return;
    }

    $keys = rt_comment_recaptcha_keys();

    if (! $keys) {
        return;
    }

    wp_enqueue_script(
        'rt-comment-recaptcha-api',
        'https://www.google.com/recaptcha/api.js?render=' . rawurlencode($keys['sitekey']),
        [],
        null,
        true
    );
});

// Add the hidden token field + a tiny submit handler to the comment form.
$rt_recaptcha_field = function () {
    $keys = rt_comment_recaptcha_keys();

    if (! $keys) {
        return;
    }

    $sitekey = esc_js($keys['sitekey']);

    echo '<input type="hidden" name="rt_recaptcha_token" id="rt_recaptcha_token" value="">';
    echo "<script>(function(){var f=document.getElementById('commentform');if(!f)return;"
        . "f.addEventListener('submit',function(e){var t=document.getElementById('rt_recaptcha_token');"
        . "if(t&&!t.value&&typeof grecaptcha!=='undefined'){e.preventDefault();"
        . "grecaptcha.ready(function(){grecaptcha.execute('{$sitekey}',{action:'comment'}).then(function(tok){"
        . "t.value=tok;if(f.requestSubmit){f.requestSubmit();}else{f.submit();}});});}});})();</script>";
};
add_action('comment_form_after_fields', $rt_recaptcha_field);
add_action('comment_form_logged_in_after', $rt_recaptcha_field);

// Verify the token before the comment is accepted.
add_filter('preprocess_comment', function ($commentdata) {
    // Moderators skip the challenge.
    if (is_user_logged_in() && current_user_can('moderate_comments')) {
        return $commentdata;
    }

    // Only guard real comments (not pingbacks/trackbacks).
    $type = $commentdata['comment_type'] ?? '';
    if (! in_array($type, ['', 'comment'], true)) {
        return $commentdata;
    }

    $keys = rt_comment_recaptcha_keys();
    if (! $keys) {
        return $commentdata; // No keys configured — don't block.
    }

    $token = isset($_POST['rt_recaptcha_token'])
        ? sanitize_text_field(wp_unslash($_POST['rt_recaptcha_token']))
        : '';

    $block = function () {
        wp_die(
            esc_html__('Your comment could not be verified as human. Please go back and try again.', 'sage'),
            esc_html__('Comment blocked', 'sage'),
            ['response' => 403, 'back_link' => true]
        );
    };

    if (! $token) {
        $block();
    }

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'timeout' => 8,
        'body' => [
            'secret' => $keys['secret'],
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ],
    ]);

    // If Google is unreachable, fail open rather than block legitimate users.
    if (is_wp_error($response)) {
        return $commentdata;
    }

    $result = json_decode(wp_remote_retrieve_body($response), true);

    if (empty($result['success']) || (isset($result['score']) && $result['score'] < 0.5)) {
        $block();
    }

    return $commentdata;
});
