<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>;.

/**
 * Main file to view greetings
 *
 * @package     local_greeting
 * @copyright   2026 Rein Laaneser <rein.laaneser@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot. '/local/greeting/lib.php');

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/greeting/index.php'));
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('pluginname', 'local_greeting'));
$PAGE->set_heading(get_string('pluginname', 'local_greeting'));

if (isloggedin()) {
    $usergreeting = local_greeting_get_greeting($USER);
} else {
    $usergreeting = get_string('greetinguser', 'local_greeting');
}

require_once(__DIR__ . '/classes/form/message_form.php');

$messageform = new \local_greeting\form\message_form();

if ($data = $messageform->get_data()) {
    $message = required_param('message', PARAM_TEXT);

    if (!empty($message)) {
        $record = new stdClass;
        $record->message = $message;
        $record->timecreated = time();

        $record->userid = $USER->id;

        $DB->insert_record('local_greeting_messages', $record);
    }
}

echo $OUTPUT->header();

$templatedata = ['usergreeting' => $usergreeting];

echo $OUTPUT->render_from_template('local_greeting/greeting_message', $templatedata);

$messageform->display();

$messages = $DB->get_records('local_greeting_messages');

$templatedata = ['messages' => array_values($messages)];
echo $OUTPUT->render_from_template('local_greeting/messages', $templatedata);

echo $OUTPUT->footer();
