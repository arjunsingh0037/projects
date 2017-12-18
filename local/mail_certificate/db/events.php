<?php

defined('MOODLE_INTERNAL') || die();
$observers = array(
    array(
        'eventname' => 'mod_simplecertificate\event\course_module_viewed',
        'callback'  => 'local_mail_certificate\observers::mail_notification',
        ),
    array(
        'eventname' => '\core\event\course_module_created',
        'callback'  => 'local_mail_certificate\observers::print_msg',
        )
    );
