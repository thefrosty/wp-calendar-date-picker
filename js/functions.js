jQuery(document).ready(function($) {
		
	var time = $('#timestampdiv'),
		date;
	
	var $month 	= $('select[name="mm"]'),
		$day 	= $('input[name="jj"]'),
		$year 	= $('input[name="aa"]'),
		$hour	= $('input[name="hh"]'),
		$minute	= $('input[name="mn"]');
	
	if ( time.length > 0 ) {
		time.prepend('<input type="text" autocomplete="off" maxlength="16" size="44" value="" name="fulldate" placeholder="mm/dd/yyyy hh:mm" style="width:' + time.css('width') + '" />');
	}
	
	$('input[name="fulldate"]').datetimepicker({
		dateFormat	: "mm/dd/yy",
		timeFormat	: "HH:mm",
		onSelect	: function(dateText, inst) {
			var $this = $(this);
			
			/**
			 * Replace the space between the date and time.
			 * Replace the colon with a forward slash.
			 * Split all slashed into an Array.
			 *
			 * @ref http://stackoverflow.com/questions/5177702/how-to-break-date-values-in-jquery-ui-date-picker
			 * @ref http://stackoverflow.com/questions/5963182/how-to-remove-spaces-from-a-string-using-javascript
			 */
			date = dateText;
			date = date.replace(/\s+/g, '/');
			date = date.replace(':', '/');
			date = date.split('/');
			
//			console.log( value );
			
			$month.val(date[0]);
			$day.val(date[1]);
			$year.val(date[2]);
			$hour.val(date[3]);
			$minute.val(date[4]);
		}
	});
	
	/* Day */
	$day.datepicker({
		dateFormat: "dd"
	});
	
	/* Year */
	$year.datepicker({
		dateFormat: "yy"
	});
	
	/* Hour */
	$hour.timepicker({
		timeFormat: "HH",
		showMinute: false
	});
	
	/* Minute */
	$minute.timepicker({
		timeFormat: "mm",
		showHour: false
	});
	
	// Wrap date picker in class to narrow the scope of jQuery UI CSS and prevent conflicts
	$('#ui-datepicker-div').wrap('<div class="calendar-date-picker" />');
		
});