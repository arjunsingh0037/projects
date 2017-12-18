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
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');
require_once (dirname(__FILE__).'/q2a/qa-include/qa-base.php');

$id = optional_param('id', 0, PARAM_INT); // course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // forumqta instance ID - it should be named as the first character of the module

if ($id) {
    $cm         = get_coursemodule_from_id('forumqta', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $forumqta  = $DB->get_record('forumqta', array('id' => $cm->instance), '*', MUST_EXIST);
} elseif ($n) {
    $forumqta  = $DB->get_record('forumqta', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $forumqta->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('forumqta', $forumqta->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);
$context = context_module::instance($cm->id);

/// Print the page header
$PAGE->set_url('/mod/forumqta/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($forumqta->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

$category = $DB->get_record('forumqta_categories', array('forumqtaid'=>$forumqta->id));
$categorytags = $category->tags;

// Output starts here
echo $OUTPUT->header();

if ($forumqta->intro) { // Conditions to show the intro can change to look for own settings or whatever
    echo $OUTPUT->box(format_module_intro('forumqta', $forumqta, $cm->id), 'generalbox mod_introbox', 'forumqtaintro');
}

echo $OUTPUT->heading('Forum');

echo "<html>";

$groupmode = groups_get_activity_groupmode($cm);
if ($groupmode) {
    $groupid = groups_get_activity_group($cm, true);
    groups_print_activity_menu($cm, $CFG->wwwroot . '/mod/forumqta/view.php?id='.$id);
}

global $USER;
$userid = $USER->id;
$courseid = $course->id;
$groupingid = $cm->groupingid;
$cmid = $cm->id;

if ($groupmode == 0) {
    echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=-1&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
}
else {
    if ($groupmode == 1) { // seperated group
        if ($groupingid == 0) { // without grouping
            if ($groupid == 0) {
                if (!has_capability('moodle/course:activityvisibility', $context)) { //student not in a group
                    echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum'));
                }
                else {
                    echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=$groupid&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
                }
            }
            else {
                echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=$groupid&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
            }
        }
        else { //with grouping
            $user_groupings = groups_get_user_groups($courseid,$userid);
            if (array_key_exists($groupingid, $user_groupings) || has_capability('moodle/course:activityvisibility', $context)) {
                if ($groupid != 0) {
                    if (!groups_is_member($groupid, $userid) && !has_capability('moodle/course:activityvisibility', $context)) { //read only
                        echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum'));
                    }
                }
                echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=$groupid&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
            }
            else { //student not in the grouping
                echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum'));
            }
        }
    }
    else { // visible group
        if ($groupingid == 0) { //without grouping
            if ($groupid == 0) { //all the participants
                if (!has_capability('moodle/course:activityvisibility', $context)) {
                    echo $OUTPUT->notification(get_string('cannotadddiscussionall', 'forum')); // read only for students
                }
            }
            else if (!groups_is_member($groupid, $userid) && !has_capability('moodle/course:activityvisibility', $context)) {
                echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum')); // read only for students not in the group
            }
            echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=$groupid&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
        }
        else { // with grouping
            $user_groupings = groups_get_user_groups($courseid,$userid);
            if (array_key_exists($groupingid, $user_groupings) || has_capability('moodle/course:activityvisibility', $context)) {
                if ($groupid == 0) { //all the participants
                    if (!has_capability('moodle/course:activityvisibility', $context)) {
                        echo $OUTPUT->notification(get_string('cannotadddiscussionall', 'forum')); //read only for students
                    }
                }
                else if (!groups_is_member($groupid, $userid) && !has_capability('moodle/course:activityvisibility', $context)) {
                    echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum')); //read only for students not in the group
                }
                echo " <iframe id='forumqta' name='coursforum' src='../forumqta/q2a/index.php?k_1=$categorytags&groupid=$groupid&cmid=$cmid&qa=questions&qa_1=$categorytags' width='100%' height=800px frameborder='0'></iframe> ";
            }
            else {
                echo $OUTPUT->notification(get_string('cannotadddiscussion', 'forum')); //student not in the grouping
            }
        }
    }
}
echo "</html>";

// Finish the page
echo $OUTPUT->footer();