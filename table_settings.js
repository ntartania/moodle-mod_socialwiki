$( document ).ready( function() {

	$(".settings_table_checkbox").change(function() {
	    if(this.checked) {
	    	// console.log(this);
	        // console.log("table "+$(this).data('table_id')+" checked");
	        settingsUpdate($(this).data('table_id'), null, true);
	    } else {
	    	// console.log("table "+$(this).data('table_id')+" unchecked");
	    	settingsUpdate($(this).data('table_id'), null, false);
	    }
	});

	$(".settings_column_checkbox").change(function() {
	    if(this.checked) {
	    	// console.log(this);
	        // console.log("table "+$(this).data('table_id')+" checked");
	        settingsUpdate($(this).data('table_id'), $(this).data('column_id'), true);
	    } else {
	    	// console.log("table "+$(this).data('table_id')+" unchecked");
	    	settingsUpdate($(this).data('table_id'), $(this).data('column_id'), false);
	    }
	});

	function settingsUpdate(table_id, column_id, enabled) {
		request = $.ajax({
	        url: "table_settings.php",
	        type: "post",
	        data: {
	        	table_id: table_id,
	        	column_id: column_id,
	        	enabled: enabled,
	        	userid: userid,
	        	swid: swid
	        }
	    });

	    request.done(function (response, textStatus, jqXHR){
	        console.log(response);
	    });
	}
});	


// $( document ).ready( function() {
	
// 	setInterval(tickerUpdate, 10000);

// 	function tickerUpdate() {
// 		var time = $(".ticker_table").data("time");

// 		request = $.ajax({
// 	        url: "ticker.php",
// 	        type: "post",
// 	        data: {userid: userid, time: time, swid: swid}
// 	    });

// 	    request.done(function (response, textStatus, jqXHR){
// 	        $(".ticker_table").prepend(response);
// 	    });
// 	    $(".ticker_table").data('time', time+10);
// 	}

// });

