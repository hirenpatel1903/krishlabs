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
        columns : [
            {data : 'id', name : 'id'},
            {data : 'sale_no', name : 'sale_no'},
            {data : 'customer_id', name : 'customer_id'},
            {data : 'date', name : 'date'},
            {data : 'sub_total', name : 'sub_total'},
            {data : 'paid', name : 'paid'},
            {data : 'action', name : 'action'},
        ],
        "ordering" : false
    });
}

$(document).ready(function(){
    $("#maintable").on("click", ".remove-record", function(){
        var url = $(this).attr('data-url');
        $(".remove-record-model").attr("action",url);
        $('body').find('.remove-record-model').append('<input name="_method" type="hidden" value="DELETE">');
    });

    $('.remove-data-from-delete-form').on("click", function() {
        $('body').find('.remove-record-model').find( "input" ).remove();
    });

});
