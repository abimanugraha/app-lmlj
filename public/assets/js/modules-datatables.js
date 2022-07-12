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
