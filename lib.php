<?php

defined('MOODLE_INTERNAL') || die();

function bootstrap_user_settings($css, $theme) {
    global $CFG;
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }

    $tag = '[[setting:customcss]]';
    $css = str_replace($tag, $customcss, $css);

    
    if ($theme->settings->enableglyphicons == 1) {
        $bootstrapicons = '
        [class ^="icon-"],[class *=" icon-"] { background-image: url("'.$CFG->wwwroot.'/theme/image.php?theme=bootstrap&component=theme&image=glyphicons-halflings"); }';
        $css .= $bootstrapicons;
    }

    $navlogowidth = 40;
    $navlogoheight = 40;
    
    if (!empty($theme->settings->navlogo_height)) {
        $navlogoheight = $theme->settings->navlogo_height;
    }
     
    if (!empty($theme->settings->navlogo_width)) {
        $navlogowidth = $theme->settings->navlogo_width;
    }
    $extrapadding = 40 + $navlogowidth;
    if (!empty($theme->settings->navlogo_url)) {
        $css .= '
    @media ( min-width : 980px) {
	  .navbar .brand {
		padding-left: 40px;
	  }
	  .navbar-static-top .container .nav-collapse, .navbar-fixed-top .container .nav-collapse, .navbar-fixed-bottom .container .nav-collapse {
	  padding-left: '.$extrapadding.'px;
	  }
    }';
    }

    return $css;
}