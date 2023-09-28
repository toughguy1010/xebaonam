<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<?php if (count($banners)) {?>
    <div class="slider_main ">

        <div id="sync11" class="big_album owl-carousel owl-theme">
            <?php foreach ($banners as $banner) {?>
                <div class="item">
                    <a href="<?php echo $banner['banner_link'] ?>">
                        <img src="<?=$banner['banner_src']?>" alt="<?=$banner['banner_name']?>">
                    </a>
                </div>
            <?php } ?>

        </div>


            <div id="sync21" class="small_album owl-carousel owl-theme">
                <?php foreach ($banners as $banner) {?>
                    <div class="item">
                        <h2><?php echo $banner['banner_name'] ?></h2>
                    </div>
                <?php } ?>

            </div>
        </div>

    <?php } ?>

