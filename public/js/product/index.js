/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

$('#date-search').on('click', function () {
  let status = $('#status').val();
  let requests = $('#requested').val();
  $('#maintable').DataTable().destroy();
  load_data(status,requests);
});


$('#refresh').on('click', function () {
  let activeStatus = $('#maintable').attr('data-status');
  $('#status').val(activeStatus);
  $('#requests').val('');
  $('#maintable').DataTable().destroy();
  load_data();
});

function load_data(status = '',requests='') {
  var table = $('#maintable').DataTable({
    processing : true,
    serverSide : true,
    ajax : {
      url : $('#maintable').attr('data-url'),
      data : {status : status, requested : requests}
    },
    columns : [
      {data : 'id', name : 'id'},
      {data : 'name', name : 'name'},
      {data : 'unit', name : 'unit'},
      {data : 'categories', name : 'categories'},
      {data : 'cost', name : 'cost'},
      {data : 'price', name : 'price'},
      {data : 'status', name : 'status'},
      {data : 'action', name : 'action'},
    ],
    "ordering" : false
  });

  let hidecolumn = $('#maintable').data('hidecolumn');
  if(!hidecolumn) {
      table.column( 5 ).visible( false );
  }
}

$('#maintable').on('draw.dt', function () {
  $('[data-toggle="tooltip"]').tooltip();
})
