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
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_bootstrap
 * @copyright  2012
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


class theme_bootstrap_core_renderer extends core_renderer {

    public function notification($message, $classes = 'notifyproblem') {
        $message = clean_text($message);
        $type = '';

        if ($classes == 'notifyproblem') {
            $type = ' alert-error';
        }
        if ($classes == 'notifysuccess') {
            $type = ' alert-success';
        }
        if ($classes == 'notifymessage') {
            $type = ' alert-info';
        }
        if ($classes == 'redirectmessage') {
            $type = ' alert-block alert-info';
        }
        return '<div class="alert'.$type.'">'.$message.'</div>';
    }

    public function navbar() {
        $items = $this->page->navbar->get_items();

        $breadcrumbs = array();
        // Iterate the navarray and display each node.
        $itemcount = count($items);
        $separator = '<span class=divider>/</span>';
        for ($i=0; $i < $itemcount; $i++) {
            $item = $items[$i];
            $item->hideicon = true;
            if ($i + 1 < $itemcount) {
                $breadcrumbs[] = html_writer::tag('li', $this->render($item).' '.$separator);
            } else {
                $breadcrumbs[] = html_writer::tag('li', $this->render($item));
            }
        }
        $breadcrumb_trail = html_writer::tag('span', get_string('pagepath'), array('class'=>'accesshide'));
        return $breadcrumb_trail .= html_writer::tag('ul', join($breadcrumbs), array('class'=>'breadcrumb'));
    }
}
