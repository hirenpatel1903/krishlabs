/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

function load_data() {
    let shopid = $('#maintable').data('shopid');
    var table = $('#maintable').DataTable({
        processing : true,
        serverSide : true,
        ajax : {
            url : $('#maintable').attr('data-url'),
            data: {'shop_id': shopid}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'product', name: 'product' },
            { data: 'unit_price', name: 'unit_price' },
            { data: 'discount_price', name: 'discount_price' },
            { data: 'quantity', name: 'quantity' },
            { data: 'action', name: 'action' },
        ],
        "ordering" : false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if(!hidecolumn) {
        table.column( 4 ).visible( false );
    }
}

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})
