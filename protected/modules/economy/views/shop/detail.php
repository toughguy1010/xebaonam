<?php if (count($products)) { ?>
    <div class="row">
        <?php
        foreach ($products as $product) {
            ?>
            <div class="col-sm-4">
                <div class="box-stand">
                    <div class="box-stand-img">
                        <a href="<?php echo $product['link']; ?>" title="<?php echo $product['name'] ?>">
                            <img src="<?php echo ClaHost::getImageHost(), $product['avatar_path'] . 's380_380/', $product['avatar_name'] ?>">
                        </a>
                    </div>
                    <div class="box-stand-info clearfix">
                        <div class="box-stand-info-left">
                            <div class="name-stand">
                                <h4><a href="<?php echo $product['link']; ?>"><?php echo $product['name'] ?></a></h4>
                            </div>
                            <div class="price-in">
                                <p><?php echo $product['price_text'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
        <div class='product-page'>
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
<?php } else { ?>
    <p class="text-info">
        <?php Yii::t('product', 'product_no_result'); ?>
    </p>
<?php } ?>
    
<script type="text/javascript">
    $(document).ready(function () {
        $('.btn-like-shop').click(function () {
            var status = '';
            if ($(this).hasClass('btn-unlike-shop')) {
                status = 'unlike';
            } else {
                status = 'like';
            }
            var user_id = '<?php echo Yii::app()->user->id; ?>';
            if (user_id == '') {
                if (confirm('Bạn cần đăng nhập để thích!')) {
                    location.href = '<?php echo Yii::app()->createUrl('login/login/login') ?>';
                } else {
                    return false;
                }
            }
            $.getJSON(
                    "<?php echo $this->createUrl('likeshop'); ?>",
                    {id:<?php echo $shop['id'] ?>, status: status},
            function (data) {
                if (data.code == 200) {
                    if (data.status == 'like') {
                        $('.btn-like-shop').addClass('btn-unlike-shop');
                        $('.btn-like-shop img').attr('src', data.srcimg);
                        $('.count_like').text(data.count_like)
                        alert('Đã thích');
                    } else if (data.status == 'unlike') {
                        $('.btn-like-shop').removeClass('btn-unlike-shop');
                        $('.btn-like-shop img').attr('src', data.srcimg);
                        $('.count_like').text(data.count_like)
                        alert('Đã bỏ thích');
                    }
                }
            }
            );
        });
    });
</script>

