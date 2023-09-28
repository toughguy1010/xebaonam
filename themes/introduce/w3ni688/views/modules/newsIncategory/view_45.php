<!--album  -->
<div class="album_user fadeInUp wow">
    <div class="">
        <div class="title_v"><h3><?= $category['cat_name'] ?></h3></div>
        <div id="owl-demo2" class="owl-carousel owl-theme">
            <?php if ($news) foreach ($news as $ne) {
                $src = ClaHost::getImageHost() . $ne['image_path'] . 's380_380/' . $ne['image_name'];
                ?>
                <div class="item">
                    <a href="<?= $ne['link'] ?>" title="<?= $ne['news_title'] ?>">
                        <?php Yii::app()->controller->renderPartial('//layouts/img_lazy_owl', array('src'=> $src,'class' => '', 'title' => $ne['news_title'])); ?>
                    </a>
                    <h2>
                        <a href="<?= $ne['link'] ?>">
                            <?= $ne['news_title'] ?>
                        </a>
                    </h2>
                </div>
            <?php } ?>

        </div>
    </div>
</div>