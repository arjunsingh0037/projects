<?php

defined('MOODLE_INTERNAL') || die();

$observer = array(
    array(
        'eventname' => '\core\event\user_loggedin',
        'callback' => '\local_sample_observer\observer::send_notification',
    ),
);

?>