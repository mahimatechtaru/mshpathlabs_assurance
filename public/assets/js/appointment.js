"use strict";

const progress = document.getElementById("progress");
const prev = document.getElementById("prev");
const next = document.getElementById("next");
const circles = document.querySelectorAll(".circle");

var lat , lng ,currency , amount;
var base_url = $('input[name=base_url]').val();
var $form,inputSelector,$inputs,$errorMessage,valid;
lat = parseFloat($('#lat').val());
lng = parseFloat($('#lng').val());

$(document).ready(function () {
    $('.select2').select2
        ({
            width: '100%' // need to override the changed default
        });


    // Check Offer
    $(".applyCoupon").click(function () {
        let coupon_code = document.getElementById('coupon_code').value;
        if (coupon_code.length == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please provide the coupon code...!!',
            });
        } else if (coupon_code.length > 0) {
            $.ajax(
            {
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                data:{
                    offer_code:$('input[name=coupon_code]').val(),
                    date: $('input[name="date"]').val(),
                    amount :$('input[name=amount]').val(),
                },
                url: base_url + '/checkCoupen',
                success: function (result)
                {
                    if (result.success == true)
                    {
                        $('input[name=discount_price]').val(result.data.price);
                        $('input[name=discount_id]').val(result.data.discount_id);
                        $('input[name=amount]').val(result.data.finalAmount);
                        $('.discountLi').removeClass('hidden');
                        $('.discountAmount').text(result.data.price);
                        $('.finalAmount').text(result.data.finalAmount);
                        Swal.fire({
                            icon: 'success',
                            text: 'you Get ' + result.currency + parseInt(result.data.price) + ' Discount',
                        });
                    }
                    else
                    {
                        $('input[name=discount_price]').val('');
                        $('input[name=discount_id]').val('');
                        $('.discountLi').hide();
                        $('.discountAmount').text('00');
                        $('.finalAmount').text($('.appointmentFees').text());
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: result.data,
                        });
                    }
                },
                error: function (err) {

                }
            });
        }
    });

    currency = $('input[name=currency]').val();
    amount = $('input[name=amount]').val();
    // $('input[name=payment]').change(function ()
    // {
    //     if(this.value == 'paypal')
    //     {
    //         $('.paypal_row').show();
    //         $('.razor_row').hide();
    //         $('.stripe_row').hide();
    //         $('.cod_card').hide();
    //         $('.paystack_row').hide();
    //         $('.flutterwave_row').hide();
    //         paypalPayment();
    //     }
    //     if(this.value == 'razor')
    //     {
    //         $('.paypal_row').hide();
    //         $('.razor_row').show();
    //         $('.stripe_row').hide();
    //         $('.cod_card').hide();
    //         $('.paystack_row').hide();
    //         $('.flutterwave_row').hide();
    //         RazorPayPayment();
    //     }
    //     if(this.value == 'cod')
    //     {
    //         $('.paypal_row').hide();
    //         $('.razor_row').hide();
    //         $('.stripe_row').hide();
    //         $('.paystack_row').hide();
    //         $('.flutterwave_row').hide();
    //     }
    //     if(this.value == 'stripe')
    //     {
    //         $('.paypal_row').hide();
    //         $('.razor_row').hide();
    //         $('.stripe_row').show();
    //         $('.cod_card').hide();
    //         $('.paystack_row').hide();
    //         $('.flutterwave_row').hide();
    //         StripPayment();
    //     }
    //     if(this.value == 'paystack')
    //     {
    //         $('.paypal_row').hide();
    //         $('.razor_row').hide();
    //         $('.stripe_row').hide();
    //         $('.cod_card').hide();
    //         $('.paystack_row').show();
    //         $('.flutterwave_row').hide();
    //     }
    //     if(this.value == 'flutterwave')
    //     {
    //         $('.paypal_row').hide();
    //         $('.razor_row').hide();
    //         $('.stripe_row').hide();
    //         $('.cod_card').hide();
    //         $('.paystack_row').hide();
    //         $('.flutterwave_row').show();
    //     }
    // });

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

function getTime() {
    var date = new Date(a.dates[0]);
    date = moment(date).format('DD-MM-YYYY');

    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            date:this.value,
            doctor_id:$('input[name=doctor_id]').val(),
        },
        url: base_url + '/displayTimeslot',
        success: function (result)
        {
            $('.timeSlotRow').html('');
            if (result.data.length > 0)
            {
                $.each(result.data, function (key, value) {
                    var select;
                    if(key == 0)
                    {
                        var select = 'active';
                        $('.timeSlotRow').append('<input type="hidden" name="time" value="'+value.start_time+'">');
                    }
                    else
                      var select = '';
                    $('.timeSlotRow').append(
                      '<div class="m-1 d-flex time '+select+' timing'+key+' rounded-3" onclick="thisTime('+key+')">'+
                        '<a class="selectedClass'+key+'" href="javascript:void(0)">'+value.start_time+'</a>'+
                      '</div>');
                });
            }
            else
            {
                $('.timeSlotRow').html('<strong class="text-danger text-center w-100">At this time doctor is not available please change the date...</strong>');
            }
        },
        error: function (err) {

        }
    });
}

document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
    const dropZoneElement = inputElement.closest(".drop-zone");

    dropZoneElement.addEventListener("click", (e) => {
      inputElement.click();
    });

    inputElement.addEventListener("change", (e) => {
      if (inputElement.files.length) {
        updateThumbnail(dropZoneElement, inputElement.files[0]);
      }
    });

    dropZoneElement.addEventListener("dragover", (e) => {
      e.preventDefault();
      dropZoneElement.classList.add("drop-zone--over");
    });

    ["dragleave", "dragend"].forEach((type) => {
      dropZoneElement.addEventListener(type, (e) => {
        dropZoneElement.classList.remove("drop-zone--over");
      });
    });

    dropZoneElement.addEventListener("drop", (e) => {
      e.preventDefault();

      if (e.dataTransfer.files.length) {
        inputElement.files = e.dataTransfer.files;
        updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
      }

      dropZoneElement.classList.remove("drop-zone--over");
    });
});

/**
 * Updates the thumbnail on a drop zone element.
 *
 * @param {HTMLElement} dropZoneElement
 * @param {File} file
 */
function updateThumbnail(dropZoneElement, file) {
let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

if ($(dropZoneElement).find('.drop-zone__prompt')) {
    $(dropZoneElement).find('.drop-zone__prompt').remove();
}

// First time - there is no thumbnail element, so lets create it
if (!thumbnailElement) {
    thumbnailElement = document.createElement("div");
    thumbnailElement.classList.add("drop-zone__thumb");
    dropZoneElement.appendChild(thumbnailElement);
}

thumbnailElement.dataset.label = file.name;

// Show thumbnail for image files
if (file.type.startsWith("image/")) {
    const reader = new FileReader();

    reader.readAsDataURL(file);
    reader.onload = () => {
    thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
    };
} else {
    thumbnailElement.style.backgroundImage = null;
}
}

let currentActive = 1;

next.addEventListener("click", () => {
    if (currentActive == 1) {
        var response = checkFirstFormValidation();
        if (response == true) {
            currentActive++;
            if (currentActive > circles.length) currentActive = circles.length;
            update();
            shoeStep();
            displayHospital();
        }
    }
    else if (currentActive == 2) {
        var response = checkSecondFormValidation();
        if (response == true) {
            currentActive++;
            if (currentActive > circles.length) currentActive = circles.length;
            update();
            shoeStep();
        }
        else
        {
            alert("Please select mandotaroy field");
        }
    }
});

prev.addEventListener("click", () => {
  currentActive--;
  if (currentActive < 1) currentActive = 1;
  update();
  shoeStep();
});

const update = () => {
  circles.forEach((circle, index) => {
    if (index < currentActive) circle.classList.add("progress_active");
    else circle.classList.remove("progress_active");
  });
  const actives = document.querySelectorAll(".progress_active");
  progress.style.width =
    ((actives.length - 1) / (circles.length - 1)) * 100 + "%";
  if (currentActive === 1)
    prev.disabled = true;
  else if (currentActive === circles.length)
    next.disabled = true;
  else
  {
    prev.disabled = false;
    next.disabled = false;
  }
};

function shoeStep() {
  if ($(circles).filter(".progress_active").length == 1) {
    seeData("#step1");
  }
  if ($(circles).filter(".progress_active").length == 2) {
    seeData("#step2");
  }
  if ($(circles).filter(".progress_active").length == 3)
  {
    seeData("#step3");
    $("#payment").addClass("block");
    $("#next").addClass("hidden");
    $("#payment").removeClass("hidden");
  }
  else
  {
    $("#payment").removeClass("block");
    $("#payment").addClass("hidden");
    $("#next").removeClass("hidden");
  }
}

function displayHospital() {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/displayHospital',
        data: {
            patient_address_id: $('select[name=patient_address]').val(),
            doctor_id:$('input[name=doctor_id]').val(),
        },
        success: function (result)
        {
            if (result.success == true)
            {
                var data = result.data;
                $(data).each(function( index ) {
                    var single_data = data[index];
                    var ele = $('.displayHospital').find('.displayKm'+single_data['id']);
                    ele.text(single_data.distance);
                });
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
            $('#prev').trigger('click');
            $('#prev').trigger('click');
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function dateChange() {
    var date = new Date(datepicker.dates[0]);
    date = moment(date).format('YYYY-MM-DD');
    $('input[name=date]').val(date);

    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            date:date,
            doctor_id:$('input[name=doctor_id]').val(),
        },
        url: base_url + '/displayTimeslot',
        success: function (result)
        {
            $('.timeSlotRow').html('');
            if (result.data.length > 0)
            {
                $('.currentDate').text(result.date);
                $.each(result.data, function (key, value) {
                    var select;
                    if(key == 0)
                    {
                        var select = 'activeTimeslots';
                        $('.timeSlotRow').append('<input type="hidden" name="time" value="'+value.start_time+'">');
                    }
                    else
                        var select = '';

                    $('.timeSlotRow').append('<a href="javascript:void(0)" onclick="thisTime('+key+')" class="'+select+' time timing'+key+' border border-gray text-center py-1 2xl:px-2 sm:px-2 msm:px-2 font-fira-sans font-normal xl:px-1 xlg:px-1 text-black m-1 timeslots"><svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 11.75C4.60761 11.75 3.27226 11.1969 2.28769 10.2123C1.30312 9.22774 0.75 7.89239 0.75 6.5C0.75 5.10761 1.30312 3.77226 2.28769 2.78769C3.27226 1.80312 4.60761 1.25 6 1.25C7.39239 1.25 8.72774 1.80312 9.71231 2.78769C10.6969 3.77226 11.25 5.10761 11.25 6.5C11.25 7.89239 10.6969 9.22774 9.71231 10.2123C8.72774 11.1969 7.39239 11.75 6 11.75ZM6 12.5C7.5913 12.5 9.11742 11.8679 10.2426 10.7426C11.3679 9.61742 12 8.0913 12 6.5C12 4.9087 11.3679 3.38258 10.2426 2.25736C9.11742 1.13214 7.5913 0.5 6 0.5C4.4087 0.5 2.88258 1.13214 1.75736 2.25736C0.632141 3.38258 0 4.9087 0 6.5C0 8.0913 0.632141 9.61742 1.75736 10.7426C2.88258 11.8679 4.4087 12.5 6 12.5V12.5Z" fill="white"/><path d="M8.22727 4.22747C8.22192 4.23264 8.21691 4.23816 8.21227 4.24397L5.60752 7.56272L4.03777 5.99222C3.93113 5.89286 3.7901 5.83876 3.64437 5.84134C3.49865 5.84391 3.35961 5.90294 3.25655 6.006C3.15349 6.10906 3.09446 6.2481 3.09188 6.39382C3.08931 6.53955 3.14341 6.68059 3.24277 6.78722L5.22727 8.77247C5.28073 8.82583 5.34439 8.86788 5.41445 8.89611C5.48452 8.92433 5.55955 8.93816 5.63507 8.93676C5.7106 8.93536 5.78507 8.91876 5.85404 8.88796C5.92301 8.85716 5.98507 8.81278 6.03652 8.75747L9.03052 5.01497C9.13246 4.90796 9.1882 4.76514 9.18568 4.61737C9.18317 4.4696 9.12259 4.32875 9.01706 4.22529C8.91152 4.12182 8.76951 4.06405 8.62171 4.06446C8.47392 4.06486 8.33223 4.12342 8.22727 4.22747Z" fill="white"/></svg><span class="ml-1">'+value.start_time+'</span></a>');
                });
            }
            else
            {
                $('.timeSlotRow').html('<strong class="text-red-600 text-bs text-center w-100">At this time doctor is not available please change the date.</strong>');
            }
            // $('.timeSlotRow').html('');
            // if (result.data.length > 0)
            // {
            //     $.each(result.data, function (key, value) {
            //         var select;
            //         if(key == 0)
            //         {
            //             var select = 'active';
            //             $('.timeSlotRow').append('<input type="hidden" name="time" value="'+value.start_time+'">');
            //         }
            //         else
            //           var select = '';
            //         $('.timeSlotRow').append(
            //           '<div class="m-1 d-flex time '+select+' timing'+key+' rounded-3" onclick="thisTime('+key+')">'+
            //             '<a class="selectedClass'+key+'" href="javascript:void(0)">'+value.start_time+'</a>'+
            //           '</div>');
            //     });
            // }
            // else
            // {
            //     $('.timeSlotRow').html('<strong class="text-danger text-center w-100">At this time doctor is not available please change the date...</strong>');
            // }
        },
        error: function (err) {

        }
    });
}

// function initAutocomplete()
// {
//     const map = new google.maps.Map(document.getElementById("map"), {
//     center: { lat: lat, lng: lng },
//         zoom: 13,
//         mapTypeId: "roadmap",
//     });

//     const a = new google.maps.Marker({
//         position: {
//             lat: lat,
//             lng: lng
//         },
//         map,
//         draggable: true,
//     });

//     google.maps.event.addListener(a, 'dragend', function() {
//         geocodePosition(a.getPosition());
//         $('#lat').val(a.getPosition().lat().toFixed(5));
//         $('#lng').val(a.getPosition().lng().toFixed(5));
//     });
// }

// function geocodePosition(pos) {
//     var geocoder = new google.maps.Geocoder();
//     geocoder.geocode({
//     latLng: pos
//     }, function(responses)
//     {
//         if (responses && responses.length > 0) {
//             $('textarea[name=address]').val(responses[0].formatted_address);
//         } else {
//             $('textarea[name=address]').val('Cannot determine address at this location.');
//         }
//     });
// }

function makePayment(event)
{
    var script = document.createElement('script');
    script.src = 'https://checkout.flutterwave.com/v3.js';

    script.onload = function() {
        FlutterwaveCheckout({
            public_key: $('input[name=flutterwave_key]').val(),
            tx_ref: Math.floor(Math.random() * (1000 - 9999 + 1)) + 9999,
            amount: amount,
            currency: currency,
            payment_options: " ",
            customer: {
                email: $('input[name=email]').val(),
                phone_number: $('input[name=phone]').val(),
                name: $('input[name=name]').val(),
            },
            callback: function(data) {
                if (data.status == 'successful') {
                    $('input[name=payment_status]').val(1);
                    $('input[name=payment_token]').val(data.transaction_id);
                    $('input[name=payment_type]').val('FLUTTERWAVE');
                    booking();
                } else if (data.status == 'cancelled') {
                    console.log('cancelled');
                    event.preventDefault();
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
    };
    document.body.appendChild(script);
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
                    $('input[name=payment_status]').val(1);
                    $('input[name=payment_token]').val(result.data);
                    $('input[name=payment_type]').val('STRIPE');
                    booking();
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
                    $('input[name=payment_type]').val('PAYPAL');
                    $('input[name=payment_status]').val(1);
                    $('input[name=payment_token]').val(details.id);
                    booking();
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

function RazorPayPayment()
{
    var options =
    {
        key: $('#RAZORPAY_KEY').val(),
        amount: amount * 100,
        description: '',
        currency: 'INR',
        // currency: currency,
        handler: demoSuccessHandler,
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
    $('input[name=payment_type]').val('RAZOR');
    $('input[name=payment_status]').val(1);
    $('input[name=payment_token]').val(transaction.razorpay_payment_id);
    booking();
}

function payStack() {
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
            $('input[name=payment_type]').val('PAYSTACK');
            $('input[name=payment_status]').val(1);
            $('input[name=payment_token]').val(transaction.reference);
            booking();
        },
        onCancel: () => {
            console.log("User cancelled the transaction");
        },
        onError: (error) => {
            console.log("Error: ", error.message);
          },
    });
}

function booking()
{
    $('#bookingloading').show();
    $('#btnPayCOD').attr('disabled', true);
    var formData = new FormData($('#appointmentForm')[0]);
    var time = formData.getAll('time');
    if (time.length > 0) {
        formData.delete('time');
        formData.append('time',time[0]);
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/bookAppointment',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result)
        {
            $('#bookingloading').hide();
            $('#btnPayCOD').attr('disabled', false);
            if (result.success == true)
            {
                $('#bookingloading').hide();
                $('#btnPayCOD').attr('disabled', false);
                location.replace(base_url+'/user_profile');
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
            console.log(err);
            $('#prev').trigger('click');
            $('#prev').trigger('click');
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
            $('#bookingloading').hide();
            $('#btnPayCOD').attr('disabled', false);
        }
    });
    $('#bookingloading').hide();
    $('#btnPayCOD').attr('disabled', false);
}

// add selected class
function thisTime(i)
{
    $(".time").removeClass('activeTimeslots');
    $('.timing'+i).addClass('activeTimeslots');
    $('input[name=time]').val($.trim($('.timing'+i).text()));
}

function changeHospital(i) {
    $(".hospitals").removeClass('activeAddress');
    $('.hospital'+i).addClass('activeAddress');
    $('input[name=hospital_id]').val($.trim($('.hospital'+i).attr('data-attribute')));
    $('.displayHospitalName').text($.trim($('.hospitalName'+i).text()));
    $('.displayAddress').text($.trim($('.hospitalAddress'+i).text()));
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
            $(".invalid-div span").html('');
            if (result.success == true)
            {
                var newState = new Option(result.data.address, result.data.id, true, true);
                $("#patient_address").append(newState).trigger('change');
                $('#exampleModalCenteredScrollable').find('.modelCloseBtn').trigger("click");
            }
            else
            {
                $(".invalid-div .address").html(result.data);
            }
        },
        error: function (err)
        {
            $(".invalid-div span").html('');
            for (let v1 of Object.keys( err.responseJSON.errors)) {
                $(".invalid-div ."+v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function initAutocomplete()
{
    const map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: lat, lng: lng },
        zoom: 13,
        mapTypeId: "roadmap",
        gestureHandling: "greedy"
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

function geocodePosition(pos) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
    latLng: pos
    }, function(responses)
    {
        if (responses && responses.length > 0) {
            $('textarea[name=address]').val(responses[0].formatted_address);
        } else {
            $('textarea[name=address]').val('Cannot determine address at this location.');
        }
    });
}

function checkFirstFormValidation()
{
    // return true;
    $("#appointmentForm").validate({
        errorElement: 'span',
        errorClass: 'custom-error',
        rules: {
            patient_name: {
                required: true,
            },
            age: {
                required: true,
            },
            phone_no: {
                required: true,
            },
            patient_address: {
                required: true,
            },
            appointment_for: {
                required: true,
            },
        }
    });
    var $form = $('#appointmentForm');
    return $form.valid();
}

function checkSecondFormValidation() {
    var hospital_id = $('input[name=hospital_id]').val();
    var date = $('input[name=date]').val();
    var time = $('input[name=time]').val();
    if (hospital_id == '' || hospital_id == undefined || hospital_id == "" || hospital_id == null) {
        return false;
    }
    else if(date == '' || date == undefined || date == "" || date == null)
    {
        return false;
    }
    else if(time == '' || time == undefined || time == "" || time == null)
    {
        return false;
    }
    return true;
}
