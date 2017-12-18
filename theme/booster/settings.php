    <?php
// This file is part of Ranking block for Moodle - http://moodle.org/
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
 * Theme booster block settings file
 *
 * @package    theme_booster
 * @copyright  2017 Willian Mano http://conecti.me
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingbooster', get_string('configtitle', 'theme_booster'));

    /*
    * ----------------------
    * General settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_booster_general', get_string('generalsettings', 'theme_booster'));

    // Logo file setting.
    $name = 'theme_booster/logo';
    $title = get_string('logo', 'theme_booster');
    $description = get_string('logodesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset.
    $name = 'theme_booster/preset';
    $title = get_string('preset', 'theme_booster');
    $description = get_string('preset_desc', 'theme_booster');
    $default = 'default.scss';

    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_booster', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_booster/presetfiles';
    $title = get_string('presetfiles', 'theme_booster');
    $description = get_string('presetfiles_desc', 'theme_booster');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_booster/brandcolor';
    $title = get_string('brandcolor', 'theme_booster');
    $description = get_string('brandcolor_desc', 'theme_booster');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    /*
    * ----------------------
    * Advanced settings tab
    * ----------------------
    */
    $page = new admin_settingpage('theme_booster_advanced', get_string('advancedsettings', 'theme_booster'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_scsscode('theme_booster/scsspre',
        get_string('rawscsspre', 'theme_booster'), get_string('rawscsspre_desc', 'theme_booster'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_scsscode('theme_booster/scss', get_string('rawscss', 'theme_booster'),
        get_string('rawscss_desc', 'theme_booster'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    /*
    * -----------------------
    * Frontpage settings tab
    * -----------------------
    */
    $page = new admin_settingpage('theme_booster_frontpage', get_string('frontpagesettings', 'theme_booster'));

    // Headerimg file setting.
    $name = 'theme_booster/headerimg';
    $title = get_string('headerimg', 'theme_booster');
    $description = get_string('headerimgdesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerimg', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannerheading.
    $name = 'theme_booster/bannerheading';
    $title = get_string('bannerheading', 'theme_booster');
    $description = get_string('bannerheadingdesc', 'theme_booster');
    $default = 'Perfect Learning System';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Bannercontent.
    $name = 'theme_booster/bannercontent';
    $title = get_string('bannercontent', 'theme_booster');
    $description = get_string('bannercontentdesc', 'theme_booster');
    $default = 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/displaymarketingbox';
    $title = get_string('displaymarketingbox', 'theme_booster');
    $description = get_string('displaymarketingboxdesc', 'theme_booster');
    $default = 1;
    $choices = array(0 => 'No', 1 => 'Yes');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $page->add($setting);

    // Marketing1icon.
    $name = 'theme_booster/marketing1icon';
    $title = get_string('marketing1icon', 'theme_booster');
    $description = get_string('marketing1icondesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing1icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1heading.
    $name = 'theme_booster/marketing1heading';
    $title = get_string('marketing1heading', 'theme_booster');
    $description = get_string('marketing1headingdesc', 'theme_booster');
    $default = 'We host';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1subheading.
    $name = 'theme_booster/marketing1subheading';
    $title = get_string('marketing1subheading', 'theme_booster');
    $description = get_string('marketing1subheadingdesc', 'theme_booster');
    $default = 'your MOODLE';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1content.
    $name = 'theme_booster/marketing1content';
    $title = get_string('marketing1content', 'theme_booster');
    $description = get_string('marketing1contentdesc', 'theme_booster');
    $default = 'Moodle hosting in a powerful cloud infrastructure';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing1url.
    $name = 'theme_booster/marketing1url';
    $title = get_string('marketing1url', 'theme_booster');
    $description = get_string('marketing1urldesc', 'theme_booster');
    $default = '#';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2icon.
    $name = 'theme_booster/marketing2icon';
    $title = get_string('marketing2icon', 'theme_booster');
    $description = get_string('marketing2icondesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing2icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2heading.
    $name = 'theme_booster/marketing2heading';
    $title = get_string('marketing2heading', 'theme_booster');
    $description = get_string('marketing2headingdesc', 'theme_booster');
    $default = 'Consulting';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2subheading.
    $name = 'theme_booster/marketing2subheading';
    $title = get_string('marketing2subheading', 'theme_booster');
    $description = get_string('marketing2subheadingdesc', 'theme_booster');
    $default = 'for your company';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2content.
    $name = 'theme_booster/marketing2content';
    $title = get_string('marketing2content', 'theme_booster');
    $description = get_string('marketing2contentdesc', 'theme_booster');
    $default = 'Moodle consulting and training for you';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing2url.
    $name = 'theme_booster/marketing2url';
    $title = get_string('marketing2url', 'theme_booster');
    $description = get_string('marketing2urldesc', 'theme_booster');
    $default = '#';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3icon.
    $name = 'theme_booster/marketing3icon';
    $title = get_string('marketing3icon', 'theme_booster');
    $description = get_string('marketing3icondesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing3icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3heading.
    $name = 'theme_booster/marketing3heading';
    $title = get_string('marketing3heading', 'theme_booster');
    $description = get_string('marketing3headingdesc', 'theme_booster');
    $default = 'Development';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3subheading.
    $name = 'theme_booster/marketing3subheading';
    $title = get_string('marketing3subheading', 'theme_booster');
    $description = get_string('marketing3subheadingdesc', 'theme_booster');
    $default = 'themes and plugins';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3content.
    $name = 'theme_booster/marketing3content';
    $title = get_string('marketing3content', 'theme_booster');
    $description = get_string('marketing3contentdesc', 'theme_booster');
    $default = 'We develop themes and plugins as your desires';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing3url.
    $name = 'theme_booster/marketing3url';
    $title = get_string('marketing3url', 'theme_booster');
    $description = get_string('marketing3urldesc', 'theme_booster');
    $default = '#';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4icon.
    $name = 'theme_booster/marketing4icon';
    $title = get_string('marketing4icon', 'theme_booster');
    $description = get_string('marketing4icondesc', 'theme_booster');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.tiff', '.svg'));
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'marketing4icon', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4heading.
    $name = 'theme_booster/marketing4heading';
    $title = get_string('marketing4heading', 'theme_booster');
    $description = get_string('marketing4headingdesc', 'theme_booster');
    $default = 'Support';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4subheading.
    $name = 'theme_booster/marketing4subheading';
    $title = get_string('marketing4subheading', 'theme_booster');
    $description = get_string('marketing4subheadingdesc', 'theme_booster');
    $default = 'we give you answers';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4content.
    $name = 'theme_booster/marketing4content';
    $title = get_string('marketing4content', 'theme_booster');
    $description = get_string('marketing4contentdesc', 'theme_booster');
    $default = 'MOODLE specialized support';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Marketing4url.
    $name = 'theme_booster/marketing4url';
    $title = get_string('marketing4url', 'theme_booster');
    $description = get_string('marketing4urldesc', 'theme_booster');
    $default = '#';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    /*
    * --------------------
    * Footer settings tab
    * --------------------
    */
    $page = new admin_settingpage('theme_booster_footer', get_string('footersettings', 'theme_booster'));

    $name = 'theme_booster/getintouchcontent';
    $title = get_string('getintouchcontent', 'theme_booster');
    $description = get_string('getintouchcontentdesc', 'theme_booster');
    $default = 'Conecti.me';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Website.
    $name = 'theme_booster/website';
    $title = get_string('website', 'theme_booster');
    $description = get_string('websitedesc', 'theme_booster');
    $default = 'http://conecti.me';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Mobile.
    $name = 'theme_booster/mobile';
    $title = get_string('mobile', 'theme_booster');
    $description = get_string('mobiledesc', 'theme_booster');
    $default = 'Mobile : +55 (98) 00123-45678';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Mail.
    $name = 'theme_booster/mail';
    $title = get_string('mail', 'theme_booster');
    $description = get_string('maildesc', 'theme_booster');
    $default = 'willianmano@conectime.com';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Facebook url setting.
    $name = 'theme_booster/facebook';
    $title = get_string('facebook', 'theme_booster');
    $description = get_string('facebookdesc', 'theme_booster');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Twitter url setting.
    $name = 'theme_booster/twitter';
    $title = get_string('twitter', 'theme_booster');
    $description = get_string('twitterdesc', 'theme_booster');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Googleplus url setting.
    $name = 'theme_booster/googleplus';
    $title = get_string('googleplus', 'theme_booster');
    $description = get_string('googleplusdesc', 'theme_booster');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Linkdin url setting.
    $name = 'theme_booster/linkedin';
    $title = get_string('linkedin', 'theme_booster');
    $description = get_string('linkedindesc', 'theme_booster');
    $default = '';
    $setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    /*
    * --------------------
    * Section1 settings tab
    * --------------------
    */

    $page = new admin_settingpage('theme_booster_section1', get_string('sec1settings', 'theme_booster'));

    $name = 'theme_booster/course1';
    $title = get_string('cour1', 'theme_booster');
    $description = get_string('course1', 'theme_booster');
    $default = 'Hi';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/Discription1';
    $title = get_string('dis1', 'theme_booster');
    $description = get_string('d1', 'theme_booster');
    $default = 'Hello';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/course2';
    $title = get_string('cour2', 'theme_booster');
    $description = get_string('course2', 'theme_booster');
    $default = 'Hi';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/Discription2';
    $title = get_string('dis2', 'theme_booster');
    $description = get_string('d2', 'theme_booster');
    $default = 'Hello';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/course3';
    $title = get_string('cour3', 'theme_booster');
    $description = get_string('course3', 'theme_booster');
    $default = 'Hi';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/Discription3';
    $title = get_string('dis3', 'theme_booster');
    $description = get_string('d3', 'theme_booster');
    $default = 'Hello';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/course4';
    $title = get_string('cour4', 'theme_booster');
    $description = get_string('course4', 'theme_booster');
    $default = 'Hi';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/Discription4';
    $title = get_string('dis4', 'theme_booster');
    $description = get_string('d4', 'theme_booster');
    $default = 'Hello';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    
    $settings->add($page);

     /*
    * --------------------
    * Menu settings tab
    * --------------------
    */

    $page = new admin_settingpage('theme_booster_menu', get_string('menusetting', 'theme_booster'));

    $name = 'theme_booster/tab1';
    $title = get_string('tab1', 'theme_booster');
    $description = get_string('t1', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab2';
    $title = get_string('tab2', 'theme_booster');
    $description = get_string('t2', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab3';
    $title = get_string('tab3', 'theme_booster');
    $description = get_string('t3', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab4';
    $title = get_string('tab4', 'theme_booster');
    $description = get_string('t4', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab5';
    $title = get_string('tab5', 'theme_booster');
    $description = get_string('t5', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab6';
    $title = get_string('tab6', 'theme_booster');
    $description = get_string('t6', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab7';
    $title = get_string('tab7', 'theme_booster');
    $description = get_string('t7', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab8';
    $title = get_string('tab8', 'theme_booster');
    $description = get_string('t8', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab9';
    $title = get_string('tab9', 'theme_booster');
    $description = get_string('t9', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_booster/tab10';
    $title = get_string('tab10', 'theme_booster');
    $description = get_string('t10', 'theme_booster');
    $default = 'URL';
   	$setting = new admin_setting_configtext($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);


      $settings->add($page);

}

