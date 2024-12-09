$(document).ready(function () {
	(function poll() {
		setTimeout(function () {
			$.ajax({
				url: "ajax/poll.php",
				type: "GET",
				complete: function (data) {
					$("#notifications").html(data.responseText);
					poll();
					console.log("Polled");
				},
				timeout: 5000
			})
		}, 5000);
	})();
});