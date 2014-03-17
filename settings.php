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
 * Theme version info
 *
 * @package    theme_bootstrapbase
 * @copyright  2014 Bas Brands, www.basbrands.nl
 * @authors    Bas Brands, David Scotson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(theme_bootstrap_checkbox('fluidwidth'));
    $settings->add(theme_bootstrap_checkbox('fonticons'));
}

function theme_bootstrap_checkbox($setting, $default='0') {
    list($name, $title, $description) = theme_bootstrap_setting_details($setting);
    return new admin_setting_configcheckbox($name, $title, $description, $default);
}

function theme_bootstrap_setting_details($setting) {
    $theme = "theme_bootstrap";
    $name = "$theme/$setting";
    $title = get_string($setting, $theme);
    $description = get_string($setting.'desc', $theme);
    return array($name, $title, $description);
}
