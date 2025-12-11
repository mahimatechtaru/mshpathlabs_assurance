"use strict";

var categories;

$(document).ready(function () {
    var page = 1;
    $("#more-doctor").click(function ()
    {
        page++;
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '?page=' + page,
            type: 'post',
        })
        .done(function(data){
            if(data.meta.current_page == data.meta.last_page){
                $('#more-doctor').hide();
            } else{
                $('#more-doctor').show();
            }
            $('.display_medicine').append(data.html);
        })
        .fail(function(jqXHR, ajaxOptions, throwError){
            alert('Server error');
        })
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
            },
            url: window.location.href,
            success: function (result)
            {
                $('.display_medicine').html('');
                $('.display_medicine').append(result.html);
            },
            error: function (err) {

            }
        });
    });
});

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

function searchPharmacy() {
    var search_val = $('input[name=search_pharmacy]').val();
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        data:{
            search_val:search_val,
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

    function searchBlog(){
        var search_val = $('input[name=search_val]').val();
        $.ajax({
            headers:
            {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            data:{
                search_val:search_val,
            },
            url: base_url + '/our_blogs',
            success: function (result)
            {
                $('.disBlog').html('');
                $('.disBlog').append(result.html);
            },
            error: function (err) {
    
            }
    });
}