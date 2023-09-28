<div class="box-compare-page-list">
    <?php if (count($products)) { ?>
        <div class="box-compare-product">
            <h2><?php echo $widget_title; ?><span class="fa fa-minus"></span></h2>
            <?php
            foreach ($products as $product) {
                $price = number_format(floatval($product['price']));
                if ($price == 0)
                    $price_label = Product::getProductPriceNullLabel();
                else
                    $price_label = $price . Product::getProductUnit($product);
                ?>
                <div class="item-compare-product" id="<?php echo 'item-' . $product['id'] ?>">
                    <div class="img-item-compare">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                            <img
                                src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's150_150/' . $product['avatar_name'] ?>"
                                alt="<?php echo $product['name']; ?>">
                        </a>
                    </div>
                    <div class="ctn-item-compare">
                        <h2>
                            <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name']; ?>">
                                <?php echo $product['name']; ?>
                            </a>
                        </h2>
                        <a class="remove-product" href="javascript:void(0)" onclick="removeit(this)"
                           data-id="<?php echo $product['id']; ?>">XÓA</a>
                    </div>
                </div>
            <?php } ?>
            <div class="box-clear-product">
                <div class="btn-compare">
                    <a href="<?php echo Yii::app()->createUrl('economy/product/compareProduct')?>">SO SÁNH</a>
                </div>
                <div class="btn-clear-all">
                    <a href="javascript:void(0)" onclick="removeitall()">XÓA Tất CẢ</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">
    //Remove Item
    function removeit(ev) {
        var id = $(ev).attr('data-id');
        var url = '<?php echo Yii::app()->createUrl('economy/product/deleteCompare') ?>';
        $.ajax({
            url: url,
            data: {id: id},
            type: 'get',
            dataType: 'json',
            success: function (data) {
                if (data.code == 200) {
                    $('#item-' + id).remove();
                }
            }
        });
    }
    //Remove All Item
    function removeitall() {
        var url = '<?php echo Yii::app()->createUrl('economy/product/deleteCompare', array('clear' => true)) ?>';
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.code == 200) {
                    $(".box-compare-page-list").html(data.html);
                }
            }
        });
    }
</script>



