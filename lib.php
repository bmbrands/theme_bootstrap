<?php

defined('MOODLE_INTERNAL') || die();

function bootstrap_user_settings($css, $theme) {
     if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    
    $tag = '[[setting:customcss]]';
    $css = str_replace($tag, $customcss, $css);
    
    return $css;

}