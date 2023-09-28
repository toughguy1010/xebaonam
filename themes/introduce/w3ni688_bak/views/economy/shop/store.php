<div class=" container">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>

    <div class="page-store">
        <div class="cont">
            <?php
            if (isset($stores) && count($stores)) {
                $n = 0;
                foreach ($stores as $store) {
                    $n++;
                    ?>
                    <div class="box-store clearfix" id="<?php echo 'shop', $store['id'] ?>">
                        <div class="box-img-store">
                            <a href="<?php echo Yii::app()->createUrl('/economy/shop/storedetail', array('id' => $store['id'])); ?>">
                                <img src="<?php echo ClaHost::getImageHost(), $store['avatar_path'], 's600_600/', $store['avatar_name']; ?>">
                            </a>
                        </div>
                        <div class="box-info-store">
                            <div class="cont-info">
                                <div class="address">
                                    <h2>ĐỊA CHỈ</h2>
                                    <p><?php echo $store['address'] ?></p>
                                </div>
                                <div class="contact-in">
                                    <h2>LIÊN HỆ</h2>
                                    <p>HOLINE:<?php echo $store['hotline'] ?></p>
                                    <p><?php echo $store['email'] ?></p>
                                </div>
                                <div class="hours-in">
                                    <h2>GIỜ LÀM VIỆC</h2>
                                    <p>
                                        <?php echo nl2br($store['hours']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>