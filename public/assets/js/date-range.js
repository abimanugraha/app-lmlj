"use strict";
$('.daterange-cus').daterangepicker({
    locale: {format: 'YYYY-MM-DD'},
    drops: 'down',
    opens: 'right'
});
$('.daterange-btn').daterangepicker({
    "showDropdowns": true,
    "minYear": 2020,
ranges: {
    'Hari Ini'       : [moment(), moment()],
    'Minggu Ini' : [moment().subtract(6, 'days'), moment()],
    'Bulan Ini'  : [moment().startOf('month'), moment().endOf('month')],
    '30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
    'Tahun Ini'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
},
startDate: moment().subtract(29, 'days'),
endDate  : moment()
}, function (start, end) {
$('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
});