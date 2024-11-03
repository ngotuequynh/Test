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
 * Leader board settings page.
 *
 * @package    block_stash
 * @copyright  2023 Adrian Greeve <adriangreeve.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$courseid = required_param('courseid', PARAM_INT);

require_login($courseid);

$manager = \block_stash\manager::get($courseid);
$manager->require_enabled();
$manager->require_manage();

$url = new moodle_url('/blocks/stash/lbsettings.php', ['courseid' => $courseid]);
list($title, $subtitle, $returnurl) = \block_stash\page_helper::setup_for_lbsettings($url, $manager);

$renderer = $PAGE->get_renderer('block_stash');

echo $OUTPUT->header();
echo $OUTPUT->heading($title);
echo $renderer->navigation($manager, 'leaderboards');

if (!empty($subtitle)) {
    echo $OUTPUT->heading($subtitle, 3);
}

$lbsettingsdata = new \block_stash\output\local\main_pages\leaderboard_content($manager);
echo $renderer->render_leaderboard_settings($lbsettingsdata);
echo $OUTPUT->footer();
