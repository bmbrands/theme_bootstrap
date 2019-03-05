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
 * Overriden core maintenance renderer.
 *
 * @package    theme_bootstrapbase
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_bootstrapbase\output;
defined('MOODLE_INTERNAL') || die();

use coding_exception;
use moodle_page;
use block_contents;
use stdClass;

/**
 * The maintenance renderer.
 *
 * @package    theme_bootstrapbase
 * @copyright  2016 Frédéric Massart - FMCorz.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer_maintenance extends \theme_bootstrapbase_core_renderer {

    /**
     * Initialises the renderer instance.
     * @param moodle_page $page
     * @param string $target
     * @throws coding_exception
     */
    public function __construct(moodle_page $page, $target) {
        if ($target !== RENDERER_TARGET_MAINTENANCE || $page->pagelayout !== 'maintenance') {
            throw new coding_exception('Invalid request for the maintenance renderer.');
        }
        parent::__construct($page, $target);
    }

    /**
     * Does nothing. The maintenance renderer cannot produce blocks.
     *
     * @param block_contents $bc
     * @param string $region
     * @return string
     */
    public function block(block_contents $bc, $region) {
        // Computer says no blocks.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce blocks.
     *
     * @param string $region
     * @param array $classes
     * @param string $tag
     * @return string
     */
    public function blocks($region, $classes = array(), $tag = 'aside') {
        // Computer says no blocks.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce blocks.
     *
     * @param string $region
     * @return string
     */
    public function blocks_for_region($region) {
        // Computer says no blocks for region.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a course content header.
     *
     * @param bool $onlyifnotcalledbefore
     * @return string
     */
    public function course_content_header($onlyifnotcalledbefore = false) {
        // Computer says no course content header.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a course content footer.
     *
     * @param bool $onlyifnotcalledbefore
     * @return string
     */
    public function course_content_footer($onlyifnotcalledbefore = false) {
        // Computer says no course content footer.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a course header.
     *
     * @return string
     */
    public function course_header() {
        // Computer says no course header.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a course footer.
     *
     * @return string
     */
    public function course_footer() {
        // Computer says no course footer.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a custom menu.
     *
     * @param string $custommenuitems
     * @return string
     */
    public function custom_menu($custommenuitems = '') {
        // Computer says no custom menu.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce a file picker.
     *
     * @param array $options
     * @return string
     */
    public function file_picker($options) {
        // Computer says no file picker.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce and HTML file tree.
     *
     * @param array $dir
     * @return string
     */
    public function htmllize_file_tree($dir) {
        // Hell no we don't want no htmllized file tree.
        // Also why on earth is this function on the core renderer???
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';

    }

    /**
     * Does nothing. The maintenance renderer does not support JS.
     *
     * @param block_contents $bc
     */
    public function init_block_hider_js(block_contents $bc) {
        // Computer says no JavaScript.
        // Do nothing, ridiculous method.
    }

    /**
     * Does nothing. The maintenance renderer cannot produce language menus.
     *
     * @return string
     */
    public function lang_menu() {
        // Computer says no lang menu.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer has no need for login information.
     *
     * @param null $withlinks
     * @return string
     */
    public function login_info($withlinks = null) {
        // Computer says no login info.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }

    /**
     * Does nothing. The maintenance renderer cannot produce user pictures.
     *
     * @param stdClass $user
     * @param array $options
     * @return string
     */
    public function user_picture(stdClass $user, array $options = null) {
        // Computer says no user pictures.
        // debugging('Please do not use $OUTPUT->'.__FUNCTION__.'() when performing maintenance tasks.', DEBUG_DEVELOPER);
        return '';
    }
}
