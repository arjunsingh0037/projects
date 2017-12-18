<!DOCTYPE html>
<html>


<?php
	
	require_once('../../config.php');
  global $DB,$OUTPUT;
  $disid='';
	$discussionid   = optional_param('id', 0, PARAM_INT);
 // print_object($discussionid)||die();

   //$disid = $DB->get_record('hsuforum_discussions', array('id' => $discussionid), '*', MUST_EXIST);
  // print_object($disid)||die();
  //$discussionid  =$_POST['data'];
  //print_object($discussionid)||die();

	$newpost = new stdClass();
        $newpost->id      = $discussionid;
        $newpost->status  = 2;
        

        $val= $DB->update_record("hsuforum_posts", $newpost);
        // echo $OUTPUT->notification(get_string($msg, 'badges'), 'notifysuccess');
         echo $OUTPUT->notification(get_string('postinsertification', 'hsuforum'),'notifysuccess');

        // $subject='';
        // $message='';
        // $subject="Post Notification ";
        // $message='User add new post please go through its';
        // $touser = $DB->get_record('user',array('id'=>'2'));

        

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
          print_object("1111");
        }
  ?>
  </html>