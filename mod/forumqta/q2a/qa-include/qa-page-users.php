<?php

/*
	Question2Answer (c) Gideon Greenspan

	http://www.question2answer.org/

	
	File: qa-include/qa-page-users.php
	Version: See define()s at top of qa-include/qa-base.php
	Description: Controller for top scoring users page


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/
/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../');
		exit;
	}

	require_once QA_INCLUDE_DIR.'qa-db-users.php';
	require_once QA_INCLUDE_DIR.'qa-db-selects.php';
	require_once QA_INCLUDE_DIR.'qa-app-format.php';



//	Get list of all users
	
	$start=qa_get_start();

    // Récupération de la catégorie ID par l'URL
    $string_k1 = $_GET['k_1'];
    $categoryid = substr(qa_get('k_1'), 1, strlen($string_k1));

	//$users=qa_db_select_with_pending(qa_db_top_users_selectspec($start, qa_opt_if_loaded('page_size_users')));
    $users = qa_db_get_ranking_paged($start, qa_opt_if_loaded('page_size_users'), $categoryid);

	//$usercount=qa_opt('cache_userpointscount');
    $allusers = qa_db_get_users($categoryid);
    $usercount = count($allusers);
	$pagesize=qa_opt('page_size_users');
	$users=array_slice($users, 0, $pagesize);
	$usershtml=qa_userids_handles_html($users);


//	Prepare content for theme
	
	$qa_content=qa_content_prepare();

	$qa_content['title']=qa_lang_html('main/highest_users');

	$qa_content['ranking']=array(
		'items' => array(),
		'rows' => ceil($pagesize/qa_opt('columns_users')),
		'type' => 'users'
	);

    //$userfinal = qa_db_get_ranking($categoryid);
    if (isset($users)) {
        /*foreach ($userfinal as $userid => $userfinal) {
            if($userfinal['userid']!=0){
               $qa_content['ranking']['items'][]=array(
                    'label' =>
                        (QA_FINAL_EXTERNAL_USERS
                            ? qa_get_external_avatar_html($userfinal['userid'], qa_opt('avatar_users_size'), true)
                            : qa_get_user_avatar_html($userfinal['flags'], $userfinal['email'], $userfinal['handle'],
                                $userfinal['avatarblobid'], $userfinal['avatarwidth'], $userfinal['avatarheight'], qa_opt('avatar_users_size'), true)
                        ).' '.$usershtml[$userfinal['userid']],
                    'score' => qa_html(number_format($userfinal['counted'])*150),
                    'raw' => $userfinal,
                );
                echo $usershtml[$userfinal['userid']];
            }
        }*/
        foreach ($users as $userid => $userfinal) {
            if($userfinal['userid']!=0){
                $qa_content['ranking']['items'][]=array(
                    'label' => $usershtml[$userfinal['userid']],
                    'score' => qa_html(number_format($userfinal['counted'])*150),
                    'raw' => $userfinal,
                );
            }
        }

    } else
        $qa_content['title']=qa_lang_html('main/no_active_users');

        $qa_content['page_links']=qa_html_page_links(qa_request(), $start, $pagesize, $usercount, qa_opt('pages_prev_next'));

        $qa_content['navigation']['sub']=qa_users_sub_navigation();

	return $qa_content;


/*
	Omit PHP closing tag to help avoid accidental output
*/