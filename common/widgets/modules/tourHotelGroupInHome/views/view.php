<?php
if (isset($groupinhome) && count($groupinhome)) {
    ?>
    <div class="new-hotel">
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <?php
                $i = 0;
                $count_group = count($groupinhome);
                foreach ($groupinhome as $group) {
                    $i++;
                    if ($i == 1) {
                        $class = 'vpGolf';
                    } else if ($i == 2) {
                        $class = 'vpLuxury';
                    } else if ($i == 3) {
                        $class = 'vp';
                    } else if ($i == 4) {
                        $class = 'vpPer';
                    } else if ($i == 5) {
                        $class = 'vpResort';
                    }
                    ?>
                    <li role="presentation" class="<?php echo (($i == 3) ? 'active' : '') ?> <?php echo $class; ?>">
                        <a href="#<?php echo $class ?>" role="tab" id="<?php echo $class ?>-tab" data-toggle="tab" aria-controls="profile" class="icon-vp<?php echo $i; ?>">
                            <img src="<?php echo ClaHost::getImageHost(), $group['image_path'], $group['image_name']; ?>"  alt="<?php echo $group['name'] ?>"/>
                            <h4><?php echo $group['name']; ?></h4>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
            <div id="myTabContent" class="tab-content clearfix">
                <?php
                $i = 0;
                foreach ($data as $item) {
                    $i++;
                    if ($i == 1) {
                        $class = 'vpGolf';
                    } else if ($i == 2) {
                        $class = 'vpLuxury';
                    } else if ($i == 3) {
                        $class = 'vp';
                    } else if ($i == 4) {
                        $class = 'vpPer';
                    } else if ($i == 5) {
                        $class = 'vpResort';
                    }
                    ?>
                    <div role="tabpanel" class="tab-pane fade <?php echo (($i == 3) ? 'active in' : '') ?>" id="<?php echo $class ?>" aria-labelledby="<?php echo $class ?>-tab">
                        <div class="cont">
                            <?php if (count($item['hotels'])) { ?>
                                <div class="row">
                                    <?php
                                    foreach ($item['hotels'] as $hotel) {
                                        ?>
                                        <div class="col-sm-3 box-product">
                                            <div class="box-product-box">
                                                <div class="box-img">
                                                    <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>">
                                                        <img src="<?php echo ClaHost::getImageHost(), $hotel['image_path'], $hotel['image_name']; ?>" alt="<?php echo $hotel['name'] ?>" />
                                                    </a>
                                                    <div class="triangle">
                                                    </div>
                                                </div>
                                                <div class="title-product">
                                                    <h3><a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>"><?php echo $hotel['name'] ?></a></h3>
                                                    <span class="hotstar_small star_<?php echo $hotel['star'] ?>"></span>
                                                    <p><?php echo implode(', ', array($hotel['ward_name'], $hotel['district_name'], $hotel['province_name'])); ?></p>
                                                    <?php if (isset($hotel['min_price']) && $hotel['min_price'] > 0) { ?>
                                                        <div class="price">
                                                            <p><span><?php echo Yii::t('tour_hotel', 'price_from') ?></span> <?php echo number_format($hotel['min_price'], 0, '', '.') ?> đ</p>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="content-product">
                                                    <?php echo $hotel['sort_description']; ?>
                                                </div>
                                                <div class="checkbox-product">
                                                    <a href="<?php echo $hotel['link'] ?>" title="Xem phòng" class="a-btn-2">
                                                        Xem phòng
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php } ?>
