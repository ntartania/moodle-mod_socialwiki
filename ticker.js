$( document ).ready( function() {
	
	setInterval(tickerUpdate, 10000);

	function tickerUpdate() {
		var time = $(".ticker_table").data("time");

		request = $.ajax({
	        url: "ticker.php",
	        type: "post",
	        data: {userid: userid, time: time, swid: swid}
	    });

	    request.done(function (response, textStatus, jqXHR){
	        $(".ticker_table").prepend(response);
	    });
	    $(".ticker_table").data('time', time+10);
	}

});

