
"use strict";

load_data();

$('#date-search').on('click', function () {
    let status = $('#status').val();
    $('#maintable').DataTable().destroy();
    load_data(status);
});

$('#refresh').on('click', function () {
  let activeStatus = $('#maintable').attr('data-status');
    $('#status').val(activeStatus);
    $('#maintable').DataTable().destroy();
    load_data();
});

function load_data(status = '') {
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {status : status}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'language_name', name: 'language_name' },
            { data: 'flag', name: 'flag' },
            { data: 'code', name: 'code' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
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
