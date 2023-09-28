<?php if (count($news)) { ?>
    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <div id="collection">
        <div class="container">
            <?php if ($show_widget_title) { ?>
                <div class="header-cat-in-home">
                    <h2><a href="<?= $category['link']?>"><?= $widget_title?></a></h2>
                </div>
            <?php } ?>
            <div class="" style="margin-right: -5px;margin-left: -5px;">
                <div id="demo">
                    <div id="owl-demo123" class="owl-carousel">
                        <!-- Slides Container -->
                        <?php foreach ($news as $ne) {
                             ?>
                            <div class="item">
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
        </div>  
    </div>
     <script>
         $(document).ready(function () {
             var owl = $("#owl-demo123");
             owl.owlCarousel({
                 itemsCustom: [
                     [0, 4]
                 ],
                 navigation: false,
                 autoPlay: true,
             });
         });
     </script>
    <?php
}
