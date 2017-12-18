<?php
/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Define the complete forum structure for backup, with file and id annotations
 */
class backup_forumqta_activity_structure_step extends backup_activity_structure_step {

    protected function define_structure() {

        // To know if we are including userinfo
        $userinfo = $this->get_setting_value('userinfo');

        // Define each element separated
       $forumqta = new backup_nested_element('forumqta', array('id'), array(
            'course', 'name', 'intro', 'introformat',
            'timecreated', 'timemodified'));

        $categories = new backup_nested_element('categories');

        $categorie = new backup_nested_element('categorie', array('id'), array(
            'categoryid', 'parentid', 'forumqtaid', 'tags', 'content', 'qcount',
            'position', 'backpath'));

        $forumqta->add_child($categories);
        $categories->add_child($categorie);

        $forumqta->set_source_table('forumqta', array('id' => backup::VAR_ACTIVITYID));

        $categorie->set_source_sql('
            SELECT *
            FROM {forumqta_categories}
            WHERE forumqtaid = ?
            ORDER BY id',
            array(backup::VAR_PARENTID));

        // Define file annotations
        $forumqta->annotate_files('mod_forumqta', 'intro', null); // This file area hasn't itemid

        // Return the root element (forumqta), wrapped into standard activity structure
        return $this->prepare_activity_structure($forumqta);
    }
}