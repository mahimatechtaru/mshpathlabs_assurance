"use strict";

var base_url = $('input[name=base_url]').val();
var subscriptionData,amount,duration,currency;
var $form, inputSelector, $inputs, $errorMessage, valid, string;

$(document).ready(function()
{
    currency = $('input[name=currency]').val();
    string = $('input[name="plan"]:checked').val();
    amount = string.split("/")[0];
    duration = string.split("/")[1];
    $('input[name="plan"]').change(function ()
    {
        string = $('input[name="plan"]:checked').val();
        amount = string.split("/")[0];
        duration = string.split("/")[1];
    });
    subscriptionData = new FormData();
    subscriptionData.append('payment_type','COD');
    subscriptionData.append('amount',amount);
    subscriptionData.append('duration',duration);
    subscriptionData.append('subscription_id',$('input[name=subscription_id]').val());
    subscriptionData.append('payment_status',0);
    $('input[name=paymentradio]').change(function ()
    {
        if(this.value == 'paypal')
        {
            subscriptionData.append('payment_type','PAYPAL');
            $('.paypal_card').show();
            $('.razor_card').hide();
            $('.stripe_card').hide();
            $('.cod_card').hide();
            $('.paystack_card').hide();
            $('.flutterwave_card').hide();
            paypalPayment();
        }
        if(this.value == 'razor')
        {
            subscriptionData.append('payment_type','RAZOR');
            $('.paypal_card').hide();
            $('.razor_card').show();
            $('.stripe_card').hide();
            $('.cod_card').hide();
            $('.paystack_card').hide();
            $('.flutterwave_card').hide();
            RazorPayPayment();
        }
        if(this.value == 'cod')
        {
            subscriptionData.append('payment_type','COD');
            $('.paypal_card').hide();
            $('.razor_card').hide();
            $('.stripe_card').hide();
            $('.cod_card').show();
            $('.flutterwave_card').hide();
            $('.paystack_card').hide();
        }
        if(this.value == 'stripe')
        {
            subscriptionData.append('payment_type','STRIPE');
            $('.paypal_card').hide();
            $('.razor_card').hide();
            $('.stripe_card').show();
            $('.cod_card').hide();
            $('.paystack_card').hide();
            $('.flutterwave_card').hide();
            StripPayment()
        }
        if(this.value == 'paystack')
        {
            subscriptionData.append('payment_type','PAYSTACK');
            $('.paypal_card').hide();
            $('.razor_card').hide();
            $('.stripe_card').hide();
            $('.cod_card').hide();
            $('.paystack_card').show();
            $('.flutterwave_card').hide();
            StripPayment()
        }
        if(this.value == 'flutterwave')
        {
            subscriptionData.append('payment_type','FLUTTERWAVE');
            $('.paypal_card').hide();
            $('.razor_card').hide();
            $('.stripe_card').hide();
            $('.cod_card').hide();
            $('.paystack_card').hide();
            $('.flutterwave_card').show();
            StripPayment()
        }
    });
});

function StripPayment()
{
    $form = $(".require-validation");
    $('form.require-validation').bind('submit', function (e)
    {
        $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]',
        'input[type=text]', 'input[type=file]',
        'textarea'].join(', '),
        $inputs = $form.find('.required').find(inputSelector),
        $errorMessage = $form.find('div.error'),
        valid = true;
        $errorMessage.addClass('hide');

        $('.has-error').removeClass('has-error');
        $inputs.each(function (i, el) {
            var $input = $(el);
            if ($input.val() === '')
            {
                $input.parent().addClass('has-error');
                $errorMessage.removeClass('hide');
                e.preventDefault();
            }
        });
        var month = $('.expiry-date').val().split('/')[0];
        var year = $('.expiry-date').val().split('/')[1];
        $('.card-expiry-month').val(month);
        $('.card-expiry-year').val(year);

        if (!$form.data('cc-on-file'))
        {
            e.preventDefault();
            Stripe.setPublishableKey($form.data('stripe-publishable-key'));Stripe.createToken({
                number: $('.card-number').val(),
                cvc: $('.card-cvc').val(),
                exp_month: $('.card-expiry-month').val(),
                exp_year: $('.card-expiry-year').val()
            }, stripeResponseHandler);
        }
    });
}

function stripeResponseHandler(status, response)
{
    if (response.error) {
        $('.stripe_alert').show();
        $('.stripe_alert').text(response.error.message);
    }
    else
    {
        var token = response['id'];
        $form.find('input[type=text]').empty();
        $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
        var paymentData = new FormData($('#stripe-payment-form')[0]);
        paymentData.append('amount',amount);
        paymentData.append('duration',duration);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: base_url + '/stripePayment',
            data: paymentData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (result)
            {
                if (result.success == true)
                {
                    subscriptionData.append('payment_token',result.data);
                    subscriptionData.append('payment_status',1);
                    purchase();
                }
                else
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: "Payment not complete",
                    }
                )}
            },
            error: function (err)
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: err.responseJSON.message,
                })
            }
        });
    }
}

function paypalPayment()
{
    if(currency != 'INR')
    {
        $('.paypal_card_body').html('');
        paypal_sdk.Buttons({
            createOrder: function (data, actions)
            {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: amount
                        }
                    }]
                });
            },
            onApprove: function (data, actions)
            {
                return actions.order.capture().then(function (details)
                {
                    subscriptionData.append('payment_token', details.id);
                    subscriptionData.append('payment_status',1);
                    purchase();
                });
            },
            onError: function (err) {
                alert(err);
            }
        }).render('.paypal_card_body');
    }
    else
    {
        $('.paypal_card_body').html('INR currency not supported in Paypal');
    }
}

function flutterwave()
{
    purchase();
}

function RazorPayPayment()
{
    var options =
    {
        key: $('#RAZORPAY_KEY').val(),
        amount: amount * 100,
        description: '',
        currency: currency,
        handler: demoSuccessHandler
    }
    window.r = new Razorpay(options);
    document.getElementById('paybtn').onclick = function ()
    {
        r.open();
    }
}

function padStart(str) {
    return ('0' + str).slice(-2)
}

function demoSuccessHandler(transaction)
{
    $("#paymentDetail").removeAttr('style');
    $('#paymentID').text(transaction.razorpay_payment_id);
    var paymentDate = new Date();
    $('#paymentDate').text(
        padStart(paymentDate.getDate()) + '.' + padStart(paymentDate.getMonth() + 1) + '.' + paymentDate.getFullYear() + ' ' + padStart(paymentDate.getHours()) + ':' + padStart(paymentDate.getMinutes())
    );
    subscriptionData.append('payment_token', transaction.razorpay_payment_id);
    subscriptionData.append('payment_status',1);
    purchase();
}

function purchase()
{
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/purchase',
        data: subscriptionData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            if (result.success == true)
            {
                if(result.url != undefined)
                {
                    window.location.replace(result.url);
                }
                else
                {
                    window.location.replace(base_url + '/subscription');
                }
            }
        },
        error: function (err)
        {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: err.responseJSON.message,
            })
        }
    });
}

function payWithPaystack()
{
    var email = document.getElementById('email-address').value;
    var payableAmount = amount * 100;
    var publicKey = $('#paystack-public-key').val();

    const paystack = new PaystackPop();
    paystack.newTransaction(
    {
        key: publicKey,
        email: email,
        amount: payableAmount,
        currency: currency,
        onLoad: (response) => {
            console.log("onLoad: ", response);
        },
        onSuccess: (transaction) => {
            subscriptionData.append('payment_status',1);
            subscriptionData.append('payment_token', transaction.reference);
            purchase();
        },
        onCancel: () => {
            console.log("User cancelled the transaction");
        },
        onError: (error) => {
            console.log("Error: ", error.message);
          },
    });
}
