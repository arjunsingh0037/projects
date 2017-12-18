/**
* @package    mod_forumqta
* @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
* @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/

<?php

$CFG = new stdClass();
$CFG->dataroot = 'C:\\Work\\applications\\moodledata';
$CFG->cookiename = 'MoodleSession';

function init_moodle_session() {
    global $CFG;

    session_name($CFG->cookiename);
    ini_set('session.save_handler', 'files');
    session_save_path($CFG->dataroot . '/sessions');
    session_start();
}

echo "<pre>========= COOKIE ==================================</pre>\n";
var_dump($_COOKIE);
echo "<pre>========= SESSION (BEFORE)=========================</pre>\n";
var_dump($_SESSION);

init_moodle_session();
session_start();

echo "<pre>========= SESSION (AFTER)=========================</pre>\n";
var_dump($_SESSION);