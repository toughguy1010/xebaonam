<!--album  -->
    <div class="album_user fadeInUp wow">
        <div class="">
            <div class="title_v"><h3><?= $category['cat_name'] ?></h3></div>
            <div id="owl-demo2" class="owl-carousel owl-theme">
                <?php if($news) foreach ($news as $ne) { ?>
                    <div class="item">
                        <a href="<?= $ne['link'] ?>" title="<?= $ne['news_title'] ?>"> 
                            <img alt="<?= $ne['news_title'] ?>" src="<?= ClaHost::getImageHost(). $ne['image_path']. 's380_380/'. $ne['image_name'] ?>" />
                        </a> 
                        <h2>
                            <a href="<?= $ne['link'] ?>" >
                                <?= $ne['news_title'] ?>
                            </a>
                        </h2>
                    </div>
                <?php } ?>
                
            </div>
        </div>
    </div>