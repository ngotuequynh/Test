<?php
// This file is part of CodeRunner - http://coderunner.org.nz/
//
// CodeRunner is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// CodeRunner is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with CodeRunner.  If not, see <http://www.gnu.org/licenses/>.

/**
 * API routines for qtype_coderunner
 *
 * @package qtype_coderunner
 * @author Dongsheng Cai <dongsheng@moodle.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Checks file access for CodeRunner questions.
 *
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 */
function qtype_coderunner_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    global $CFG;
    if ($filearea === 'feedbackfiles') {
        require_login($course, false, $cm);

        // Note: Implement additional checks here, as needed, to ensure users are authorized to access the file

        // Serve the file
        $fs = get_file_storage();
        $filename = array_pop($args);
        $itemid = intval(array_shift($args));
        $filepath = '/';
        $contextid = $context->id;
        $file = $fs->get_file($contextid, 'qtype_coderunner', $filearea, $itemid, $filepath, $filename);
        if (!$file) {
            send_file_not_found();
        }
        send_stored_file($file, 0, 0, $forcedownload, $options); // Adjust options as necessary
    }
    require_once($CFG->libdir . '/questionlib.php');
    question_pluginfile($course, $context, 'qtype_coderunner', $filearea, $args, $forcedownload, $options);
}
