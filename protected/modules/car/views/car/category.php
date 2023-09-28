<div class="container">
    <div class="title">
            <h2><?php echo $category->cat_name ?></h2>
        <div class="right">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK16));
            ?>

            <?php
            // danh mục xe
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK5));
            ?>

        </div>
    </div>
    <div class="content">
        <div class="cars">
            <?php
            foreach ($cars as $car) {
                ?>

                <div class="item">
                    <div class="content_item">
                        <div class="img">
                            <div class="img-s">

                                <a href="<?php echo $car['link']; ?>" title="<?php echo $car['name']; ?>">
                                    <img alt="<?php echo $car['name']; ?>" src="<?php echo ClaHost::getImageHost() . $car['avatar_path'] . 's400_400/' . $car['avatar_name'] ?>" >
                                </a>
                            </div>
                        </div>
                        <div class="text_item">
                            <a href="<?php echo $car['link']; ?>"><h3> <?php echo $car['name']; ?></h3></a>
                            <p class="price"> Giá từ :<?php echo number_format($car['price'], 0); ?> VND</p>
                            <?= ($car['sortdesc']);?>
                            <div class="link_car">
                                <a href="<?= Yii::app()->createUrl("car/buycar/calculateCostToyotaStep2", ['id' => $car['id']]) ?>">Dự đoán</a>
                                <?php
                                if($car['allow_try_drive']){
                                    ?>
                                    <a href="<?= Yii::app()->createUrl("car/service/registerTryDriveV2", ['id' => $car['id']]) ?>">Đăng ký thử lái</a>
                                <?php }?>
                            </div>
                            <div style="clear:both;"></div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>