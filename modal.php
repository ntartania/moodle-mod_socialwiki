<?php

require_once($CFG->dirroot . '/tag/lib.php');

class Modal
{
	private $data;
	private $title;
	private $modal_id;
	private $link_id;
	private $contents;

	private static $counter = 0;

	public static function get_html($contents, $modal_id, $link_id, $title = null, $data = array())
	{
		$modal = new Modal($contents, $modal_id, $link_id, $title, $data);
		self::$counter++;
		return $modal->generateModal();
	}

	public function __construct($contents, $modal_id, $link_id=null, $title = null, $data = array())
	{
		global $PAGE;

		$this->data = $data;
		$this->contents = $contents;
		$this->title = $title;
		$this->modal_id = $modal_id;
		$this->link_id = isset($link_id) ? $link_id : $modal_id."_link".$counter;
	}

	public function generateModal()
	{
		$html = $this->modalJS();
		$html .= html_writer::start_tag("div", array("id" => "$this->modal_id"));

		// $html .= html_writer::tag("p", "TEST", array());
		$html .= html_writer::tag("div", $this->contents, array());

		$html .= html_writer::end_tag("div");

		return $html;
	}

	public function getLink()
	{
		return $this->link_id;
	}

	private function modalJS()
	{
		global $PAGE;
		$script = "YUI().use('panel', 'dd-plugin', function (Y) {

			var addRowBtn".self::$counter."  = Y.one('#$this->link_id');
	    	var panel".self::$counter." = new Y.Panel({
		        srcNode      : '#$this->modal_id',
		        headerContent: '$this->title',
		        centered     : true,
		        visible      : false,
		        render       : true,
		        zIndex		 : 900,
		        modal 		 : true,
		        hideOn: [
		            {
		                eventName: 'clickoutside'
		            }
		        ],
				plugins      : [Y.Plugin.Drag]
		    });

		    addRowBtn".self::$counter.".on('click', function (e) {
		        panel".self::$counter.".show();
		    });

		});";
		return html_writer::tag("script", $script, array());
	}

    
}