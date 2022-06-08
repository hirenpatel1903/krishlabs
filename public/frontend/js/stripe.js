"use strict";

var stripe = Stripe(stripeKey);
var elements = stripe.elements();
var element = elements.create('card', {
    style: {
        base: {
            iconColor: '#000',
            color: '#000',
            fontWeight: '500',
            fontFamily: 'Roboto, Open Sans, Segoe UI, sans-serif',
            fontSize: '16px',
            fontSmoothing: 'antialiased',
            ':-webkit-autofill': {
                color: '#fce883',
            },
            '::placeholder': {
                color: '#98a1aa',
            },
        },
        invalid: {
            iconColor: '#eb1c26',
            color: '#eb1c26',
        },
    },
});

element.mount('#card-element');
$(document).ready(function () {
    var paymentType = jQuery('#payment_type').val();
    if (paymentType == 15) {
        $('.stripe-payment-method-div').show('slow');
    } else {
        $('.stripe-payment-method-div').hide('slow');
    }
});

jQuery(document).on('change', '#payment_type', function () {
    var paymentType = jQuery('#payment_type').val();
    if (paymentType == 15) {
        $('.stripe-payment-method-div').show('slow');
    } else {
        $('.stripe-payment-method-div').hide('slow');
    }
});

var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {
    event.preventDefault();
    var paymentType = jQuery('#payment_type').val();
    var first_name = jQuery('#first_name').val();
    var last_name = jQuery('#last_name').val();
    var last_name = jQuery('#phone').val();
    var amount = $('#deposit_amount').val();
    var erro = 1;
    if (amount && last_name && first_name && phone) {
        erro = 0;
    }
    if (paymentType == 15) {
        stripe.createToken(element).then(function (result) {
            if (result.error) {
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;
            } else {
                stripeTokenHandler(result.token);
            }
        });
    } else if (paymentType == 16 && erro == 0) {

        var total_amount = amount * 100;
        razorPay(razorPayKey, total_amount, siteName, siteLogo, currency);
    } else {
        form.submit();
    }
});

function stripeTokenHandler(token) {
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
    form.submit();
}

function razorPay(razorPayKey, amount, siteName, siteLogo, currency) {
    var options = {
        "key": razorPayKey,
        "amount": amount,
        "currency": 'INR',
        "name": siteName,
        "description": '',
        "image": siteLogo,
        "order_id": "",
        "handler": function (response) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'razorpay_payment_id');
            hiddenInput.setAttribute('value', response.razorpay_payment_id);
            form.appendChild(hiddenInput);
            form.submit();
        },
        "prefill": {
            "name": "",
            "email": "",
            "contact": ""
        },
        "notes": {
            "address": "test test"
        },
        "theme": {
            "color": "#feb406"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}
