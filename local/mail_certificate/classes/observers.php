<?php 
namespace local_mail_certificate;
defined('MOODLE_INTERNAL') || die();
use stdClass;
	

class observer {
	
	const OBS_CERTIFICATE_COMPONENT_NAME = 'mod_obs_simplecertificate';

	public static function print_msg(\core\event\course_module_created $event) {

		echo 'hello';
		die();
	}
    
    public static function mail_notification() 
    {
        global $DB, $CFG;

        print_object("22222");

		print_object($event)||die();
		// $event->objectid is the id in mdl_simplecertificate table
		$issuecert = $DB->get_record('simplecertificate_issues', array('userid' => $event->userid, 'certificateid' => $event->objectid, 'timedeleted' => null));
		
		$destination = new stdClass();
		$destination->email = 'sangita8252@gmail.com';
		$destination->id = rand(-10, -1);
		
		$user = $DB->get_record('user', array('id' => $event->userid));
		$course = $DB->get_record('course', array('id' => $event->courseid));
		
		$info = new stdClass();
        $info->username = format_string(fullname($user), true);
        $info->certificate = format_string($issuecert->certificatename, true);
        $info->course = format_string($course->fullname, true);
        
        $subject = get_string('emailstudentsubject', 'simplecertificate', $info);
        $message = get_string('emailstudenttext', 'simplecertificate', $info) . "\n";
        
        // Make the HTML version more XHTML happy  (&amp;)
        $messagehtml = text_to_html($message);
        
		$fs = get_file_storage();
        $file = $fs->get_file_by_hash($issuecert->pathnamehash);
	
		
        // Get generated certificate file
        if ($file) { //put in a tmp dir, for e-mail attachament
            $fullfilepath = self::create_cert_temp_file($file->get_filename());
            $file->copy_content_to($fullfilepath);
            $relativefilepath = str_replace($CFG->dataroot . DIRECTORY_SEPARATOR, "", $fullfilepath);
            
            if (strpos($relativefilepath, DIRECTORY_SEPARATOR, 1) === 0) {
                $relativefilepath = substr($relativefilepath, 1);
            }
            
			$from = \core_user::get_support_user();
			
			var_dump($destination);
			var_dump($from);
			var_dump($relativefilepath);
			var_dump($file->get_filename());
            
            email_to_user($destination, $from, $subject, $message, $messagehtml, $relativefilepath, $file->get_filename());
            @unlink($fullfilepath);
            
        } else {
            error_log(get_string('filenotfound', 'simplecertificate'));
            print_error(get_string('filenotfound', 'simplecertificate'));
        }
		
    }
	
	public static function create_cert_temp_file($file) {
        global $CFG;
        
        $path = make_temp_directory(self::OBS_CERTIFICATE_COMPONENT_NAME);
        return tempnam($path, $file);
    }
	
	
}

