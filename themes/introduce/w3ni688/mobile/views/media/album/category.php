<div class="col-xs-12">
    <?php if($category['image_path'] != '' && $category['image_name'] != '') { ?>
    <div class="banner-danhmuc">
        <img src="<?php echo ClaHost::getImageHost() . $category['image_path'] . $category['image_name']; ?>">
    </div>
    <?php } ?>
    <div class="title clearfix">
        <div class="title_box">
            <h2><a onclick="javascript:void(0)"><?php echo $category['cat_name'] ?></a></h2>
        </div>
    </div>
    <?php if (count($children_category)) { ?>
        <div class="container">
            <ul id="myTab" class="nav nav-tabs" role="tablist">
                <?php foreach ($children_category as $sub_cat) { ?>
                    <li role="presentation">
                        <a href="<?php echo $sub_cat['link'] ?>" title="<?php echo $sub_cat['cat_name'] ?>"><?php echo $sub_cat['cat_name'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>

    <div class="list-albums clearfix">
        <div class="row">
            <?php
            if (count($list_album)) {
                $first = ClaArray::getFirst($list_album);
                $list_album = ClaArray::removeFirstElement($list_album);
                ?>
                <div class="item-album-large col-sm-6">
                    <a href="<?php echo $first['link']; ?>" title="<?php echo $first['album_name']; ?>">
                        <img src="<?php echo ClaHost::getImageHost() . $first['avatar_path'] . 's600_600/' . $first['avatar_name']; ?>">
                    </a>
                    <div class="album-description">
                        <span></span>
                    </div>
                    <div class="album-description-text">
                        <a href="#"><?php echo $first['album_name'] ?></a>
                    </div>
                </div>
                <?php foreach ($list_album as $album) { ?>
                    <div class="item-album-small col-sm-6">
                        <a href="<?php echo $album['link']; ?>" title="<?php echo $album['album_name']; ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $album['avatar_path'] . 's600_600/' . $album['avatar_name']; ?>">
                        </a>
                        <div class="album-description">
                            <span></span>
                        </div>
                        <div class="album-description-text">
                            <a href="<?php echo $album['link'] ?>"><?php echo $album['album_name'] ?></a>
                        </div>
                    </div>
                <?php } ?>
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
    </div>

</div>

