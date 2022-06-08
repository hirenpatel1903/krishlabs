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
    $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data : {status : status}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'product', name: 'product' },
            { data: 'unit', name: 'unit' },
            { data: 'sale_qty', name: 'sale_qty' },
            { data: 'total_qty', name: 'total_qty' },
            { data: 'stock_qty', name: 'stock_qty' },
        ],
        "ordering" : false
    });
}

