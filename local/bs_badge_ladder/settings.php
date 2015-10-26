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
 * Global settings for badge ladder plugin.
 *
 * @package local_bs_badge_ladder
 * @author Matthias Schwabe <mail@matthiasschwabe.de>
 * @copyright 2015 Matthias Schwabe
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {

    $settings = new admin_settingpage('local_bs_badge_ladder', get_string('pluginname', 'local_bs_badge_ladder'));

    $settings->add(new admin_setting_heading('local_bs_badge_ladder_systemladder',
        get_string('systemladderhead', 'local_bs_badge_ladder'), ''));

    $settings->add(new admin_setting_configcheckbox('local_bs_badge_ladder/enablesystemladder',
        get_string('systemladder', 'local_bs_badge_ladder'), get_string('systemladderinfo', 'local_bs_badge_ladder'), 0));

    $settings->add(new admin_setting_configcheckbox('local_bs_badge_ladder/anonymizesystemstudentbadgeladder',
        get_string('anonymizesystemstudentbadgeladder', 'local_bs_badge_ladder'),
        get_string('anonymizesystemstudentbadgeladderinfo', 'local_bs_badge_ladder'), 1));

    $settings->add(new admin_setting_heading('local_bs_badge_ladder_courseladder',
        get_string('courseladderhead', 'local_bs_badge_ladder'), ''));

    $settings->add(new admin_setting_configcheckbox('local_bs_badge_ladder/enablecourseladder',
        get_string('courseladder', 'local_bs_badge_ladder'), get_string('courseladderinfo', 'local_bs_badge_ladder'), 1));
		
    $options = array('0' => get_string('disabled', 'local_bs_badge_ladder'),
        '1' => get_string('enabled', 'local_bs_badge_ladder'));

    $settings->add(new admin_setting_configselect('local_bs_badge_ladder/courseladderdefault',
        get_string('courseladderdefault', 'local_bs_badge_ladder'),
        get_string('courseladderdefaultinfo', 'local_bs_badge_ladder'), '0', $options));

    $settings->add(new admin_setting_configcheckbox('local_bs_badge_ladder/anonymizestudentbadgeladder',
        get_string('anonymizestudentladder', 'local_bs_badge_ladder'),
        get_string('anonymizestudentladderinfo', 'local_bs_badge_ladder'), 0));

    $options2 = array('0' => get_string('disabled', 'local_bs_badge_ladder'),
        '1' => get_string('enabled', 'local_bs_badge_ladder'));

    $settings->add(new admin_setting_configselect('local_bs_badge_ladder/anonymizestudentbadgeladderdefault',
        get_string('anonymizestudentladderdefault', 'local_bs_badge_ladder'),
        get_string('anonymizestudentladderdefaultinfo', 'local_bs_badge_ladder'), '0', $options2));

    $ADMIN->add('localplugins', $settings);
}
