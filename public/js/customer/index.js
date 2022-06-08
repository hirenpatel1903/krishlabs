
"use strict";

$(function() {
    var table = $('#maintable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $('#maintable').attr('data-url'),
        columns: [
            { data: 'id', name: 'id' },
            { data: 'image', name: 'image' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'credit', name: 'credit' },
            { data: 'action', name: 'action' },
        ],
        "ordering": false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if(!hidecolumn) {
        table.column( 5 ).visible( false );
    }

});

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
