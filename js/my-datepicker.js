console.log("TP#02");
jQuery(document).ready(function ($) {
	console.log("TP#03");
	// $.fn.datepicker.defaults.format = "dd/mm/yyyy";
	// $.fn.datepicker.defaults.autoclose = true;
	// $.fn.datepicker.defaults.language = "zh-TW";

	// var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
	// $.fn.bootstrapDP = datepicker; // give $().bootstrapDP the bootstrap-datepicker functionality

	$(".datepicker123").datepicker({
		dateFormat: "dd-mm-yy",
	});
	$(".datepicker123").click(() => {
		console.log("hello world!");
	});
	$.datepicker.setDefaults(
		$.extend(
			{
				dateFormat: "dd-mm-yy",
			},
			$.datepicker.regional["zh-TW"]
		)
	);
});
