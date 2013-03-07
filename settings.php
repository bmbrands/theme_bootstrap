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
 * Setings for the Bootstrap theme
 *
 *
 * @package   Moodle Bootstrap theme
 * @copyright 2012 Bas Brands. www.sonsbeekmedia.nl
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // This is the note box for all the settings pages.
    $name = 'theme_bootstrap/notes';
    $heading = get_string('notes', 'theme_bootstrap');
    $information = get_string('notesdesc', 'theme_bootstrap');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

    $name = 'theme_bootstrap/enablejquery';
    $title = get_string('enablejquery', 'theme_bootstrap');
    $description = get_string('enablejquerydesc', 'theme_bootstrap');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/enableglyphicons';
    $title = get_string('enableglyphicons', 'theme_bootstrap');
    $description = get_string('enableglyphiconsdesc', 'theme_bootstrap');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/shortennavbar';
    $title = get_string('shortennavbar', 'theme_bootstrap');
    $description = get_string('shortennavbardesc', 'theme_bootstrap');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/showpurgecaches';
    $title = get_string('showpurgecaches', 'theme_bootstrap');
    $description = get_string('showpurgecachesdesc', 'theme_bootstrap');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/logo_url';
    $title = get_string('logo_url', 'theme_bootstrap');
    $description = get_string('logo_urldesc', 'theme_bootstrap');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $settings->add($setting);

    $name = 'theme_bootstrap/navlogo_url';
    $title = get_string('navlogo_url', 'theme_bootstrap');
    $description = get_string('navlogo_urldesc', 'theme_bootstrap');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $settings->add($setting);

    $name = 'theme_bootstrap/navlogo_width';
    $title = get_string('navlogo_width', 'theme_bootstrap');
    $description = get_string('navlogo_widthdesc', 'theme_bootstrap');
    $default = 40;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/navlogo_height';
    $title = get_string('navlogo_height', 'theme_bootstrap');
    $description = get_string('navlogo_heightdesc', 'theme_bootstrap');
    $default = 40;
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'theme_bootstrap/customcss';
    $title = get_string('customcss', 'theme_bootstrap');
    $description = get_string('customcssdesc', 'theme_bootstrap');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);
}
