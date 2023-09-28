<div class="list-album">
    <?php if (count($albums)) { ?>
        <div class="albums">
            <?php foreach ($albums as $album) { ?>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 album-item-col">
                    <div class="album-item">
                        <a href="<?php echo $album['link']; ?>" class="album-item-link" title="<?php echo $album['album_name']; ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's400_400/' . $album['avatar_name']; ?>" alt="<?php echo $album['album_name']; ?>">
                        </a>
                        <div class="album-item-content">
                            <a href="<?php echo $album['link']; ?>" class="title_album">
                                <?php echo $album['album_name']; ?>
                            </a>
                            <p class="content_album">
                                <?php echo $album['album_name']; ?>
                            </p>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="wpager">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    <?php } else { ?>
        <p><?php echo Yii::t('album', 'havenoalbum') ?></p>
    <?php } ?>
</div>