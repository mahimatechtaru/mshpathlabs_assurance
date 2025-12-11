
"use strict";

var base_url = $('input[name=base_url]').val();

$(document).ready(function()
{
    // select2
    $('.select2').select2({
        dropdownAutoWidth : true,
        width: '-webkit-fill-available'
    });

    $('.phone_code_select2').select2({
        dropdownAutoWidth : true,
        width: '100px'
    });

    $('.summernote').summernote({
        placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 100,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']]],
    });

    // image upload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var type = $('#imagePreview').attr('data-id');
                var fileName = document.getElementById("image").value;
                var idxDot = fileName.lastIndexOf(".") + 1;
                var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
                if (extFile=="jpg" || extFile=="jpeg" || extFile=="png")
                {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                else
                {
                    $('input[type=file]').val('');
                    alert("Only jpg/jpeg and png files are allowed!");
                    if(type == 'add')
                    {
                        $('#imagePreview').css('background-image', 'url()');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image").change(function () {
        readURL(this);
    });

    function readURL2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview2').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview2').hide();
                $('#imagePreview2').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image2").change(function () {
        readURL2(this);
    });

    function readURL3(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview3').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview3').hide();
                $('#imagePreview3').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#image3").change(function () {
        readURL3(this);
    });
    // image over

    $('#master').on('click', function(e) {
        if($(this).is(':checked',true))
        {
            $(".sub_chk").prop('checked', true);
        }
        else
        {
            $(".sub_chk").prop('checked',false);
        }
    });

    $('input[name=json_file]').on('change',function(e)
    {
        var fileName = e.target.files[0].name;
        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="json"){
            $(this).next('.custom-file-label').html(fileName);
        }else{
            $('input[type=file]').val('');
            alert("Only Json files are allowed!");
        }
    })

    // datatable start
    var datatable = $('.datatable').DataTable({
        "buttons": [
            'print',
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
        language: {
            paginate:
            {
                previous: "<i class='fa fa-angle-left'>",
                next: "<i class='fa fa-angle-right'>",
                first: "<i class='fa fa-angle-double-left'>",
                last: "<i class='fa fa-angle-double-right'>",
            }
        },
        pagingType: "full_numbers",
    });
    $('#export_print').on('click', function(e) {
        e.preventDefault();
        datatable.button(0).trigger();
    });

    $('#export_copy').on('click', function(e) {
        e.preventDefault();
        datatable.button(1).trigger();
    });

    $('#export_excel').on('click', function(e) {
        e.preventDefault();
        datatable.button(2).trigger();
    });

    $('#export_csv').on('click', function(e) {
        e.preventDefault();
        datatable.button(3).trigger();
    });

    $('#export_pdf').on('click', function(e) {
        e.preventDefault();
        datatable.button(4).trigger();
    });
    // datatable over

    // display Category ( treatments wise )
    $('select[name=treatment_id]').on('change', function()
    {
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: base_url + '/display_category/'+this.value,
            success: function (result)
            {
                $('select[name="category_id"]').html('');
                $('select[name="category_id"]').append(
                    $("<option></option>").attr("value", '').text('please select category')
                );
                result.data.forEach(element => {
                    $('select[name="category_id"]').append(
                        $("<option></option>").attr("value", element.id).text(element.name)
                    );
                });
            },
            error: function (err) {

            }
        });
    });

    // display expertise ( category wise )
    $('select[name=category_id]').on('change', function()
    {
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: base_url + '/display_expertise/'+this.value,
            success: function (result)
            {
                $('select[name="expertise_id"]').html('');
                result.data.forEach(element => {
                    $('select[name="expertise_id"]').append(
                        $("<option></option>").attr("value", element.id).text(element.name)
                    );
                });
            },
            error: function (err) {

            }
        });
    });

    // Timeslot other===============================================================
    $('select[name=timeslot]').on('change', function()
    {
        if(this.value == 'other')
        {
            $('.custom_timeslot').show();
            $('.custom_timeslot_text').prop('required',true);
        }
        else
        {
            $('.custom_timeslot').hide();
            $('.custom_timeslot_text').prop('required',false);
        }
    });

    $('input[name=is_flat]').on('change', function()
    {
        if(this.checked == true)
        {
            $('.flatDiscCol').show();
            $('.discountCol').hide();
            $('input[name=flatDiscount]').prop('required',true);
            $('input[name=discount]').prop('required',false);
        }
        else
        {
            $('.flatDiscCol').hide();
            $('.discountCol').show();
            $('input[name=flatDiscount]').prop('required',false);
            $('input[name=discount]').prop('required',true);
        }
    });

    if($('input[name="start_end_date"]').length > 0)
    {
        var today = new Date();
        $('input[name="start_end_date"]').daterangepicker(
        {
            opens: 'left',
            minDate: today,
            locale:
            {
                format: 'YYYY-MM-DD'
            },
        }, function (start, end, label) {
            $('#start_Period').val(start.format('YYYY-MM-DD'));
            $('#end_Period').val(end.format('YYYY-MM-DD'));
        });
    }

    if($('input[name="update_start_end_date"]').length > 0)
    {
        var today = new Date();
        $('input[name="update_start_end_date"]').daterangepicker(
        {
            opens: 'left',
            locale:
            {
                format: 'YYYY-MM-DD'
            },
        }, function (start, end, label) {
            $('#start_Period').val(start.format('YYYY-MM-DD'));
            $('#end_Period').val(end.format('YYYY-MM-DD'));
        });
    }

    // Flatpicker timepicker
    $(".timepicker").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: false,
    });

    // Flatpicker datepicker
    $(".datePicker").flatpickr({
        dateFormat: "Y-m-d",
        maxDate: "today",
    });

    // Based On
    $('select[name=based_on]').on('change', function()
    {
        if(this.value == 'commission')
        {
            $('.base_on_com').show();
            $('.base_on_com_text').prop('required',true);
        }
        else
        {
            $('.base_on_com').hide();
            $('.base_on_com_text').prop('required',false);
        }
    });

    // Default Based On in setting
    $('select[name=default_base_on]').on('change', function()
    {
        if(this.value == 'commission')
        {
            $('.default_base_on_com').show();
            $('.default_base_on_com_text').prop('required',true);
        }
        else
        {
            $('.default_base_on_com').hide();
            $('.default_base_on_com_text').prop('required',false);
        }
    });

    // Add More Hours
    $(".hours-info").on('click','.trash', function () {
        $(this).closest('.hours-cont').remove();
        return false;
    });

    $(".add-hours").on('click', function ()
    {
        var hourscontent = '<div class="row form-row hours-cont">' +
            '<div class="col-12 col-md-10">' +
                '<div class="row form-row">' +
                    '<div class="col-12 col-md-6">' +
                        '<div class="form-group">' +
                            '<label>Start Time</label>' +
                            '<input readonly class="timeslots form-control" value="11:00 AM" name="start_time[]" />' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-12 col-md-6">' +
                        '<div class="form-group">' +
                            '<label>End Time</label>' +
                            '<input readonly class="timeslots form-control" value="11:00 PM" name="end_time[]" />' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="col-12 col-md-2"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0)" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
        '</div>';

        $(".hours-info").append(hourscontent);
        timeslot_generator();
        return false;
    });

    // Timeslot Generator
    timeslot_generator();

    // Registration Add More
    $(".registrations-info").on('click','.trash', function () {
        $(this).closest('.reg-cont').remove();
        return false;
    });

    $(".add-reg").on('click', function () {
        var regcontent = '<div class="row form-row reg-cont">' +
            '<div class="col-12 col-md-5">' +
                '<div class="form-group">' +
                    '<label>Month</label>' +
                    '<input type="number" name="month[]" required class="form-control">' +
                '</div>' +
            '</div>' +
            '<div class="col-12 col-md-5">' +
                '<div class="form-group">' +
                    '<label>Price</label>' +
                    '<input type="number" name="price[]" required class="form-control">' +
                '</div>' +
            '</div>' +
            '<div class="col-12 col-md-2">' +
                '<label class="d-md-block d-sm-none d-none">&nbsp;</label>' +
                '<a href="javascript:void(0)" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a>' +
            '</div>' +
        '</div>';

        $(".registrations-info").append(regcontent);
        return false;
    });

    // ADD TABLE ROW IN PRESCRIPTION
    $(".AddMoreRow").on('click', function ()
    {
        var length = $('.trCopy').length;
        $('.tBody').append(
            '<tr class="trCopy">'+
            '<td class="medicine'+length+'"></td>'+
            '<td>' +
                '<input class="form-control" min="1" name="day[]" value="2" type="text">' +
            '</td>' +
            '<td>' +
                '<div class="d-flex">'+
                    '<div class="p-2">'+
                        '<input type="checkbox" value="1" id="morning'+length+'" name="morning'+length+'[]">'+
                        '<label class="ml-2" for="morning'+length+'">morning</label>'+
                    '</div>'+
                    '<div class="p-2">' +
                        '<input type="checkbox" value="1" id="afternoon'+length+'" name="afternoon'+length+'[]">'+
                        '<label class="ml-2" for="afternoon'+length+'">afternoon</label>'+
                    '</div>'+
                    '<div class="p-2">' +
                        '<input type="checkbox" value="1" id="night'+length+'" name="night'+length+'[]">' +
                        '<label class="ml-2" for="night'+length+'">night</label>'+
                    '</div>' +
                '</div>' +
            '</td>' +
            '<td>' +
                '<button type="button" class="btn bg-danger-light trash deleteBtn"><i class="far fa-trash-alt"></i></button>' +
            '</td>' +
        '</tr>');
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "GET",
            url: base_url + '/allMedicine',
            success: function (result) {
                $('.medicine'+length).append('<select name="medicines[]" class="select2 custom">');
                $('.select2').select2({
                    dropdownAutoWidth : true,
                    width: '-webkit-fill-available'
                });
                result.data.forEach(element => {
                    $('.custom').append('<option value="'+element.name+'">'+element.name+'</option>');
                });
            },
            error: function (err) {
            }
        });

        $(document).on('click', '.deleteBtn', function() {
            $(this).closest('.trCopy').remove();
        });
    });

    $(document).on('click', 'button.removebtn', function ()
    {
        $(this).closest('tr').remove();
        return false;
    });

    // Delivery Charge toggle button
    $("#is_shipping").change(function()
    {
        if(this.checked == true)
        {
            $('.deliveryChargeDiv').show(500);
            $('.min_value').prop('required',true);
            $('.max_value').prop('required',true);
            $('.charges').prop('required',true);
        }
        else
        {
            $('.deliveryChargeDiv').hide(500);
            $('.min_value').prop('required',false);
            $('.max_value').prop('required',false);
            $('.charges').prop('required',false);
        }
    });
});



// Delivery charge
function addCharge(){
    $('.delivery_charge_table').append(
        '<tr><td><input type="number" required name="min_value[]" class="form-control"></td>'+
        '<td><input type="number" required name="max_value[]" class="form-control"></td>' +
        '<td><input type="number" required name="charges[]" class="form-control"></td>' +
        '<td><button type="button" class="btn btn-danger removebtn"><i class="fas fa-times"></i></button></td></tr>'
    );
}

// display stock in medicine
function display_stock(id)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/medicine/display_stock/'+id,
        success: function (result) {
            $('.incoming_stock').val(result.data.incoming_stock);
            $('input[name=medicine_id]').val(result.data.id);
        },
        error: function (err) {

        }
    });
}

// change status
function change_status(url, id)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/' + url + '/change_status',
        data:
        {
            id: id,
        },
        success: function (result) {
            // iziToast.success({
            //     message: 'Change status successfully..!!',
            //     position: 'topRight',
            // })
        },
        error: function (err) {

        }
    });
}

// Delete Data
function deleteData(url, id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) =>
    {
        if (result.value) {
            $.ajax({
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "DELETE",
                dataType: "JSON",
                url: base_url + '/' + url + '/' + id,
                success: function (result) {
                    if (result.success == true) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        Swal.fire(
                            'Deleted!',
                            'Your Data has been deleted.',
                            'success'
                        )
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops',
                            text: result.msg ?? result.data,
                        })
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: result.data
                    })
                }
            });
        }
    });
}

// Delete Multiple Data
function deleteAll(url) {
    var allVals = [];
    $(".sub_chk:checked").each(function() {
        allVals.push($(this).attr('data-id'));
    });
    if(allVals.length <=0)
    {
        alert("Please select row.");
    }
    else
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
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
                    type: "POST",
                    url: base_url +'/' + url,
                    data:{
                        ids: allVals.join(","),
                    },
                    success: function (result) {
                        if (result.success == true) {
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                            Swal.fire(
                                'Deleted!',
                                'Your Data has been deleted.',
                                'success'
                            )
                        }
                        else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: result.data
                            })
                        }
                    },
                    error: function (err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'This record is conntect with another data!'
                        })
                    }
                });
            }
        });
    }
}

// Education Add More
$(".education-info").on('click','.trash', function () {
    $(this).closest('.education-cont').remove();
    // $(this).closest('div').remove();
    return false;
});

$(".add-education").on('click', function () {
    var educationcontent = '<div class="row form-row education-cont">' +
        '<div class="col-12 col-md-10 col-lg-11">' +
            '<div class="row form-row">' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                    '<div class="form-group">' +
                        '<label>Degree</label>' +
                        '<input type="text" required name="degree[]" class="form-control">' +
                    '</div>' +
                '</div>' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                    '<div class="form-group">' +
                        '<label>College/Institute</label>' +
                        '<input type="text" required name="college[]" class="form-control">' +
                    '</div>' +
                '</div>' +
                '<div class="col-12 col-md-6 col-lg-4">' +
                    '<div class="form-group">' +
                        '<label>Year of Completion</label>' +
                        '<input type="number" required name="year[]" maxlength="4" pattern="^[0-9]{4}$" class="form-control">' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2 col-lg-1"><label class="d-md-block d-sm-none d-none">&nbsp;</label><a href="javascript:void(0)" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a></div>' +
    '</div>';

    $(".education-info").append(educationcontent);
    return false;
});

// Awards Add More
$(".awards-info").on('click','.trash', function () {
    $(this).closest('.awards-cont').remove();
    return false;
});

$(".add-award").on('click', function () {

    var regcontent = '<div class="row form-row awards-cont">' +
        '<div class="col-12 col-md-5">' +
            '<div class="form-group">' +
                '<label>certificate</label>' +
                '<input type="text" required name="certificate[]" class="form-control">' +
            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-5">' +
            '<div class="form-group">' +
                '<label>Year</label>' +
                '<input type="text" required name="certificate_year[]" maxlength="4" pattern="^[0-9]{4}$" class="form-control">' +
            '</div>' +
        '</div>' +
        '<div class="col-12 col-md-2">' +
            '<label class="d-md-block d-sm-none d-none">&nbsp;</label>' +
            '<a href="javascript:void(0)" class="btn btn-danger trash"><i class="far fa-trash-alt"></i></a>' +
        '</div>' +
    '</div>';

    $(".awards-info").append(regcontent);
    return false;
});

$(".add-moreInfo").on('click', function ()
{
    var append = '<div class="moreInfoDiv"><label class="col-form-label">Title</label>'+
    '<div class="form-group">'+
    '<input type="text" name="title[]" required class="form-control">'+
    '</div>'+
    '<label class="col-form-label">Description</label>'+
    '<div class="form-group">'+
    '<textarea name="desc[]" required class="form-control summernote"></textarea>'+
    '</div>'+
    '<a class="btn btn-danger text-white moreDelete"><i class="far fa-trash-alt"></i></a>' +
    '</div>'
    $(".moreInfo").append(append);
    $('.summernote').summernote({
        placeholder: 'Hello',
        tabsize: 2,
        height: 100,
        toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']]],
    });
});

$(document).on('click', '.moreDelete', function()
{
    $(this).closest('.moreInfoDiv').remove();
});

// Circle Progress Bar
function animateElements() {
    $('.circle-bar1').each(function () {
        var elementPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        var percent = $(this).find('.circle-graph1').attr('data-percent');
        var animate = $(this).data('animate');
        if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
            $(this).data('animate', true);
            $(this).find('.circle-graph1').circleProgress({
                value: percent / 100,
                size : 400,
                thickness: 30,
                fill: {
                    color: '#da3f81'
                }
            });
        }
    });
    $('.circle-bar2').each(function () {
        var elementPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        var percent = $(this).find('.circle-graph2').attr('data-percent');
        var animate = $(this).data('animate');
        if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
            $(this).data('animate', true);
            $(this).find('.circle-graph2').circleProgress({
                value: percent / 100,
                size : 400,
                thickness: 30,
                fill: {
                    color: '#68dda9'
                }
            });
        }
    });
    $('.circle-bar3').each(function () {
        var elementPos = $(this).offset().top;
        var topOfWindow = $(window).scrollTop();
        var percent = $(this).find('.circle-graph3').attr('data-percent');
        var animate = $(this).data('animate');
        if (elementPos < topOfWindow + $(window).height() - 30 && !animate) {
            $(this).data('animate', true);
            $(this).find('.circle-graph3').circleProgress({
                value: percent / 100,
                size : 400,
                thickness: 30,
                fill: {
                    color: '#1b5a90'
                }
            });
        }
    });
}

function display_timeslot(id)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/display_timeslot'+'/'+id,
        success: function (result)
        {
            $('input[name=working_id]').val(result.data.id);
            $('.doc-times').html('');
            JSON.parse(result.data.period_list).forEach(element => {
                $('.doc-times').append('<div class="badge badge-primary ml-2 mt-5">'+element.start_time+' - '+element.end_time+'</div>')
            });
            $('.doc-times').append(
                '<div class=" float-right">'+
                '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                '<a href="#edit_time_slot" data-toggle="modal" onclick="edit_timeslot()" class="btn btn-danger mt-2">'+
                    '<i class="fa fa-edit mr-1"></i> Edit Slot' +
                '</a>' +
            '</div>');

        },
        error: function (err) {

        }
    });
}
function edit_timeslot()
{
    var id = $('input[name=working_id]').val();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/edit_timeslot'+'/'+id,
        success: function (result)
        {
            $('.working_form').attr('action', base_url+'/update_timeslot');
            $('input[name=working_id]').val(result.data.id);
            if(result.data.status == 1)
            {
                $('input[name=status]').prop('checked',true);
            }
            else
            {
                $('input[name=status]').prop('checked',false);
            }
            $('.display_timing').html('');
            JSON.parse(result.data.period_list).forEach((element,index) =>
            {
                $('.display_timing').append(
                    '<div class="row form-row hours-cont delete'+index+'">'+
                        '<div class="col-12 col-md-10">'+
                            '<div class="row form-row">'+
                                '<div class="col-12 col-md-6">' +
                                    '<div class="form-group">' +
                                        '<label>Start Time</label>'+
                                        '<input readonly class="timeslots form-control start_time" name="start_time[]" value="'+element.start_time+'" />' +
                                    '</div>' +
                                '</div>'+
                                '<div class="col-12 col-md-6">'+
                                    '<div class="form-group">'+
                                    '<label>End Time</label>'+
                                    '<input readonly class="timeslots form-control end_time" name="end_time[]" value="'+element.end_time+'"/>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>');
                timeslot_generator();
                if(index != 0)
                {
                    $('.delete'+index).append('<div class="col-12 col-md-2">'+
                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                    '<a href="javascript:void(0)" class="btn btn-danger trash">'+
                        '<i class="far fa-trash-alt"></i>' +
                    '</a>' +
                '</div>');
                }
            });
        },
        error: function (err) {

        }
    });
}

function display_lab_timeslot(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/display_lab_timeslot'+'/'+id,
        success: function (result)
        {
            $('input[name=working_id]').val(result.data.id);
            $('.lbtimeslot').html('');
            JSON.parse(result.data.period_list).forEach(element => {
                $('.lbtimeslot').append('<div class="badge badge-primary ml-2 mt-5">'+element.start_time+' - '+element.end_time+'</div>');
            });
        },
        error: function (err) {

        }
    });
}



function edit_lab_timeslot() {
    var id = $('input[name=working_id]').val();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/edit_lab_timeslot'+'/'+id,
        success: function (result)
        {
            $('.working_form').attr('action', base_url+'/update_lab_timeslot');
            $('input[name=working_id]').val(result.data.id);
            if(result.data.status == 1)
            {
                $('input[name=status]').prop('checked',true);
            }
            else
            {
                $('input[name=status]').prop('checked',false);
            }
            $('.display_timing').html('');
            JSON.parse(result.data.period_list).forEach((element,index) =>
            {
                $('.display_timing').append(
                    '<div class="row form-row hours-cont delete'+index+'">'+
                        '<div class="col-12 col-md-10">'+
                            '<div class="row form-row">'+
                                '<div class="col-12 col-md-6">' +
                                    '<div class="form-group">' +
                                        '<label>Start Time</label>'+
                                        '<input readonly class="timeslots form-control start_time" name="start_time[]" value="'+element.start_time+'" />' +
                                    '</div>' +
                                '</div>'+
                                '<div class="col-12 col-md-6">'+
                                    '<div class="form-group">'+
                                    '<label>End Time</label>'+
                                    '<input readonly class="timeslots form-control end_time" name="end_time[]" value="'+element.end_time+'"/>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>');
                timeslot_generator();
                if(index != 0)
                {
                    $('.delete'+index).append('<div class="col-12 col-md-2">'+
                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                    '<a href="javascript:void(0)" class="btn btn-danger trash">'+
                        '<i class="far fa-trash-alt"></i>' +
                    '</a>' +
                '</div>');
                }
            });
        },
        error: function (err) {

        }
    });
}

function change_lab_payment_status(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/change_lab_payment_status'+'/'+id,
        success: function (result)
        {
            location.reload();
        },
        error: function (err) {

        }
    });
}

function display_pharmacy_timeslot(id)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/display_pharmacy_timeslot'+'/'+id,
        success: function (result)
        {
            $('input[name=working_id]').val(result.data.id);
            $('.pharmacyTimeslot').html('');
            JSON.parse(result.data.period_list).forEach(element => {
                $('.pharmacyTimeslot').append('<div class="badge badge-primary ml-2 mt-5">'+element.start_time+' - '+element.end_time+'</div>');
            });
        },
        error: function (err) {

        }
    });
}

function edit_pharmacy_timeslot()
{
    var id = $('input[name=working_id]').val();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/edit_pharmacy_timeslot'+'/'+id,
        success: function (result)
        {
            $('.working_pharmacy_form').attr('action', base_url+'/update_pharmacy_timeslot');
            $('input[name=working_id]').val(result.data.id);
            if(result.data.status == 1)
            {
                $('input[name=status]').prop('checked',true);
            }
            else
            {
                $('input[name=status]').prop('checked',false);
            }
            $('.display_timing').html('');
            JSON.parse(result.data.period_list).forEach((element,index) =>
            {
                $('.display_timing').append(
                    '<div class="row form-row hours-cont delete'+index+'">'+
                        '<div class="col-12 col-md-10">'+
                            '<div class="row form-row">'+
                                '<div class="col-12 col-md-6">' +
                                    '<div class="form-group">' +
                                        '<label>Start Time</label>'+
                                        '<input readonly class="timeslots form-control start_time" name="start_time[]" value="'+element.start_time+'" />' +
                                    '</div>' +
                                '</div>'+
                                '<div class="col-12 col-md-6">'+
                                    '<div class="form-group">'+
                                    '<label>End Time</label>'+
                                    '<input readonly class="timeslots form-control end_time" name="end_time[]" value="'+element.end_time+'"/>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                    '</div>');
                timeslot_generator();
                if(index != 0)
                {
                    $('.delete'+index).append('<div class="col-12 col-md-2">'+
                    '<label class="d-md-block d-sm-none d-none">&nbsp;</label>'+
                    '<a href="javascript:void(0)" class="btn btn-danger trash">'+
                        '<i class="far fa-trash-alt"></i>' +
                    '</a>' +
                '</div>');
                }
            });
        },
        error: function (err) {

        }
    });
}

// timeslot generator
function timeslot_generator()
{
    var start_time = $('input[name=start_time]').val();
    var end_time =  $('input[name=end_time]').val();
    var timeslot = $('input[name=timeslot]').val();

    $('.timeslots').timepicker({
        timeFormat: 'hh:mm p',
        interval: timeslot,
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        startTime: start_time,
        minTime: start_time,
        maxTime: end_time,
    });
}

// Notification template
function edit_template(id)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/edit_notification'+'/'+id,
        success: function (result)
        {
            if(result.success == true)
            {
                $('#subject').val(result.data.subject);
                $('#title').val(result.data.title);
                $('h5').text(result.data.title);
                $('#msg_content').val(result.data.msg_content);
                $('#mail_content').summernote('code', result.data.mail_content);
                $('.update_template').attr("action",base_url+"/update_template/"+result.data.id);
            }
        },
        error: function (err) {

        }
    });
}

// change subscription status
function change_paymentStatus(id) {
    $.ajax(
    {
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        data:
        {
            subscription_id: id,
        },
        url: base_url + '/subscription/changePaymentStatus/'+id,
        success: function (result) {
            if (result.success == true)
            {
                $('#paymentStatus' + id).prop('disabled',true);
            }
        },
        error: function (err) {
        }
    });
}

// Display Appointment
function show_appointment(appointment_id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/show_appointment/'+appointment_id,
        success: function (result)
        {
            $('.appointment_id').text(result.data.appointment_id);
            $('.doctor_name').text(result.data.doctor.name);
            $('.amount').text(result.currency+result.data.amount);
            $('.date').text(result.data.date);
            $('.hospital').text(result.data.hospital.name);
            $('.time').text(result.data.time);
            $('.drug_effect').text(result.data.drug_effect);
            $('.doctor_note').text(result.data.note);
            $('.doctor_note').text(result.data.note);
            if(result.data.payment_status == 0)
            {
                $('.payment_status').text('payment not complete')
            }
            else
            {
                $('.payment_status').text('payment complete')
            }
            $('.payment_type').text(result.data.payment_type);
            $('.illness_info').text(result.data.illness_information);
            $('.patient_name').text(result.data.patient_name);
            $('.patient_phone').text(result.data.phone_no);
            $('.patient_address').text(result.data.patient_address);
            $('.patient_age').text(result.data.age);
            $('.is_insured').text(result.data.is_insured);
            if (result.data.is_insured == 1) {
                $('.policy_insurer_row').show();
                $('.policy_number_row').show();
                $('.policy_insurer_name').text(result.data.policy_insurer_name);
                $('.policy_number').text(result.data.policy_number);
            } else {
                $('.policy_insurer_row').hide();
                $('.policy_number_row').hide();
            }
        },
        error: function (err) {

        }
    });
}

// Cancel reason
function add_cancel_reason() {
    $('.cancel_reason').append('<tr><td><input type="text" name="cancel_reason[]" class="form-control" required></td><td><button type="button" class="btn btn-danger removebtn"><i class="fas fa-times"></i></button></td></tr>');
}

// show settlement details
function show_settle_details(index) {
    var duration = $('#duration' + index).text();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/show_settalement',
        data:{
            duration : duration
        },
        success: function (result) {
            if (result.success == true) {
                $('.details_body').html('');
                $('.details_body').append('<div class="table-responsive">'+
                    '<table class="table">' +
                        '<thead class="display">'+
                            '<tr>'+
                                '<th>Date</th>'+
                                '<th>Doctor earning</th>'+
                                '<th>Admin earning</th>' +
                            '</tr>'+
                        '</thead>' +
                    '</table></div>');
                if (result.data.length != 0) {
                    result.data.forEach(element => {
                    $('.display').after(
                        '<tbody>' +
                            '<td>' + element.date + '</td>'+
                            '<td>' + result.currency + element.doctor_amount + '</td>'+
                            '<td>' + result.currency + element.admin_amount + '</td>'+
                        '</tbody>');
                    });
                }
                else {
                    $('.display').after('<tbody class="text-center"><td colspan="4">No details found</td></tbody>');
                }
            }
        },
        error: function (err) {
        }
    });
}

// show lab settle details
function show_lab_settle_details(index) {
    var duration = $('#duration' + index).text();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/show_lab_settalement',
        data:{
            duration : duration
        },
        success: function (result) {
            if (result.success == true) {
                $('.details_body').html('');
                $('.details_body').append('<div class="table-responsive">'+
                    '<table class="table">' +
                        '<thead class="display">'+
                            '<tr>'+
                                '<th>Date</th>'+
                                '<th>Lab earning</th>'+
                                '<th>Admin earning</th>' +
                            '</tr>'+
                        '</thead>' +
                    '</table></div>');
                if (result.data.length != 0) {
                    result.data.forEach(element => {
                    $('.display').after(
                        '<tbody>' +
                            '<td>' + element.date + '</td>'+
                            '<td>' + result.currency + element.lab_amount + '</td>'+
                            '<td>' + result.currency + element.admin_amount + '</td>'+
                        '</tbody>');
                    });
                }
                else {
                    $('.display').after('<tbody class="text-center"><td colspan="4">No details found</td></tbody>');
                }
            }
        },
        error: function (err) {
        }
    });
}

// show pharmacy settlement details
function show_pharmacy_settle_details(index) {
    var duration = $('#duration' + index).text();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: base_url + '/show_pharmacy_settle_details',
        data:{
            duration : duration
        },
        success: function (result) {
            if (result.success == true) {
                $('.details_body').html('');
                $('.details_body').append('<div class="table-responsive">'+
                    '<table class="table">' +
                        '<thead class="display">'+
                            '<tr>'+
                                '<th>Date</th>'+
                                '<th>Pharmacy earning</th>'+
                                '<th>Admin earning</th>' +
                            '</tr>'+
                        '</thead>' +
                    '</table></div>');
                if (result.data.length != 0) {
                    result.data.forEach(element => {
                    $('.display').after(
                        '<tbody>' +
                            '<td>' + element.date + '</td>'+
                            '<td>' + result.currency + element.pharmacy_amount + '</td>'+
                            '<td>' + result.currency + element.admin_amount + '</td>'+
                        '</tbody>');
                    });
                }
                else {
                    $('.display').after('<tbody class="text-center"><td colspan="4">No details found</td></tbody>');
                }
            }
        },
        error: function (err) {
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
        url: base_url + '/display_purchase_medicine/'+id,
        success: function (result) {
            if (result.success == true)
            {
                $('.shippingAt').text(result.data.shipping_at);
                if(result.data.shipping_at == 'home')
                {
                    $('.shippingAddressTr').show();
                    $('.shippingAddress').text(result.data.address.address);
                    $('.deliveryCharge').text(result.data.delivery_charge != null ? result.currency+result.data.delivery_charge : 'N/A');
                }
                else
                {
                    $('.shippingAddressTr').hide();
                }
                $('.phone').text(result.phone);
                $('.tbody').html('');
                result.data.medicine_name.forEach(element =>
                {
                    $('.tbody').append(
                        '<tr><td>'+element.name+'</td>'+
                        '<td>'+element.qty+'</td>'+
                        '<td>'+result.currency+element.price+'</td></tr>'
                    );
                });
            }
        },
        error: function (err) {
        }
    });
}

function upload_report(id) {
    $('input[name=report_id]').val(id);
}

function single_report(id) {
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "GET",
        url: base_url + '/single_report/'+id,
        success: function (result) {
            if (result.success == true)
            {
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
                if (result.data.radiology_category == null) {
                    $('.radiology_category_id').hide();
                }
                else
                {
                    $('.radiology_category').text(result.data.radiology_category);
                    $('.types').html('');
                    $('.types').append(
                        '<thead><tr><th>Screening For</th>'+
                        '<th>Charge</th>'+
                        '<th>Report Days</th></tr></thead><tbody></tbody>'
                    );
                    result.data.radiology.forEach(element =>
                    {
                        $('.types tbody').append(
                            '<tr><td>'+element.screening_for+'</td>'+
                            '<td>'+result.currency+element.charge+'</td>'+
                            '<td>'+element.report_days+'</td></tr>'
                        );
                    });
                }

                if (result.data.pathology_category == null) {
                    $('.pathology_category_id').hide();
                    $('.patho_test_type').hide();
                }
                else
                {
                    $('.pathology_category').text(result.data.pathology_category);
                    $('.types').html('');
                    $('.types').append(
                        '<thead><tr><th>Test Name</th>'+
                        '<th>Charge</th>'+
                        '<th>Report Days</th>'+
                        '<th>Method</th></tr></thead><tbody></tbody>'
                    );
                    result.data.pathology.forEach(element =>
                    {
                        $('.types tbody').append(
                            '<tr><td>'+element.test_name+'</td>'+
                            '<td>'+result.currency+element.charge+'</td>'+
                            '<td>'+element.report_days+'</td>'+
                            '<td>'+element.method+'</td></tr>'
                        );
                    });
                }
            }
        },
        error: function (err) {
        }
    });
}

function testMail()
{
    var mail_to = $('input[name="mail_to"]').val();
    if(mail_to == "")
    {
        $('#validate').text('Email Field Is Required.');
    }
    else
    {
        $('.emailstatus').html('<div class="text-success mt-3"><h6>Sending...</h6></div>');
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:
            {
                to: mail_to
            },
            url: base_url + '/test_mail',
            success: function (result) {
                if (result.success == true) {
                    $('.emailstatus').html('');
                    $('.emailstatus').html(' <div class="text-success mt-3"><h6>' + result.message + '</h6></div>');
                } else if (result.success == false) {
                    $('.emailstatus').html('');
                    $('.emailstatus').html(' <div class="text-danger mt-3"><h6>' + result.message + '</h6></div>');
                    $('.emailerror').html(' <div class="text-danger mt-2"><p>' + result.message + '</p></div>');
                }
            }
        });
    }
}
