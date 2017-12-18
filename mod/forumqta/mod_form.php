<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    mod_forumqta
 * @copyright  2016 Cyberlearn HES-SO, Leyun Xia<leyun.xia@hevs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/course/moodleform_mod.php');

/**
 * Module instance settings form
 */
class mod_forumqta_mod_form extends moodleform_mod {

    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;

        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('forumqtaname', 'forumqta'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'forumqtaname', 'forumqta');

        // Adding the standard "intro" and "introformat" fields
        $this->standard_intro_elements() ;

        //-------------------------------------------------------------------------------
        // Adding the rest of forumqta settings, spreeading all them into this fieldset
        // or adding more fieldsets ('header' elements) if needed for better logic
        //$mform->addElement('static', 'label1', 'forumqtasetting1', 'Your forumqta fields go here. Replace me!');

        //$mform->addElement('header', 'forumqtafieldset', get_string('forumqtafieldset', 'forumqta'));
        //$mform->addElement('static', 'label2', 'forumqtasetting2', 'Your forumqta fields go here. Replace me!');

        /*$options = array(NOGROUPS => 'Public',
            SEPARATEGROUPS => 'Group A',
            VISIBLEGROUPS => 'Group B');
        $mform->addElement('select', 'groupmode', get_string('groupmode', 'group'), $options, NOGROUPS);*/

        /*$mform->addElement('header', 'forumqtafieldset', get_string('forumqtafieldset', 'forumqta'));
        $options2 = array(NOGROUPS => 'Public',
                SEPARATEGROUPS => 'Private');
        $mform->addElement('select', 'groupmode', get_string('groupmode', 'group'), $options2, NOGROUPS);*/

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
}
