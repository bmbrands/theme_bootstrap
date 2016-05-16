<?php
// This file is part of The Bootstrap Moodle theme
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
        $regions = array('content' => 'col-sm-6 push-sm-3 col-lg-8 push-lg-2');
        $regions['pre'] = 'col-sm-3 pull-sm-6 col-lg-2 pull-lg-8';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if ($hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-sm-9 push-sm-3 col-lg-10 push-lg-2');
        $regions['pre'] = 'col-sm-3 pull-sm-9 col-lg-2 pull-lg-10';
        $regions['post'] = 'emtpy';
    } else if (!$hassidepre && $hassidepost) {
        $regions = array('content' => 'col-sm-9 col-lg-10');
        $regions['pre'] = 'empty';
        $regions['post'] = 'col-sm-3 col-lg-2';
    } else if (!$hassidepre && !$hassidepost) {
        $regions = array('content' => 'col-md-12');
        $regions['pre'] = 'empty';
        $regions['post'] = 'empty';
    }

    if ('rtl' === get_string('thisdirection', 'langconfig')) {
        if ($hassidepre && $hassidepost) {
            $regions['pre'] = 'col-sm-3  push-sm-3 col-lg-2 push-lg-2';
            $regions['post'] = 'col-sm-3 pull-sm-9 col-lg-2 pull-lg-10';
        } else if ($hassidepre && !$hassidepost) {
            $regions = array('content' => 'col-sm-9 col-lg-10');
            $regions['pre'] = 'col-sm-3 col-lg-2';
            $regions['post'] = 'empty';
        } else if (!$hassidepre && $hassidepost) {
            $regions = array('content' => 'col-sm-9 push-sm-3 col-lg-10 push-lg-2');
            $regions['pre'] = 'empty';
            $regions['post'] = 'col-sm-3 pull-sm-9 col-lg-2 pull-lg-10';
        }
    }
    return $regions;
}

function theme_bootstrap_page_init(moodle_page $page) {
    $page->requires->jquery();
}