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

    public function htmlattributes() {
        $parts = explode(' ', trim(get_html_lang(true)));
        return $parts[0] . ' ' . $parts[1]; // Ditch xml:lang part.
    }

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
        if ($classes == 'notifymessage') {
            // $type = '';
        }
        if ($classes == 'redirectmessage') {
            $type = ' alert-block alert-info';
        }
        return '<div class="alert'.$type.'">'.$message.'</div>';
    }
    /*
     * The standard navigation bar (breadcrumb)
     * shows the course category
     * For this theme the course category has been removed
     * This is now a optional setting
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();

        $htmlblocks = array();
        // Iterate the navarray and display each node
        $itemcount = count($items);
        $separator =  '&nbsp;<span class=divider>/</span>';
        for ($i=0;$i < $itemcount;$i++) {
            $item = $items[$i];
            if($this->page->theme->settings->shortennavbar) {
                if ($item->type == "0" || $item->type == "30") {
                    continue;
                }
            }
            $item->hideicon = true;
            if ($i===0) {
                $content = html_writer::tag('li', $this->render($item));
            } else {
                $content = html_writer::tag('li', $separator.$this->render($item));
            }
            $htmlblocks[] = $content;
        }
        // Accessibility: heading for navbar list  (MDL-20446)
        $navbarcontent = html_writer::tag('span', get_string('pagepath'), array('class'=>'accesshide'));
        $navbarcontent .= html_writer::tag('ul', join('', $htmlblocks), array('class'=>'breadcrumb'));
        // XHTML
        return $navbarcontent;
    }

    /*
     * Overriding the custom_menu function ensures the custom menu is
     * always shown, even if no menu items are configured in the global
     * theme settings page.
     * We use the sitename as the first menu item
     */
    public function custom_menu($custommenuitems = '') {
        global $CFG;

        $site  = get_site();
        $custommenuitems = $site->fullname . "|" . $CFG->wwwroot . "\n";

        if (!empty($CFG->custommenuitems)) {
            $custommenuitems .= $CFG->custommenuitems;
        }

        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    /*
     * this renders the bootstrap top menu
     * 
     * This renderer is needed to enable the Bootstrap style navigation
     * 
     */

    protected function render_custom_menu(custom_menu $menu) {
        global $OUTPUT, $USER;
        // If the menu has no children return an empty string
        if (!$menu->has_children()) {
            return '';
        }

        $menupos = 3;
        if ($this->page->theme->settings->showpurgecaches) {
            if (is_siteadmin($USER)) {
                $menu->add(get_string('purgecaches', 'admin'), new moodle_url('/admin/purgecaches.php', array('sesskey' =>  sesskey(), 'confirm' => '1')), null, $menupos++);
            }
        }
        // Initialise this custom menu
        $content = html_writer::start_tag('div',array('class'=>"navbar navbar-fixed-top"));
        $content .= html_writer::start_tag('div',array('class'=>"navbar-inner"));
        $content .= html_writer::start_tag('div',array('class'=>"container-fluid"));
        $content .= html_writer::start_tag('a',array('class'=>"btn btn-navbar",'data-toggle'=>"collapse",'data-target'=>".nav-collapse"));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::end_tag('a');


        if (!empty($this->page->theme->settings->navlogo_url)) {

            $navlogowidth = 40;
            $navlogoheight = 40;

            if (!empty($this->page->theme->settings->navlogo_height)) {
                $navlogoheight = $this->page->theme->settings->navlogo_height;
            }
             
            if (!empty($this->page->theme->settings->navlogo_width)) {
                $navlogowidth = $this->page->theme->settings->navlogo_width;
            }

            $content .= html_writer::start_tag('a',array('class'=>"brand"));
            $content .= html_writer::tag('img', '',array('src'=>$this->page->theme->settings->navlogo_url,'height'=>$navlogoheight.'px','width'=>$navlogowidth.'px','class'=>'brand','style'=>'width:'.$navlogowidth.'px;height:'.$navlogoheight.'px;'));
            $content .= html_writer::end_tag('a');
        }

        $content .= html_writer::start_tag('div', array('class'=>'nav-collapse'));
        $content .= html_writer::start_tag('ul', array('class'=>'nav'));

        // Render each child
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item,1);
        }

        // Close the open tags
        $content .= $this->lang_menu();
        $content .= html_writer::end_tag('ul');

        //$content .= $this->login_info();

        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('div');
        $content .= html_writer::end_tag('div');
        // Return the custom menu
        return $content;
    }

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu
     */

    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 ) {
        // Required to ensure we get unique trackable id's
        static $submenucount = 0;

        if ($menunode->has_children()) {

            if ($level == 1) {
                $dropdowntype = 'dropdown';
            } else {
                $dropdowntype = 'dropdown-submenu';
            }

            $content = html_writer::start_tag('li', array('class'=>$dropdowntype));
            // If the child has menus render it as a sub menu
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            //$content .= html_writer::link($url, $menunode->get_text(), array('title'=>,));
            $content .= html_writer::start_tag('a', array('href'=>$url,'class'=>'dropdown-toggle','data-toggle'=>'dropdown'));
            $content .= $menunode->get_title();
            if ($level == 1) {
                $content .= html_writer::start_tag('b', array('class'=>'caret'));
                $content .= html_writer::end_tag('b');
            }
            $content .= html_writer::end_tag('a');
            $content .= html_writer::start_tag('ul', array('class'=>'dropdown-menu'));
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= html_writer::end_tag('ul');
        } else {
            $content = html_writer::start_tag('li');
            // The node doesn't have children so produce a final menuitem

            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#';
            }
            $content .= html_writer::link($url, $menunode->get_text(), array('title'=>$menunode->get_title()));
        }
        $content .= html_writer::end_tag('li');
        // Return the sub menu
        return $content;
    }
}
