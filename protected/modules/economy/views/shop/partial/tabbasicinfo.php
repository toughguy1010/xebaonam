<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/plugins/ckeditor/ckeditor.js') ?>
<style>
    input.col-sm-12 {
        width: auto;
        min-width: 33.333%;
    }
</style>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'image', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-4">
        <?php echo $form->hiddenField($model, 'image', array('class' => 'span12 col-sm-12')); ?>
        <div id="shop_image" style="display: block; margin-top: 0px;">
            <div id="shop_image_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->image) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->image_path && $model->image_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->image_path, 's100_100/', $model->image_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="shop_image_form" style="display: inline-block;">
                <?php echo CHtml::button('Chọn ảnh bìa', array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'image'); ?>
    </div>

    <?php echo $form->labelEx($model, 'avatar', array('class' => 'col-sm-1 control-label no-padding-left')); ?>
    <div class="controls col-sm-5">
        <?php echo $form->hiddenField($model, 'avatar', array('class' => 'span12 col-sm-12')); ?>
        <div id="shop_avatar" style="display: block; margin-top: 0px;">
            <div id="shop_avatar_img" style="display: inline-block; max-width: 100px; max-height: 100px; overflow: hidden; vertical-align: top; <?php if ($model->avatar) echo 'margin-right: 10px;'; ?>">  
                <?php if ($model->avatar_path && $model->avatar_name) { ?>
                    <img src="<?php echo ClaHost::getImageHost(), $model->avatar_path, 's100_100/', $model->avatar_name; ?>" style="width: 100%;" />
                <?php } ?>
            </div>
            <div id="shop_avatar_form" style="display: inline-block;">
                <?php echo CHtml::button('Chọn ảnh đại diện', array('class' => 'btn  btn-sm')); ?>
            </div>
        </div>
        <?php echo $form->error($model, 'avatar'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'name', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'province_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'province_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'district_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'district_id'); ?>
    </div>
</div> 
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'ward_id', array('class' => 'col-xs-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->dropDownList($model, 'ward_id', $listward, array('class' => 'span12 col-sm-12',)); ?>
        <?php echo $form->error($model, 'ward_id'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'address', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'hotline', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'hotline', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'hotline'); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'phone', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'phone', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'email', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'email', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'phone', array(), true, false); ?>
        <?php echo $form->error($model, 'email', array(), true, false); ?>
    </div>
</div>

<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'facebook', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'facebook', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'instagram', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'instagram', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'facebook', array(), true, false); ?>
        <?php echo $form->error($model, 'instagram', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'pinterest', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textField($model, 'pinterest', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->labelEx($model, 'twitter', array('class' => 'col-sm-2 align-right')); ?>
        <?php echo $form->textField($model, 'twitter', array('class' => 'span12 col-sm-12')); ?>
        <?php echo $form->error($model, 'pinterest', array(), true, false); ?>
        <?php echo $form->error($model, 'twitter', array(), true, false); ?>
    </div>
</div>
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'description', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->textArea($model, 'description', array('class' => 'span12 col-sm-12', 'placeholder' => 'Nhập giới thiệu gian hàng')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>
<!--Chọn Ảnh-->
<div class="form-group no-margin-left">
    <?php echo $form->labelEx($model, 'latlng', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
    <div class="controls col-sm-10">
        <?php echo $form->hiddenField($model, 'latlng'); ?>
        <?php echo $form->error($model, 'latlng'); ?>
        <div id="map-canvas" style="width: 100%; height: 550px; background-color: #F1F1F1;" class="span10 col-sm-12"></div>
    </div>
</div>

<script type="text/javascript">

    jQuery(document).on('change', '#Shop_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#Shop_province_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#Shop_province_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_district_id').html(res.html);
                }
                w3HideLoading();
                getWard();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });

    jQuery(document).on('change', '#Shop_district_id', function () {
        getWard();
    });

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#Shop_district_id').val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(jQuery('#Shop_district_id'), 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#Shop_ward_id').html(res.html);
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    }

    if (!Array.prototype.remove) {
        Array.prototype.remove = function (val) {
            var i = this.indexOf(val);
            return i > -1 ? this.splice(i, 1) : [];
        };
    }

    jQuery(function ($) {
        jQuery('#shop_avatar_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shop/uploadfile"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Shop_avatar').val(obj.data.avatar);
                        if (jQuery('#shop_avatar_img img').attr('src')) {
                            jQuery('#shop_avatar_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#shop_avatar_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#shop_avatar_img').css({"margin-right": "10px"});
                    }
                }
            }
        });
        jQuery('#shop_image_form').ajaxUpload({
            url: '<?php echo Yii::app()->createUrl("/economy/shop/uploadfileimage"); ?>',
            name: 'file',
            onSubmit: function () {
            },
            onComplete: function (result) {
                var obj = $.parseJSON(result);
                if (obj.status == '200') {
                    if (obj.data.realurl) {
                        jQuery('#Shop_image').val(obj.data.image);
                        if (jQuery('#shop_image_img img').attr('src')) {
                            jQuery('#shop_image_img img').attr('src', obj.data.realurl);
                        } else {
                            jQuery('#shop_image_img').append('<img src="' + obj.data.realurl + '" />');
                        }
                        jQuery('#shop_image_img').css({"margin-right": "10px"});
                    }
                }
            }
        });


    });


</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places"></script>
<script>
    var map;
    var infowindow;
    var markers = [];
    var defaultContent = '';
    var defaultLatLng = new google.maps.LatLng(<?php echo (!(isset($model->id)) || !$model->id || !isset($model->latlng) || $model->latlng == null) ? '21.03139, 105.8525' : $model->latlng; ?>);
    function initialize() {
        var mapOptions = {
            zoom: 12,
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
//        var input = (document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
//        var searchBox = new google.maps.places.SearchBox((input));
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
                $('input#Shop_latlng').val(marker.getPosition().toUrlValue());
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
