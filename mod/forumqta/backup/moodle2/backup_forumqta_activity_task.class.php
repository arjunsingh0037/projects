<?php
/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/forumqta/backup/moodle2/backup_forumqta_stepslib.php');
require_once($CFG->dirroot . '/mod/forumqta/backup/moodle2/backup_forumqta_settingslib.php');

/**
 * Provides the steps to perform one complete backup of the forum instance
 */
class backup_forumqta_activity_task extends backup_activity_task {

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the forumqta.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_forumqta_activity_structure_step('forumqta_structure', 'forumqta.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of forums
        $search="/(".$base."\/mod\/forumqta\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMQTAINDEX*$2@$', $content);

        // Link to forum view by moduleid
        $search="/(".$base."\/mod\/forumqta\/view.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@FORUMQTAVIEWBYID*$2@$', $content);

        return $content;
    }
}