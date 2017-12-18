<?php 
namespace local_userloggedin;
defined('MOODLE_INTERNAL') || die();

	

class observer {

	public static function send_notification(\core\event\user_loggedin $event) {
        global $CFG, $SITE;
        redirect('http://google.com');
        print_object($event);die();

	}

}

?>	