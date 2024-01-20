/*=========================================================================================
    File Name: pickers.js
    Description: Pick a date/time Picker, Date Range Picker JS
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: Pixinvent
    Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
(function (window, document, $) {
    'use strict';

    /*******  Flatpickr  *****/
    var basicPickr = $('.flatpickr-basic'),
        timePickr = $('.flatpickr-time'),
        dateTimePickr = $('.flatpickr-date-time'),
        multiPickr = $('.flatpickr-multiple'),
        rangePickr = $('.flatpickr-range'),
        rangePickrV2 = $('.daterangepicker_v2'),
        humanFriendlyPickr = $('.flatpickr-human-friendly'),
        disabledRangePickr = $('.flatpickr-disabled-range'),
        inlineRangePickr = $('.flatpickr-inline');

    // Default
    if (basicPickr.length) {
        basicPickr.map(function (key, value) {
            let enableDate = $(value).attr('date-endable');
            if (enableDate) {
                value.flatpickr({
                    enable: [enableDate]
                });
            } else {
                value.flatpickr();
            }
        });
    }

    // Time
    if (timePickr.length) {
        timePickr.flatpickr({
            enableTime: true,
            noCalendar: true
        });
    }

    // Date & TIme
    if (dateTimePickr.length) {
        dateTimePickr.flatpickr({
            enableTime: true
        });
    }

    // Multiple Dates
    if (multiPickr.length) {
        multiPickr.flatpickr({
            weekNumbers: true,
            mode: 'multiple',
            minDate: 'today'
        });
    }

    // Range
    if (rangePickr.length) {
        rangePickr.flatpickr({
            mode: 'range'
        });
    }
    // Range
    if (rangePickrV2.length) {
        rangePickrV2.each(function () {
            let ele = $(this);
            let options = {
                'autoApply': true,
                'showCustomRangeLabel': false,
                'alwaysShowCalendars': true,
                'locale': {
                    "format": "YYYY-MM-DD",
                    "separator": " to ",
                    "daysOfWeek": ["CN", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy"],
                    "monthNames": ["Tháng một", "Tháng hai", "Tháng ba", "Tháng tư", "Tháng năm", "Tháng sáu", "Tháng bảy", "Tháng tám", "Tháng chín", "Tháng mười", "Tháng mười một", "Tháng mười hai"],
                },
            };

            if (ele.data('minDate')) {
                options['minDate'] = ele.data('minDate');
            }
            let showRanges = typeof ele.data('ranges') != 'undefined' ? ele.data('ranges') : true;
            if (showRanges) {
                options['ranges'] = {
                    'Hôm nay': [moment(), moment()],
                    'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    '7 ngày qua': [moment().subtract(6, 'days'), moment()],
                    '30 ngày qua': [moment().subtract(29, 'days'), moment()],
                    'Tháng này': [moment().startOf('month'), moment().endOf('month')],
                    'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                };
            }

            ele.daterangepicker(
                options,
                // function (start, end, label) {
                //     console.log('New date range selected: ' + start.format('DD/MM/YYYY') + ' to ' + end.format('DD/MM/YYYY') + ' (predefined range: ' + label + ')');
                // }
            );
        })
    }

    // Human Friendly
    if (humanFriendlyPickr.length) {
        humanFriendlyPickr.flatpickr({
            altInput: true,
            altFormat: 'F j, Y',
            dateFormat: 'Y-m-d'
        });
    }

    // Disabled Range
    if (disabledRangePickr.length) {
        disabledRangePickr.flatpickr({
            dateFormat: 'Y-m-d',
            disable: [
                {
                    from: new Date().fp_incr(2),
                    to: new Date().fp_incr(7)
                }
            ]
        });
    }

    // Inline
    if (inlineRangePickr.length) {
        inlineRangePickr.flatpickr({
            inline: true
        });
    }
    /*******  Pick-a-date Picker  *****/
    // Basic date
    $('.pickadate').pickadate();

    // Format Date Picker
    $('.format-picker').pickadate({
        format: 'mmmm, d, yyyy'
    });

    // Date limits
    $('.pickadate-limits').pickadate({
        min: [2019, 3, 20],
        max: [2019, 5, 28]
    });

    // Disabled Dates & Weeks

    $('.pickadate-disable').pickadate({
        disable: [1, [2019, 3, 6], [2019, 3, 20]]
    });

    // Picker Translations
    $('.pickadate-translations').pickadate({
        formatSubmit: 'dd/mm/yyyy',
        monthsFull: [
            'Janvier',
            'Février',
            'Mars',
            'Avril',
            'Mai',
            'Juin',
            'Juillet',
            'Août',
            'Septembre',
            'Octobre',
            'Novembre',
            'Décembre'
        ],
        monthsShort: ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'],
        weekdaysShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
        today: "aujourd'hui",
        clear: 'clair',
        close: 'Fermer'
    });

    // Month Select Picker
    $('.pickadate-months').pickadate({
        selectYears: false,
        selectMonths: true
    });

    // Month and Year Select Picker
    $('.pickadate-months-year').pickadate({
        selectYears: true,
        selectMonths: true
    });

    // Short String Date Picker
    $('.pickadate-short-string').pickadate({
        weekdaysShort: ['S', 'M', 'Tu', 'W', 'Th', 'F', 'S'],
        showMonthsShort: true
    });

    // Change first weekday
    $('.pickadate-firstday').pickadate({
        firstDay: 1
    });

    /*******    Pick-a-time Picker  *****/
    // Basic time
    $('.pickatime').pickatime();

    // Format options
    $('.pickatime-format').pickatime({
        // Escape any “rule” characters with an exclamation mark (!).
        format: 'T!ime selected: h:i a',
        formatLabel: 'HH:i a',
        formatSubmit: 'HH:i',
        hiddenPrefix: 'prefix__',
        hiddenSuffix: '__suffix'
    });

    // Format options
    $('.pickatime-formatlabel').pickatime({
        formatLabel: function (time) {
            var hours = (time.pick - this.get('now').pick) / 60,
                label = hours < 0 ? ' !hours to now' : hours > 0 ? ' !hours from now' : 'now';
            return 'h:i a <sm!all>' + (hours ? Math.abs(hours) : '') + label + '</sm!all>';
        }
    });

    // Min - Max Time to select
    $('.pickatime-min-max').pickatime({
        // Using Javascript
        min: new Date(2015, 3, 20, 7),
        max: new Date(2015, 7, 14, 18, 30)

        // Using Array
        // min: [7,30],
        // max: [14,0]
    });

    // Intervals
    $('.pickatime-intervals').pickatime({
        interval: 150
    });

    // Disable Time
    $('.pickatime-disable').pickatime({
        disable: [
            // Disable Using Integers
            3,
            5,
            7,
            13,
            17,
            21

            /* Using Array */
            // [0,30],
            // [2,0],
            // [8,30],
            // [9,0]
        ]
    });

    // Close on a user action
    $('.pickatime-close-action').pickatime({
        closeOnSelect: false,
        closeOnClear: false
    });
})(window, document, jQuery);
