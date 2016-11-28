$( document ).ready(function() {
	$( "#submit" ).click(function(event) {
		var request = $.ajax({
			url: "response.php",
			type: "POST",
			data: {
					"teacher": $( "#teacher" ).val(),
			},
			dataType: "html"
		});
		request.done(function(msg) {
			$( "#faculty" ).html(msg);
		});
		request.fail(function(msg) {
			alert("FAIL");
		});
		
		event.preventDefault();
	});
});
