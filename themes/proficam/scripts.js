$(function () {
	$.getScript(BASE + "/_cdn/widgets/hellobar/hellobar.wc.js", function () {
			$("head").append("<link rel='stylesheet' href='" + BASE + "/_cdn/widgets/hellobar/hellobar.wc.css'/>");
		});

});