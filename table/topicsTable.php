<?php
global $CFG;

require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');
require_once($CFG->dirroot . '/mod/socialwiki/sortableTable/sortableTable.php');
// require_once($CFG->dirroot . '/mod/socialwiki/table/table.php');


class PagesTable {
	private $uid;
	private $cmid;
	private $courseid;
	private $swid;

	public static function makeTopicsTables($uid, $swid, $courseid, $cmid) {
		$pagesTable = new PagesTable($uid, $swid, $courseid, $cmid);
		$pagesTable->allPagesTable();
	}
	
	public function __construct( $uid, $swid, $courseid, $cmid) {
		$this->uid = $uid;
		$this->swid = $swid;
		$this->courseid= $courseid;
		$this->cmid= $cmid;
	}

	public function allPagesTable() {
		//get all topics
		$pages = socialwiki_get_topics($this->swid);
		$rows = $this->getRows($pages);
		$this->makeTable($rows);
	}

	private function getRows($pages) {
		$rows = array();
		foreach ($pages as $title => $page) {
			$row = array(
				"Title" => $title,
				"Views" => $page["Views"],
				"Likes" => $page["Likes"],
				"Versions" => $page["Versions"],
			);
			array_push($rows, $row);
		}
		return $rows;
	}

	private function makeTable($rows) {
		$table = new SortableTable();

		foreach ($rows as $row) {
			$table->add_row($row);
		}
		echo "<div id=\"allPagesTable\"></div>";
		$table->print_table("allPagesTable"); 
	}
}