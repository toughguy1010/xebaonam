
<?php if ($main && count($main)) { ?>
    <div id="<?php echo $id; ?>" class="map"></div>
    <script>
        var map;
        var infowindow = [];
        var defaultLatLng = new google.maps.LatLng(<?php echo $main['latlng']; ?>);
        var latlng;
        function initialize() {
            var mapOptions = {
                zoom: <?php echo count($maps) ? 13 : 16; ?>,
                center: defaultLatLng
            };
            map = new google.maps.Map(document.getElementById('<?php echo $id; ?>'), mapOptions);
            infowindow[<?php echo $main['id']; ?>] = new google.maps.InfoWindow({content: <?php echo json_encode($this->render('info', array('map' => $main), true)); ?>});
            //
            placeMarker(defaultLatLng, map, <?php echo $main['id']; ?>);

    <?php // foreach ($maps as $map) { ?>
//                infowindow[<?php echo $map['id']; ?>] = new google.maps.InfoWindow({content: <?php echo json_encode($this->render('info', array('map' => $map), true)); ?>});
//                latlng = new google.maps.LatLng(<?php echo $map['latlng']; ?>);
//                placeMarker(latlng, map, <?php echo $map['id']; ?>);
    <?php // } ?>

        }

        function placeMarker(position, map, id) {
            var marker = new google.maps.Marker({
                position: position,
                draggable: false,
                map: map
            });
            google.maps.event.addListener(marker, 'click', function (e) {
                infowindow[id].open(map, marker);
            });
            if (id ==<?php echo $main['id']; ?>) {
                google.maps.event.trigger(marker, 'click');
            }
        }
        //
        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
<?php } ?>