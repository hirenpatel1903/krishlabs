/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */
"use strict";

var updatePurchaseProduct = updatePurchaseProduct;
var productObj = productobj;
var productVariantUrl = productVariantUrl;


$('.input-daterange').datepicker({
    todayBtn : 'linked',
    format : 'dd-mm-yyyy',
    autoclose : true
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#previewImage').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

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

function parseSentenceForNumber(sentence) {
    var matches = sentence.replace(/,/g, '').match(/(\+|-)?((\d+(\.\d+)?)|(\.\d+))/);
    return matches && matches[0] || null;
}

function getRandomInt() {
    return Math.floor(Math.random() * Math.floor(9999999999999999));
}

function productItemDesign(productID,productType,productVariantID, productText) {
    var randID = getRandomInt();
    var quantity = 1;
    if ($('#productList tr:last').text() == '') {
        var lastTdNumber = 0;
    } else {
        var lastTdNumber = $("#productList tr:last td:eq(0)").text();
    }

    if (typeof (productObj) == 'object') {
        if (typeof (productObj[productID]) == 'object') {
            var productobjinfo = productObj[productID];
        } else {
            var productobjinfo = {'productID': productID, 'price': ''};
        }
    }


    lastTdNumber = parseInt(lastTdNumber);
    lastTdNumber++;

    var text = '<tr id="tr_' + randID + '" purchaseproductid="' + productID + '">';
    text += '<td>';
    text += lastTdNumber;
    text += '</td>';

    text += '<td>';
    text += '<span id="productName_' + randID + '">' + productText + '</span>';
    text += '<input type="hidden" id="producttype_' + randID + '" value="' + productType + '">';
    if (productType == 10){
        text += '<i class="pull-right fa fa-edit tip open-modal crosser-css" id="' + randID + '"   data-id ="' + productID + '" data-productunitprice-id="' + randID + '" data-product-barcode="' + productobjinfo.barcode + '" data-product="' + productobjinfo.name + '" title="Edit"></i>';
        text += '<input type="hidden" id="productvariant_' + randID + '" value="' + productVariantID + '">';
    }
    text += '</td>';

    text += '<td>';
    text += ('<input type="number" class="form-control change-productunitprice" id="productunitprice_'+randID+'" value="'+productobjinfo.cost+'"   data-productunitprice-id="'+randID+'">');
    text += '</td>';

    text += '<td>';
    text += ('<input type="number" class="form-control change-productquantity" id="productquantity_'+randID+'" value="'+quantity+'" data-productquantity-id="'+randID+'">' );
    text += '</td>';

    text += '<td id="producttotal_'+randID+'">';
    text += productobjinfo.cost;
    text += '</td>';

    text += '<td>';
    text += ('<a  href="#" class="btn btn-danger btn-sm deleteBtn margin-3px" id="productaction_'+randID+'" data-productaction-id="'+randID+'"><i class="fa fa-trash"></i></a>');
    text += '</td>';
    text += '</tr>';
    $('#totalQuantity').text(currencyConvert(parseFloat(quantity)));
    $('#totalSubtotal').text(currencyConvert(parseFloat(productobjinfo.cost)));
    return text;
}

function currencyConvert(data) {
    return data.toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
function lenCheckerWithoutParseFloat(data, len) {
    var retdata = 0;
    var lencount = 0;
    if(data.length > len) {
        lencount = (data.length - len);
        data = data.toString();
        data = data.slice(0, -lencount);
        retdata = data;
    } else {
        retdata = data;
    }

    return retdata;
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


function totalInfo() {
    var i = 1;
    var totalQuantity = 0;
    var totalSubtotal = 0;
    $('#productList tr').each(function(index, value) {
        if($(this).children().eq(3).children().val() != '' && $(this).children().eq(3).children().val() != null) {
            var quantity = parseFloat($(this).children().eq(3).children().val());
            var subtotal = parseFloat($(this).children().eq(4).text().replace(/,/gi, ''));
            totalQuantity += quantity;
            totalSubtotal += subtotal;
        }
    });

    $('#totalQuantity').text(currencyConvert(totalQuantity));
    $('#totalSubtotal').text(currencyConvert(totalSubtotal));
}

$('#product').on("change", function() {
    var productID   = $(this).val();
    if(productID != 0) {
        var productText = $(this).find(":selected").text();
        var productVariantID = $(this).find(":selected").attr('data-variant');
        var productType = $(this).find(":selected").attr('data-product-type');
        if(productType== 10){
            productVariant(productID,0);
        }
        var appendData  = productItemDesign(productID, productType, productVariantID, productText);
        $('#productList').append(appendData);
        totalInfo();

        $(this).val($("#product option:first").val());
    }
});

$('#shop_id').on("change", function() {
    var shopID   = $(this).val();
    if(shopID != 0) {
        $.ajax({
            type: 'POST',
            url: productShopUrl,
            data: {'shopID':shopID},
            success: function(data) {
                $('#product').html('0');
                $('#product').html(data);
            }
        });
    }
});


$(document).on('keyup change', '.change-productunitprice', function() {
    var productPrice =  toFixedVal($(this).val());
    var productPriceID = $(this).attr('data-productunitprice-id');
    var productQuantity = toFixedVal($('#productquantity_'+productPriceID).val());

    if(dotAndNumber(productPrice)) {
        if(productPrice.length > 15) {
            productPrice = lenChecker(productPrice, 15);
            $(this).val(productPrice);
        }

        if((productPrice != '' && productPrice != null) && (productQuantity != '' && productQuantity != null)) {
            if(floatChecker(productPrice)) {
                if(productPrice.length > 15) {
                    productPrice = lenChecker(productPrice, 15);
                    $(this).val(productPrice);
                    $('#producttotal_'+productPriceID).text(currencyConvert(productPrice*productQuantity));
                    totalInfo();
                } else {
                    $('#producttotal_'+productPriceID).text(currencyConvert(productPrice*productQuantity));
                    totalInfo();
                }
            }
        } else {
            $('#producttotal_'+productPriceID).text('0.00');
            totalInfo();
        }
    } else {
        var productPrice = parseSentenceForNumber($(this).val());
        $(this).val(productPrice);
    }
});

$(document).on('keyup change', '.change-productquantity', function() {
    var productQuantity =  toFixedVal($(this).val());
    var productQuantityID = $(this).attr('data-productquantity-id');
    var productPrice = toFixedVal($('#productunitprice_'+productQuantityID).val());

    if(dotAndNumber(productQuantity)) {
        if(productQuantity.length > 15) {
            productQuantity = lenChecker(productQuantity, 15);
            $(this).val(productQuantity);
        }

        if((productQuantity != '' && productQuantity != null) && (productPrice != '' && productPrice != null)) {
            if(floatChecker(productQuantity)) {
                if(productQuantity.length > 15) {
                    productQuantity = lenChecker(productQuantity, 15);
                    $(this).val(productQuantity);
                    $('#producttotal_'+productQuantityID).text(currencyConvert(productPrice*productQuantity));
                    totalInfo();
                } else {
                    $('#producttotal_'+productQuantityID).text(currencyConvert(productPrice*productQuantity));
                    totalInfo();
                }
            }
        } else {
            $('#producttotal_'+productQuantityID).text('0.00');
            totalInfo();
        }
    } else {
        var productQuantity = parseSentenceForNumber($(this).val());
        $(this).val(productQuantity);
    }
});

$(document).on('click', '.deleteBtn', function(e) {
    e.preventDefault();
    var productItemID = $(this).attr('data-productaction-id');
    $('#tr_'+productItemID).remove();

    var i = 1;
    $('#productList tr').each(function(index, value) {
        $(this).children().eq(0).text(i);
        i++;
    });
    totalInfo();
});


$(document).on('click', '#addPurchaseButton', function() {
    var error=0;

    var field = {
        'shop_id' : $('#shop_id').val(),
        'date' : $('#date').val(),
        'purchases_no' : $('#purchases_no').val(),
        'product' : $('#product').val(),
        'description' : $('#description').val(),
    };

    if (field['date'] === '') {
        $('#date').addClass('is-invalid');
        error++;
    } else {
        $('#date').removeClass('is-invalid');
    }
    if (field['shop_id'] === '' || field['shop_id'] === '0') {
        $('#shop_id').addClass('is-invalid');
        error++;
    } else {
        $('#shop_id').removeClass('is-invalid');
    }
    if (field['purchases_no'] === '') {
        $('#purchases_no').addClass('is-invalid');
        error++;
    } else {
        $('#purchases_no').removeClass('is-invalid');
    }

    var item = 1;
    var productitem = $('#productList tr').map(function(){
        var purchaseproductid = $(this).attr('purchaseproductid');
        var producttype         = $(this).children().eq(1).children().eq(1).val();
        if(producttype==10){
            var productvariant         = $(this).children().eq(1).children().eq(3).val();
        }
        var price         = $(this).children().eq(2).children().val();
        var quantity          = $(this).children().eq(3).children().val();

        if(price == ''  && quantity == '') {
            item = 0;
        }
        if(producttype==10){
            return { 'productID' : purchaseproductid, 'price': price, 'quantity' : quantity,'variantID': productvariant};
        }else{
            return { 'productID' : purchaseproductid, 'price': price, 'quantity' : quantity,'variantID': 0 };
        }
    }).get();

    if (typeof productitem == 'undefined' || productitem.length <= 0 || item == 0) {
        error++;

        iziToast.error({
            title: 'Error',
            message: 'Please add valid purchase items',
            position: 'topRight'
        });
    }

    var postData = {};

    if(error === 0) {
        $(this).attr('disabled', 'disabled');
        productitem = JSON.stringify(productitem);

        postData['shop_id']  = field['shop_id'];
        postData['date']  = field['date'];
        postData['purchases_no']  = field['purchases_no'];
        postData['description']  = field['description'];
        postData['productitem'] = productitem;
        postData['_method'] = 'PUT';
        postData['_token'] = csrf_token;

        ajaxCall(postData);
    }

});

function ajaxCall(passData) {
    $.ajax({
        type: 'POST',
        url: updatePurchaseProduct,
        data: passData,
        success: function(data) {
            if(data){
                window.location = indexPurchaseUrl;
            }
        }
    });
}

function productVariant(product,productvariantID) {
    $.ajax({
        type: 'POST',
        url: productVariantUrl,
        data: {'product':product,'productvariantID':productvariantID},
        success: function(data) {
            $('#ProductVariants').html('0');
            $('#ProductVariants').html(data);
        }
    });
}
let productRandomID = '';
let productName = '';
let productBarcode = '';
$(document).on("click", ".open-modal", function () {
    productRandomID = $(this).attr('data-productunitprice-id');
    var productvariantID = $('#productvariant_'+productRandomID).val();

    var product = $(this).attr('data-id');
    productVariant(product,productvariantID);
    var productPrice =  toFixedVal($('#productunitprice_'+productRandomID).val());
    var productQuantity = toFixedVal($('#productquantity_'+productRandomID).val());
    productName = $(this).attr( "data-product" );
    productBarcode = $(this).attr( "data-product-barcode" );
    $('#productTitle').text(productBarcode+'-'+productName);
    $('#pquantity').val(productQuantity);
    $('#pprice').val(productPrice);
    $('#productVariantModal').modal('show');
});

$(document).on("click", "#addProductVariant", function () {
    var productPrice =  toFixedVal($('#pprice').val());
    var productQuantity = toFixedVal($('#pquantity').val());
    var varintId = $('#ProductVariants').val();
    var varintText = $('#ProductVariants').find(":selected").text();
    $('#productvariant_'+productRandomID).val(varintId);
    $('#productquantity_'+productRandomID).val(productQuantity);
    $('#productName_'+productRandomID).text(productBarcode+varintId+'-'+productName+'('+varintText+')');
    $('#productunitprice_'+productRandomID).val(productPrice);
    $('#producttotal_'+productRandomID).text(currencyConvert(productPrice*productQuantity));
    totalInfo();
    $('#productVariantModal').modal('hide');
});

