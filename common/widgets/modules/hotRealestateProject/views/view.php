<?php if (isset($hotRealestateProject) && count($hotRealestateProject)) { ?>
    <div class="new-project">
        <?php foreach ($hotRealestateProject as $realestate) { ?>
            <div class="box-prọject">
                <div class="box-img">
                    <a href="<?php echo $realestate['link'] ?>">
                        <?php if ($realestate['image_path'] && $realestate['image_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost() . $realestate['image_path'] . 's800_800/' . $realestate['image_name'] ?>" alt="<?php echo $realestate['name'] ?>">
                        <?php } ?>
                    </a>
                    <div class="in-the-list">

                        <?php if ($realestate['real_estate_cat_id'] == 1) { ?>
                            <p class="finish"><a href="/du-an-bat-dong-san?rcid=1"><?php echo $realestate['type'] ?></a></p>
                        <?php } else if ($realestate['real_estate_cat_id'] == 2) { ?>
                            <p class="finish"><a href="/du-an-bat-dong-san?rcid=2"><?php echo $realestate['type'] ?></a></p>
                        <?php } else if ($realestate['real_estate_cat_id'] == 3) {
                            ?>
                            <p class="finish"><a href="/du-an-bat-dong-san?rcid=3"><?php echo $realestate['type'] ?></a></p>
                        <?php } else { ?>
                            <p class="finish"><a href="/du-an-bat-dong-san"><?php echo $realestate['type'] ?></a></p>
                        <?php } ?>

                    </div>
                </div>
                <div class="box-info">
                    <div class="title-project">
                        <h4> <a href="<?php echo $realestate['link'] ?>"><?php echo $realestate['name'] ?></a></h4>
                    </div>
                    <div class="description-project">
                        <p>  <b>Địa chỉ: </b><?php echo $realestate['address'] . ' - ' . $realestate['district_name'] . ' - ' . $realestate['province_name']; ?><br>
                            <!--<b>Giá mỗi căn: </b><?php echo $realestate['price_range']; ?><br>-->
                            <b>Diện tích: </b><?php echo $realestate['area']; ?><br>
                            <b>Quy mô: </b> <?php echo $realestate['sort_description']; ?></p>
                    </div>
                    <div class="share-social">
                        <?php
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
                        ?>
                    </div>
                </div>
            </div>          
        <?php } ?>
    </div>
<?php } ?>