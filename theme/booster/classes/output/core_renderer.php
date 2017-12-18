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
 * Overriden theme boost core renderer.
 *
 * @package    theme_booster
 * @copyright  2017 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_booster\output;

use html_writer;
use custom_menu_item;
use custom_menu;
use action_menu_filler;
use action_menu_link_secondary;
use navigation_node;
use action_link;
use stdClass;
use moodle_url;
use action_menu;
use pix_icon;
use theme_config;
use core_text;

defined('MOODLE_INTERNAL') || die;

/**
 * Renderers to align Moodle's HTML with that expected by Bootstrap
 *
 * @package    theme_booster
 * @copyright  2017 Willian Mano - http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class core_renderer extends \theme_boost\output\core_renderer {

    /**
     * Renders the custom menu
     *
     * @param custom_menu $menu
     * @return mixed
     */
    protected function render_custom_menu(custom_menu $menu) {
        global $CFG;

        if (!$menu->has_children()) {
            return '';
        }

        $content = '';
        foreach ($menu->get_children() as $item) {
            $context = $item->export_for_template($this);
            $content .= $this->render_from_template('core/custom_menu_item', $context);
        }

        return $content;
    }

    /**
     * Renders the lang menu
     *
     * @return mixed
     */
    public function render_lang_menu() {
        $langs = get_string_manager()->get_list_of_translations();
        $haslangmenu = $this->lang_menu() != '';
        $menu = new custom_menu;

        if ($haslangmenu) {
            $strlang = get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $menu->add($currentlang, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }

            foreach ($menu->get_children() as $item) {
                $context = $item->export_for_template($this);
            }

            if (isset($context)) {
                return $this->render_from_template('theme_booster/lang_menu', $context);
            }
        }
    }

    /**
     * Renders the login form.
     *
     * @param \core_auth\output\login $form The renderable.
     * @return string
     */
    public function render_login(\core_auth\output\login $form) {
        global $SITE;

        $context = $form->export_for_template($this);

        // Override because rendering is not supported in template yet.
        $context->cookieshelpiconformatted = $this->help_icon('cookiesenabled');
        $context->errorformatted = $this->error_text($context->error);

        $context->logourl = $this->get_logo();
        $context->sitename = format_string($SITE->fullname, true, array('context' => \context_course::instance(SITEID)));

        return $this->render_from_template('core/login', $context);
    }

    /**
     * Gets the logo to be rendered.
     *
     * The priority of get log is: 1st try to get the theme logo, 2st try to get the theme logo
     * If no logo was found return false
     *
     * @return mixed
     */
    public function get_logo() {
        if ($this->should_display_theme_logo()) {
            return $this->get_theme_logo_url();
        }

        $url = $this->get_logo_url();
        if ($url) {
            return $url->out(false);
        }

        return false;
    }

    /**
     * Outputs the pix url base
     *
     * @return string an URL.
     */
    public function get_pix_image_url_base() {
        global $CFG;

        return $CFG->wwwroot . "/theme/booster/pix";
    }

    /**
     * Whether we should display the main theme logo in the navbar.
     *
     * @return bool
     */
    public function should_display_theme_logo() {
        $logo = $this->get_theme_logo_url();

        return !empty($logo);
    }

    /**
     * Get the main logo URL.
     *
     * @return string
     */
    public function get_theme_logo_url() {
        $theme = theme_config::load('booster');

        return $theme->setting_file_url('logo', 'logo');
    }

    /**
     * Return getintouch config
     *
     * @return string Getintouch url config
     */
    public function get_getintouchcontent_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->getintouchcontent;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return website config
     *
     * @return string Website url config
     */
    public function get_website_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->website;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return mobile config
     *
     * @return string Mobile url config
     */
    public function get_mobile_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->mobile;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return mail config
     *
     * @return string Mail url config
     */
    public function get_mail_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->mail;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return facebook config
     *
     * @return string Facebook url config
     */
    public function get_facebook_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->facebook;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return twitter config
     *
     * @return string Twitter url config
     */
    public function get_twitter_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->twitter;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return googleplus config
     *
     * @return string Googleplus url config
     */
    public function get_googleplus_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->googleplus;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return linkedin config
     *
     * @return string Linkeding url config
     */
    public function get_linkedin_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->linkedin;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return course1 config
     *
     * @return string course1 url config
     */

    public function get_course1_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->course1;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return Discription1 config
     *
     * @return string Discription1 config
     */
    public function get_Discription1_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->Discription1;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return course2 config
     *
     * @return string course1 url config
     */

    public function get_course2_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->course2;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return Discription2 config
     *
     * @return string Discription2 config
     */
    public function get_Discription2_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->Discription2;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return course3 config
     *
     * @return string course3 config
     */

    public function get_course3_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->course3;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return Discription3 config
     *
     * @return string Discription3 config
     */
    public function get_Discription3_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->Discription3;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return course4 config
     *
     * @return string course4 url config
     */

    public function get_course4_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->course4;

        return $setting != '' ? $setting : '';
    }

    /**
     * Return Discription4 config
     *
     * @return string Discription4 config
     */
    public function get_Discription4_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->Discription4;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return WebsiteName config
     *
     * @return WebsiteName config
     */
    public function get_tab1_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab1;

        return $setting != '' ? $setting : '';
    }
     /**
     * Return First Tab config
     *
     * @return string First Tab config
     */
    public function get_tab2_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab2;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Second Tab config
     *
     * @return string Second Tab config
     */
    public function get_tab3_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab3;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Third Tab config
     *
     * @return string Third Tab config
     */
    public function get_tab4_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab4;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Fourth Tab config
     *
     * @return string Fourth Tab config
     */
    public function get_tab5_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab5;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Fifth Tab config
     *
     * @return string Fifth Tab config
     */
    public function get_tab6_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab6;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Sixth Tab config
     *
     * @return string Sixth Tab config
     */
    public function get_tab7_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab7;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Seventh Tab config
     *
     * @return string Seventh Tab config
     */
    public function get_tab8_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab8;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Eight Tab config
     *
     * @return string Eight Tab config
     */
    public function get_tab9_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab9;

        return $setting != '' ? $setting : '';
    }

     /**
     * Return Ninth Tab config
     *
     * @return string Ninth Tab config
     */
    public function get_tab10_config() {
        $theme = theme_config::load('booster');

        $setting = $theme->settings->tab10;


        return $setting != '' ? $setting : '';
    }

    /**
     * Construct a user menu, returning HTML that can be echoed out by a
     * layout file.
     *
     * @param stdClass $user A user object, usually $USER.
     * @param bool $withlinks true if a dropdown should be built.
     * @return string HTML fragment.
     */
    public function user_menu($user = null, $withlinks = null) {
        global $USER, $CFG;
        require_once($CFG->dirroot . '/user/lib.php');

        if (is_null($user)) {
            $user = $USER;
        }

        // Note: this behaviour is intended to match that of core_renderer::login_info,
        // but should not be considered to be good practice; layout options are
        // intended to be theme-specific. Please don't copy this snippet anywhere else.
        if (is_null($withlinks)) {
            $withlinks = empty($this->page->layout_options['nologinlinks']);
        }

        // Add a class for when $withlinks is false.
        $usermenuclasses = 'usermenu';
        if (!$withlinks) {
            $usermenuclasses .= ' withoutlinks';
        }

        $returnstr = "";

        // If during initial install, return the empty return string.
        if (during_initial_install()) {
            return $returnstr;
        }

        $loginpage = $this->is_login_page();
        $loginurl = get_login_url();
        // If not logged in, show the typical not-logged-in string.
        if (!isloggedin()) {
            $returnstr = get_string('loggedinnot', 'moodle');
            if (!$loginpage) {
                $returnstr .= " (<a href=\"$loginurl\">" . get_string('login') . '</a>)';
            }

            return html_writer::tag(
                'li',
                html_writer::span(
                    $returnstr,
                    'login'
                ),
                array('class' => $usermenuclasses)
            );
        }

        // If logged in as a guest user, show a string to that effect.
        if (isguestuser()) {
            $returnstr = get_string('loggedinasguest');
            if (!$loginpage && $withlinks) {
                $returnstr .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
            }

            return html_writer::tag(
                'li',
                html_writer::span(
                    $returnstr,
                    'login'
                ),
                array('class' => $usermenuclasses)
            );
        }

        // Get some navigation opts.
        $opts = user_get_user_navigation_info($user, $this->page);

        $avatarclasses = "avatars";
        $avatarcontents = html_writer::span($opts->metadata['useravatar'], 'avatar current');
        $usertextcontents = $opts->metadata['userfullname'];

        // Other user.
        if (!empty($opts->metadata['asotheruser'])) {
            $avatarcontents .= html_writer::span(
                $opts->metadata['realuseravatar'],
                'avatar realuser'
            );
            $usertextcontents = $opts->metadata['realuserfullname'];
            $usertextcontents .= html_writer::tag(
                'span',
                get_string(
                    'loggedinas',
                    'moodle',
                    html_writer::span(
                        $opts->metadata['userfullname'],
                        'value'
                    )
                ),
                array('class' => 'meta viewingas')
            );
        }

        // Role.
        if (!empty($opts->metadata['asotherrole'])) {
            $role = core_text::strtolower(preg_replace('#[ ]+#', '-', trim($opts->metadata['rolename'])));
            $usertextcontents .= html_writer::span(
                $opts->metadata['rolename'],
                'meta role role-' . $role
            );
        }

        // User login failures.
        if (!empty($opts->metadata['userloginfail'])) {
            $usertextcontents .= html_writer::span(
                $opts->metadata['userloginfail'],
                'meta loginfailures'
            );
        }

        // MNet.
        if (!empty($opts->metadata['asmnetuser'])) {
            $mnet = strtolower(preg_replace('#[ ]+#', '-', trim($opts->metadata['mnetidprovidername'])));
            $usertextcontents .= html_writer::span(
                $opts->metadata['mnetidprovidername'],
                'meta mnet mnet-' . $mnet
            );
        }

        $returnstr .= html_writer::span(
            html_writer::span($usertextcontents, 'usertext') .
            html_writer::span($avatarcontents, $avatarclasses),
            'userbutton'
        );

        // Create a divider (well, a filler).
        $divider = new action_menu_filler();
        $divider->primary = false;

        $am = new action_menu();
        $am->set_menu_trigger(
            $returnstr
        );
        $am->set_alignment(action_menu::TR, action_menu::BR);
        $am->set_nowrap_on_items();
        if ($withlinks) {
            $navitemcount = count($opts->navitems);
            $idx = 0;
            foreach ($opts->navitems as $key => $value) {

                switch ($value->itemtype) {
                    case 'divider':
                        // If the nav item is a divider, add one and skip link processing.
                        $am->add($divider);
                        break;

                    case 'invalid':
                        // Silently skip invalid entries (should we post a notification?).
                        break;

                    case 'link':
                        // Process this as a link item.
                        $pix = null;
                        if (isset($value->pix) && !empty($value->pix)) {
                            $pix = new pix_icon($value->pix, $value->title, null, array('class' => 'iconsmall'));
                        } else if (isset($value->imgsrc) && !empty($value->imgsrc)) {
                            $value->title = html_writer::img(
                                $value->imgsrc,
                                $value->title,
                                array('class' => 'iconsmall')
                            ) . $value->title;
                        }

                        $al = new action_menu_link_secondary(
                            $value->url,
                            $pix,
                            $value->title,
                            array('class' => 'icon')
                        );
                        if (!empty($value->titleidentifier)) {
                            $al->attributes['data-title'] = $value->titleidentifier;
                        }
                        $am->add($al);
                        break;
                }

                $idx++;

                // Add dividers after the first item and before the last item.
                if ($idx == 1 || $idx == $navitemcount - 1) {
                    $am->add($divider);
                }
            }
        }

        return html_writer::tag(
            'li',
            $this->render($am),
            array('class' => $usermenuclasses)
        );
    }

    /**
     * Secure login info.
     *
     * @return string
     */
    public function secure_login_info() {
        return $this->login_info(false);
    }
}
