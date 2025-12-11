"use strict";
var removeItem,categories,lat,lng;
var amount,bookingMedicine,shipping_at,currency;
var $form,inputSelector,$inputs,$errorMessage,valid;

lat = parseFloat($('#lat').val());
lng = parseFloat($('#lng').val());
var base_url = $('input[name=base_url]').val();

$(document).ready(function () {
    amount = $('input[name=amount]').val();
    currency = $('input[name=currency_code]').val();
    shipping_at = $('input[name=shipping_at]').val();
    bookingMedicine = new FormData();
    bookingMedicine.append('payment_type','cod');
    bookingMedicine.append('payment_status','0');
    bookingMedicine.append('amount',amount);
    bookingMedicine.append('shipping_at',shipping_at);

    initAutocomplete();
    $("#all_filter").click(function () {
        $(".myDrop").toggleClass("show");
    });

    $('#delivery_type').change(function () {
        if(this.checked == true)
        {
            $('input[name=shipping_at]').val('home');
            bookingMedicine.append('shipping_at','home');
            $('.addresses-list').show();
            const firstRadio = document.querySelector('input[name="address_id"]');
            if (firstRadio) {
                firstRadio.checked = true;
            } else {
                console.log('adsdasdasd');
                $(".payment_style").hide();
            }
        }
        else
        {
            $('input[name=shipping_at]').val('pharmacy');
            bookingMedicine.append('shipping_at','pharmacy');
            $("input[name=address_id]").prop('checked', false);
            var amount = $('input[name=amount]').val();
            var grand_total = parseInt(amount);
            $('input[name=delivery_charge]').val('00');
            $('.deliveryCharge').text('00');
            $('.finalPrice').text(grand_total);
            bookingMedicine.append('amount',grand_total);
            bookingMedicine.delete('delivery_charge');
            bookingMedicine.delete('address_id');
            $('.addresses-list').hide();
            $(".payment_style").show();
        }
    })

    $('#pdf').change(function ()
    {
        if(this.value != null && this.value != undefined && this.value != '')
        {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("pdf").files[0]);

            var fileName = document.getElementById("pdf").value;
            var idxDot = fileName.lastIndexOf(".") + 1;
            var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
            if (extFile != 'pdf') {
                alert('Prescription should be in PDF file only.');
                $('#pdf').val('');
            }
            else
            {
                $('.payment_style').show();
                var f = document.getElementById("pdf").files[0];
                bookingMedicine.append('pdf', f);
            }
        }
        else
        {
            $('.payment_style').hide();
        }
    });

    $("#filter_form").change(function ()
    {
        categories = [];
        $('input[name="select_specialist"]:checked').each(function(i)
        {
            if(categories.indexOf(this.value) === -1)
                categories.push(this.value);
        });
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:{
                category:categories,
                from: 'js',
            },
            url: base_url + '/pharmacy-product/'+$('input[name=pharmacy_id]').val()+'/'+$('input[name=pharmacy_name]').val(),
            success: function (result)
            {
                $('.display_medicine').html('');
                $('.display_medicine').append(result.html);
                $(".myDrop").toggleClass("show");
            },
            error: function (err) {

            }
        });

    });

    $("input[name=address_id]").change(function()
    {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: base_url + '/getDeliveryCharge',
            data:
            {
                address_id : $('input[name=address_id]:checked').val()
            },
            success: function (result)
            {
                var deliveryCharge = parseInt(result.data.delivery_charge);
                var amount = $('input[name=amount]').val();
                var grand_total = parseInt(deliveryCharge) + parseInt(amount);
                $('input[name=delivery_charge]').val(deliveryCharge);
                $('.deliveryCharge').text(deliveryCharge);
                $('.finalPrice').text(grand_total);
                bookingMedicine.append('delivery_charge',deliveryCharge);
                bookingMedicine.append('address_id',$('input[name=address_id]:checked').val());
                bookingMedicine.append('amount',grand_total);
            },
            error: function (err)
            {
            }
        });
    });

    $('.paymentDiv').on('click',function () {
        $('.paymentDiv').removeClass("activePayment");
        $(this).addClass("activePayment");
        if($(this).attr('data-attribute') == "paypal")
        {
            $('.paypalDiv').show();
            $('.stripDiv').hide();
            $('.paystackDiv').hide();
            $('.flutterwaveDiv').hide();
            $('.razorpayDiv').hide();
            $('.codDiv').hide();
            paypalPayment();
        }
        if($(this).attr('data-attribute') == "stripe")
        {
            $('.paypalDiv').hide();
            $('.stripDiv').show();
            $('.paystackDiv').hide();
            $('.flutterwaveDiv').hide();
            $('.razorpayDiv').hide();
            $('.codDiv').hide();
            StripPayment();
        }
        if($(this).attr('data-attribute') == "paystack")
        {
            $('.paypalDiv').hide();
            $('.stripDiv').hide();
            $('.paystackDiv').show();
            $('.flutterwaveDiv').hide();
            $('.razorpayDiv').hide();
            $('.codDiv').hide();
        }
        if($(this).attr('data-attribute') == "flutterwave")
        {
            $('.paypalDiv').hide();
            $('.stripDiv').hide();
            $('.paystackDiv').hide();
            $('.flutterwaveDiv').show();
            $('.razorpayDiv').hide();
            $('.codDiv').hide();
        }
        if($(this).attr('data-attribute') == "razorpay")
        {
            $('.paypalDiv').hide();
            $('.stripDiv').hide();
            $('.paystackDiv').hide();
            $('.flutterwaveDiv').hide();
            $('.razorpayDiv').show();
            $('.codDiv').hide();
        }
        if($(this).attr('data-attribute') == "cod") {
            $('.paypalDiv').hide();
            $('.stripDiv').hide();
            $('.paystackDiv').hide();
            $('.flutterwaveDiv').hide();
            $('.razorpayDiv').hide();
            $('.codDiv').show();
        }
    });
});

function initAutocomplete()
{
    if (document.getElementById("map")) {
        const map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: lat, lng: lng },
            zoom: 13,
            mapTypeId: "roadmap",
        });

        const a = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng
            },
            map,
            draggable: true,
        });

        google.maps.event.addListener(a, 'dragend', function() {
            geocodePosition(a.getPosition());
            $('#lat').val(a.getPosition().lat().toFixed(5));
            $('#lng').val(a.getPosition().lng().toFixed(5));
        });
    }
}

function addAddress() {
    var addformData = new FormData($('.addAddress')[0]);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/addAddress',
        data: addformData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            if (result.success == true)
            {
                var data = '<div class="form-check"><input class="form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer" type="radio" id="address'+result.data.id+'" value='+result.data.id+' name="address_id"><label class="form-check-label font-fira-sans text-sm inline-block text-gray-800" for="address'+result.data.id+'">'+result.data.address+'</label></div>';
                $(".displayAddress").append(data);
                $('#exampleModalCenter').modal('toggle');
            }
        },
        error: function (err)
        {
        }
    });
}


function geocodePosition(pos) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
    latLng: pos
    }, function(responses) {
    if (responses && responses.length > 0) {
        $('textarea[name=address]').val(responses[0].formatted_address);
    } else {
        $('textarea[name=address]').val('Cannot determine address at this location.');
    }
    });
}

function geolocate()
{
    var autocomplete = new google.maps.places.Autocomplete(
        /** @type {HTMLInputElement} */(document.getElementById('autocomplete')),
        { types: ['geocode'] });
    google.maps.event.addListener(autocomplete, 'place_changed', function()
    {
        var lat = autocomplete.getPlace().geometry.location.lat();
        var lang = autocomplete.getPlace().geometry.location.lng();
        $('input[name=pharmacy_lat]').val(lat);
        $('input[name=pharmacy_lang]').val(lang);
        if (base_url+'/all-pharmacies' == window.location.href) {
            $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:{
                lat:lat,
                lang:lang,
            },
            url: base_url + '/all-pharmacies',
            success: function (result)
            {
                $('.display_pharmacy').html('');
                $('.display_pharmacy').append(result.html);
            },
            error: function (err) {

            }
            });
        }
    });
}

function payStack()
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
            bookingMedicine.append('payment_type','PAYSTACK');
            bookingMedicine.append('payment_status',1);
            bookingMedicine.append('payment_token',transaction.reference);
            bookMedicine();
        },
        onCancel: () => {
            console.log("User cancelled the transaction");
        },
        onError: (error) => {
            console.log("Error: ", error.message);
          },
    });
}

function StripPayment()
{
    $form = $(".require-validation");
    $('.btn-submit').bind('click', function (e)
    {
        $form = $(".require-validation"),
        inputSelector = ['input[type=email]', 'input[type=password]','input[type=text]', 'input[type=file]','textarea'].join(', '),
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
            Stripe.setPublishableKey($('input[name=stripe_publish_key]').val());

            Stripe.createToken({
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
        var paymentData = new FormData();
        paymentData.append('amount',amount);
        paymentData.append('stripeToken',token);
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
                    bookingMedicine.append('payment_token',result.data);
                    bookingMedicine.append('payment_status',1);
                    bookingMedicine.append('payment_type','STRIPE');
                    bookMedicine();
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

function RazorPayPayment()
{
    var options =
    {
        key: $('#RAZORPAY_KEY').val(),
        amount: amount * 100,
        description: '',
        // currency: 'INR',
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

    bookingMedicine.append('payment_token',transaction.razorpay_payment_id);
    bookingMedicine.append('payment_status',1);
    bookingMedicine.append('payment_type','RAZOR');
    bookMedicine();
}

function makePayment()
{
    FlutterwaveCheckout({
        public_key: $('input[name=flutterwave_key]').val(),
        tx_ref: Math.floor(Math.random() * (1000 - 9999 + 1) ) + 9999,
        amount: amount,
        currency: currency,
        payment_options: " ",
        customer: {
        email: $('input[name=email]').val(),
        phone_number: $('input[name=phone]').val(),
        name: $('input[name=name]').val(),
      },
      callback: function (data)
      {
        if (data.status == 'successful')
        {
            bookingMedicine.append('payment_token',data.transaction_id);
            bookingMedicine.append('payment_status',1);
            bookingMedicine.append('payment_type','FLUTTERWAVE');
            bookMedicine();
        }
        },
        onclose: function ()
        {
            event.preventDefault();
        },
      customizations: {
        title: $('input[name=company_name]').val(),
        description: "Doctor Appointment Booking",
      },
    });
}

function addCart(id,operation) {
    var qty = $('#txtCart'+id).val();

    if (operation == 'plus')
        $('#minus' + id).removeClass("disabled");
    else
    {
        if (qty == 0)
            $('#minus' + id).addClass("disabled");

        else
            $('#minus' + id).removeClass("disabled");
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/addCart',
        data:
        {
            id: id,
            pharmacy_id : $('input[name=pharmacy_id]').val(),
            operation: operation
        },
        success: function (result)
        {
            if (result.success == true)
            {
                $('.tot_cart').text(result.data.total_items);
                $('.total_price').text(result.data.total_price);
                $('.item_price'+id).text(result.data.item_price);
                if (result.data.cartString != '' && result.data.cartString != undefined)
                {
                    $('.sessionCart'+id).html('');
                    $('.sessionCart'+id).append(result.data.cartString);
                }
                $('#txtCart'+id).val(result.data.qty);
            }
            else {
                if (result.data) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.data
                    })
                }
            }
        },
        error: function (err) {
        }
    });
}

function paypalPayment()
{
    if(currency != 'INR')
    {
        $('.paypal_row_body').html('');
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
                    bookingMedicine.append('payment_token', details.id);
                    bookingMedicine.append('payment_status',1);
                    bookMedicine();
                });
            },
            onError: function (err) {
                alert(err);
            }
        }).render('.paypal_row_body');
    }
    else
    {
        $('.paypal_row_body').html('INR currency not supported in Paypal');
    }
}

function medicineSearch() {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            medicine_name:$('input[name=medicine_name]').val(),
            from: 'js',
        },
        url: base_url + '/pharmacy-product/'+$('input[name=pharmacy_id]').val()+'/'+$('input[name=pharmacy_name]').val(),
        success: function (result)
        {
            $('.display_medicine').html('');
            $('.display_medicine').append(result.html);
            $(".myDrop").toggleClass("show");
        },
        error: function (err) {

        }
    });
}

function bookMedicine() {
    const prescription = document.getElementById('prescription_require').value;
    const fileInput = document.getElementById('pdf');
    if ($('input[name=shipping_at]').val() == 'home') {
        if ($('input[name=address_id]:checked').val() == undefined) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "Please First select or add address",
            });
        }
        else {
            bookingMedicine.append('address_id', $('input[name=address_id]:checked').val());
            bookingConfirm();
        }
    } else if(prescription == 1) {
        if (fileInput.files.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please First Add Doctor Prescription'
            })
        } else {
            bookingConfirm();
        }
    }
    else {
        bookingConfirm();
    }
}

function bookingConfirm() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/bookMedicine',
        data: bookingMedicine,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            if (result.success == true)
            {
                if(result.url != undefined)
                {
                    window.open(result.url,'_self');
                }
                else
                {
                    window.location.replace(base_url + '/user_profile');
                }
            }
            else
            {

            }
        },
        error: function (err)
        {
        }
    });
}
