<?php
$map_api_key = SiteSettings::model()->findByPk(Yii::app()->controller->site_id)['map_api_key'];
if (!Yii::app()->request->isAjaxRequest) {
    if (!defined("REGISTERSCRIPT_MAP")) {
        define("REGISTERSCRIPT_MAP", true);
        $client = Yii::app()->clientScript;
        if (isset($map_api_key) && $map_api_key) {
            $url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=' . $map_api_key;
        } else {
            $url = 'https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places';
        }
        $client->registerScriptFile($url);
    }
}
?>
<script>
    var map;
    var infowindow;
    var markers = [];
    var defaultContent = '';
    var defaultLatLng = new google.maps.LatLng(<?php echo (!(isset($model->id)) || !$model->id || !isset($model->latlng) || $model->latlng == null) ? '21.03139, 105.8525' : $model->latlng; ?>);
    function initialize() {
        var mapOptions = {
            zoom: 11,
            center: defaultLatLng
        };
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        //
//        infowindow = new google.maps.InfoWindow({content: defaultContent})
        google.maps.event.addListener(map, 'click', function (e) {
            //infowindow = new google.maps.InfoWindow({content: defaultContent});
            placeMarker(e.latLng, map);
        });
        <?php if ((isset($model->latlng)) && $model->latlng) { ?>
        placeMarker(defaultLatLng, map);
        <?php } ?>
        var input = (document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
        var searchBox = new google.maps.places.SearchBox((input));
        google.maps.event.addListener(searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }
            // For each place, get the icon, place name, and location.
            markers = [];
            var bounds = new google.maps.LatLngBounds();
            for (var i = 0, place; place = places[i]; i++) {
                var image = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };
                // Create a marker for each place.
                var marker = new google.maps.Marker({
                    map: map,
                    icon: image,
                    title: place.name,
                    position: place.geometry.location
                });
                markers.push(marker);
                bounds.extend(place.geometry.location);
            }
            map.fitBounds(bounds);
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
                $('input#ShopStore_latlng').val(marker.getPosition().toUrlValue());
            }, 500);
        });
        markers.push(marker);
        map.panTo(position);
        google.maps.event.trigger(marker, 'click');
    }

    // Sets the map on all markers in the array.
    function setAllMap(map) {
        for (var i = 0; i < markers.length; i++) {
            markers[i].setMap(map);
        }
    }
    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setAllMap(null);
    }
    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }

    function setPosition(position) {
        jQuery('#Maps_latlng').val(position);
    }
    //     google.maps.event.trigger(window, 'resize');
    google.maps.event.trigger(window, 'resize')
    google.maps.event.addDomListener(window, 'load', initialize);


</script>