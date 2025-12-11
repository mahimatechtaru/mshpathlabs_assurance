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
            $('.dispDoctor').append(data.html);
        })
        .fail(function(jqXHR, ajaxOptions, throwError){
            alert('Server error');
        })
    });

    $('#filter_form').change(function () {
        var categories = [];
        var gender = $('input[name="gender_type"]:checked').val();
        var sort_by = $('select[name=sort_by]').val();
        $('input[name="select_specialist"]:checked').each(function(i)
        {
            if(categories.indexOf(this.value) === -1) {
                categories.push(this.value);
            }
        });

        $.ajax({
          headers:
          {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "POST",
          data:{
              category:categories,
              gender_type:gender,
              sort_by:sort_by,
              from: 'js',
              doc_lat: $('input[name=doc_lat]').val(),
              doc_lang: $('input[name=doc_lang]').val(),
              search_doctor: $('input[name=search_doctor]').val(),
          },
          url: base_url + '/show-doctors',
          success: function (result)
          {
              $('.dispDoctor').html('');
              $('.dispDoctor').append(result.html);
              $(".myDrop").toggleClass("show");
              $("#more-doctor").hide();
              categories.length = 0;
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
        $('input[name=doc_lat]').val(lat);
        $('input[name=doc_lang]').val(lang);
    });
}

function searchDoctor()
{
    var doc_lat = $('input[name=doc_lat]').val();
    var doc_lang = $('input[name=doc_lang]').val();
    var search_doctor = $('input[name=search_doctor]').val();
    var categories = [];
    var gender = $('input[name="gender_type"]:checked').val();
    var sort_by = $('select[name=sort_by]').val();
    $('input[name="select_specialist"]:checked').each(function(i)
    {
        if(categories.indexOf(this.value) === -1) {
            categories.push(this.value);
        }
    });
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url+'/show-doctors',
        type: 'post',
        data: {
            doc_lat: doc_lat,
            doc_lang: doc_lang,
            search_doctor: search_doctor,
            category: categories,
            gender_type: gender,
            sort_by: sort_by,
        },
        success: function (result)
        {
            $('.dispDoctor').html('');
            $('.dispDoctor').append(result.html);
            $("#more-doctor").hide();
        },
        error: function (err) {
        }
    });
}
