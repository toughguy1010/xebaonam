<?php if (isset($data) && count($data)) { ?>
    <div class="center-main-content">
        <?php if ($show_widget_title) { ?>
            <div class="main-list"> 
                <h2><?php echo $widget_title ?></h2> 
            </div>
        <?php } ?>
        <div class="list-demo">
            <div id="demo">
                <div id="owl-demo" class="owl-carousel">
                    <?php foreach ($data as $province) { ?>
                        <div class="list-item">
                            <div class="list-content">
                                <div class="list-content-box">
                                    <div class="list-content-img"> 
                                        <a href="<?php echo $province['link'] ?>" title="<?php echo $province['name'] ?>"> 
                                            <img src="<?php echo ClaHost::getImageHost(), $province['image_path'], 's250_0/', $province['image_name'] ?>" alt="<?php echo $province['name'] ?>"> 
                                        </a> 
                                        <div class="triangle">
                                        </div>                                                
                                    </div>
                                    <div class="list-content-body clearfix"> 
                                        <div class="list-content-title">
                                            <a href="<?php echo $province['link'] ?>"> <h3><?php echo $province['name'] ?></h3> </a>
                                            <p> <?php echo $province['count_hotel'] ?> <?php echo Yii::t('tour', 'hotel') ?></p>
                                        </div>
                                        <div class="introduce-button">
                                            <a href="<?php echo $province['link'] ?>" class="box-btn"><?php echo Yii::t('common', 'viewall') ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div> 
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 1],
                    [450, 1],
                    [600, 2],
                    [768, 2],
                    [769, 3],
                    [1000, 3],
                    [1200, 4],
                    [1400, 4],
                    [1600, 4]
                ],
                navigation: 0,
                autoPlay: true,
            });
        });
    </script>
<?php } ?>