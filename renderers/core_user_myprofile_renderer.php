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
 * @copyright  2012
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class theme_bootstrap_core_user_myprofile_renderer extends \core_user\output\myprofile\renderer {

    /**
     * Render the whole tree.
     *
     * @param \core_user\output\myprofile\tree $tree
     *
     * @return string
     */
    public function render_tree(\core_user\output\myprofile\tree $tree) {
        $return = $this->render_key_info($tree);
        $return .= \html_writer::start_tag('div', array('class' => 'profile_tree card-columns'));
        $categories = $tree->categories;
        foreach ($categories as $category) {
            $return .= $this->render($category);
        }
        $return .= \html_writer::end_tag('div');
        return $return;
    }

    /**
     * Render some key info before the rest of the profile tree.
     *
     * @param \core_user\output\myprofile\tree $tree
     * @return string
     */
    public function render_key_info(\core_user\output\myprofile\tree $tree) {
        global $DB;
        $userid = $this->page->context->instanceid;
        $picture = $this->output->user_picture(
                $DB->get_record('user', array('id' => $userid)),
                array('size' => 128));
        // Array of the nodes from the tree that we want to display.
        // This could be a config setting?
        $contactfields = array('email', 'skypeid', 'custom_field_twitter');
        $contactinfo = '';
        foreach ($contactfields as $contactfield) {
            if (array_key_exists($contactfield, $tree->nodes)) {
                $contactinfo .= $this->render($tree->nodes[$contactfield]);
            }
        }
        $picture = \html_writer::tag('div', $picture, array('class'=>'card-header bg-faded'));
        $contact = \html_writer::tag('ul', $contactinfo, array('class'=>'card-block'));
        $keyinfo = $this->output->container($picture . $contact, 'profile_keyinfo card');
        return $keyinfo;
    }

    /**
     * Render a category.
     *
     * @param category $category
     *
     * @return string
     */
    public function render_category(\core_user\output\myprofile\category $category) {
        $classes = $category->classes;
        if (empty($classes)) {
            $return = \html_writer::start_tag('section', array('class' => 'node_category card'));
        } else {
            $return = \html_writer::start_tag('section', array('class' => 'node_category card ' . $classes));
        }
        $return .= \html_writer::tag('div', $category->title, array('class' => 'card-header'));
        $nodes = $category->nodes;
        if (empty($nodes)) {
            // No nodes, nothing to render.
            return '';
        }
        $return .= \html_writer::start_tag('ul');
        foreach ($nodes as $node) {
            $return .= $this->render($node);
        }
        $return .= \html_writer::end_tag('ul');
        $return .= \html_writer::end_tag('section');
        return $return;
    }

}
