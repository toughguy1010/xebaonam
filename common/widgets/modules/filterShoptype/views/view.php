<div class="check-box clearfix">
    <div class="container">
        <p class="title-option">Lựa chọn:</p>
        <div class="cont">
            <form class="me-select clearfix" role="form" method="post">
                <ul id="me-select-list">
                    <li>
                        <input id="cb1" <?php echo in_array(ActiveRecord::TYPE_SELL_ONLINE, $filter_shop) ? 'checked' : ''; ?> type="checkbox" class="filter_shop" value="<?php echo ActiveRecord::TYPE_SELL_ONLINE ?>">
                        <label for="cb1">Gian hàng online</label>
                    </li>
                    <li>
                        <input id="cb2" <?php echo in_array(ActiveRecord::TYPE_HAS_ADDRESS, $filter_shop) ? 'checked' : ''; ?> type="checkbox" class="filter_shop" value="<?php echo ActiveRecord::TYPE_HAS_ADDRESS ?>">
                        <label for="cb2">Gian hàng có địa chỉ cụ thể</label>
                    </li>
                    <li>
                        <input id="cb3" <?php echo in_array(ActiveRecord::TYPE_BEST_LIKE, $filter_shop) ? 'checked' : ''; ?> type="checkbox" class="filter_shop" value="<?php echo ActiveRecord::TYPE_BEST_LIKE; ?>">
                        <label for="cb3">Gian hàng được yêu thích nhất</label>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.filter_shop').click(function () {
            var type_filter = $(this).val();
            var execute_filter = 0;
            if ($(this).is(':checked')) {
                execute_filter = 1;
            } else {
                execute_filter = 0;
            }
            $.getJSON(
                    '<?php echo Yii::app()->createUrl('/economy/shop/setFilterShop') ?>',
                    {type_filter: type_filter, execute_filter: execute_filter},
            function (res) {
                if (res.code == 200) {
                    location.reload();
                }
            }
            );
        });
    });
</script>