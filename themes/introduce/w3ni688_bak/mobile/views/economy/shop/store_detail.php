
<?php
if (isset($store) && count($store)) {
//    foreach ($stores as $store) {
    ?>

    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="divtitleSystem">
        <a href="#">&nbsp;«&nbsp; Hệ thống siêu thị Xebaonam</a>
    </div>
    <h1 class="divStoreName">SIÊU THỊ XEBAONAM TẠI
        <b><?php echo $store['name'] ?></b>
    </h1>
    <div class="box-images-store">
        <img src="<?php echo ClaHost::getImageHost(), $store['avatar_path'], 's500_500/', $store['avatar_name'] ?>"/>
    </div>
    <div class="divStoreInfo">
        <p class="pStoreAddress">- <b>Địa chỉ:</b>  <?php echo $store['address'] ?> </p>
        <p class="pStorePhone">- <b>Điện thoại:</b> <?php echo $store['hotline'] ?></p>
        <p class="pStorePhone">- <b>Email:</b><?php echo $store['email'] ?></p>
    </div>
    <div class="divActiveTimeTitle">
        <?php echo nl2br($store['hours']); ?>
    </div>
    <div class="cuahang" style="text-indent: -9999px;height: 0px;margin: 0px;">
        <a name="cua-hang" >Cửa hàng</a>
    </div>
    <div class="divStoreDetail">
        <div class="img_map_wrap">
            <!-- <div id="canvas-map" style="width: 100%; height: 550px; background-color: #F1F1F1;" class="span10 col-sm-12"></div> -->
            <?php if(isset($store['iframe_map'])&& sizeof($store['iframe_map'])>0){?>
              <div class="map-store"><?php echo $store['iframe_map']; ?></div>
          <?php }else{ ?>
              <div class="map-store"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d3724.994003348711!2d105.80033271445404!3d20.992877494379293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1svi!2s!4v1575602977958!5m2!1svi!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""></iframe></div>
          <?php } ?>
          <!--   <?php
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
                <?php } ?> -->
            </div>


        </div>
        <?php
    }
    ?>
