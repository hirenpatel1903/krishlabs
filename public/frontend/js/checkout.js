"use strict";

$(document).ready(function () {
    "use strict";
    if ($('#payment_type').val() == 15) {
        $('.stripe-payment-method-div #card-element-label').show('slow');
    } else {
        $('.stripe-payment-method-div #card-element-label').hide('slow');
    }

    $('#payment_type').on("change", function() {
        if ($('#payment_type').val() == 15) {
            $('.stripe-payment-method-div #card-element-label').show('slow');
        } else {
            $('.stripe-payment-method-div #card-element-label').hide('slow');
        }
    });
});
