<?php
// This file is part of The Bootstrap 3 Moodle theme
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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_bootstrap
 * @copyright  2014 Bas Brands, www.basbrands.nl
 * @authors    Bas Brands, David Scotson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function bootstrap_grid($hassidepre, $hassidepost) {
    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-4 col-sm-push-4 col-md-6 col-md-push-3');
        $regions['pre'] = 'col-sm-4 col-sm-pull-4 col-md-3 col-md-pull-6';
        $regions['post'] = 'col-sm-4 col-md-3';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-8 col-sm-push-4 col-md-9 col-md-push-3');
        $regions['pre'] = 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-8 col-md-9');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-4 col-md-3';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }
    return $regions;
}

function theme_bootstrap_checkbox($setting, $default='0') {
    list($name, $title, $description) = theme_bootstrap_setting_details($setting);
    return new admin_setting_configcheckbox($name, $title, $description, $default);
}

function theme_bootstrap_textarea($setting, $default='') {
    list($name, $title, $description) = theme_bootstrap_setting_details($setting);
    return new admin_setting_configtextarea($name, $title, $description, $default);
}

function theme_bootstrap_setting_details($setting) {
    $theme = "theme_bootstrap";
    $name = "$theme/$setting";
    $title = get_string($setting, $theme);
    $description = get_string($setting.'desc', $theme);
    return array($name, $title, $description);
}

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_bootstrap_process_css($css, $theme) {

    $defaultsettings = array(
        'customcss' => '',
    );

    $settings = theme_bootstrap_get_user_settings($defaultsettings, $theme);

    return theme_bootstrap_replace_settings($settings, $css);
}

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param array $settings containing setting names and default values
 * @param theme_config $theme The theme config object.
 * @return array The setting with defaults replaced with user settings (if any)
 */
function theme_bootstrap_get_user_settings($settings, $theme) {
    foreach (array_keys($settings) as $setting) {
        if (!empty($theme->settings->$setting)) {
            $settings[$setting] = $theme->settings->$setting;
        }
    }
    return $settings;
}

/**
 * For each setting called e.g. "customcss" this looks for the string
 * "[[setting:customcss]]" in the CSS and replaces it with
 * the value held in the $settings array for the key
 * "customcss".
 *
 * @param array $settings containing setting names and values
 * @param string $css The CSS
 * @return string The CSS with replacements made
 */
function theme_bootstrap_replace_settings($settings, $css) {
    $settingnames = array_keys($settings);

    $wrapsettings = function($name) {
        return "[[setting:$name]]";
    };

    $find = array_map($wrapsettings, $settingnames);
    $replace = array_values($settings);

    return str_replace($find, $replace, $css);
}
