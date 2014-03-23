<?php

require_once('../../config.php');
require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');

$userid = $_POST["userid"];
$time = $_POST["time"];

$recent_responses = socialwiki_get_updates_after_time($time);

$likes = $recent_responses["likes"];
$created = $recent_responses["created"];

$string = "";

while (!empty($likes)) {
    if (empty($created)) {
        $string .= likes_ticker_item(array_pop($likes));
    } else if (end($likes)->datetime <= end($created)->timecreated) {
        $string .= created_ticker_item(array_pop($created));
    } else {
        $string .= likes_ticker_item(array_pop($likes));
    }
}

while (!empty($created)) {
    $string .= created_ticker_item(array_pop($created));
}

echo $string;
// echo "<tr class='ticker_row'><td>".$time."<tr/><td/>";

function created_ticker_item($created) {
    $line = fullname(socialwiki_get_user_info($created->userid)) . " created a new version of " . $created->title . ".";
    return "<tr class='ticker_row'><td>".$line."<tr/><td/>";
}

function likes_ticker_item($like) {
    $page = socialwiki_get_page($like->pageid);
    $line = fullname(socialwiki_get_user_info($like->userid)) . " liked version " . $liked->pageid . " of " . $page->title . " (Version By " . fullname(socialwiki_get_user_info($page->userid)) . ").";
    return "<tr class='ticker_row'><td>".$line."<tr/><td/>";
}