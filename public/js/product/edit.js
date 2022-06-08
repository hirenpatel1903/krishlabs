/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

var UnitShopUrl = UnitShopUrl;
var TaxShopUrl = TaxShopUrl;
var categoryShopUrl = categoryShopUrl;

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

if(jQuery().summernote) {
    $(".summernote").summernote({
        dialogsInBody: true,
        minHeight: 250,
    });
    $(".summernote-simple").summernote({
        dialogsInBody: true,
        minHeight: 150,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['para', ['paragraph']]
        ]
    });
}


$(function() {
    var checkBox = document.getElementById("checkbox-3");
    if (checkBox && checkBox.checked == true){
        $('#variantsShow').show('slow');
    } else {
        $('#variantsShow').hide('slow');
    }
});


function myFunction() {
    const checkBox = document.getElementById("checkbox-3");
    if (checkBox.checked == true){
        $('#variantsShow').show('slow');
    } else {
        $('#variantsShow').hide('slow');
    }
}


function variationItemDesign(name,price) {
    product_variation_count++;
    var markup = '';
    markup += '<tr>';
    markup += '<td>';
    markup += '<input type="text" name="variation['+product_variation_count+'][name]" placeholder="Name" value="'+name+'"  class="form-control form-control-sm">';
    markup +='</td>';
    markup +='<td>';
    markup += '<input type="number" name="variation['+product_variation_count+'][price]" placeholder="Price" value="'+price+'"  class="form-control form-control-sm change-productprice">';
    markup += '</td>';
    markup +='<td>';
    markup += '<button class="btn btn-danger btn-sm removeBtn">'
    markup += '<i class="fa fa-trash"></i>';
    markup += '</button>';
    markup += '</td>';
    markup += '</tr>';
    return markup;
}
function variationAdd(e){
    e.preventDefault();
    const name =     $('#variationName').val();
    const price =     $('#variationPrice').val();
    if(name && price) {
        $('#itemTable tbody tr:last').after(variationItemDesign(name, price));
        $('#variationName').val('');
        $('#variationPrice').val('');
    }
}

$(document).on('click','.removeBtn', function(event) {
    event.preventDefault();
    $(this).parent().parent().remove()
});


$(document).on('keyup', '.change-productprice', function() {
    var productPrice =  toFixedVal($(this).val());
    console.log($(this).val());

    $(this).val(productPrice);

    if(dotAndNumber(productPrice)) {
        if(productPrice.length > 15) {
            productPrice = lenChecker(productPrice, 15);
            $(this).val(productPrice);
        }

        if(productPrice != '' && productPrice != null) {
            if(floatChecker(productPrice)) {
                if(productPrice.length > 15) {
                    productPrice = lenChecker(productPrice, 15);
                    $(this).val(productPrice);
                }
            }
        }
    } else {
        var productPrice = parseSentenceForNumber(toFixedVal($(this).val()));
        $(this).val(productPrice);
    }
});

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function floatChecker(value) {
    var val = value;
    if(isNumeric(val)) {
        return true;
    } else {
        return false;
    }
}

function dotAndNumber(data) {
    var retArray = [];
    var fltFlag = true;
    if(data.length > 0) {
        for(var i = 0; i <= (data.length-1); i++) {
            if(i == 0 && data.charAt(i) == '.') {
                fltFlag = false;
                retArray.push(true);
            } else {
                if(data.charAt(i) == '.' && fltFlag == true) {
                    retArray.push(true);
                    fltFlag = false;
                } else {
                    if(isNumeric(data.charAt(i))) {
                        retArray.push(true);
                    } else {
                        retArray.push(false);
                    }
                }

            }
        }
    }

    if(jQuery.inArray(false, retArray) ==  -1) {
        return true;
    }
    return false;
}

function toFixedVal(x) {
    if (Math.abs(x) < 1.0) {
        var e = parseFloat(x.toString().split('e-')[1]);
        if (e) {
            x *= Math.pow(10,e-1);
            x = '0.' + (new Array(e)).join('0') + x.toString().substring(2);
        }
    } else {
        var e = parseFloat(x.toString().split('+')[1]);
        if (e > 20) {
            e -= 20;
            x /= Math.pow(10,e);
            x += (new Array(e+1)).join('0');
        }
    }
    return x;
}

function parseSentenceForNumber(sentence) {
    var matches = sentence.replace(/,/g, '').match(/(\+|-)?((\d+(\.\d+)?)|(\.\d+))/);
    return matches && matches[0] || null;
}

function lenChecker(data, len) {
    var retdata = 0;
    var lencount = 0;
    data = toFixedVal(data);
    if(data.length > len) {
        lencount = (data.length - len);
        data = data.toString();
        data = data.slice(0, -lencount);
        retdata = parseFloat(data);
    } else {
        retdata = parseFloat(data);
    }

    return toFixedVal(retdata);
}

$('#shop_id').on("change", function() {
    var shopID   = $(this).val();
    if(shopID != 0) {
        $.ajax({
            type: 'POST',
            url: UnitShopUrl,
            data: {'shop_id':shopID},
            success: function(data) {
                $('#unit').html('0');
                $('#unit').html(data);
            }
        });
        $.ajax({
            type: 'POST',
            url: TaxShopUrl,
            data: {'shop_id':shopID},
            success: function(data) {
                $('#tax_id').html('0');
                $('#tax_id').html(data);
            }
        });

        $.ajax({
            type: 'POST',
            url: categoryShopUrl,
            data: {'shop_id':shopID},
            success: function(data) {
                $('#categories').html('0');
                $('#categories').html(data);
            }
        });
    }
});
