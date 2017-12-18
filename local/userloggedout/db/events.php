<?php

defined('MOODLE_INTERNAL') || die();

$observers = array(
    array(
        'eventname' => '\core\event\user_loggedout',
        'callback' => '\local_userloggedout\observer::send_message',
    ),
);

?>