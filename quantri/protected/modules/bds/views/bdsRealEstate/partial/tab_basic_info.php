<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<?php if (!$model->isNewRecord) { ?>
    <div class="form-group no-margin-left">
        <?php echo $form->labelEx($model, 'alias', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
        <div class="controls col-sm-10">
            <?php echo $form->textField($model, 'alias', array('class' => 'span10 col-sm-12')); ?>
            <?php echo $form->error($model, 'alias'); ?>
        </div>
    </div>
<?php } ?>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'width', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'width', array('class' => 'span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'long', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'long', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'area', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'area', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'width'); ?>
        <?php echo $form->error($model, 'long'); ?>
        <?php echo $form->error($model, 'area'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'facade_width', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'facade_width', array('class' => 'span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'behind_width', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'behind_width', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'area_on_papers', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'area_on_papers', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'facade_width'); ?>
        <?php echo $form->error($model, 'behind_width'); ?>
        <?php echo $form->error($model, 'area_on_papers'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'total_room', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'total_room', array('class' => 'span2 col-sm-2')); ?>
        <?php echo $form->labelEx($model, 'area_room', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'area_room', array('class' => 'numberFormat col-sm-2')); ?>
        <?php echo $form->error($model, 'total_room'); ?>
        <?php echo $form->error($model, 'area_room'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'width_street_facade', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'width_street_facade', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'width_street_facade'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'quality', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'quality', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'quality'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'price', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'price', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <div class="col-sm-4">
        <p class="alert alert-info">
            <?php echo Yii::t('map', 'map_help') ?>
        </p>
    </div>
    <div class="col-sm-8">
        <div class="widget-main">
            <div class="wmap">
                <div id="map-canvas" style="width: 100%; height: 550px; background-color: #F1F1F1;"></div>
                <input type="text" class="pac-input" id="pac-input" placeholder="<?php echo Yii::t('map', 'search-help'); ?>" />
            </div>
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
            <script>
                var map;
                var infowindow;
                var markers = [];
                var defaultContent = '' + <?php echo json_encode($this->renderPartial('_form_map', array('model' => $real_estate_map, 'form' => $form), true)); ?>;
                var defaultLatLng = new google.maps.LatLng(<?php echo (!(isset($real_estate_map->id)) || !$real_estate_map->id) ? '21.03139, 105.8525' : $real_estate_map->latlng; ?>);
                function initialize() {
                    var mapOptions = {
                        zoom: 12,
                        center: defaultLatLng
                    };
                    map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                    //
                    infowindow = new google.maps.InfoWindow({content: defaultContent})
                    google.maps.event.addListener(map, 'click', function (e) {
                        //infowindow = new google.maps.InfoWindow({content: defaultContent});
                        placeMarker(e.latLng, map);
                    });
<?php if ((isset($real_estate_map->latlng)) && $real_estate_map->latlng) { ?>
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
                        infowindow.open(map, marker);
                        setTimeout(function () {
                            setPosition(marker.getPosition().toUrlValue());
                        }, 300);
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
                    jQuery('#BdsMaps_latlng').val(position);
                }
                google.maps.event.addDomListener(window, 'load', initialize);

                var formSubmit = true;
                $(document).on("submit", "#maps-form", function () {
                    if (!formSubmit)
                        return false;
                    formSubmit = false;
                    var thi = jQuery(this);
                    jQuery.ajax({
                        'type': 'POST',
                        'dataType': 'JSON',
                        'url': thi.attr('action'),
                        'data': thi.serialize(),
                        'beforeSend': function () {
                            w3ShowLoading(jQuery('#savemap'), 'right', 60, 0);
                        },
                        'success': function (res) {
                            w3HideLoading();
                            if (res.code != "200") {
                                if (res.errors) {
                                    parseJsonErrors(res.errors);
                                }
                                //
                            } else if (res.redirect) {
                                //
                                window.location.href = res.redirect;
                            }
                            formSubmit = true;
                        },
                        'error': function () {
                            w3HideLoading();
                            formSubmit = true;
                        }
                    });
                    return false;
                });
            </script>
        </div>
    </div>
</div>
