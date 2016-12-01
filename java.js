$( document ).ready(function() {
	$( "#button" ).click(function(event) {
		alert("starting");
		var request = $.ajax({
			url: "fac.php",
			type: "POST",
			data: {
					"teacher_id": $( "#teacher_id" ).val(),
			},
			dataType: "html"
		});
		request.done(function(msg) {
			$( "#spot" ).html(msg);
			alert("done");
		});
		request.fail(function(msg) {
			alert("FAIL");
		});
		
		event.preventDefault();
	});
});
