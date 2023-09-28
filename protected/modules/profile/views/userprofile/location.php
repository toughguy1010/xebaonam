<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/imagesloaded.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<div id="userlocation">
    <div class="listlocation clearfix">
        <?php
        if ($listlocation) {
            $listprovince = array();
            $listdistrict = array();
            foreach ($listlocation as $location) {

                if ($listprovince[$location['province_id']])
                    $province = $listprovince[$location['province_id']];
                else {
                    $province = $listprovince[$location['province_id']] = LibProvinces::getProvinceDetail($location['province_id']);
                }
                $province_alias = LibProvinces::getProvinceTypeAlias($province['type']);
                if ($listdistrict[$location['district_id']])
                    $district = $listdistrict[$location['district_id']];
                else {
                    $district = $listdistrict[$location['district_id']] = LibDistricts::getDistrictDetailFollowProvince($location['province_id'], $location['district_id']);
                }
                $district_alias = LibDistricts::getDistrictTypeAlias($district['type']);
                ?>
                <div class="locationitem">
                    <div class="locationbox">
                        <a href="<?php echo Yii::app()->createUrl('location/location/detail', array('id' => $location['location_id'], 'alias' => $location['alias'])) ?>" class="locationlink">
                            <div class="locationimage">
                                <img src="<?php echo ClaHost::getImageHost() . $location['avatar_path'] . 's300_300/' . $location['avatar_name']; ?>" />
                            </div>
                            <p class="locationname">
                                <?php echo $location['location_name']; ?>
                            </p>
                            <p class="locationaddress">
                                <i class="fa fa-location-arrow"></i>
                                <?php echo $location['location_address'] . Locations::LOCATION_ADDRESS_SEPARATE . $district_alias . Locations::LOCATION_ADDRESS_PRE . $district['name'] . Locations::LOCATION_ADDRESS_SEPARATE . $province_alias . Locations::LOCATION_ADDRESS_PRE . $province['name']; ?>
                            </p>
                            <?php if ($location['location_phone'] && $location['location_phone'] != '') { ?>
                                <p class="locationmobile">
                                    <i class="fa fa-phone"></i> <?php echo $location['location_phone']; ?>
                                </p>
                            <?php } ?>
                        </a>
                        <div class="locationfb">
                            <div class="fb-like" data-href="<?php echo Yii::app()->createAbsoluteUrl('/location/location/detail', array('id' => $location['location_id'], 'alias' => $location['alias'])) ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <p><?php echo Yii::t('location','location_result_none'); ?></p>
        <?php } ?>
    </div>
    <div class="lpaging">
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'showfirstPage' => false,
            'showlastPage' => false,
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
</div>
</div>
<script>
    jQuery(document).ready(function() {
        //var $container = $('#algalley .alimglist').masonry('reloadItems');
        $('#userlocation .listlocation').imagesLoaded(function() {
            $('#userlocation .listlocation').masonry({
                itemSelector: '.locationitem',
                isAnimated: true
            });
        });
    });
</script>

