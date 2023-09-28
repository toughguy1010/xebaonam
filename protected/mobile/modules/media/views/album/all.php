<div class="list-album">
    <?php if (count($albums)) { ?>
        <div class="row albums">
            <?php foreach ($albums as $album) { ?>
                <div class="col-xs-4">
                    <div class="album-item">
                        <div class="album-item-box">    
                            <a href="<?php echo $album['link']; ?>" class="album-item-link" title="<?php echo $album['album_name']; ?>">
                                <i class="album-item-avatar" style="background-image: url(<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's500_500/' . $album['avatar_name']; ?>)">
                                </i>
                                <div class="album-item-name">
                                    <?php echo $album['album_name']; ?>
                                </div>
                            </a>
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