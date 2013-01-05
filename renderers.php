<?php
/* some documentation here */

class theme_bootstrap_core_renderer extends core_renderer {
     
    /*
     * Course layouts show the type of layout on top of the course page
     * Using this renderer I hide these headings
     */
    public function heading($text, $level = 2, $classes = 'main', $id = null) {
        global $COURSE;
         
        $topicoutline = get_string('topicoutline');

        if ($text == $topicoutline) {
            $text = '';
        }

        if ($text == get_string('weeklyoutline')) {
            $text = '';
        }

        $content = parent::heading($text, $level, $classes, $id);

        return $content;
    }
    /*
     * The standard navigation bar (breadcrumb)
     * shows the course category
     * For this theme the course category has been removed
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();

        $htmlblocks = array();
        // Iterate the navarray and display each node
        $itemcount = count($items);
        $separator =  '&nbsp;/ ';
        for ($i=0;$i < $itemcount;$i++) {
            $item = $items[$i];
            if ($item->type == "0" || $item->type == "30") {
                continue;
            }
            $item->hideicon = true;
            if ($i===0) {
                $content = html_writer::tag('li', $this->render($item));
            } else {
                $content = html_writer::tag('li', $separator.$this->render($item));
            }
            $htmlblocks[] = $content;
        }
        //accessibility: heading for navbar list  (MDL-20446)
        $navbarcontent = html_writer::tag('span', get_string('pagepath'), array('class'=>'accesshide'));
        $navbarcontent .= html_writer::tag('ul', join('', $htmlblocks));
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
     */

    protected function render_custom_menu(custom_menu $menu) {
        global $OUTPUT, $USER;
        // If the menu has no children return an empty string
        if (!$menu->has_children()) {
            return '';
        }


        $menupos = 3;
        if (is_siteadmin($USER)) {
            $menu->add(get_string('purgecaches', 'theme_bootstrap'), new moodle_url('/admin/purgecaches.php', array('sesskey' =>  sesskey(), 'confirm' => '1')), null, $menupos++);
        }
        // Initialise this custom menu
        $content = html_writer::start_tag('div',array('class'=>"navbar navbar-fixed-top"));
        $content .= html_writer::start_tag('div',array('class'=>"navbar-inner"));
        $content .= html_writer::start_tag('div',array('class'=>"container"));
        $content .= html_writer::start_tag('a',array('class'=>"btn btn-navbar",'data-toggle'=>"collapse",'data-target'=>".nav-collapse"));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::tag('span', '',array('class'=>'icon-bar'));
        $content .= html_writer::end_tag('a');

        $content .= html_writer::start_tag('div', array('class'=>'nav-collapse'));
        $content .= html_writer::start_tag('ul', array('class'=>'nav'));

        $content .= html_writer::end_tag('a');
        if (!empty($this->page->theme->settings->navlogo_url)) {
            $content .= html_writer::start_tag('a',array('class'=>"brand"));
            $content .= html_writer::tag('img', '',array('src'=>$this->page->theme->settings->navlogo_url,'height'=>'40px','width'=>'40px'));
            $content .= html_writer::end_tag('a');
        }

        // Render each child
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item);
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

    protected function render_custom_menu_item(custom_menu_item $menunode) {
        // Required to ensure we get unique trackable id's
        static $submenucount = 0;

        if ($menunode->has_children()) {
            $content = html_writer::start_tag('li', array('class'=>'dropdown'));
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
            $content .= html_writer::start_tag('b', array('class'=>'caret'));
            $content .= html_writer::end_tag('b');
            $content .= html_writer::end_tag('a');
            $content .= html_writer::start_tag('ul', array('class'=>'dropdown-menu'));
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode);
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

    /*
     * This code replaces the standard moodle icons
     * with a icon sprite that is included in bootstrap
     * If the icon is not listed in the $icons array
     * the original Moodle icon will be shown
     */

    static $icons = array(
            'docs' => 'question-sign',
            'book' => 'book',
            'chapter' => 'file',
            'spacer' => 'spacer',
            'generate' => 'gift',
            'add' => 'plus',
            't/hide' => 'eye-open',
            'i/hide' => 'eye-open',
            't/show' => 'eye-close',
            'i/show' => 'eye-close',
            't/assignroles' => 'icon-glass',
            't/add' => 'plus',
            't/right' => 'arrow-right',
            't/left' => 'arrow-left',
            't/up' => 'arrow-up',
            't/down' => 'arrow-down',
            't/edit' => 'edit',
            't/editstring' => 'tag',
            't/copy' => 'repeat',
            't/delete' => 'remove',
            'i/edit' => 'pencil',
            'i/settings' => 'list-alt',
            'i/grades' => 'grades',
            'i/group' => 'user',
            't/groupn' => 'share-alt',
    //'t/groupv' => '?',
            't/switch_plus' => 'plus-sign',
            't/switch_minus' => 'minus-sign',
            'i/filter' => 'filter',
            't/move' => 'resize-vertical',
            'i/move_2d' => 'move',
            'i/backup' => 'cog',
            'i/restore' => 'cog',
            'i/return' => 'repeat',
            'i/reload' => 'refresh',
            'i/roles' => 'user',
            'i/user' => 'user',
            'i/users' => 'user',
            'i/publish' => 'publish',
            'i/navigationitem' => 'chevron-right' );


    public function block_controls($controls) {
        if($this->page->theme->settings->enableglyphicons) {
            if (empty($controls)) {
                return '';
            }
            $controlshtml = array();
            foreach ($controls as $control) {
                $controlshtml[] = self::a(array('href'=>$control['url'], 'title'=>$control['caption']), self::moodle_icon($control['icon']));
            }
            return self::div(array('class'=>'commands'), implode($controlshtml));
        } else {
            return parent::block_controls($controls);
        }
    }


    protected static function a($attributes, $content) {
        return html_writer::tag('a', $content, $attributes);
    }

    protected static function div($attributes, $content) {
        return html_writer::tag('div', $content, $attributes);
    }

    protected static function span($attributes, $content) {
        return html_writer::tag('span', $content, $attributes);
    }

    protected static function icon($name, $text=null) {
        if (!$text) {$text = $name;}
        return "<i class=icon-$name></i>";
    }
    protected static function moodle_icon($name) {
        return self::icon(self::$icons[$name]);
    }
    public function icon_help() {
        return self::icon('question-sign');
    }

    public function action_icon($url, pix_icon $pixicon, component_action $action = null, array $attributes = null, $linktext=false) {
        if($this->page->theme->settings->enableglyphicons) {
             
            if (!($url instanceof moodle_url)) {
                $url = new moodle_url($url);
            }
            $attributes = (array)$attributes;

            if (empty($attributes['class'])) {
                // let ppl override the class via $options
                $attributes['class'] = 'action-icon';
            }

            $icon = $this->render($pixicon);

            if ($linktext) {
                $text = $pixicon->attributes['alt'];
            } else {
                $text = '';
            }

            return $this->action_link($url, $text.$icon, $action, $attributes);
        } else {
             return parent::action_icon($url, $pixicon, $action, $attributes , $linktext);
        }
    }
     

    protected function render_pix_icon(pix_icon $icon) {
        if($this->page->theme->settings->enableglyphicons) {
            if (isset(self::$icons[$icon->pix])) {
                return self::icon(self::$icons[$icon->pix]);
            } else {
                return parent::render_pix_icon($icon);
                //return '<i class=icon-not-assigned data-debug-icon="'.$icon->pix.'"></i>';
            }
        } else {
            return parent::render_pix_icon($icon);
        }

    }

}
?>
