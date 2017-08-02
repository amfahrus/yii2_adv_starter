function initializeMap(lat,lng,rad) {

  var centerMap = new google.maps.LatLng(lat,lng);
  var markersArray = [];

  var myOptions = {
    zoom: 15,
    center: centerMap,
    mapTypeId: google.maps.MapTypeId.MAP
  }

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var cityCircle = new google.maps.Circle({
    strokeColor: '#FF0000',
    strokeOpacity: 0.8,
    strokeWeight: 2,
    fillColor: '#58FA82',
    fillOpacity: 0.35,
    map: map,
    center: myOptions.center,
    radius: Number(rad)
  });

  google.maps.event.addListener(cityCircle, 'click', function (e) {
    $("#lat").val(e.latLng.lat().toFixed(6));
    $("#long").val(e.latLng.lng().toFixed(6));
    placeMarker(e.latLng);
  });

  function placeMarker(location) {
    // first remove all markers if there are any
    deleteOverlays();

    var marker = new google.maps.Marker({
      position: location,
      map: map
    });

    // add marker in markers array
    markersArray.push(marker);

    //map.setCenter(location);
  }

  // Deletes all markers in the array by removing references to them
  function deleteOverlays() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
    markersArray.length = 0;
    }
  }

};
$(document).ready(function() {
initializeMap('-6.240524','106.877515',2500);
//$('#map_canvas').hide();
});
