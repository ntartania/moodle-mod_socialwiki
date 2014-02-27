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
 * @package mod-wiki
 * @copyright 2010 Dongsheng Cai <dongsheng@moodle.com>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->dirroot . '/mod/socialwiki/table/table.php');
require_once($CFG->dirroot . '/mod/socialwiki/table/userTable.php');
require_once($CFG->dirroot . '/mod/socialwiki/table/topicsTable.php');
require_once($CFG->dirroot . '/mod/socialwiki/table/versionTable.php');

$tabletype = required_param('type', PARAM_TEXT);
//allowed values: faves, recentlikes, newpageversions, allpageversions, followedusers, followers, allusers, alltopics
$userid = required_param('userid', PARAM_INT);
$swid = required_param('swid', PARAM_INT);
$courseid = required_param('courseid', PARAM_INT);
$cmid = required_param('cmid', PARAM_INT);



$t = null;
switch($tabletype){
	case "faves":
		$t= versionTable::makeFavouritesTable($userid, $swid);
		break;
	case "recentlikes":
		$t= versionTable::makeRecentLikesTable($userid, $swid);
		break;
	case "newpageversions":
		$t= versionTable::makeNewPageVersionsTable($userid, $swid);
		break;
	case "allpageversions":
		$t= versionTable::makeAllVersionsTable($userid, $swid);
		break;
	case "followedusers":
		$t = UserTable::make_followed_users_table($userid, $swid);
		break;
	case "followers":
		$t = UserTable::make_followers_table($userid, $swid);
		break;
	case "allusers":
		$t = UserTable::make_all_users_table($userid, $swid);
		break;
	case "alltopics":
		$t = TopicsTable::make_all_topics_table($userid, $swid, $courseid, $cmid);
		break;
	default:
		echo "error in tablefactory";
}
if ($t!=null)
	echo $t->get_as_HTML();
else 
	echo '<table><tr><td>No Data Here.</td></tr></table>';
