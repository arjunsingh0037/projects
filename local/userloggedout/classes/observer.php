<?php 
namespace local_userloggedout;

defined('MOODLE_INTERNAL') || die();

class observer {

    public static function send_message(\core\event\user_loggedout $event) {
        global $CFG, $SITE;

        $eventdata = $event->get_data();

        print_object($event);
        //redirect ('google.com');
        die();


    }
}