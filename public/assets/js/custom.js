"use strict";

var base_url = $('input[name=base_url]').val();

$(document).ready(function () {
    // if ($.fn.dataTable.isDataTable('.datatable')) {
    //     table = $('.datatable').DataTable();
    // }
    // else {
        // $('.datatable').DataTable({
        //     language: {
        //         paginate: {
        //             previous: "<i class='fa fa-angle-left'>",
        //             next: "<i class='fa fa-angle-right'>",
        //             first: "<i class='fa fa-angle-double-left'>",
        //             last: "<i class='fa fa-angle-double-right'>",
        //         }
        //     },
        //     pagingType: "full_numbers",
        // });
    // }
});

$('.datatable').DataTable();

function seeData(id) {
    $(id).addClass("block");
    $(id).siblings().removeClass("block");
    $(id).siblings().addClass("hidden");
}

$(".add-favourite").click(function () {
    $(this).toggleClass("active");
    if ($(this).find("i").hasClass("fa-regular fa-bookmark") && $(this).hasClass("active")) {
        $(this).find("i").removeClass("fa-regular fa-bookmark");
        $(this).find("i").addClass("fa fa-bookmark");
    }
    else if ($(this).find("i").hasClass("fa fa-bookmark")) {
        $(this).find("i").removeClass("fa fa-bookmark");
        $(this).find("i").addClass("fa-regular fa-bookmark");
    }
    var doctor_id = $(this).attr('data-id');
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/addBookmark/' + doctor_id,
        success: function (result) {
            if (result.success == false)
                window.location.href = base_url + '/patient-login';
            else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })
                Toast.fire({
                    icon: 'success',
                    title: result.msg
                })
            }
        },
        error: function (err) {

        }
    });
});

// Display Appointment
function show_appointment(appointment_id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/show_appointment/' + appointment_id,
        success: function (result) {
            $('.appointment_id').text(result.data.appointment_id);
            $('.doctor_name').text(result.data.doctor.name);
            $('.amount').text(result.currency + result.data.amount);
            $('.date').text(result.data.date);
            $('.time').text(result.data.time);
            if (result.data.payment_status == 0) {
                $('.payment_status').text('payment not complete')
            }
            else {
                $('.payment_status').text('payment complete')
            }
            $('.payment_type').text(result.data.payment_type);
            $('.illness_info').text(result.data.illness_information);
            $('.hospital').text(result.data.hospital.name);
            $('.patient_name').text(result.data.patient_name);
            $('.patient_address').text(result.data.address.address);
            $('.patient_age').text(result.data.age);
        },
        error: function (err) {

        }
    });
}

function appointId(id) {
    $('input[name=appointment_id]').val(id);
    $('input[name=id]').val(id);
}

// add review
function addReview() {
    var formData = new FormData($('#reviewForm')[0]);
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/addReview',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $(".invalid-div span").html('');
            if (result.success == true) {
                location.reload();
            }
            else {
                $(".invalid-div .review").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div span").html('');
            for (let v1 of Object.keys(err.responseJSON.errors)) {
                $(".invalid-div ." + v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });
}

function show_medicines(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/display_purchase_medicine/' + id,
        success: function (result) {
            if (result.success == true) {
                $('.shippingAt').text(result.data.shipping_at);
                if (result.data.shipping_at == 'home' || result.data.shipping_at == 'Home') {
                    $('.shippingAddressTr').show();
                    $('.shippingAddress').text(result.data.address.address);
                    let charge = result.data.delivery_charge == null ? 0 : result.data.delivery_charge;
                    $('.deliveryCharge').text(result.currency + charge);
                }
                else {
                    $('.shippingAddressTr').hide();
                }
                $('.tbody').html('');
                result.data.medicine_name.forEach(element => {
                    $('.tbody').append(
                        '<tr><td class="text-sm text-gray-600 px-2 py-2 text-center font-fira-sans">' + element.name + '</td>' +
                        '<td class="text-sm text-gray-600 px-2 py-2 text-center font-fira-sans">' + element.qty + '</td>' +
                        '<td class="text-sm text-gray-600 px-2 py-2 text-center font-fira-sans">' + result.currency + element.price + '</td></tr>'
                    );
                });
            }
        },
        error: function (err) {
        }
    });
}

function single_report(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/single_report/' + id,
        success: function (result) {
            if (result.success == true) {
                $('.report_id').text(result.data.report_id);
                $('.patient_name').text(result.data.patient_name);
                $('.patient_phone').text(result.data.phone_no);
                $('.patient_age').text(result.data.age);
                $('.patient_gender').text(result.data.gender);
                $('.amount').text(result.currency + result.data.amount);
                if (result.data.payment_status == 1) {
                    $('.payment_status').text('Complete');
                } else {
                    $('.payment_status').text('Not Complete');
                }
                $('.payment_type').text(result.data.payment_type);
                if (result.data.radiology == null) {
                    $('.radiology_category_id').hide();
                }
                else {
                    $('.types').html('');
                    $('.types').append(
                        '<thead class="bg-[#f4fbfd]"><tr><th class="text-sm font-semibold px-2 py-2 font-fira-sans">Screening For</th>' +
                        '<th class="text-sm font-semibold px-2 py-2 font-fira-sans">Charge</th>' +
                        '<th class="text-sm font-semibold px-2 py-2 font-fira-sans">Report Days</th></tr></thead><tbody></tbody>'
                    );
                    result.data.radiology.forEach(element => {
                        $('.types tbody').append(
                            '<tr><td class="text-sm font-light px-2 py-2 font-fira-sans">' + element.screening_for + '</td>' +
                            '<td class="text-sm font-light px-2 py-2 font-fira-sans">' + result.currency + element.charge + '</td>' +
                            '<td class="text-sm font-light px-2 py-2 font-fira-sans">' + element.report_days + '</td></tr>'
                        );
                    });
                }

                if (result.data.pathology == null) {
                    $('.pathology_category_id').hide();
                    $('.patho_test_type').hide();
                }
                else {
                    $('.types').html('');
                    $('.types').append(
                        '<thead class="bg-[#f4fbfd]"><tr><th class="text-sm font-semibold px-2 py-2 font-fira-sans">Test Name</th>' +
                        '<th class="text-sm font-semibold px-2 py-2 font-fira-sans">Charge</th>' +
                        '<th class="text-sm font-semibold px-2 py-2 font-fira-sans">Report Days</th>' +
                        '<th class="text-sm font-semibold px-2 py-2 font-fira-sans">Method</th></tr></thead><tbody></tbody>'
                    );
                    result.data.pathology.forEach(element => {
                        $('.types tbody').append(
                            '<tr><td class="text-sm font-light px-2 py-2 font-fira-sans">' + element.test_name + '</td>' +
                            '<td class="text-sm font-light px-2 py-2 font-fira-sans">' + result.currency + element.charge + '</td>' +
                            '<td class="text-sm font-light px-2 py-2 font-fira-sans">' + element.report_days + '</td>' +
                            '<td class="text-sm font-light px-2 py-2 font-fira-sans">' + element.method + '</td></tr>'
                        );
                    });
                }
            }
        },
        error: function (err) {
        }
    });

}
$("#dropdownMenuButton").click(function () {
    $(".dropdownClass").toggle();
});

function cancelAppointment(id,event) {
    event.preventDefault();
    var formData = new FormData($('#cancelForm')[0]);
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/cancelAppointment/' + id,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $(".invalid-div span").html('');
            if (result.success == true) {
                location.reload();
            }
            else {
                $(".invalid-div .review").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div span").html('');
            for (let v1 of Object.keys(err.responseJSON.errors)) {
                $(".invalid-div ." + v1).html(Object.values(err.responseJSON.errors[v1]));
            }
        }
    });

}

function delete_account(){
    Swal.fire({
        title: 'Are you sure to delete the account?',
        text: "You will lose all the data and won't be able to log back in",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                dataType: "JSON",
                url: base_url + '/delete_account',
                success: function (result) {
                    if (result.success == true) {
                         window.location.href = base_url;
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hold on!',
                            text: result.message,
                        })
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'something went wrong!'
                    })
                }
            });
        }

    });

}
