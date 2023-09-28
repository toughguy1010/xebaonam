<?php if (count($news)) { ?>
    <div class="panel panel-default menu-vertical">
        <?php if ($show_widget_title) { ?>
            <div class="panel-heading">
                <h2><?php echo $widget_title; ?></h2>
            </div>
        <?php } ?>
        <div class="panel-body">
            <div class="list">
                <?php foreach ($news as $ne) { ?>
                    <div class="list-item">
                        <div class="list-content">
                            <div class="list-content-box">
                                <?php if ($ne['image_path'] && $ne['image_name']) { ?>
                                    <div class="list-content-img">
                                        <a href="<?php echo $ne['link']; ?>" title="<?php echo $ne['news_title']; ?>">
                                            <img src="<?php echo ClaHost::getImageHost() . $ne['image_path'] . 's150_150/' . $ne['image_name']; ?>" alt="<?php echo $ne['news_title']; ?>" />
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="list-content-body">
                                    <span class="list-content-title">
                                        <a href="<?php echo $ne['link']; ?>" title="<?php echo $ne['news_title']; ?>">
                                            <?php echo $ne['news_title']; ?>
                                        </a>
                                    </span>
                                    <div class="list-content-detail">
                                        <p>
                                            <?php
                                            echo $ne['news_sortdesc'];
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>