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
 * @package    enrol_apply
 * @copyright  emeneo.com (http://emeneo.com/)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @author     emeneo.com (http://emeneo.com/)
 * @author     Johannes Burk <johannes.burk@sudile.com>
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class enrol_apply_edit_form extends moodleform {

    protected function definition() {
        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('pluginname', 'enrol_apply'));

        $mform->addElement('text', 'name', get_string('custominstancename', 'enrol'));
        $mform->setType('name', PARAM_TEXT);

        $mform->addElement('select', 'status', get_string('status', 'enrol_apply'), array(
            ENROL_INSTANCE_ENABLED => get_string('yes'),
            ENROL_INSTANCE_DISABLED  => get_string('no')));
        // $mform->addHelpButton('status', 'status', 'enrol_apply');
        $mform->setDefault('status', $plugin->get_config('status'));

        if ($instance->id) {
            $roles = get_default_enrol_roles($context, $instance->roleid);
        } else {
            $roles = get_default_enrol_roles($context, $plugin->get_config('roleid'));
        }
        $mform->addElement('select', 'roleid', get_string('defaultrole', 'role'), $roles);
        $mform->setDefault('roleid', $plugin->get_config('roleid'));

        $mform->addElement('textarea', 'customtext1', get_string('editdescription', 'enrol_apply'));

        $options = array(1 => get_string('yes'),
                         0 => get_string('no'));

        $mform->addElement('select', 'customint1', get_string('show_standard_user_profile', 'enrol_apply'), $options);
        $mform->setDefault('customint1', $plugin->get_config('customint1'));

        $mform->addElement('select', 'customint2', get_string('show_extra_user_profile', 'enrol_apply'), $options);
        $mform->setDefault('customint2', $plugin->get_config('customint2'));

        $choices = array(
            '$@NONE@$' => get_string('nobody'),
            '$@ALL@$' => get_string('everyonewhocan', 'admin', get_capability_string('enrol/apply:manageapplications')));
        $users = get_enrolled_users($context, 'enrol/apply:manageapplications');
        foreach ($users as $userid => $user) {
            $choices[$userid] = fullname($user);
        }
        $select = $mform->addElement('select', 'notify', get_string('notify_desc', 'enrol_apply'), $choices);
        $select->setMultiple(true);

        $mform->addElement('text', 'customint3', get_string('maxenrolled', 'enrol_apply'));
        $mform->setType('customint3', PARAM_INT);
        $mform->setDefault('customint3', $plugin->get_config('customint3'));

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }
}
