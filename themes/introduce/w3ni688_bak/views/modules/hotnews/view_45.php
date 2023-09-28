<?php if (count($hotnews)) { ?>
    <div id="newstab" class="show">
        <ul class="list_news">
            <?php foreach ($hotnews as $news) { ?>
                <li>
                    <a href="<?= $news['link']; ?>" title="<?= $news['news_title']; ?>">
                        <img alt="<?= $news['news_title']; ?>" src="<?= ClaHost::getImageHost() . $news['image_path'] . 's100_100/' . $news['image_name']; ?>" width="100px" height="60px">
                        <h3>
                            <?= $news['news_title']; ?>  <div class="cyan">
                                <i class="fa fa-eye">
                                </i>
                                <?= $news['viewed'] ?>
                            </div>
                        </h3>
                        <label>
                            <span class="log">
                                <?= date('y-m-d h:i:s', $news['publicdate']) ?>
                            </span>
                            •  Tin tức
                        </label>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="text-right xemthem">
            <a href="<?= Yii::app()->createUrl(['/news/news']) ?>" title="Tin tức xe điện">
                <span>
                    Xem thêm tin <i class="fa fa-angle-double-right">
                    </i>
                </span>
            </a>
        </div>

        <div class="dipimg">
            <?php
            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK16));
            ?>

        </div>
    </div>
<?php } ?>