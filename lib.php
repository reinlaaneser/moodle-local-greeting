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
 * Library functions for the local_greeting plugin.
 *
 * @package     local_greeting
 * @copyright   2026 Rein Laaneser <rein.laaneser@outlook.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Get greeting text for the given user.
 *
 * @param stdClass|null $user User object or null.
 * @return string Greeting text.
 */
function local_greeting_get_greeting($user) {
    if ($user == null) {
        return get_string('greetinguser', 'local_greeting');
    }

    $country = $user->country;

    switch ($country) {
        case 'EE':
            $langstr = 'greetinguseret';
            break;

        case 'RU':
            $langstr = 'greetinguserru';
            break;

        default:
            $langstr = 'greetingloggedinuser';
            break;
    }

    return get_string($langstr, 'local_greeting', fullname($user));
}

/**
 * Insert a link to index.php on the site front page navigation menu.
 *
 * @param navigation_node $frontpage Node representing the front page in the navigation tree.
 */
function local_greeting_extend_navigation_frontpage(navigation_node $frontpage) {
    $frontpage->add(
        get_string('pluginname', 'local_greeting'),
        new moodle_url('/local/greeting/index.php'),
        navigation_node::TYPE_CUSTOM,
    );
}