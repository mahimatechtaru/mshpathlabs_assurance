
"use strict";

var lat = parseFloat($('#lat').val());
var lng = parseFloat($('#lng').val());

function initAutocomplete()
{
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
        title: "Drag me!",
      });
    a.addListener("dragend", (e) => {
        $('#lat').val(e.latLng.lat().toFixed(5));
        $('#lng').val(e.latLng.lng().toFixed(5));
    });

    const input = document.getElementById("pac-input");
    const searchBox = new google.maps.places.SearchBox(input);
    map.addListener("bounds_changed", () => {
      searchBox.setBounds(map.getBounds());
    });
    let markers = [];

    searchBox.addListener("places_changed", () => {
      const places = searchBox.getPlaces();

      if (places.length == 0) {
        return;
      }
      a.setMap(null)
    markers.forEach((marker) => {
        marker.setMap(null);
    });
    markers = [];

      const bounds = new google.maps.LatLngBounds();
      places.forEach((place) => {
        if (!place.geometry || !place.geometry.location) {
          return;
        }
        const icon = {
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(25, 25),
        };
        $('#lat').val(place.geometry.location.lat().toFixed(5));
        $('#lng').val(place.geometry.location.lng().toFixed(5));
        // Create a marker for each place.
        markers.push(
          new google.maps.Marker({
            map,
            icon,
            title: place.name,
            position: place.geometry.location,
          })
        );

        if (place.geometry.viewport) {

          bounds.union(place.geometry.viewport);
        } else {
          bounds.extend(place.geometry.location);
        }
      });
      map.fitBounds(bounds);
    });
}
