<?php
if (count($products)) {
    foreach ($products as $product) {
        $images_configurable = ProductConfigurableImages::getImagesProductConfigurable($product['id']);
        ?>
        <div class=" col-sm-6 ">
            <div class="option-left">
                <div class="box-img-slider">
                    <a id="show-img" href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                        <img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>"> 
                    </a>
                </div>
                <div class="color-xe">
                    <?php
                    if (count($images_configurable)) {
                        foreach ($images_configurable as $item_image) {
                            ?>
                    <a href="javascript:void(0)" data-img="<?php echo ClaHost::getImageHost().$item_image['path'].'s330_330/'.$item_image['name']; ?>">
                        <img src="<?php echo ClaHost::getImageHost().$item_image['path'].'s50_50/'.$item_image['name']; ?>" />
                    </a>
            <?php }
        } ?>
                </div>
            </div>
            <script>
                $(document).ready(function (e) {
                    $('.color-xe a').on('click', function () {
                        var link = $(this).attr('data-img');
                        $('#show-img img').attr('src', link);
                    })
                });
            </script>
        </div>
        <div class=" col-sm-6 ">
            <div class="option-right clearfix">
                <div class="cont">
                    <h3><a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a></h3>
                    <span class="sl-title"><?php echo $group->name ?></span>
        <?php if ($product['price'] && $product['price'] > 0) { ?>
                        <div class="price"><?php echo $product['price_text']; ?></div>
        <?php } ?>
                    <div class="view-all">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"><?php echo Yii::t('common', 'view_detail') ?></a>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}
?>