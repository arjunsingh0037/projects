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
 * FileSettings Lib file.
 *
 * @package    theme_fordson
 * @copyright  2016 Chris Kenniburg
 * @credits    theme_boost - MoodleHQ
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */

defined('MOODLE_INTERNAL') || die();

function theme_fordson_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('fordson');
    }
    if ($context->contextlevel == CONTEXT_SYSTEM && ($filearea === '')) {
        $theme = theme_config::load('fordson');
        return $theme->setting_file_serve($filearea, $args, $forcedownload, $options);
    } else if ($filearea === 'headerlogo') { // Default header image.
        return $theme->setting_file_serve('headerlogo', $args, $forcedownload, $options);
    } else if ($filearea === 'headerdefaultimage') { // Default header image.
        return $theme->setting_file_serve('headerdefaultimage', $args, $forcedownload, $options);
    } else if ($filearea === 'backgroundimage') { // Background image.
        return $theme->setting_file_serve('backgroundimage', $args, $forcedownload, $options);
    } else if ($filearea === 'loginimage') { // Login page image.
        return $theme->setting_file_serve('loginimage', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing1image') { // Login page image.
        return $theme->setting_file_serve('marketing1image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing2image') { // Login page image.
        return $theme->setting_file_serve('marketing2image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing3image') { // Login page image.
        return $theme->setting_file_serve('marketing3image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing4image') { // Login page image.
        return $theme->setting_file_serve('marketing4image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing5image') { // Login page image.
        return $theme->setting_file_serve('marketing5image', $args, $forcedownload, $options);
    } else if ($filearea === 'marketing6image') { // Login page image.
        return $theme->setting_file_serve('marketing6image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide1image') { // Login page image.
        return $theme->setting_file_serve('slide1image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide2image') { // Login page image.
        return $theme->setting_file_serve('slide2image', $args, $forcedownload, $options);
    } else if ($filearea === 'slide3image') { // Login page image.
        return $theme->setting_file_serve('slide3image', $args, $forcedownload, $options);
    }else if ($filearea === 'logo') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
    }else if ($filearea === 'logo2') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo2', $args, $forcedownload, $options);
    }else if ($filearea === 'logo3') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo3', $args, $forcedownload, $options);
    } else if ($filearea === 'logo4') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo4', $args, $forcedownload, $options);
    }else if ($filearea === 'logo5') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo5', $args, $forcedownload, $options);
    }else if ($filearea === 'logo6') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo6', $args, $forcedownload, $options);
    }else if ($filearea === 'logo7') { // Logo upload .....sangita.
        return $theme->setting_file_serve('logo7', $args, $forcedownload, $options);
    }      
       

    else {
        send_file_not_found();
    }
}


/**
 * This function creates the dynamic HTML needed for some
 * settings and then passes it back in an object so it can
 * be echo'd to the page.
 *
 * This keeps the logic out of the layout files.
 *
 * @param string $setting bring the required setting into the function
 * @param bool $format
 * @param string $setting
 * @param array $theme
 * @param stdclass $CFG
 * @return string
 */
function theme_fordson_get_setting($setting, $format = false) {
    global $CFG;
    require_once($CFG->dirroot . '/lib/weblib.php');
    static $theme;
    if (empty($theme)) {
        $theme = theme_config::load('fordson');
    }
    if (empty($theme->settings->$setting)) {
        return false;
    } else if (!$format) {
        return $theme->settings->$setting;
    } else if ($format === 'format_text') {
        return format_text($theme->settings->$setting, FORMAT_PLAIN);
    } else if ($format === 'format_html') {
        return format_text($theme->settings->$setting, FORMAT_HTML, array('trusted' => true, 'noclean' => true));
    } else {
        return format_string($theme->settings->$setting);
    }
}
