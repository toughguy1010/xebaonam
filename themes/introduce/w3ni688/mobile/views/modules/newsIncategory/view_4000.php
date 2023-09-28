<?php if (count($news)) { ?>
    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <script type="text/javascript" src="<?= $themUrl ?>/js/owl.carousel.min.js"></script> 
    <script>
        $(document).ready(function () {
            var owl = $("#owl-demo");
            owl.owlCarousel({
                itemsCustom: [
                    [0, 2]
                ],
                navigation: false,
                autoPlay: true,
            });
        });
    </script>
    <div id="collection">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <a href="<?php echo $category['link'] ?>"><h2><?php echo $category['cat_name'] ?></h2></a>
            </div>
        <?php } ?>
        <div id="demo">
            <div id="owl-demo" class="owl-carousel">
                <!-- Slides Container -->
                <?php foreach ($news as $ne) { ?>
                <div class="item" style="padding: 10px;">
                        <div class="box-img img-collection">
                            <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"> 
                                <img alt="<?php echo $ne['news_title'] ?>" src="<?php echo ClaHost::getImageHost(), $ne['image_path'], 's300_300/', $ne['image_name'] ?>" /> 
                            </a> 
                        </div>
                        <div class="tittle-new"> 
                            <h3>
                                <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"><?php echo $ne['news_title'] ?></a> 
                            </h3>
                        </div>
                    </div>
                <?php } ?>
            </div>  
        </div>  
    </div>  
    <?php
}
