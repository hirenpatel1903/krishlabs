"use strict";
function printOrder() {
    printElement( document.getElementById('print_order_body') );
}
function printBill() {
    printElement( document.getElementById('print_bill_body'));
}

function printElement(elem) {
    var domClone = elem.cloneNode(true);

    var $printSection = document.getElementById("printSection");

    if (!$printSection) {
        var $printSection = document.createElement("div");
        $printSection.id = "printSection";
        document.body.appendChild($printSection);
    }

    $printSection.innerHTML = "";
    $printSection.appendChild(domClone);
    window.print();
}

var currentDate = function () {
    let x = new Date();
    let date = x.toDateString() + ', ' + x.toLocaleTimeString();
    return date;
}
$('.currentDate').text(currentDate());

$('#customerModal').appendTo('body');
$('#sellGCModal').appendTo('body');
$('#holdModal').appendTo('body');
$('#discountModal').appendTo('body');
$('#registerDetailsModal').appendTo('body');
$('#todaySaleModal').appendTo('body');
$('#closeRgModal').appendTo('body');

$('#add_tax').on("click", function() {
    $('#orderTaxModal').appendTo('body').modal();
});

$('#cancel-order').on("click", function() {
    if (carts.length == 0) {
        $("#actionError").appendTo('body').modal();
    } else {
        $('#cancelOrder').appendTo('body').modal();
    }
});

$('#payment').on("click", function() {
    if (carts.length == 0) {
        $("#actionError").appendTo('body').modal();
    } else {
        $("#payModal").appendTo('body').modal();
    }
});

$('#print_bill').on("click", function() {
    if (carts.length == 0) {
        $("#actionError").appendTo('body').modal();
    } else {
        $("#printBillModal").appendTo('body').modal();
    }
});

$('#print_order').on("click", function() {
    if (carts.length == 0) {
        $("#actionError").appendTo('body').modal();
    } else {
        carts.forEach((cart, index) => {
            index += 1
            $('#order-table > tbody').append(
                `
                <tr class="bb" data-item-id="${index}">
                    <td>#${index} ${cart.item.name} (${cart.item.value})</td>
                    <td>[ ${cart.qty} ]</td>
                </tr>
                `
            );
        });
        $("#printOrderModal").appendTo('body').modal();
    }
});
var openCartItem = function(id) {
    editCartItem(id);
    $('#editCartItem').appendTo('body').modal();
};

var orderTax = 0.05;
$('#updateTax').on("click", function() {
    let value = $('#get_tax').val();
    orderTax = parseInt(value) / 100;
    updateOrderData();
    $('#orderTaxModal').modal("hide")
});


var productObj = productobj;
var productVariantUrl = productVariantUrl;


$('.addProduct').on("click", function() {
    let productID = $(this).attr('id');

    if (typeof (productObj) == 'object') {
        if (typeof (productObj[productID]) == 'object') {
            var productobjinfo = productObj[productID];
        } else {
            var productobjinfo = {'productID': productID, 'price': ''};
        }
    }
    addToCart(productobjinfo,'');
});

var carts = [];

function addToCart(product,variation) {
    if (carts.length == 0) {
        carts = [
            {
                item: product,
                qty: 1,
                subTotal: product.price,
                productType:5,
                variation:variation,
            }
        ];
        refreshTable();
    } else {
        var itemNotFound = true;
        carts.forEach(cart => {
            if (cart.item.id === product.id) {
                cart.qty += 1;
                cart.subTotal = cart.qty * cart.item.price;
                itemNotFound = false;
                refreshTable();
            }
        });
        if ( itemNotFound ) {
            carts.push({
                item: product,
                qty: 1,
                subTotal: product.price,
            });
            refreshTable();
        }
    }
}
function removeItem(id) {

    var index = carts.map(x => {
        return x.Id;
      }).indexOf(id);

      carts.splice(index, 1);

      refreshTable();
      updateOrderData();

};
function delAllItem() {

    carts = [];

      refreshTable();
      updateOrderData();

};
function addCartTable() {
    carts.forEach((cart, index ) => {
        index += 1
        $('#posTable > tbody').prepend(
            `
<tr data-item-id="${index}">
                <td>
                    <button type="button" data-item-id="${index}" onclick="openCartItem('${cart.item.id}')" class="btn bg-purple btn-block px-0 btn-small">
                        <span class="sname" id="">${cart.item.name} (${cart.item.value})</span>
                    </button>
                </td>
                <td class="text-right">
                    <span class="text-right">${cart.item.price}</span>
                </td>
                <td>
                    <input class="form-control text-center px-0" type="text" value="${cart.qty}" data-item-id="${index}" >
                </td>
                <td class="text-right">
                    <span class="text-right subtotal">${cart.subTotal}</span>
                </td>
                <td class="text-center" onclick="removeItem(${index})">
                    <i class="fa fa-trash pointer" title="Remove"></i>
                </td>
            </tr>`
        );
    });

    updateOrderData();
}
function editCartItem(id) {
    console.log(String(id));
    carts.forEach(cart => {
        console.log(cart.item.id);
        if (cart.item.id == id) {
            let net_price = cart.item.price - cart.item.discount;
            $('#cartItem').append(`

            <div class="modal-header modal-primary">
                <h5 class="modal-title">${cart.item.name}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody><tr>
                        <th>Net Price</th>
                        <th><span id="net_price">${cart.net_price}</span></th>
                        <th>Product Tax</th>
                        <th><span id="pro_tax">0.00</span> <span id="pro_tax_method">()</span></th>
                    </tr>
                </tbody></table>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nPrice">Unit Price</label>
                            <input type="text" class="form-control input-sm" id="nPrice" value="${cart.item.price}" onclick="this.select();" placeholder="New Price">
                        </div>
                        <div class="form-group">
                            <label for="nDiscount">Discount</label>
                            <input type="text" class="form-control input-sm" id="nDiscount" value="${cart.item.discount}" onclick="this.select();" placeholder="Discount">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="nQuantity">Quantity</label>
                            <input type="text" class="form-control input-sm" id="nQuantity" value="${cart.qty}" onclick="this.select();" placeholder="Current Quantity">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="nComment">Comment</label>
                            <textarea class="form-control" id="nComment"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button class="btn btn-success" id="editItem">Update</button>
            </div>

`);
        }
    });
};

function updateOrderData() {
    var total = 0;
    var totalItem = 0;
    var totalTax = 0;
    var totalPayable = 0;
    var totalDiscount = 0;
    if (carts.length > 0) {
        let subTotals = carts.map(item => item.subTotal);
        $.each(subTotals, function() { total+=parseFloat(this) || 0;});

        let itemsNum = carts.map(cart => cart.qty);
        $.each(itemsNum, function() { totalItem+=parseFloat(this) || 0;});

        let itemDis = carts.map(cart => (cart.item.discount * cart.qty));
        $.each(itemDis, function() { totalDiscount+=parseFloat(this) || 0;});

        totalTax = totalItem * orderTax;

        var totalPayable = Number(total + totalTax);
    }
    $('#total').text(total.toFixed(2));
    $('#count').text(carts.length +'('+ totalItem + ')');
    $('#ts_con').text(totalTax.toFixed(2));
    $('#total-payable').text(totalPayable.toFixed(2));
    $('#ds_con').text(totalDiscount.toFixed(2));
}

function refreshTable() {
    $('#posTable > tbody').empty();
    addCartTable();
}

$('body').on('DOMSubtreeModified', function(){
    var self = $(this);
    var posFooter = $('footer');
    var top = Number(screen.height) + 90 + 'px';
    if (self.hasClass('sidebar-mini')) {
        posFooter.addClass('footer-bottom');
        posFooter.css('top',top);
    } else if (self.hasClass('sidebar-mini') === false && posFooter.hasClass('footer-bottom')) {
        posFooter.removeClass('footer-bottom');
    }
});
