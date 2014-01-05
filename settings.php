<?php

/**
 * Settings for the nuim theme
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $name = 'theme_bootstrap/subtitle';
    $title = get_string('subtitle','theme_bootstrap');
    $description = get_string('subtitle_desc', 'theme_bootstrap');
    $setting = new admin_setting_configtext($name, $title, $description, '');
    $settings->add($setting);
}