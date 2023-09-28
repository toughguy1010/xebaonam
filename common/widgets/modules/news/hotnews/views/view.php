<?php if (count($hotnews)) { ?>
    <?php if ($show_widget_title) { ?>
        <div class="panel panel-default menu-horizontal">
            <div class="panel-heading">
                <h2><?php echo $widget_title; ?></h2>
            </div>
            <div class="panel-body">
            <?php } ?>
            <div class="list list-small">
                <?php foreach ($hotnews as $news) { ?>
                    <div class="list-item">
                        <div class="list-content">
                            <div class="list-content-box">
                                <?php if ($news['image_path'] && $news['image_name']) { ?>
                                    <div class="list-content-img">
                                        <a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
                                            <img src="<?php echo ClaHost::getImageHost() . $news['image_path'] . 's100_100/' . $news['image_name']; ?>" alt="<?php echo $news['news_title']; ?>" />
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="list-content-body">
                                    <span class="list-content-title">
                                        <a href="<?php echo $news['link'] ?>" title="<?php echo $news['news_title']; ?>">
                                            <?php echo $news['news_title']; ?>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>  
                <?php } ?>
            </div>
        <?php } ?>
        <?php if ($show_widget_title) { ?>
        </div>
    </div>
<?php } ?>