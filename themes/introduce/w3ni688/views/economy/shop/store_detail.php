<?php $themUrl = Yii::app()->theme->baseUrl; ?>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/jssor.slider.js"></script>
<?php
if (isset($store) && count($store)) {
//    foreach ($stores as $store) {
    ?>
    <div class=" container">
        <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
        <div class="page-store">
            <div class="widget-product-detail">
                <div class="hot-image">
                    <h2 class="name-store"><?php echo $store['name'] ?></h2>
                </div>
                <div class="cont">
                    <?php
                    $images = $store->getImages();
                    if (count($images)) {
                        ?>
                        <div id="slider1_container" style="position: relative; padding: 0px; margin: 0 auto; top: 0px; left: 0px; width: 1200px;
                             height: 600px; background: #fff;">
                            <!-- Loading Screen -->
                            <div u="loading"
                                 style="position: absolute; top: 0px; left: 0px;">
                                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                                     background-color: #fff; top: 0px; left: 0px;width: 100%;height:100%;">
                                </div>
                                <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                                     top: 0px; left: 0px;width: 100%;height:100%;">
                                </div>
                            </div>
                            <!-- Slides Container -->
                            <div u="slides"
                                 style="cursor: move; position: absolute; left: 0px; top: 0px; width: 900px; height: 600px; overflow: hidden;">
                                <?php
                                foreach ($images as $image) {
                                    ?>
                                    <div>
                                        <img u="image"
                                             src="<?php echo ClaHost::getImageHost(), $image['path'], 's1000_1000/', $image['name'] ?>"/>
                                        <img u="thumb"
                                             src="<?php echo ClaHost::getImageHost(), $image['path'], 's150_150/', $image['name'] ?>"/>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <!--#region Thumbnail Navigator Skin Begin -->
                            <!-- Help: http://www.jssor.com/development/slider-with-thumbnail-navigator-jquery.html -->
                            <style>
                                /* jssor slider thumbnail navigator skin 06 css */
                                /*
                                .jssort06 .p            (normal)
                                .jssort06 .p:hover      (normal mouseover)
                                .jssort06 .pav          (active)
                                .jssort06 .pav:hover    (active mouseover)
                                .jssort06 .pdn          (mousedown)
                                */
                                .jssort06 {
                                    position: absolute;
                                    /* size of thumbnail navigator container */
                                    width: 300px;
                                    height: 600px;
                                }

                                .jssort06 .p {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 270px;
                                    height: 192px;
                                    border-radius: 5px;
                                    cursor: pointer;
                                }

                                .jssort06 .o {
                                    position: absolute;
                                    top: 0px;
                                    left: 0px;
                                    width: 270px;
                                    height: 192px;
                                    overflow: hidden;
                                    border-radius: 5px;
                                }

                                .jssort06 .b {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 270px;
                                    height: 192px;
                                    border: none;
                                    border-radius: 5px;
                                }

                                .jssort06 .f {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 270px;
                                    height: 192px;
                                    border: none;
                                    clip: inherit;
                                    border-radius: 5px;
                                }

                                .jssort06 .pav .f {
                                    clip: initial;
                                    border: 2px solid #fed100;
                                }

                                .jssort06 .i {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 270px;
                                    height: 192px;
                                    background: #000;
                                    filter: alpha(opacity=30);
                                    opacity: .3;
                                    transition: background-color .6s;
                                    -moz-transition: background-color .6s;
                                    -webkit-transition: background-color .6s;
                                    -o-transition: background-color .6s;
                                    border-radius: 5px;
                                }

                                .jssort06 .pav .i {
                                    background: #fff;
                                    filter: alpha(opacity=100);
                                    opacity: 1;
                                }

                                .jssort06 .p:hover .i, .jssort06 .pav:hover .i {
                                    background: #fff;
                                    filter: alpha(opacity=30);
                                    opacity: .3;
                                }

                                .jssort06 .p:hover .i {
                                    transition: none;
                                    -moz-transition: none;
                                    -webkit-transition: none;
                                    -o-transition: none;
                                }

                                .jssort06 .p.pdn .i {
                                    background: none;
                                }
                            </style>
                            <!-- thumbnail navigator container -->
                            <div u="thumbnavigator" class="jssort06"
                                 style="right: 0px; bottom: 0px;">
                                <!-- Thumbnail Item Skin Begin -->
                                <div u="slides" style="cursor: default;">
                                    <div u="prototype" class="p">
                                        <div class="o">
                                            <div u="thumbnailtemplate" class="b"></div>
                                            <div class="i"></div>
                                            <div u="thumbnailtemplate" class="f"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Thumbnail Item Skin End -->
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="cont-page-store clearfix">
                <div class="row">
                    <div class="col-xs-4">
                        <div class="address-store">
                            <h5>Thông tin</h5>
                            <div class="cont">
                                <ul>
                                    <li>
                                        <p class="dc-icon">Địa chỉ :
                                            <?php echo $store['address'] ?>
                                            <?php // echo implode(' - ', array($store['ward_name'], $store['district_name'], $store['province_name'])); ?>
                                        </p>
                                    </li>
                                    <li><p class="dt-icon">Điện
                                            thoại: <?php echo $store['hotline'] ?></p>
                                    </li>
                                    <li><p class="bh-icon">Bảo
                                            hành: <?php echo $store['phone'] ?></p></li>
                                    <li><p class="glv-icon">Giờ làm
                                            việc: <?php echo nl2br($store['hours']); ?></p>
                                    </li>
                                    <li>
                                        <p class="nql-icon"><?php echo $store['email'] ?></p>
                                    </li>

                                </ul>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-8">
                         <?php if(isset($store['iframe_map'])&& sizeof($store['iframe_map'])>0){?>
                          <div class="map-store"><?php echo $store['iframe_map']; ?></div>
                        <?php }else{ ?>
                          <div class="map-store"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3724.994003348711!2d105.80033271445404!3d20.992877494379293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1575602977958!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe></div>
                        <?php } ?>
                       <!--  <div class="map-store">
                            <div id="canvas-map" style="min-height: 500px"
                                 class="span10 col-sm-12"></div>
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
                            if ($store && count($store)) { ?>
                                <script>
                                    var map;
                                    var infowindow = [];
                                    var defaultLatLng = new google.maps.LatLng(<?php echo $store['latlng']; ?>);
                                    var latlng;

                                    function initialize() {
                                        var mapOptions = {
                                            zoom: 15,
                                            center: defaultLatLng
                                        };
                                        map = new google.maps.Map(document.getElementById('canvas-map'), mapOptions);
                                        infowindow[<?php echo $store['id']; ?>] = new google.maps.InfoWindow({content: <?php echo json_encode($this->renderpartial('partial/info', array('map' => $store), true)); ?>});
                                        //
                                        placeMarker(defaultLatLng, map, <?php echo $store['id']; ?>);
//                                        infowindow[<?php echo $store['id']; ?>] = new google.maps.InfoWindow();
//                                        latlng = new google.maps.LatLng(<?php echo $store['latlng']; ?>);
//                                        placeMarker(latlng, map, <?php echo $store['id']; ?>);
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
                                        if (id ==<?php echo $store['id']; ?>) {
                                            google.maps.event.trigger(marker, 'click');
                                        }
                                    }

                                    //
                                    google.maps.event.addDomListener(window, 'load', initialize);
                                </script>
                            <?php } ?>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script>
    init_jssor_slider1 = function (containerId) {
        var options = {
            $AutoPlay: false, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
            $SlideDuration: 200, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

            $ThumbnailNavigatorOptions: {//[Optional] Options to specify and enable thumbnail navigator or not
                $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                $Lanes: 1, //[Optional] Specify lanes to arrange thumbnails, default value is 1
                $SpacingX: 14, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                $SpacingY: 12, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                $DisplayPieces: 3, //[Optional] Number of pieces to display, default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park thumbnail
                $Orientation: 2                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
            }
        };
        var jssor_slider1 = new $JssorSlider$(containerId, options);
    };
    init_jssor_slider1("slider1_container");
</script>
