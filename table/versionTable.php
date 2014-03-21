<?php
global $CFG;

require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');
require_once($CFG->dirroot . '/mod/socialwiki/sortableTable/sortableTable.php');
// require_once($CFG->dirroot . '/mod/socialwiki/table/table.php');


class VersionTable {
    

    private $uid;
    private $cmid;
    private $courseid;
    private $swid;

    public function __construct( $uid, $swid, $courseid, $cmid) {
        $this->uid = $uid;
        $this->swid = $swid;
        $this->courseid= $courseid;
        $this->cmid= $cmid;
    }

    public function allVersionsTable() {
        //get all topics
        $pages = socialwiki_get_page_list($this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "allVersionsTable");
        // return $pages;
    }

    public function likedVersionsTable() {
        $pages = socialwiki_get_liked_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "likedVersionsTable");
    }

    public function favoriteVersionTable() {
        $pages = socialwiki_get_user_favorites($this->uid, $this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "favoritedVersionsTable");
    }

    public function userCreatedTable() {
        $pages = socialwiki_user_authored_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "userCreatedTable");
    }

    public function newVersionTable() {
        $pages = socialwiki_get_latest_pages($this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "newVersionTable");
    }

    public function recomendedVersionTable() {
        $pages = socialwiki_get_recommended_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages);
        return $this->makeTable($rows, "recomendedVersionTable");
    }

    // public function popularPagesTable() {

    // }

    // public function popularAuthorTable() {

    // }

    private function getPageRows($pages) {

        $rows = array();
        foreach ($pages as $title => $page) {
            $author = socialwiki_get_user_info($page->userid);
            $contributors = socialwiki_get_contributors($page->id);
            $peer = new peer($page->userid,
                             $this->swid,
                             $this->uid,
                             //socialwiki_get_user_count($swid),
                             null);

            $row = array(
                "Title" => $this->makeUserColumn($page),
                "Contributers" => fullname($author) . " and ".(count($contributors)-1)." others",
                "Updated" => strftime('%d %b %Y', $page->timecreated),
                "Likes" => socialwiki_numlikes($page->id),
                "Views" => $page->pageviews,
                "Favorited By" => count(socialwiki_get_favorites($page->id, $swid)),
                "Author Popularity (Max)" => $this->combine_indicators($page, "max", "peerpopularity"),
                "Like Similarity (Max)" => $this->combine_indicators($page, "max", "likesimilarity"),
                "Follow Similarity (Max)" => $this->combine_indicators($page, "max", "followsimilarity"),
                "Network Distance (Max)" => $this->combine_indicators($page, "max", "networkdistance"),
                "Author Popularity (Min)" => $this->combine_indicators($page, "min", "peerpopularity"),
                "Like Similarity (Min)" => $this->combine_indicators($page, "min", "likesimilarity"),
                "Follow Similarity (Min)" => $this->combine_indicators($page, "min", "followsimilarity"),
                "Network Distance (Min)" => $this->combine_indicators($page, "min", "networkdistance"),
                "Author Popularity (Average)" => $this->combine_indicators($page, "avg", "peerpopularity"),
                "Like Similarity (Average)" => $this->combine_indicators($page, "avg", "likesimilarity"),
                "Follow Similarity (Average)" => $this->combine_indicators($page, "avg", "followsimilarity"),
                "Network Distance (Average)" => $this->combine_indicators($page, "avg", "networkdistance"),
                "Author Popularity (Sum)" => $this->combine_indicators($page, "sum", "peerpopularity"),
                "Like Similarity (Sum)" => $this->combine_indicators($page, "sum", "likesimilarity"),
                "Follow Similarity (Sum)" => $this->combine_indicators($page, "sum", "followsimilarity"),
                "Network Distance (Sum)" => $this->combine_indicators($page, "sum", "networkdistance"),
            );
            array_push($rows, $row);
        }
        return $rows;
    }

    private function makeTable($rows, $id) {
        $table = new SortableTable();

        foreach ($rows as $row) {
            $table->add_row($row);
        }
        echo "<div id=\"$id\"></div>";
        $table->print_table($id); 
    }

    /** combines trust indicators obtained from the peers who like a page
    *
    */
    private function combine_indicators($page, $reducer,$indicator){
        $uservals = array();
        foreach($page->likers as $u){
            $peer = $this->allpeers[$u];
        
            $score= 0; // meant to stand out if errors come up
            switch($indicator){
                case "followsimilarity":
                    $score = $peer->followsim;
                    break;
                case "likesimilarity":
                    $score = $peer->likesim;
                    break;
                case "peerpopularity":
                    $score = $peer->popularity;
                    break;
                case "networkdistance":
                    $score = max(0,$peer->depth);
                    break;
            }
            $uservals[] = $score;
        }

        if (count($uservals)==0) return 0;

        switch($reducer){
            case "max":
                return max($uservals);
                
            case "min":
                return min($uservals);
                
            case "avg":
                $len = count($uservals);
                return (array_reduce($uservals, function($a,$b){return $a+$b;})/$len);
                
            case "sum":
                return array_reduce($uservals, function($a,$b){return $a+$b;});
                
        }


        return 0.99; //kludge: just an error value
    }

    private function makePageLink($page) {
        global $CFG;
        return "<a style='margin:0;' class='socialwiki_link' href=".$CFG->wwwroot."/mod/socialwiki/view.php?pageid=".$page->id.">".$page->title."</a>";
    }

    private function makeLikeLink($page) {
        global $CFG, $PAGE;
        $img;
        if(socialwiki_liked($this->uid, $page->id)) {
            $img = "likefilled.png";
        } else {
            $img = "hollowlike.png";
        }
        $liked_img = "<img style='width:22px; vertical-align:middle;' class='socialwiki_unlikeimg' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/".$img."'></img>";
        $likelink = "<a style='margin:0;' class='socialwiki_likelink socialwiki_link' href='".$CFG->wwwroot."/mod/socialwiki/like.php?pageid=".$page->id."&from=".urlencode($PAGE->url->out()."&option=$option")."'>".$liked_img."</a>";
        return $likelink;
    }

    private function makeUserColumn($page) {
        global $CFG;
        return "<span>".$this->makePageLink($page).$this->makeLikeLink($page)."</span>";
    }
}