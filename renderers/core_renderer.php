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

defined('MOODLE_INTERNAL') || die();

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_bootstrap
 * @copyright  2012
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class theme_bootstrap_core_renderer extends core_renderer {

    public function notification($message, $classes = 'notifyproblem') {
        //$message = clean_text($message);

        if ($classes == 'notifyproblem') {
            return html_writer::div($message, 'alert alert-danger');
        }
        if ($classes == 'notifywarning') {
            return html_writer::div($message, 'alert alert-warning');
        }
        if ($classes == 'notifysuccess') {
            return html_writer::div($message, 'alert alert-success');
        }
        if ($classes == 'notifymessage') {
            return html_writer::div($message, 'alert alert-info');
        }
        if ($classes == 'redirectmessage') {
            return html_writer::div($message, 'alert alert-block alert-info');
        }
        if ($classes == 'notifytiny') {
            // Not an appropriate semantic alert class!
            return $this->debug_listing($message);
        }
        return html_writer::div($message, $classes);
    }

    private function debug_listing($message) {
        $message = str_replace('<ul style', '<ul class="list-unstyled" style', $message);
        return html_writer::tag('pre', $message, array('class' => 'alert alert-info'));
    }

    public function navbar() {
        $items = $this->page->navbar->get_items();
        if (empty($items)) { // MDL-46107.
            return '';
        }
        $breadcrumbs = '';
        foreach ($items as $item) {
            $item->hideicon = true;
            $breadcrumbs .= '<li>'.$this->render($item).'</li>';
        }
        return "<ol class=breadcrumb>$breadcrumbs</ol>";
    }

    public function custom_menu($custommenuitems = '') {
        // The custom menu is always shown, even if no menu items
        // are configured in the global theme settings page.
        global $CFG;

        if (empty($custommenuitems) && !empty($CFG->custommenuitems)) { // MDL-45507.
            $custommenuitems = $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
    }

    protected function render_custom_menu(custom_menu $menu) {

        // TODO: eliminate this duplicated logic, it belongs in core, not
        // here. See MDL-39565.

        $content = '<ul class="nav navbar-nav pull-right">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content.'</ul>';
    }

    public function user_menu($user = null, $withlinks = null) {
        $usermenu = new custom_menu('', current_language());
        return $this->render_user_menu($usermenu, $user);
    }

    protected function render_user_menu(custom_menu $menu, $user) {
        global $USER, $DB, $SESSION;

        if (empty($user)) {
            $user = $USER;
        }

        $menuclass = 'guest';

        if (isloggedin() && !isguestuser()) {
            $menuclass = 'loggedin';
            $userpicture = new user_picture($user);
            $userpicture->link = false;
            $userpicture->size = 30;
            $picture = html_writer::tag('span', $this->render($userpicture), array('class' => 'picspan'));
            $name = fullname($user);
            $name = html_writer::tag('span', $name, array('class' => 'username hidden-sm'));
            $usermenu = $menu->add($name . $picture, new moodle_url('#'), fullname($user), 10001);

  
            $usermenu->add(
                $this->glyphicon('dashboard')  . get_string('myhome'),
                new moodle_url('/my'),
                get_string('myhome')
            );

            $usermenu->add(
                '#######',
                new moodle_url('/'),
                '#######'
            );

            $usermenu->add(
                $this->glyphicon('user') . get_string('profile'),
                new moodle_url('/user/profile.php', array('id' => $user->id)),

                get_string('profile')
            );

            $usermenu->add(
                $this->glyphicon('list-alt') . get_string('grades'),
                new moodle_url('/grade/report/overview/index.php'),
                get_string('grades')
            );
        
            $usermenu->add(
                $this->glyphicon('inbox') . get_string('messages', 'message'),
                new moodle_url('/message/index.php'),

                get_string('messages', 'message')
            );

            $usermenu->add(
                $this->glyphicon('cog') . get_string('preferences'),
                new moodle_url('/user/preferences.php'),

                get_string('preferences')
            );
        
            $usermenu->add(
                '#######',
                new moodle_url('/'),
                '#######'
            );

            $usermenu->add(
                $this->glyphicon('sign-out') . get_string('logout'),
                new moodle_url('/login/logout.php', array('sesskey' => sesskey(), 'alt' => 'logout')),
                get_string('logout')
            );
        } else {
            $menu->add(
                $this->glyphicon('sign-in')  . get_string('login'),
                new moodle_url('/login/index.php', array('alt' => get_string('login'))),
                get_string('login')
            );
        }

        $content = html_writer::start_tag('ul', array('class' => 'nav pull-left usermenu ' . $menuclass, 'role' => 'menubar'));
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1, 'pull-right');
        }
        $content .= html_writer::end_tag('ul');

        return $content;
    }

    private function glyphicon($icon) {
        $icon = html_writer::tag('i', '', array('class' => 'glyphicon glyphicon-' . $icon));
        return html_writer::tag('span', $icon, array('class' => 'iconwrapper'));
    }

    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0, $direction = '' ) {
        static $submenucount = 0;

        if ($menunode->has_children()) {

            if ($level == 1) {
                $dropdowntype = 'dropdown';
            } else {
                $dropdowntype = 'dropdown-submenu';
            }

            $content = html_writer::start_tag('li', array('class' => $dropdowntype));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $linkattributes = array(
                'href' => $url,
                'class' => 'dropdown-toggle',
                'data-toggle' => 'dropdown',
                'title' => $menunode->get_title(),
            );
            $content .= html_writer::start_tag('a', $linkattributes);
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
            $content .= '<ul class="dropdown-menu '.$direction.'">';
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            $content = '<li>';
            // The node doesn't have children so produce a final menuitem.
            $class = $menunode->get_title();
            if (preg_match("/^#+$/", $menunode->get_text())) {
                $content = '<li class="divider" role="presentation">';
            } else  {
                $content = '<li>';
            // The node doesn't have children so produce a final menuitem.
                if ($menunode->get_url() !== null) {
                    $url = $menunode->get_url();
                } else {
                    $url = '#';
                }
                $content .= html_writer::link($url, $menunode->get_text(), array('class' => $class, 'title' => $menunode->get_title()));
            }
        }
        return $content;
    }

    protected function render_tabtree(tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs nav-justified')) . $secondrow;
    }

    protected function render_tabobject(tabobject $tab) {
        if ($tab->selected or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // Backward compatibility when link was passed as quoted string.
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            return html_writer::tag('li', $link);
        }
    }

    public function box($contents, $classes = 'generalbox', $id = null, $attributes = array()) {
        if (isset($attributes['data-rel']) && $attributes['data-rel'] === 'fatalerror') {
            return html_writer::div($contents, 'alert alert-danger', $attributes);
        }
        return parent::box($contents, $classes, $id, $attributes);
    }
}
