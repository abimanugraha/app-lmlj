"use strict";

$("[data-checkboxes]").each(function() {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function() {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if(role == 'dad') {
      if(me.is(':checked')) {
        all.prop('checked', true);
      }else{
        all.prop('checked', false);
      }
    }else{
      if(checked_length >= total) {
        dad.prop('checked', true);
      }else{
        dad.prop('checked', false);
      }
    }
  });
});

$("#table-1").dataTable({
  pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
  "columnDefs": [
    { "sortable": false, "targets": [2,3],max :5, }
  ]
});
$("#table-2").dataTable({
  pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
  "columnDefs": [
    { "sortable": false, "targets": [0,2,3] }
  ]
});

var tableHistory = $("#table-history").dataTable({
  pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
  "columnDefs": [
    { "sortable": true, "targets": [0,2,3] }
  ]
});

var minDate, maxDate;

// Custom filtering function which will search data in column four between two values

// $.fn.dataTableExt.afnFiltering.push(
//   function( settings, data, dataIndex ) {
//       var min = new Date(minDate);
//       var max = new Date(maxDate);
//       var date = new Date( data[0] );
//       console.log(date);
//       // console.log(min);

//       if (
//           ( min === null && max === null ) ||
//           ( min === null && date <= max ) ||
//           ( min <= date   && max === null ) ||
//           ( min <= date   && date <= max )
//       ) {
//           return true;
//       }
//       return false;
//   }
// );

$(".daterangepicker-field").daterangepicker({
  forceUpdate: false,
  orientation: 'left',
  callback: function(startDate, endDate, period) {
      console.log(startDate.format('DD MM YYYY'));
      var title = startDate.format('L') + ' – ' + endDate.format('L');
      // $(this).html(`<i class="fas fa-calendar"></i> ` + title)
      if ($('#filter-date')) {
          $('#filter-date').remove();
      }
      $('#filtered').append(`<span id="filter-date" class="badge badge-light">${title}</span>`)

      minDate = startDate;
      maxDate = endDate;

      // Refilter the table
      // console.log(tableHistory)
      tableHistory.fnFilter();

  }
});



