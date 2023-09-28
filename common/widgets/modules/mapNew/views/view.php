<div id="map-canvas" class="map"></div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAxKsm0KLj7N_MUO8vMxOcOlUwXZQE9PxQ&callback=initMap"
type="text/javascript"></script>

<script>
    function initMap() {
        map = new google.maps.Map(document.getElementById('map-canvas'), {
            center: {lat: 21.03139, lng: 105.8525},
            zoom: 12
        });
<?php
if ($main && count($main)) {
    list($lat, $lng) = explode(',', $main['latlng']);
    ?>
            default_map = {lat: <?php echo $lat ?>, lng: <?php echo $lng ?>};
            placeMarker(default_map, map);
    <?php
}
?>
        google.maps.event.addListener(map, 'click', function (e) {
            //infowindow = new google.maps.InfoWindow({content: defaultContent});
            placeMarker(e.latLng, map);
        });
    }

    function placeMarker(position, map) {
        deleteMarkers();
        var marker = new google.maps.Marker({
            position: position,
            draggable: true,
            map: map
        });
        google.maps.event.addListener(marker, 'dragend', function (e) {
            setPosition(marker.getPosition().toUrlValue());
            //map.panTo(marker.getPosition());
        });
        google.maps.event.addListener(marker, 'click', function (e) {
//            infowindow.open(map, marker);
            setTimeout(function () {
                setPosition(marker.getPosition().toUrlValue());
                $('input#Shop_latlng').val(marker.getPosition().toUrlValue());
            }, 500);
        });
        markers.push(marker);
        map.panTo(position);
        google.maps.event.trigger(marker, 'click');
    }

</script>
