<?php
/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/forumqta/backup/moodle2/restore_forumqta_stepslib.php'); // Because it exists (must)

/**
 * forumqta restore task that provides all the settings and steps to perform one
 * complete restore of the activity
 */
class restore_forumqta_activity_task extends restore_activity_task {

    /**
     * Define (add) particular settings this activity can have
     */
    protected function define_my_settings() {
        // No particular settings for this activity
    }

    /**
     * Define (add) particular steps this activity can have
     */
    protected function define_my_steps() {
        // evoting only has one structure step
        $this->add_step(new restore_forumqta_activity_structure_step('forumqta_structure', 'forumqta.xml'));
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    static public function define_decode_contents() {
        $contents = array();

        $contents[] = new restore_decode_content('forumqta', array('intro'), 'forumqta');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    static public function define_decode_rules() {
        $rules = array();

        $rules[] = new restore_decode_rule('FORUMQTAVIEWBYID', '/mod/forumqta/view.php?id=$1', 'course_module');
        $rules[] = new restore_decode_rule('FORUMQTAINDEX', '/mod/forumqta/index.php?id=$1', 'course');

        return $rules;

    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * forumqta logs. It must return one array
     * of {@link restore_log_rule} objects
     */
    static public function define_restore_log_rules() {
        $rules = array();

        $rules[] = new restore_log_rule('forumqta', 'add', 'view.php?id={course_module}', '{forumqta}');
        $rules[] = new restore_log_rule('forumqta', 'update', 'view.php?id={course_module}', '{forumqta}');
        $rules[] = new restore_log_rule('forumqta', 'view', 'view.php?id={course_module}', '{forumqta}');
        $rules[] = new restore_log_rule('forumqta', 'choose', 'view.php?id={course_module}', '{forumqta}');
        $rules[] = new restore_log_rule('forumqta', 'choose again', 'view.php?id={course_module}', '{forumqta}');
        $rules[] = new restore_log_rule('forumqta', 'report', 'report.php?id={course_module}', '{forumqta}');

        return $rules;
    }

    /**
     * Define the restore log rules that will be applied
     * by the {@link restore_logs_processor} when restoring
     * course logs. It must return one array
     * of {@link restore_log_rule} objects
     *
     * Note this rules are applied when restoring course logs
     * by the restore final task, but are defined here at
     * activity level. All them are rules not linked to any module instance (cmid = 0)
     */
    static public function define_restore_log_rules_for_course() {
        $rules = array();

        // Fix old wrong uses (missing extension)
        $rules[] = new restore_log_rule('forumqta', 'view all', 'index?id={course}', null,
            null, null, 'index.php?id={course}');
        $rules[] = new restore_log_rule('forumqta', 'view all', 'index.php?id={course}', null);

        return $rules;
    }
}