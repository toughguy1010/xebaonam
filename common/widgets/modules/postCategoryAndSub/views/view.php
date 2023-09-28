<div class="postCategory">
    <?php foreach ($data['categories'] as $cat) { ?>
        <div class="box-main-one"> 
            <div class="main-list">
                <h3><?php echo $cat['cat_name']; ?></h3>
                <a href="<?php echo $cat['link']; ?>"><?php echo Yii::t('common', 'viewall'); ?></a>
            </div><!--end-main-list-->
            <?php if (isset($cat['posts'])) { ?>
                <div class="list grid clearfix">
                    <?php foreach ($cat['posts'] as $post) { ?>
                        <div class="list-item">
                            <div class="list-content">
                                <div class="list-content-box">
                                    <div class="list-content-img">
                                        <?php if ($post['image_path'] && $post['image_name']) { ?>
                                            <a href="<?php echo $post['link']; ?>" title="<?php echo $post['title']; ?>">
                                                <img src="<?php echo ClaHost::getImageHost() . $post['image_path'] . 's220_220/' . $post['image_name'] ?>" alt="<?php echo $post['title'] ?>">
                                            </a>
                                        <?php } ?>
                                    </div>
                                    <div class="bg-body-box">
                                        <div class="list-content-body">
                                            <span class="list-content-title">
                                                <a href="<?php echo $post['link']; ?>" title="<?php echo $post['name']; ?>">
                                                    <?php echo $post['title']; ?>                             
                                                </a>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div><!--end-list-gird-->
            <?php } ?>
        </div>
    <?php } ?>
</div>