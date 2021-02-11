<?php
// This file enqueues your shortcode.

defined('ABSPATH') or die('Direct script access disallowed.');

add_shortcode('erw_widget', function ($atts) {
    $default_atts = array('color' => 'black');
    $args = shortcode_atts($default_atts, $atts);

    return "<div id='erw-root'></div>";
});
