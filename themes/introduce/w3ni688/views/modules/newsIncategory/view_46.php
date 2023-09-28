<?php if (count($news)) { ?>
    <div class="box-news-right">
        <div class="title-news-right">
            <h2><?php echo $widget_title?></h2>
        </div>
        <div class="cont">
            <?php foreach ($news as $ne) { ?>
                <div class="box-news">
                    <div class="box-img img-news">
                        <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"> 
                            <img alt="<?php echo $ne['news_title'] ?>" src="<?php echo ClaHost::getImageHost(), $ne['image_path'], 's80_80/', $ne['image_name'] ?>" /> 
                        </a> 
                    </div>
                    <div class="box-info">
                        <h4>
                            <a href="<?php echo $ne['link'] ?>" title="<?php echo $ne['news_title'] ?>"><?php echo $ne['news_title'] ?></a> 
                        </h4>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
