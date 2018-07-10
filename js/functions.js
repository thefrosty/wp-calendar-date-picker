/* global jQuery, wpCalendarDatePicker */
(function ($) {
  'use strict';

  var component = {
    $timestampdiv: $('#timestampdiv'),
    dateText: {}
  };

  /**
   * Init component.
   */
  component.init = function () {
    $(function () {
      component.bindClick();
      component.$month = $('select[name="mm"]');
      component.$day = $('input[name="jj"]');
      component.$year = $('input[name="aa"]');
      component.$hour = $('input[name="hh"]');
      component.$minute = $('input[name="mn"]');
    });
  };

  component.bindClick = function () {
    component.$timestampdiv.siblings('a.edit-timestamp').on('click', function () {
      if (component.$timestampdiv.find('input[name="fulldate"]').length === 0) {
        component.$timestampdiv
          .prepend('<input type="text" autocomplete="off" maxlength="16" size="44" value="" name="fulldate" placeholder="mm/dd/yyyy hh:mm" style="width:' + component.$timestampdiv.css('width') + '" />');
      }
      component.setDateTimePicker();
      component.setDateValues();
    });
  };

  component.setDateTimePicker = function () {
    $('input[name="fulldate"]').datetimepicker({
      dateFormat: "mm/dd/yy",
      timeFormat: "HH:mm",
      onSelect: function (dateText) {
        /**
         * Replace the space between the date and time.
         * Replace the colon with a forward slash.
         * Split all slashed into an Array.
         *
         * @ref http://stackoverflow.com/questions/5177702/how-to-break-date-values-in-jquery-ui-date-picker
         * @ref http://stackoverflow.com/questions/5963182/how-to-remove-spaces-from-a-string-using-javascript
         */
        component.dateText = dateText;
        component.dateText = component.dateText.replace(/\s+/g, '/');
        component.dateText = component.dateText.replace(':', '/');
        component.dateText = component.dateText.split('/');

        component.$month.val(component.dateText[0]);
        component.$day.val(component.dateText[1]);
        component.$year.val(component.dateText[2]);
        component.$hour.val(component.dateText[3]);
        component.$minute.val(component.dateText[4]);
      }
    });

    // Wrap date picker in class to narrow the scope of jQuery UI CSS and prevent conflicts
    $('#ui-datepicker-div').wrap('<div class="calendar-date-picker" />');
  };

  component.setDateValues = function () {
    component.$day.datepicker({
      dateFormat: "dd"
    });

    component.$year.datepicker({
      dateFormat: "yy"
    });

    component.$hour.timepicker({
      timeFormat: "HH",
      showMinute: false
    });

    component.$minute.timepicker({
      timeFormat: "mm",
      showHour: false
    });
  };

  component.init();

})(jQuery);