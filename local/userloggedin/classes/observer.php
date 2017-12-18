<?php 
namespace local_userloggedin;

defined('MOODLE_INTERNAL') || die();

class observer {

    public static function send_notification(\core\event\user_created $event) {
        global $CFG, $SITE;

        // $eventdata = $event->get_data();

        // print_object($event);
        // redirect ('google.com');
        // die();


    }
}