var base_url = $('input[name=base_url]').val();

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
            $('.dispPharmacy').append(data.html);
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
                from:'js'
            },
            url: base_url + '/all-pharmacies',
            success: function (result)
            {
                $('.dispPharmacy').html('');
                $('.dispPharmacy').append(result.html);
                $('#more-doctor').hide();
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
    });
}

function searchPharmacy()
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url+'/all-pharmacies',
        type: 'post',
        data: $('#searchForm').serialize(),
        success: function (result)
        {
            $('.dispPharmacy').html('');
            $('.dispPharmacy').append(result.html);
            $("#more-doctor").hide();
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