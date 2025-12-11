"use strict";

var lat, lng;
var base_url = $("input[name=base_url]").val();
lat = parseFloat($("input[name=lat]").val());
lng = parseFloat($("input[name=lang]").val());

function addAddress() {
    var addformData = new FormData($(".addAddress")[0]);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        url: base_url + "/addAddress",
        data: addformData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            $(".invalid-div span").html("");
            if (result.success == true) {
                location.reload();
            } else {
                $(".invalid-div .address").html(result.data);
            }
        },
        error: function (err) {
            $(".invalid-div span").html("");
            for (let v1 of Object.keys(err.responseJSON.errors)) {
                $(".invalid-div ." + v1).html(
                    Object.values(err.responseJSON.errors[v1])
                );
            }
        },
    });
}

function editAddress(id) {
    $.ajax({
        headers: {
            "XCSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "GET",
        url: "edit_user_address/" + id,
        success: function (result) {
            $(".invalid-div span").html("");

            $("input[name=from]").val("edit");
            $("input[name=id]").val(result.data.id);
            $("input[name=lat]").val(result.data.lat);
            $("input[name=lang]").val(result.data.lang);
            $("textarea[name=address]").val(result.data.address);
            lat = parseFloat($("input[name=lat]").val());
            lng = parseFloat($("input[name=lang]").val());
            initAutocomplete();
        },
        error: function (err) {},
    });
}

function updateAddress() {
    var id = document.getElementById("address_id").value;
    var addformData = new FormData($(".updateAddress")[0]);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "POST",
        url: base_url + "/update_user_address/" + id,
        data: addformData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (result) {
            if(result.success == true) {
                window.location.reload();
            } else if(result.success == false) {
                $(".invalid-div span").html("");
                $(".invalid-div .address").html(result.data);
            }

        },
        error: function (err) {
            $(".invalid-div span").html("");
            for (let v1 of Object.keys(err.responseJSON.errors)) {
                $(".invalid-div ." + v1).html(
                    Object.values(err.responseJSON.errors[v1])
                );
            }
        },
    });
    console.log(addformData);
}

function initAutocomplete() {
    var map = new google.maps.Map(document.getElementById("map"), {
        center: { lat: lat, lng: lng },
        zoom: 13,
        mapTypeId: "roadmap",
    });
    var a = new google.maps.Marker({
        position: {
            lat: lat,
            lng: lng,
        },
        map,
        draggable: true,
    });
    google.maps.event.addListener(a, "dragend", function () {
        geocodePosition(a.getPosition());
        $("input[name=lat]").val(a.getPosition().lat().toFixed(5));
        $("input[name=lang]").val(a.getPosition().lng().toFixed(5));
    });

    var map = new google.maps.Map(document.getElementById("map2"), {
        center: { lat: lat, lng: lng },
        zoom: 13,
        mapTypeId: "roadmap",
    });

    var b = new google.maps.Marker({
        position: {
            lat: lat,
            lng: lng,
        },
        map,
        draggable: true,
    });
    google.maps.event.addListener(b, "dragend", function () {
        geocodePosition(b.getPosition());
        $("input[name=lat]").val(b.getPosition().lat().toFixed(5));
        $("input[name=lang]").val(b.getPosition().lng().toFixed(5));
    });
}

function geocodePosition(pos) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode(
        {
            latLng: pos,
        },
        function (responses) {
            if (responses && responses.length > 0) {
                $("textarea[name=address]").val(responses[0].formatted_address);
            } else {
                $("textarea[name=address]").val(
                    "Cannot determine address at this location."
                );
            }
        }
    );
}

function deleteData(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                type: "GET",
                dataType: "JSON",
                url: base_url + "/address_delete" + "/" + id,
                success: function (result) {
                    if (result.success == true) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                        Swal.fire(
                            "Deleted!",
                            "Your Data has been deleted.",
                            "success"
                        );
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: result.data,
                        });
                    }
                },
                error: function (err) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "This record is conntect with another data!",
                    });
                },
            });
        }
    });
}
