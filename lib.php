<?php
// This file is part of the custom Moodle Bootstrap theme
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

function bootstrap_grid() {
    global $PAGE, $OUTPUT;
    $hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
    $hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-7 col-sm-push-5 col-md-9 col-md-push-4');
        $regions['pre'] = 'col-sm-5 col-sm-pull-7 col-md-4 col-md-pull-9';
        $regions['post'] = 'col-sm-5 col-md-4';
    }

    if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-12 col-sm-push-5 col-md-13 col-md-push-4');
        $regions['pre'] = 'col-sm-5 col-sm-pull-12 col-md-4 col-md-pull-13';
    }

    if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-12 col-md-13');
        $regions['post'] = 'col-sm-5 col-md-4';
    }

    if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-17');
    }
    return $regions;
}
