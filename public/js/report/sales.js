/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.datepicker').datepicker({
    todayBtn : 'linked',
    format : 'dd-mm-yyyy',
    autoclose : true
});

function printDiv(divID) {
    var oldPage = document.body.innerHTML;
    var divElements = document.getElementById(divID).innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";

    window.print();
    document.body.innerHTML = oldPage;
    window.location.reload();
}
