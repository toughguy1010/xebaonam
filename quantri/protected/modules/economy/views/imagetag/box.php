<div class="widget-box">
    <div class="widget-header header-color-green2">
        <h4 class="lighter smaller"><?php echo Yii::t('product', 'choiced_product') ?></h4>
        <div class="widget-toolbar no-border">
            <a
                href="<?php echo Yii::app()->createUrl('economy/product/addproducttotag') ?>"
                class="btn btn-sm btn-primary addProductToTag" onclick="return imageTag.showBoxAddProduct(this);">
                    <?php echo Yii::t('product', 'product_image_tag_add'); ?>
            </a>
        </div>

    </div>

    <div class="widget-body">
        <div class="widget-main padding-8">
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'htmlOptions' => array('class' => 'itpData'),
                'summaryText' => '',
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
                    'name' => array(
                        'header' => Yii::t('product', 'product_name'),
                        'value' => '$data->product["name"]',
                    ),
                    'code' => array(
                        'name' => 'code',
                        'value' => function($data) {
                            if ($data->product['code'])
                                return $data->product['code'];
                            return '';
                        }
                    ),
//                    'price' => array(
//                        'name' => 'price',
//                        'value' => function($data) {
//                            if ($data->product['price'])
//                                return HtmlFormat::money_format($data->product['price']);
//                            return '';
//                        }
//                    ),
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
                        'deleteButtonUrl' => 'Yii::app()->createUrl("/economy/imagetag/deleteproduct",array("id"=>$data["id"]))',
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>