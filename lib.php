<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Configuration for the Bootstrap theme
 *
 *
 * @package   Moodle Bootstrap theme lib
 * @copyright 2012 Bas Brands. www.sonsbeekmedia.nl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

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
            [class ^="icon-"],[class *=" icon-"] {background-image: url("'
            .$CFG->wwwroot.
            '/theme/image.php?theme=bootstrap&component=theme&image=glyphicons-halflings");}';
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
