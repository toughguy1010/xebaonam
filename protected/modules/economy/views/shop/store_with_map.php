<div class=" container">
    <?php
    $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="page-store">
        <div class="cont">
            <div class="row">
                <div class="col-xs-9">
                    <div class="map-store">
                        <div id="canvas-map" style="width: 100%; height: 550px; background-color: #F1F1F1;"
                             class="span10 col-sm-12"></div>
                        <?php if ($stores && count($stores)) {
                            $main = $stores[0];
                            ?>
                            <script>
                                var markers = [];
                                var map;
                                var infowindow = [];
                                var defaultLatLng = new google.maps.LatLng(18.036762, 105.85714);
                                var latlng;
                                function initialize() {
                                    var mapOptions = {
                                        zoom: <?php echo count($maps) ? 6 : 6; ?>,
                                        center: defaultLatLng
                                    };
                                    map = new google.maps.Map(document.getElementById('canvas-map'), mapOptions);
                                    infowindow[<?php echo $main['id']; ?>] = new google.maps.InfoWindow({content: <?php echo json_encode($this->renderpartial('partial/info', array('map' => $map), true)); ?>});
                                    //
//                                    placeMarker(defaultLatLng, map, <?php //echo $main['id']; ?>//);
                                    <?php foreach ($stores as $map) {
                                    if ($map['latlng'] != '') {?>

                                    <?php $content = json_encode($this->renderpartial('partial/info', array('map' => $map), true)); ?>
                                    latlng = new google.maps.LatLng(<?php echo $map['latlng']; ?>);
                                    placeMarker(latlng, map, <?php echo $map['id']; ?>, 1,<?php echo $content?>);
                                    <?php
                                    }}
                                    ?>
//                                    google.maps.event.addListener(map, 'click', function () {
//                                        $.each(infowindow, function (key, value) {
//                                            value.close();
//                                        })
//                                    });
                                    google.maps.event.addListener(map, 'click', function () {
                                        for (var key in infowindow) {
//                                            infowindow[key].close();
                                        }
                                    });
                                }
                                function placeMarker(position, map, id, queue, content = '') {
                                    var marker = new google.maps.Marker({
                                        position: position,
                                        draggable: false,
                                        map: map,
                                        id: id
                                    });
                                    infowindow[id] = new google.maps.InfoWindow({content: content});
                                    google.maps.event.addListener(marker, 'click', function (e) {
                                        infowindow[id].open(map, marker);
                                    });

                                    if (queue == 1) {
                                        markers["marker_" + id] = marker;
                                    }
                                }

                                // Sets the map on all markers in the array.
                                function setMapOnAll(map) {
                                    for (var key in markers) {
                                        markers[key].setMap(map);
                                    }
                                }

                                // Removes the markers from the map, but keeps them in the array.
                                function clearMarkers() {
                                    setMapOnAll(null);
                                }

                                // Shows any markers currently in the array.
                                function showMarkers() {
                                    setMapOnAll(map);
                                }

                                // Deletes all markers in the array by removing references to them.
                                function deleteMarkers() {
                                    clearMarkers();
                                    markers = [];
                                }

                                function moveToLocation(lat, lng) {
                                    var center = new google.maps.LatLng(lat, lng);
                                    map.panTo(center);
                                    map.setZoom(13);
                                }
                                function moveToLocationMap(e) {
                                    var mk = e.getAttribute('mk');
                                    if (e.getAttribute('latng') != '') {
                                        var latlng = e.getAttribute('latng').split(',');
                                        var haightAshbury = {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])};
                                        if (!isNaN(haightAshbury.lat) && !isNaN(haightAshbury.lng)) {
                                            moveToLocation(haightAshbury.lat, haightAshbury.lng)
                                        }
                                        for (var key in infowindow) {
                                            infowindow[key].close();
                                        }
                                        google.maps.event.trigger(markers["marker_" + mk], 'click');
                                        map.setZoom(13);
                                    }
                                }

                                //
                                google.maps.event.addDomListener(window, 'load', initialize);

                                function reloadMap(_this) {
                                    if (!$(_this).hasClass('actived')) {
                                        setTimeout(initialize, 200);
                                        $(_this).addClass('actived');
                                    }
                                }
                            </script>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="list-showroom">
                        <div class="title-store" style="background: #f6f6f6;
border: 1px solid #e0e0e0;
padding: 10px;
text-align: center;">
                                    <span style="   color: #3d3d3d;
    font-size: 13px;
    font-weight: bold;
    text-transform: uppercase;">tìm địa chỉ của hàng gần bạn nhất</span>
                        </div>
                        <select name="selector" id="tinhthanhpho" style="height: 30px;
width: 100%;
font-weight: bold;
color: #333;
border-color: #dcdbdb;">
                            <?php
                            foreach ($listGroup as $key => $group) {
                                echo '<option name="option" value="' . $key . '" >' . $group . '</option>';
                            }
                            ?>
                        </select>
                        <ul style="height:450px;overflow-y:scroll;padding: 10px;
border-left: 1px solid #e0e0e0;
border-right: 1px solid #e0e0e0;
border-bottom: 1px solid #e0e0e0;">
                            <?php
                            if (count($stores) > 0) {
                                foreach ($stores as $store) {
                                    ?>
                                    <li>
                                        <a href="/cua-hang,<?php echo $store['id'] ?>"
                                           latng="<?php echo $store['latlng'] ?>">
                                            <?php echo $store['name'] ?>
                                            <br>
                                            <span>Điện thoại: <?php echo $store['hotline'] ?></span></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var group_id = 0;
            $('#tinhthanhpho').on('change', function () {
                group_id = $("#tinhthanhpho option:selected").val();
                var url = '<?php echo Yii::app()->createUrl('economy/shop/getStoreByGroup')?>/group_id/' + group_id;
                $.getJSON(url, function (data) {
                    var flag = 0;
                    deleteMarkers();
                    $(".list-showroom ul").html('');
                    $.each(data.stores, function (key, value) {
                        var latlng = value.latlng.split(',');
                        var haightAshbury = {lat: parseFloat(latlng[0]), lng: parseFloat(latlng[1])};
                        var box_info = '<div class="map-info"><h3 class="map-info-name">' + value.name + '</h3>' +
                            '<p>' + value.address + ' | ' + value.email + ' | ' + value.phone + ' | ' + value.hotline + '</p>'
                            + '<p>' + '<span> Giờ mở cửa: ' + value.hours + '</p>' + '</div>';
                        placeMarker(haightAshbury, map, value.id, 1, box_info);
                        $(".list-showroom ul").append('<li>' +
                            '<a href="/cua-hang,' + value.id + '"  latng = "' + value.latlng + '" >' +
                            value.name +
                            '<br>' +
                            '<span> Điện thoại: ' + value.hotline + ' | ' + value.phone + '</span></a>'
                        )
                        ;
                        if (flag === 0 && !isNaN(haightAshbury.lat) && !isNaN(haightAshbury.lng)) {
                            moveToLocation(haightAshbury.lat, haightAshbury.lng);
                        }
                        flag = 1;
                    })
                    showMarkers();
                });
            });
        });
    </script>
</div>