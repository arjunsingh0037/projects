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
 * Edit course completion settings - the form definition.
 *
 * @package     local_mail_certificate
 * @copyright   2017 Dan Marsden
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Defines the course completion settings form.
 *
 * @copyright   2017 Dan Marsden
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_mail_certificate_mail_certificate_form extends moodleform {

    /**
     * Defines the form fields.
     */
    public function definition() {

        $mform = $this->_form;
        $course = $this->_customdata['course'];

        $mform->addElement('checkbox', 'enablemailtoteacher', get_string('enablemailnotificationteacher', 'local_mail_certificate'));
        
        $mform->addElement('checkbox', 'enablemailtomanager', get_string('enablemailnotificationmanager', 'local_mail_certificate'));
       
        $mform->addElement('checkbox', 'enablemailattachment', get_string('enablemailattachment', 'local_mail_certificate'));
       

        $this->add_action_buttons();

        $mform->addElement('hidden', 'course', $course->id);
        $mform->setType('course', PARAM_INT);

    }
}
