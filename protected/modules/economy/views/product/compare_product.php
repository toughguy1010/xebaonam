<div class="box-compare-inpage <?php echo count($products).'product'?>">
    <div class="section-1-compare">
        <div class="item-compare-25 title-first-compare">
            <h2 class="title-compare">SO SÁNH</h2>
            <ul>
                <li>
                    <a href="">QUAY LẠI TRANG TRƯỚC</a>
                </li>
                <li><a href="">So Sánh lại</a></li>
                <li><a href="">IN BẢNG SO SÁNH</a></li>
            </ul>
        </div>
        <?php foreach ($products as $product) {
            ?>
            <div class="item-compare-25">
                <div class="product-compare">
                    <div class="img-product-compare">
                        <a href="<?php echo Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias'])); ?>"
                           title="<?php echo $product['name']; ?>">
                            <img
                                src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                alt="<?php echo $product['name']; ?>">
                        </a>
                    </div>
                    <div class="title-product-compare">
                        <h2>
                            <a href="<?php echo Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias'])); ?>"><?php echo $product['name'] ?></a>
                        </h2>
                        <span><?php if ($product['price'] && $product['price'] > 0) { ?>
                                <p><?php echo number_format($product['price'], 0, '', ',') . ' VNĐ'; ?></p>
                            <?php }?></span>
                        <div class="view-more-detail">
                            <a href="<?php echo Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias'])); ?>">MUA
                                HÀNG <i class="fa fa-shopping-cart"></i></a>
                        </div>
                        <a class="remove-product" href="javascript:void(0)" onclick="removeit(this)"
                           data-id="<?php echo $product['id']; ?>">XÓA</a>
                    </div>
                </div>
            </div>

            <?php
        } ?>
    </div>
    <div class="section-1-compare">
        <?php
        if(count($products)<=1){
            echo 'Vui lòng chọn ít nhất 2 sản phẩm để so sánh';
        }else{
        foreach ($attributesShow as $key => $att) {
            if ($att['field_configurable'] != 1) {
                ?>
                <div class="row-compare">
                    <div class="item-compare-25 title-first-compare">
                        <h2><?php echo $att['name']; ?></h2>
                    </div>
                    <?php for ($i = 0; $i < count($products); $i++) {
                        if (isset($attr[$i][$key]) && !is_array($attr[$i][$key]['value'])) {
                            ?>
                            <div class="item-compare-25">
                                <span><?php echo $attr[$i][$key]['value'] ?></span>
                            </div>
                        <?php } else if (isset($attr[$i][$key]) && is_array($attr[$i][$key]['value'])) {
                            ?>
                            <div class="item-compare-25">
                                <span><?php echo implode(' ', $attr[$i][$key]['value']); ?></span>
                            </div>
                        <?php }else{ ?>
                            <div class="item-compare-25">
                            </div>
                        <?php }
                    } ?>
                    <a href="" class="btn-hide">
                        Hide
                    </a>
                </div>
                <?php
            }
        }}
        ?>
    </div>
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
                location.reload();
            }
        });
    }
</script>
