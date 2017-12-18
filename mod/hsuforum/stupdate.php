<!DOCTYPE html>
<html>


<?php
    
    global $OUTPUT;
	
	require_once('../../config.php');

	$discussionid   = optional_param('id', 0, PARAM_INT);

 $newpost = new stdClass();
        $newpost->id      = $discussionid;
        $newpost->status  = 2;
        $val= $DB->update_record("hsuforum_discussions", $newpost);

        //echo $OUTPUT->notification(get_string('postinsertification', 'hsuforum'),'notifysuccess');

         //echo $OUTPUT->notification(get_string($msg, 'badges'), 'notifysuccess');
        // $subject='';
        // $message='';
        // $subject="Post Notification ";
        // $message='Admin add new post please go through its';
        // $touser = $DB->get_record('user',array('id'=>'2'));
        // print_object("hello3")||die();
        // $message = new stdClass();
        // $message->component         = 'mod_hsuforum'; //your component name
        // $message->name              = 'posts'; //this is the message name from messages.php
        // $message->userfrom          = $USER;
        // $message->userto            = $touser;
        // $message->subject           = $subject;
        // $message->fullmessage       = $message;
        // $message->fullmessageformat = FORMAT_PLAIN;
        // $message->fullmessagehtml   = '';
        // $message->smallmessage      = '';
        // $message->notification      = 1; //this is only set to 0 for personal messages between users
        // message_send($message);

        if($val)
        {
        	echo 1;
        }
  ?>
  </html>