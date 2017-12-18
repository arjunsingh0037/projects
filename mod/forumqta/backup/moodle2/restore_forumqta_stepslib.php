<?php
/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Structure step to restore one forumqta activity
 */
class restore_forumqta_activity_structure_step extends restore_activity_structure_step {

    protected function define_structure() {

        $paths = array();
        $userinfo = $this->get_setting_value('userinfo');

        $paths[] = new restore_path_element('forumqta', '/activity/forumqta');
        $paths[] = new restore_path_element('forumqta_categorie', '/activity/forumqta/categories/categorie');
        $paths[] = new restore_path_element('forumqta_post', '/activity/forumqta/categories/categorie/posts/post');
        $paths[] = new restore_path_element('forumqta_userpoint', '/activity/forumqta/userpoints/userpoint');

        // Return the paths wrapped into standard activity structure
        return $this->prepare_activity_structure($paths);
    }

    protected function process_forumqta($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();
        $data->timemodified = $this->apply_date_offset($data->timemodified);
        // insert the forumqta record
        $newitemid = $DB->insert_record('forumqta', $data);
        // immediately after inserting "activity" record, call this
        $this->apply_activity_instance($newitemid);
    }

    protected function process_forumqta_categorie($data) {
        global $DB;

        $data = (object)$data;
        $oldid = $data->id;
        $newitemid = $DB->insert_record('forumqta_categories', $data);
        $this->set_mapping('forumqta_categorie', $oldid, $newitemid);
        $data->tags = 'c'.$newitemid;
        $data->backpath = 'c'.$newitemid;
        $data->id = $newitemid;
        $data->categoryid = $newitemid;
        $data->forumqtaid = $this->get_new_parentid('forumqta');
        $data->qcount = 0;
        $DB->update_record('forumqta_categories', $data,  $bulk=false);
    }

    protected function process_forumqta_post($data)
    {
        global $DB;
/*
        $data = (object)$data;
      //  $data->postid = $data->id ;
        $oldid = $data->postid;

        error_log(print_r($data,true));
        error_log('posts 2: ', 0);
        error_log('data 2 : '.var_dump($data), 0);



        $data->posts = $this->get_new_parentid('forumqta_post');
        $newitemid = $DB->insert_record('forumqta_posts', $data ,$returnid=true, $primarykey='postid');
        $this->set_mapping('forumqta_post', $oldid, $newitemid,true);*/
    }

    protected function process_forumqta_userpoint($data) {
        global $DB;
      /*  error_log(var_dump($data), 0);
        $data = (object)$data;
        $oldid = $data->userid;

        $data->forumqtapostid = $this->get_mappingid('forumqta_post', $data->forumqtatagwordid);

        $newitemid = $DB->insert_record('forumqta_userpoints', $data);
        $this->set_mapping('forumqta_userpoint', $oldid, $newitemid);*/
    }


    protected function after_execute() {
        // Add forumqta related files, no need to match by itemname (just internally handled context)
        //$this->add_related_files('mod_forumqta', 'intro', null);
    }
}