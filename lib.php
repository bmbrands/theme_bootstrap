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
 * @authors    Bas Brands, David Scotson, Gareth J Barnard
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function bootstrap_grid($hassidepre, $hassidepost) {
    if ($hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-10 col-sm-push-7 col-md-12 col-md-push-6 col-lg-14 col-lg-push-5');
        $regions['pre'] = 'col-sm-7 col-sm-pull-10 col-md-6 col-md-pull-12 col-lg-5 col-lg-pull-14';
        $regions['post'] = 'col-sm-7 col-md-6 col-lg-5';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-17 col-sm-push-7 col-md-18 col-md-push-6 col-lg-19 col-lg-push-5');
        $regions['pre'] = 'col-sm-7 col-sm-pull-17 col-md-6 col-md-pull-18 col-lg-5 col-lg-pull-19';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-17 col-md-18 col-lg-19');
        $regions['post'] = 'col-sm-7 col-md-6 col-lg-5';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-24');
    }
    return $regions;
}
