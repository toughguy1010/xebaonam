<div class="container">
    <div class="sliderhome">
        <div class="titlekhachhang text-left">
            <div class="title-blockhome" style="font-weight:bold;">
                <span class="text-left">
                    <?= $category['cat_name'] ?>
                </span>
                <span class="viewmore text-right">
                    <a class="viewmore" href="<?= Yii::app()->createUrl("news/news/category/",['alias'=>$category['alias'], 'id' => $category['cat_id']]) ?>">
                        xem thêm &gt;&gt;
                    </a>
                </span>
            </div>
        </div>
        <div id="slider1" class="sliderwrapper">
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
</div>
