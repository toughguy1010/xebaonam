

<?php if ($model->isNewRecord) { ?>

    <a id="addProduct" href="javascript:void(0);" class="btn btn-sm btn-light" onclick="alert('<?php echo Yii::t('product', 'product_rel_addproduct_disable_help'); ?>');">

        <?php echo Yii::t('product', 'product_group_addproduct'); ?>

    </a>

<?php } else { ?>

    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/style3/colorbox.css"></link>

    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/colorbox/jquery.colorbox-min.js"></script>

    <a id="addProduct" href="<?php echo Yii::app()->createUrl('economy/product/addproducttorelation', array('pid' => $model->id)) ?>" class="btn btn-sm btn-primary">
        <?php echo Yii::t('product', 'product_group_addproduct'); ?>
    </a>

    <a id="addProductByImage" href="<?php echo Yii::app()->createUrl('economy/product/addproducttorelationbyimage', array('pid' => $model->id)) ?>" class="btn btn-sm btn-primary">
        <?php echo Yii::t('product', 'product_addproduct_byimage'); ?>

    </a>

    <?php

    Yii::import('common.extensions.LinkPager.LinkPager');

    $this->widget('zii.widgets.grid.CGridView', array(

        'id' => 'product-groups-grid',

        'dataProvider' => $model->SearchProductsRel(),

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

            'name' => array(

                'type' => 'raw',

                'value' => function($data) {

//                return $data->product_rel_id;

//                            return $data->object_id;

                    return Product::model()->findByPk($data->product_rel_id)->name;

                },

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

                'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/product/deleteproductinrel",array("product_id"=>$data["product_id"],"product_rel_id"=>$data["product_rel_id"]))',

            ),

        ),

    ));

    ?>

    <script>

        jQuery(document).ready(function () {

            $("#addProduct").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});

    <?php if (Yii::app()->request->getParam('create')) { ?>

                $("#addProduct").trigger('click');

    <?php } ?>

            $("#addProductByImage").colorbox({width: "80%", maxHeight: '100%', overlayClose: false});

    <?php if (Yii::app()->request->getParam('create')) { ?>

                $("#addProductByImage").trigger('click');

    <?php } ?>

        });

    </script>

<?php } ?>