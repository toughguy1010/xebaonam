    <?php if (count($news)) { ?>
    <div class="news-technology">
        <div class="title-cmr">
            <h2> 
                <a href="<?php echo $category['link'] ?>" title="<?php echo $category['cat_name'] ?>"><?php echo $category['cat_name'] ?></a> 
                <span class="triangle"></span>
            </h2>
            <div class="see-all">
                <a href="<?php echo $category['link'] ?>" title="<?php echo Yii::t('common', 'viewmore') ?>"> <?php echo Yii::t('common', 'viewmore') ?></a>
            </div>
        </div>
        <div class="cont-news-technology">
            <div class="list list-small">
                <?php foreach ($news as $ne) { ?>
                    <div class="list-item">
                        <div class="list-content clearfix">
                            <div class="list-content-box">
                                <div class="list-content-img-r"> 
                                    <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"> 
                                        <img alt="<?php echo $ne['news_title'] ?>" src="<?php echo ClaHost::getImageHost(). $ne['image_path']. 's380_380/'. $ne['image_name'] ?>" />
                                    </a> 
                                </div>
                                <div class="list-content-body-r"> 
                                    <span class="list-content-title"> 
                                        <h3>
                                            <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"><?php echo $ne['news_title'] ?></a> 
                                        </h3>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php
}
