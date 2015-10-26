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
 * The library file for badge ladder plugin.
 *
 * @package local_bs_badge_ladder
 * @author Matthias Schwabe <mail@matthiasschwabe.de>
 * @copyright 2015 Matthias Schwabe
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

// Some file imports.
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once($CFG->libdir.'/badgeslib.php');
require_once($CFG->libdir.'/formslib.php');

function local_bs_badge_ladder_extend_navigation ($nav) {
    global $PAGE, $DB, $CFG;

    $enabled = $DB->get_record('local_badge_ladder', array('courseid' => $PAGE->course->id, 'status' => 1));

    // Show link to course badge ladder.
    if ($PAGE->course->id
        and $PAGE->course->id != SITEID
        and $CFG->badges_allowcoursebadges
        and get_config('local_bs_badge_ladder')->enablecourseladder
        and ((has_capability('local/bs_badge_ladder:viewcourseladder', $PAGE->context)
        and $enabled) or has_capability('local/bs_badge_ladder:managecourseladder', $PAGE->context))) {

        $url = new moodle_url('/local/bs_badge_ladder/index.php', array('id' => $PAGE->course->id, 'type' => 2));
        $coursenode = $nav->find($PAGE->course->id, $nav::TYPE_COURSE);
        if ($enabled) {
            $navtext = get_string('viewcourseladder', 'local_bs_badge_ladder');
        } else {
            $navtext = get_string('viewcourseladderdisabled', 'local_bs_badge_ladder');
        }
        $coursenode->get('coursebadges')->add($navtext, $url,
            navigation_node::TYPE_SETTING, null, 'viewcourseladder', new pix_icon('i/badge', get_string('badgesview', 'badges')));
    }

    // Show link to system badge ladder.
    if (isloggedin()
        and !isguestuser()
        and isset(get_config('local_bs_badge_ladder')->enablesystemladder)
        and get_config('local_bs_badge_ladder')->enablesystemladder == 1) {

        $url = new moodle_url('/local/bs_badge_ladder/index.php', array('type' => 1));
        $coursenode = $nav->find(SITEID, $nav::TYPE_COURSE);
        $coursenode->add(get_string('viewsystemladder', 'local_bs_badge_ladder'),
        $url, $nav::TYPE_CONTAINER, null, 'viewsystemladder', new pix_icon('i/badge', get_string('badgesview', 'badges')));
    }
}

class local_bs_badge_ladder_form extends moodleform {

    public function definition() {
        global $COURSE;

        $mform =& $this->_form;
        $config = (isset($this->_customdata['config'])) ? $this->_customdata['config'] : false;

        $mform->addElement('advcheckbox', 'enablecoursebadgeladder',
            get_string('enablecoursebadgeladder', 'local_bs_badge_ladder'), '', null, array(0, 1));
        $mform->setDefault('enablecoursebadgeladder', get_config('local_bs_badge_ladder')->courseladderdefault);

        if (get_config('local_bs_badge_ladder')->anonymizestudentbadgeladder) {
            $mform->addElement('advcheckbox', 'anonymizestudentbadgeladder',
                get_string('anonymizestudentbadgeladder', 'local_bs_badge_ladder'), '', null, array(0, 1));
            $mform->setDefault('anonymizestudentbadgeladder',
			    get_config('local_bs_badge_ladder')->anonymizestudentbadgeladderdefault);
        }

        $this->add_action_buttons();
        $this->set_data($config);
    }

    public function set_data($config) {
        global $COURSE, $DB;

        parent::set_data($config);

        $defaultvalues = array();
        $defaultvalues['enablecoursebadgeladder'] = $DB->get_field('local_badge_ladder', 'status',
            array('courseid' => $COURSE->id), MUST_EXIST);
        $defaultvalues['anonymizestudentbadgeladder'] = $DB->get_field('local_badge_ladder', 'anonymize',
            array('courseid' => $COURSE->id), MUST_EXIST);

        parent::set_data($defaultvalues);
    }
}
