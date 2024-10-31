(function ($) {
    'use strict';

    /**
    * All of the code for your public-facing JavaScript source
    * should reside in this file.
    *
    * Note that this assume you're going to use jQuery, so it prepares
    * the $ function reference to be used within the scope of this
    * function.
    *
    * From here, you're able to define handlers for when the DOM is
    * ready:
    *
    * $(function() {
    *
    * });
    *
    * Or when the window is loaded:
    *
    * $( window ).load(function() {
    *
    * });
    *
    * ...and so on.
    *
    * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
    * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
    * be doing this, we should try to minimize doing that in our own work.
    */

    $(document).ready(function () {
        try {

            // DEFAULT DATE TIMES
            var StartDT = moment().add(2, 'hours').startOf('hour');
            var EndDT = moment().add(2, 'hours').startOf('hour').add(1, 'days');

            // COMBINED DATE AND TIME CONTROLS
            $('.PickupDT').datetimepicker({
                sideBySide: true,
                focusOnShow: false,
                locale: 'en',
                defaultDate: StartDT,
                stepping: 15
            });

            $('.ReturnDT').datetimepicker({
                sideBySide: true,
                focusOnShow: false,
                locale: 'en',
                defaultDate: EndDT,
                minDate: EndDT,
                stepping: 15
            });

            $(".PickupDT").on("dp.change", function (e) {
                $('.ReturnDT').data("DateTimePicker").minDate(e.date.add(1, 'days'));
            });



            // SEPARATE DATE AND TIME CONTROLS

            $('.PickupDate').datetimepicker({
                format: 'L',
                defaultDate: StartDT,
                minDate: StartDT
            });

            $('.ReturnDate').datetimepicker({
                format: 'L',
                defaultDate: EndDT,
                minDate: EndDT
            });

            $('.PickupTime').datetimepicker({
                format: 'LT',
                showClose: true,
                toolbarPlacement: 'bottom',
                defaultDate: StartDT,
                stepping: 15,
                icons: { close: 'glyphicon glyphicon-ok-sign' }
            });

            $('.ReturnTime').datetimepicker({
                format: 'LT',
                showClose: true,
                toolbarPlacement: 'bottom',
                defaultDate: EndDT,
                minDate: EndDT,
                stepping: 15,
                icons: { close: 'glyphicon glyphicon-ok-sign' }
            });

            $(".PickupDate").on("dp.change", function (e) {
                UpdateMinDate(e);
            });

            $(".PickupTime").on("dp.change", function (e) {
                UpdateMinDate(e);
            });

            $(".ReturnDate").on("dp.change", function (e) {
                UpdateMinDate(e);
            });

            $(".ReturnTime").on("dp.change", function (e) {
                UpdateMinDate(e);
            });

        }
        catch (err) {
            window.alert(err.message);
        }
    });

    function UpdateMinDate(e) {
        var pd = $('.PickupDate').data("DateTimePicker").date();
        var pt = $('.PickupTime').data("DateTimePicker").date();
        var pdt = moment(new Date(pd.year(), pd.month(), pd.date(), pt.hour(), pt.minute()));

        var rd = $('.ReturnDate').data("DateTimePicker").date();
        var rt = $('.ReturnTime').data("DateTimePicker").date();
        var rdt = moment(new Date(rd.year(), rd.month(), rd.date(), rt.hour(), rt.minute()));

        $('.ReturnDate').data("DateTimePicker").minDate(pdt);
        if (rdt.isSameOrBefore(pdt))
            $('.ReturnTime').data("DateTimePicker").minDate(pdt.add(1, 'hours'));
        else
            $('.ReturnTime').data("DateTimePicker").minDate(pdt);
    }

})(jQuery);
