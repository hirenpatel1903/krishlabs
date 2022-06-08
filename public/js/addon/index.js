/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$(document).on('click', '#DeleteModalClick', function(event) {
    $('#DeleteModal').modal('show');
    let href = $(this).attr('data-attr');
    let title = $(this).attr('data-title');
    $("#deleteForm").attr('action', href);
    $("#fromTitle").text('Are you sure you want to delete '+title+' ?');
});
