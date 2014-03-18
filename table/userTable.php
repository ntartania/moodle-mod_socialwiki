<?php
global $CFG;

require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');
require_once($CFG->dirroot . '/mod/socialwiki/sortableTable/sortableTable.php');
// require_once($CFG->dirroot . '/mod/socialwiki/table/table.php');


class UserTable {
	private $uid;
	private $cmid;
	private $courseid;
	private $swid;

	private $col_names = array(
		"Name",					//TODO: make these all "getString()"
		"Social Distance",
		"Number of Followers",
		"Like Similarity",
		"Follow Similarity",
	);

	public function __construct( $uid, $swid, $courseid, $cmid) {
		$this->uid = $uid;
		$this->swid = $swid;
		$this->courseid= $courseid;
		$this->cmid= $cmid;
	}

	public function allUsersTable() {
		$users = socialwiki_get_subwiki_users($this->swid);
		$rows = $this->getRows($users);
		return $this->makeTable($rows, "allUsersTable");
	}

	public function followingTable($user_id = null) {
		$user_id = ($user_id) ? $user_id : $this->uid;
		$users = socialwiki_get_follows($this->uid, $this->swid);

		$user_id_array = array();
		foreach ($users as $user) {
			array_push($user_id_array, $user->usertoid);
		}

		$rows = $this->getRows($user_id_array);
		return $this->makeTable($rows, "followingTable");
	}

	public function followersTable($user_id = null) {
		$user_id = ($user_id) ? $user_id : $this->uid;
		$users = socialwiki_get_following($this->uid, $this->swid);

		$user_id_array = array();
		foreach ($users as $user) {
			array_push($user_id_array, $user->userfromid);
		}

		$rows = $this->getRows($user_id_array);
		return $this->makeTable($rows, "followersTable");
	}

	public function likesTable($page_id) {
		
	}

	private function getRows($users) {
		$rows = array();

		foreach ($users as $user_id) {
			$user = socialwiki_get_user_info($user_id);
			$peer = new peer($user_id, $this->swid, $this->uid);
			array_push($rows, array(
				"Name" => fullname($user),
				"Followers" => $peer->popularity,
				"Social Distance" => $peer->depth,
				"Like Similarity" => $peer->likesim,
				"Follow Similarity" => $peer->followsim,
			));
		}
		return $rows;
	}

	private function makeTable($rows, $table_id) {
		$table = new SortableTable();

		foreach ($rows as $row) {
			$table->add_row($row);
		}
		return "<div id=\"$table_id\">".$table->get_table($table_id)."</div>";
	}
}