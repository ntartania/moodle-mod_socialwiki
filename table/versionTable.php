<?php

global $CFG, $PAGE, $USER;
require_once($CFG->dirroot . "/mod/socialwiki/locallib.php");
require_once($CFG->dirroot . "/mod/socialwiki/sortableTable/sortableTable.php");
require_once($CFG->dirroot . "/mod/socialwiki/table/table.php");

//$tabletype = required_param('typeid', PARAM_TEXT);



/***
* how to do this: 
* 1 - get a list of pages from DB.
* 2 - choose the headers you want, put them in an array
* 3 - pass to function: it puts the data into a table.
*/
class versionTable extends socialwiki_table {

	//$uid and swid in parent class
	private $allpeers; //maps peerid to peer object for all peers
	private $allpages; // maps pageid to page object, with additional field $p->likers containing array of likers (peerids)
	//private $headers;


	/*private $col_names = array(
		"Name",					//TODO: make these all "getString()"
		"Social Distance",
		"Number of Followers",
		"Like Similarity",
		"Follow Similarity",
	);*/

	public function __construct($uid, $swid, $pages, $headers) {
		parent::__construct($uid, $swid, $headers);
		//$this->allpages = $pages;
		$this->get_all_likers($pages); //get all peers involved, store info in $this->allpages and this->allpeers
		// get_table_data(); ?

	}

	public function set_headers($h){
		$this->headers= $h;
	}
	/*private getPeerfromId($pid){
		return $allpeers[$pid];
	}*/

	/**
	* get table data structure from spec:
	* @param pages: a selected list of pages
	* @param headers: requested column headers
	* @return an array of rows, each row being an array of head=>value pairs
	*/
	protected function get_table_data(){
		Global $CFG;

		//$number_of_users = socialwiki_get_user_count($this->swid); //total number of users is used with followers data
		$me = $this->uid;
		$swid = $this->swid;
		$www = $CFG->wwwroot;

		$table = array();

        //$option=optional_param('option', null, PARAM_INT); //?

        foreach ($this->allpages as $page) {
            $user = socialwiki_get_user_info($page->userid);
            $peer = new peer($page->userid,
                             $this->swid,
                             $this->uid,
                             //socialwiki_get_user_count($swid),
                             null);
            $updated = strftime('%d %b %Y', $page->timemodified);
            $created = strftime('%d %b %Y', $page->timecreated);

            $views = $page->pageviews;
            $likes = socialwiki_numlikes($page->id);

            //////get all contributors
            $contributors = socialwiki_get_contributors($page->id);
            
            $firstctr = fullname(socialwiki_get_user_info(array_pop($contributors)));
            $num = count ($contributors);
            if ($num ==1 ){
            	$firstctr .= " and 1 other";
            } else if ($num >1){
            	$firstctr .= " and ".$num." others.";
            }
                                
            $ctr = "";
            foreach($contributors as $c) {
                    $ctr .= fullname(socialwiki_get_user_info($c)).'\n';
            }
           
            $contrib_string = "<a title='$ctr'>$firstctr</a>";

            //$followlink;
            $likelink;

            //TODO: show contributors
            /*if(socialwiki_is_following($USER->id,$page->userid,$swid))
            {
                $img = "<img style='width:22px; vertical-align:middle;' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/man-minus.png'></img>";
                $followlink = "<a style='margin:0;'   class='socialwiki_unfollowlink socialwiki_link' href='".$CFG->wwwroot."/mod/socialwiki/follow.php?user2=".$page->userid."&from=".urlencode($PAGE->url->out()."&option=$option")."&swid=".$swid."&option=$option'>".$img."</a>";
            } else {
                $img = "<img style='width:22px; vertical-align:middle;' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/man-plus.png'></img>";
                $followlink = "<a style='margin:0;' class='socialwiki_followlink socialwiki_link' href='".$CFG->wwwroot."/mod/socialwiki/follow.php?user2=".$page->userid."&from=".urlencode($PAGE->url->out()."&option=$option")."&swid=".$swid."'>".$img."</a>";
            } */  

            $linkpage = "<a style='margin:0;' class='socialwiki_link' href=".$CFG->wwwroot."/mod/socialwiki/view.php?pageid=".$page->id.">".$page->title."</a>";
            
            if(socialwiki_liked($this->uid, $page->id)) {
                $unlikeimg = "<img style='width:22px; vertical-align:middle;' class='socialwiki_unlikeimg unlikeimg_".$page->id."' alt='unlikeimg_".$page->id."' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/likefilled.png'></img>";
                $likeimg = "<img style='width:22px; vertical-align:middle; display:none;' class='socialwiki_likeimg likeimg_".$page->id."' alt='likeimg_".$page->id."' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/hollowlike.png'></img>";
            } else {
                
                $unlikeimg = "<img style='width:22px; vertical-align:middle; display:none;' class='socialwiki_unlikeimg unlikeimg_".$page->id."'  alt='unlikeimg_".$page->id."' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/likefilled.png'></img>";
                $likeimg = "<img style='width:22px; vertical-align:middle;' class='socialwiki_likeimg likeimg_".$page->id."'  alt='likeimg_".$page->id."' src='".$CFG->wwwroot."/mod/socialwiki/img/icons/hollowlike.png'></img>";
            }

            //$name = "<a style='margin:0;' class='socialwiki_link' href='".$CFG->wwwroot."/mod/socialwiki/viewuserpages.php?userid=".$user->id."&subwikiid=".$swid."'>".fullname($user)."</a>";

            /////////// favorites
            $favorites = socialwiki_get_favorites($page->id, $swid);

            $fav = "";


            $firstfav = "";


            if(count($favorites) > 0) {
                $firstfav = fullname(array_shift($favorites));
                if(count($favorites) > 0) {
                    $firstfav .= " and ".count($favorites)." others";
                    
                    foreach($favorites as $f) {
                        $fav .= fullname($f).'\n';
                    }
                }
            }

            $favdiv = "<a href='#' title='$fav'>$firstfav</a>";

            $combiner = "max "; //TODO: make changeable, make constants

            /*trust indicators*/
            $peerpop = $this->combine_indicators($page, $combiner, "peerpopularity");
            $likesim = $this->combine_indicators($page, $combiner, "likesimilarity");
            $followsim = $this->combine_indicators($page, $combiner, "followsimilarity");
            $distance = $this->combine_indicators($page, $combiner, "networkdistance");


            $row = array(
                get_string('title', 'socialwiki') => "<div style='white-space: nowrap; width:100%;'>$likeimg$unlikeimg$linkpage</div>",//$likelink$unlikelink$linkpage</div>",
                get_string('contributors', 'socialwiki') => $contrib_string,
                //get_string('created', 'socialwiki') => "$created",
                get_string('updated', 'socialwiki') => "$updated",
                get_string('likes', 'socialwiki') => "$likes",
                get_string('views', 'socialwiki') => "$views",
                get_string('favorite','socialwiki') => $favdiv,
            	get_string('popularity','socialwiki') => "$peerpop",
            	get_string('likesim','socialwiki') => "$likesim",
            	get_string('followsim','socialwiki') => "$followsim",
                get_string('networkdistance','socialwiki') => "$distance"
                );
        ////////// add trust values

            $table[] = array_intersect_key($row, array_flip($this->headers)); // filter to get only the requested headers
        }
        
        /*$table_markup = "";
        
        $table_markup .= "<div class='yui3-js-endable'>";
        $table_markup .= $table->get_table($table_id);
        $table_markup .= "<div id='$table_id' class='table_region'></div>";
        $table_markup .= "</div>";
		*/
        return $table;
    }

    /** combines trust indicators obtained from the peers who like a page
    *
    */
    private function combine_indicators($a, $b,$c){
    	return 0.5;
    }
    /** from list of pages, get list of users that like any of the pages, with all their relevant info
    * adds the pages to $this->allpages and the peers to the existing list of peers
    */
    private function get_all_likers($pagelist){
    	$peerids = array();
    	//$this->allpages = []; //reboot this!
    	foreach ($pagelist as $p){
    		$likers = socialwiki_get_likers($p->id, $this->swid); //gets list of user likers
    		$p->likers = $likers;
    		$this->allpages[$p->id]=$p ; //add pages to list
    		$peerids = array_unique(array_merge($peerids, $likers));
    	}
    	
    	$this->allpeers = $this->get_peers($peerids); //see below 
    	//TODO: need to merge into existing list instead of overwriting
    }

    //get peers from user ids, with all relevant info: used by above
	private function get_peers($ids){		
		//$number_of_users = socialwiki_get_user_count($this->swid);

		$me = $this->uid;
		$swid = $this->swid;

		//define function to get peer from userid
		$build_function = function ($id) use ($me, $swid){
							return new peer($id, $swid, $me, null);
							};
		return array_combine($ids, array_map($build_function, $ids));
		//will return an associative array with peerid => peer object for each peerid
	}

	//todo: make configurable
    public static function getHeaders($type){
        switch($type){
            case "version":
                return array(
                    get_string('title', 'socialwiki'),
                    get_string('contributors', 'socialwiki'),
                    get_string('updated', 'socialwiki'),
                    get_string('likes', 'socialwiki'),
                    get_string('views', 'socialwiki'),
                    get_string('favorite','socialwiki'),
                    get_string('popularity','socialwiki'),
                    get_string('likesim','socialwiki'),
                    get_string('followsim','socialwiki'),
                    get_string('networkdistance','socialwiki')
                );
            case "mystuff":
                return array(
                    get_string('title', 'socialwiki'),
                    get_string('contributors', 'socialwiki'),
                    get_string('updated', 'socialwiki'),
                    get_string('likes', 'socialwiki'),
                    get_string('views', 'socialwiki'),
                    get_string('favorite','socialwiki')
                );
            case "user":
                return array(
                    get_string('popularity','socialwiki'),
                    get_string('likesim','socialwiki'),
                    get_string('followsim','socialwiki'),
                    get_string('networkdistance','socialwiki')
                );
            default:
                return array('error in getHeaders:'.$type);
        }

    }
	//=======================================================================
	// factory method
	//=======================================================================

    public static function makeFavouritesTable($uid, $swid){
    	if($favs = socialwiki_get_user_favorites($uid, $swid)) {
            $headers = versionTable::getHeaders('mystuff');
            return new versionTable($uid, $swid,$favs, $headers);
        } else {
            return null;
        }
    }

    public static function makeRecentLikesTable($uid, $swid){
    	$likes = socialwiki_get_liked_pages($uid, $swid);
    	if(!empty($likes)){
        	$headers = versionTable::getHeaders('mystuff');
    		return new versionTable($uid, $swid,$likes, $headers);
    	} else {
    		return null;
    	}
    }

    public static function makeNewPageVersionsTable($uid, $swid){
    	$pages = socialwiki_get_updated_pages_by_subwiki($swid);

        if ($pages) {
            
         	$headers = versionTable::getHeaders('version');
            
 		   	return new versionTable($uid, $swid,$pages, $headers);
 		}
 		return null;
    }

 	public static function makeAllVersionsTable($uid, $swid){
 	    $pages = socialwiki_get_page_list($swid);

        if (!empty($pages)) {
            $headers = versionTable::getHeaders('mystuff');
            return new versionTable($uid, $swid, $pages, $headers);
        }
    }


    //public static function 

	public static function makeHTMLVersionTable($uid, $swid, $pages,$headers, $tabid) {
		Global $USER;

		$thetable = new versionTable($uid, $swid, $pages, $headers);
		//echo $thetable;
		return $thetable->get_as_HTML($tabid); // defined in parent class

    }
 	

   

	
}