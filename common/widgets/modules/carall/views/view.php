<?php if (count($cars)) { ?>
    <div class="price-list">
        <?php foreach ($cars as $car) { ?>
            <div class="box-price-car clearfix">
                <div class="car-left">
                    <div class="box-img">
                        <a href="<?php echo $car['link'] ?>" title="<?php echo $car['name'] ?>">
                            <img src="<?php echo ClaHost::getImageHost(), $car['avatar_path'], $car['avatar_name'] ?>" alt="#">
                        </a>
                    </div>
                    <div class="box-more">
                        <div class="title-products">
                            <h4><a href="<?php echo $car['link'] ?>" title="<?php echo $car['name'] ?>"><?php echo $car['name'] ?></a></h4>
                            <span><?php echo $car['slogan'] ?></span>
                        </div>
                    </div>
                </div>
                <div class="car-right">
                    <div class="buttom-car">
                        <div class="item-productprice">
                            <a href="<?php echo Yii::app()->createUrl('car/buycar/calculateCost', array('cid' => $car['id'])); ?>" class="btn btn-detail-product">
                                Dự toán chi phí
                            </a>
                        </div>
                    </div>
                    <div class="price-detail">
                        <div class="bs-example" data-example-id="hoverable-table">
                            <?php if (count($car['version'])) { ?>
                                <table class="table table-hover">
                                    <tbody>
                                        <?php foreach ($car['version'] as $version) { ?>
                                            <tr>
                                                <td class="version-car"><?php echo $version['name'] ?></td>
                                                <td class="more-price-car"><?php echo $version['description'] ?></td>
                                                <td class="price-car"><?php echo number_format($version['price'], 0, '', '.'); ?> VNĐ</td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class='product-page'>
        <?php
        $this->widget('common.extensions.LinkPager.LinkPager', array(
            'itemCount' => $totalitem,
            'pageSize' => $limit,
            'header' => '',
            'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
            'selectedPageCssClass' => 'active',
        ));
        ?>
    </div>
<?php } ?>