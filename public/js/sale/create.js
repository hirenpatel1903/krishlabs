/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";


function printDiv() {
    printElement( document.getElementById('print_order_body'));
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

window.addEventListener('show', event => {
    $('#editCartItem').modal('show');
});

window.addEventListener('close', event => {
    $('#editCartItem').modal('hide');
});

window.addEventListener('OrderTax', event => {
    $('#editOrderTax').modal('show');
});


window.addEventListener('close', event => {
    $('#editOrderTax').modal('hide');
});

window.addEventListener('customerModal', event => {
    $('#customerModal').modal('show');
});

window.addEventListener('customerModalHide', event => {
    $('#customerModal').modal('hide');
});

window.addEventListener('paymentModal', event => {
    $('#paymentModal').modal('show');
});

window.addEventListener('paymentModalHide', event => {
    $('#paymentModal').modal('hide');
});

window.addEventListener('actionError', event => {
    $('#actionError').modal('show');
});
window.addEventListener('cancelModal', event => {
    $('#cancelOrder').modal('show');
});
window.addEventListener('printOrderModal', event => {
    $('#printOrderModal').modal('show');
});
window.addEventListener('printOrderModalHide', event => {
    $('#printOrderModal').modal('hide');
});
window.addEventListener('printBillModal', event => {
    $('#printBillModal').modal('show');
});
window.addEventListener('printBillModalHide', event => {
    $('#printBillModal').modal('hide');
});

window.addEventListener('showToast', event => {
    iziToast.error({
        title: 'Warning',
        message: 'Product out of stock',
        position: 'topRight'
    });
});

//Attach the scan event
onScan.attachTo(document, {
    suffixKeyCodes: [13],
    reactToPaste: true,
    onScan: function(sCode, iQty) {
        let code = sCode.toLowerCase();
        let barcode = code.substring(0, 8);
        console.log(code)
        console.log(barcode)
        let barcodeID = code.substr(8, code.length);
        console.log(barcodeID);
        if(barcode === 'customer'){
            window.livewire.emit('customerAddScan',{ id : barcodeID});
        }else{
            window.livewire.emit('getProductAdd',{ name : code});
        }
    },
    onScanError: function(oDebug) {
        console.log(oDebug);
    },
    minLength: 2
});
