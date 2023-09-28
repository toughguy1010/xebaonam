<div class="row multi-columns-row">
    <?php if (count($manufacturers)) { ?>
        <?php
        foreach ($manufacturers as $manufacturer) { ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="item-inpage-doitac">
                    <div class="img-item-inpage-doitac item-show">
                        <?php if ($manufacturer['image_path'] && $manufacturer['image_name']) { ?>
                            <a href="<?php echo $manufacturer['link']; ?>" title="<?php echo $manufacturer['name']; ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $manufacturer['image_path'] . 's200_200/' . $manufacturer['image_name'] ?>"
                                     alt="<?php echo $manufacturer['name'] ?>">
                            </a>
                        <?php } ?>
                    </div>
                    <div class="title-item-inpage-doitac">
                        <h2>
                            <a href="<?php echo $manufacturer['link']; ?>"
                               title="<?php echo $manufacturer['name']; ?>">
                                <?php echo $manufacturer['name']; ?>
                            </a>
                        </h2>
                        <span>
                                <?php echo $manufacturer['address']; ?>
                            </span>
                        <p>
                            <?php echo $manufacturer['shortdes']; ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php } else { ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= 'Hiện chưa có đối tác'; ?>
        </div>
    <?php } ?>

</div>
<div class='product-page'>
    <?php
    $this->widget('common.extensions.LinkPager.LinkPager', array(
        'itemCount' => $totalitem,
        'pageSize' => $limit,
        'header' => '',
        'htmlOptions' => array('class' => 'pagination',), // Class for ul
        'selectedPageCssClass' => 'active',
    ));
    ?>
</div>
