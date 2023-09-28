<?php if ($model->isNewRecord) { ?>
    <a id="addProduct" href="javascript:void(0);" class="btn btn-sm btn-light"
       onclick="alert('<?php echo Yii::t('product', 'product_group_addproduct_disable_help'); ?>');">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
<?php } else { ?>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css">
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>
    <a id="addProduct"
       href="<?php echo Yii::app()->createUrl('economy/productgroups/addproduct', array('gid' => $model->group_id)) ?>"
       class="btn btn-sm btn-primary">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>
    <div class="loading-shoppingcart"
         style="    background: #c55ee7;
    height: 40px;
    width: 200px;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-align: center;
    margin: auto;
    font-weight: bold;">
        <span>Vui lòng chờ</span>
    </div>
    <?php
    Yii::import('common.extensions.LinkPager.LinkPager');
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'product-groups-grid',
        'dataProvider' => $model->SearchProducts(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'filter' => null,
        'enableSorting' => false,
        'pager' => array(
            'class' => 'LinkPager',
            'header' => '',
            'nextPageLabel' => '&raquo;',
            'prevPageLabel' => '&laquo;',
            'lastPageLabel' => Yii::t('common', 'last_page'),
            'firstPageLabel' => Yii::t('common', 'first_page'),
        ),
        'columns' => array(
            'number' => array(
                'header' => '',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                'htmlOptions' => array('width' => '30px',),
            ),
            'id' => array(
                'header' => 'id',
                'value' => function($data) {
                    return $data->id;
                },
                'htmlOptions' => array('width' => '30px',),
            ),
            'product_id' => array(
                'header' => 'product_id',
                'value' => function($data) {
                    return $data->product_id;
                },
                'htmlOptions' => array('width' => '30px',),
            ),
            'name' => array(
                'header' => Yii::t('product', 'product_name'),
                'value' => '$data->product["name"]',
            ),
            'order' => array(
                'header' => 'Thứ tự',
                'type' => 'raw',
                'value' => function ($data) {
                    return '<input onchange="update(this,' . $data->id . ')" type="text" value="' . $data->order . '">';
                },
                'htmlOptions' => array('width' => '30px',),
            ),
            array(
                'class' => 'CButtonColumn',
                'template' => '{delete} ',
                'viewButtonLabel' => '',
                'updateButtonOptions' => array('class' => 'icon-edit'),
                'updateButtonImageUrl' => false,
                'updateButtonLabel' => '',
                'deleteButtonOptions' => array('class' => 'icon-trash'),
                'deleteButtonImageUrl' => false,
                'deleteButtonLabel' => '',
                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/productgroups/deleteproduct",array("id"=>$data["id"]))',
            ),
        ),
    ));
    ?>
    <script>
        function update(e, item_id) {
            $(".loading-shoppingcart").show();
            var item_id = item_id;
            var order_num = e.value;
            var url = "<?php echo Yii::app()->createUrl("/economy/productgroups/updateOrder", array("id" => $model->group_id));?>";
            $.ajax({
                url: url,
                dataType: "json",
                data: {item_id: item_id, order_num: order_num},
                success: function (msg) {
                    $(".loading-shoppingcart").hide();
                    if (msg.code != 200){
                        location.reload();
                    }
                }
            });
        }
        jQuery(document).ready(function () {
            $(".loading-shoppingcart").hide();
            $("#addProduct").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});
            <?php if(Yii::app()->request->getParam('create')){ ?>
            $("#addProduct").trigger('click');
            <?php } ?>
        });
    </script>
<?php } ?>