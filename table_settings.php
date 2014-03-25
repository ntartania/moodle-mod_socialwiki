<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');

$userid = $_POST["userid"];
$swid = $_POST["swid"];
$table_id = $_POST["table_id"];
$column_id = $_POST["column_id"];
$enabled = $_POST["enabled"];

if ($column_id == null) {
	if ($enabled == 'true') {
		socialwiki_table_enable($userid, $table_id);
		echo "enabled table $table_id for $userid";
	} else {
		socialwiki_table_disable($userid, $table_id);
		echo "disabled table $table_id for $userid";
	}
} else {
	if ($enabled == 'true') {
		socialwiki_column_enable($userid, $table_id, $column_id);
		echo "enabled column $column_id for table $table_id for $userid";
	} else {
		socialwiki_column_disable($userid, $table_id, $column_id);
		echo "disabled column $column_id for table $table_id for $userid";
	}
}