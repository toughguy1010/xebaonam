<?php if (isset($hotels) && count($hotels)) { ?>
    <div class="grid">
        <?php foreach ($hotels as $hotel) { ?>
            <div class="list-item">
                <div class="list-content clearfix">
                    <div class="list-content-box">
                        <div class="list-content-img"> 
                            <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>"> 
                                <img alt="<?php echo $hotel['name'] ?>" src="<?php echo ClaHost::getImageHost(), $hotel['image_path'], 's200_200/', $hotel['image_name']; ?>"> 
                            </a>
                        </div>
                        <div class="list-content-body">
                            <h3 class="list-content-title">
                                <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>"><?php echo $hotel['name'] ?> </a> 
                                <span class="hotstar_small star_<?php echo $hotel['star'] ?>"></span>
                            </h3>
                            <div class="adress-hotel">
                                <p><span><?php echo Yii::t('common', 'address') ?>:</span> <?php echo implode(' - ', array($hotel['ward_name'], $hotel['district_name'], $hotel['province_name'])); ?></p>
                                <!--<a href="#" title="#" class="search-map">Xem bản đồ</a>-->
                            </div>
                            <?php if (isset($hotel['min_price']) && $hotel['min_price'] > 0) { ?>
                                <div class="price">
                                    <p><span>Giá từ</span> <?php echo number_format($hotel['min_price'], 0, '', '.') ?> đ</p>
                                </div>
                            <?php } ?>
                            <?php
                            $comforted = array();
                            if (isset($hotel['comforts_ids']) && $hotel['comforts_ids']) {
                                $comforted = explode(',', $hotel['comforts_ids']);
                            }
                            if (count($comforted)) {
                                ?>
                                <div class="attribute_hotel">
                                    <ul>
                                        <?php
                                        foreach ($comforts as $comfort) {
                                            if (in_array($comfort['id'], $comforted)) {
                                                ?>
                                                <li>
                                                    <?php if ($comfort['image_path'] && $comfort['image_name']) { ?>
                                                        <a href="javascript:void(0)" title="<?php echo $comfort['name'] ?>">
                                                            <img alt="<?php echo $comfort['name'] ?>" src="<?php echo ClaHost::getImageHost(), $comfort['image_path'], $comfort['image_name']; ?>" />
                                                        </a>
                                                    <?php } ?>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="ProductAction clearfix">
                                <div class="ProductActionAdd"> 
                                    <a href="<?php echo $hotel['link'] ?>" title="<?php echo $hotel['name'] ?>" class="a-btn-2">
                                        <span class="a-btn-2-text">Xem phòng</span> 
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class='box-product-page clearfix'>
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
    <?php
} 
