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
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . "/course/classes/management_renderer.php");

class theme_bootstrap_core_course_management_renderer extends core_course_management_renderer {
    /**
     * Opens a grid.
     *
     * Call {@link core_course_management_renderer::grid_column_start()} to create columns.
     *
     * @param string $id An id to give this grid.
     * @param string $class A class to give this grid.
     * @return string
     */
    public function grid_start($id = null, $class = null) {
        $gridclass = 'grid-row-r row';
        if (is_null($class)) {
            $class = $gridclass;
        } else {
            $class .= ' ' . $gridclass;
        }
        $attributes = array();
        if (!is_null($id)) {
            $attributes['id'] = $id;
        }
        return html_writer::start_div($class, $attributes);
    }

    /**
     * Opens a grid column
     *
     * @param int $size The number of segments this column should span.
     * @param string $id An id to give the column.
     * @param string $class A class to give the column.
     * @return string
     */
    public function grid_column_start($size, $id = null, $class = null) {

        // Calculate Bootstrap grid sizing.
        $bootstrapclass = 'col-md-'.$size;

        // Calculate YUI grid sizing.
        if ($size === 12) {
            $maxsize = 1;
            $size = 1;
        } else {
            $maxsize = 12;
            $divisors = array(8, 6, 5, 4, 3, 2);
            foreach ($divisors as $divisor) {
                if (($maxsize % $divisor === 0) && ($size % $divisor === 0)) {
                    $maxsize = $maxsize / $divisor;
                    $size = $size / $divisor;
                    break;
                }
            }
        }
        if ($maxsize > 1) {
            $yuigridclass = "grid-col-{$size}-{$maxsize} grid-col";
        } else {
            $yuigridclass = "grid-col-1 grid-col";
        }

        if (is_null($class)) {
            $class = $yuigridclass . ' ' . $bootstrapclass;
        } else {
            $class .= ' ' . $yuigridclass . ' ' . $bootstrapclass;
        }
        $attributes = array();
        if (!is_null($id)) {
            $attributes['id'] = $id;
        }
        return html_writer::start_div($class, $attributes);
    }
}