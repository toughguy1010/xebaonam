<?php if (count($hotnews)) { ?>
    <div class="box-news-htv box-news-feature">
        <div class="news-feature">
            <?php if ($show_widget_title) { ?>
                <div class="news-freature-title">
                    <h2><?php echo $widget_title ?></h2>
                </div>
            <?php } ?>
        </div>
        <div class="news-feature-list">
            <?php foreach ($hotnews as $news) { ?>
                <div class="box-news-item">
                    <h4>
                        <a href="<?php echo $news['link'] ?>" title="<?php echo $news['news_title']; ?>">
                            <?php echo $news['news_title']; ?>
                        </a>
                    </h4>
                </div>
            <?php } ?>
        </div>
    </div>
  
<?php } ?>