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
    private $view;

    public function __construct( $uid, $swid, $courseid, $cmid, $view = "") {
        $this->uid = $uid;
        $this->swid = $swid;
        $this->courseid= $courseid;
        $this->cmid= $cmid;
        $this->view = $view;
    }

    public function allVersionsTable() {
        $table = SOCIALWIKI_TABLE_ALL_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_get_page_list($this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "allVersionsTable");
        // return $pages;
    }

    public function likedVersionsTable() {
        $table = SOCIALWIKI_TABLE_LIKED_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_get_liked_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "likedVersionsTable");
    }

    public function favoriteVersionTable() {
        $table = SOCIALWIKI_TABLE_FAVORITE_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_get_user_favorites($this->uid, $this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "favoritedVersionsTable");
    }

    public function userCreatedTable() {
        $table = SOCIALWIKI_TABLE_USER_CREATED_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_user_authored_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "userCreatedTable");
    }

    public function newVersionTable() {
        $table = SOCIALWIKI_TABLE_NEW_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_get_latest_pages($this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "newVersionTable");
    }

    public function recomendedVersionTable() {
        $table = SOCIALWIKI_TABLE_RECOMENDED_VERSIONS;
        $t = socialwiki_table_is_enabled($this->uid, $table);
        if($t->enabled == 0) {
            return "";
        }
        $pages = socialwiki_get_recommended_pages($this->uid, $this->swid);
        $rows = $this->getPageRows($pages, $table);
        return $this->makeTable($rows, "recomendedVersionTable");
    }

    // public function popularPagesTable() {

    // }

    // public function popularAuthorTable() {

    // }

    private function getPageRows($pages, $table_id) {

        $rows = array();
        foreach ($pages as $title => $page) {
            $author = socialwiki_get_user_info($page->userid);
            $contributors = socialwiki_get_contributors($page->id);
            $peer = new peer($page->userid,
                             $this->swid,
                             $this->uid,
                             //socialwiki_get_user_count($swid),
                             null);

            $row = array();

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_TITLE);
            if ($e->enabled == ENABLE) {
                $row["Title"] = $this->makeUserColumn($page);
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS);
            if ($e->enabled == ENABLE) {
                $row["Contributers"] = fullname($author) . " and ".(count($contributors)-1)." others";
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_UPDATED);
            if ($e->enabled == ENABLE) {
                $row["Updated"] = strftime('%d %b %Y', $page->timecreated);
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_LIKES);
            if ($e->enabled == ENABLE) {
                $row["Likes"] = socialwiki_numlikes($page->id);
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_VIEWS);
            if ($e->enabled == ENABLE) {
                $row["Views"] = $page->pageviews;
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_FAVORITE);
            if ($e->enabled == ENABLE) {
                $row["Favorited By"] = count(socialwiki_get_favorites($page->id, $this->swid));
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX);
            if ($e->enabled == ENABLE) {
                $row["Author Popularity (Max)"] = $this->combine_indicators($page, "max", "peerpopularity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX);
            if ($e->enabled == ENABLE) {
                $row["Like Similarity (Max)"] = $this->combine_indicators($page, "max", "likesimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX);
            if ($e->enabled == ENABLE) {
                $row["Follow Similarity (Max)"] = $this->combine_indicators($page, "max", "followsimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX);
            if ($e->enabled == ENABLE) {
                $row["Network Distance (Max)"] = $this->combine_indicators($page, "max", "networkdistance");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN);
            if ($e->enabled == ENABLE) {
                $row["Author Popularity (Min)"] = $this->combine_indicators($page, "min", "peerpopularity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN);
            if ($e->enabled == ENABLE) {
                $row["Like Similarity (Min)"] = $this->combine_indicators($page, "min", "likesimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN);
            if ($e->enabled == ENABLE) {
                $row["Follow Similarity (Min)"] = $this->combine_indicators($page, "min", "followsimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN);
            if ($e->enabled == ENABLE) {
                $row["Network Distance (Min)"] = $this->combine_indicators($page, "min", "networkdistance");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG);
            if ($e->enabled == ENABLE) {
                $row["Author Popularity (Average)"] = $this->combine_indicators($page, "avg", "peerpopularity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG);
            if ($e->enabled == ENABLE) {
                $row["Like Similarity (Average)"] = $this->combine_indicators($page, "avg", "likesimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG);
            if ($e->enabled == ENABLE) {
                $row["Follow Similarity (Average)"] = $this->combine_indicators($page, "avg", "followsimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG);
            if ($e->enabled == ENABLE) {
                $row["Network Distance (Average)"] = $this->combine_indicators($page, "avg", "networkdistance");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM);
            if ($e->enabled == ENABLE) {
                $row["Author Popularity (Sum)"] = $this->combine_indicators($page, "sum", "peerpopularity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM);
            if ($e->enabled == ENABLE) {
                $row["Like Similarity (Sum)"] = $this->combine_indicators($page, "sum", "likesimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM);
            if ($e->enabled == ENABLE) {
                $row["Follow Similarity (Sum)"] = $this->combine_indicators($page, "sum", "followsimilarity");
            }

            $e = socialwiki_column_is_enabled($this->uid, $table_id, SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM);
            if ($e->enabled == ENABLE) {
                $row["Network Distance (Sum)"] = $this->combine_indicators($page, "sum", "networkdistance");
            }
            
            array_push($rows, $row);
        }
        return $rows;
    }

    private function makeTable($rows, $id) {
        $table = new SortableTable();

        foreach ($rows as $row) {
            $table->add_row($row);
        }
        return "<div id=\"$id\">".$table->get_table($id)."</div>";
    }

    /** combines trust indicators obtained from the peers who like a page
    *
    */
    private function combine_indicators($page, $reducer,$indicator){
        $likers = socialwiki_get_likers($page->id, $this->swid);

        $uservals = array();
        foreach($likers as $user_id){
            $user = socialwiki_get_user_info($user_id);
            $peer = new Peer($user->id, $this->swid, $this->uid);
        
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
        $likelink = "<a style='margin:0;' class='socialwiki_likelink socialwiki_link' href='".$CFG->wwwroot."/mod/socialwiki/like.php?pageid=".$page->id."&from=".urlencode($PAGE->url->out()."&tabid=".$this->view)."'>".$liked_img."</a>";
        return $likelink;
    }

    private function makeUserColumn($page) {
        global $CFG;
        return "<span>".$this->makePageLink($page).$this->makeLikeLink($page)."</span>";
    }
}