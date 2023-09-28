<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#translate-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('translate', 'translate_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/translateLanguage/create'); ?>"
               class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('translate', 'translate_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/translateLanguage/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="translate-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                <?php
                $this->renderPartial('_search', array(
                    'model' => $model,
                ));
                ?>
                <div class="pageSizebox" style="position: relative; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'translate-grid', //Gridview id
                            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                        ));
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'translate-grid',
                'dataProvider' => $model->search(),
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
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'id',
                    'from_lang' => array(
                        'name' => 'from_lang',
                        'value' => function ($data) {
                            if ($data->from_lang)
                                return ClaLanguage::getCountryName($data->from_lang);
                            return '';
                        }
                    ),
                    'to_lang' => array(
                        'name' => 'to_lang',
                        'value' => function ($data) {
                            if ($data->to_lang)
                                return ClaLanguage::getCountryName($data->to_lang);
                            return '';
                        }
                    ),
                    'price' => array(
                        'name' => 'price',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<input onchange="updatePriceStandard(this,' . $data->id . ')" type="text" value="' . $data->price . '">';
                        }
                    ),
                    'price_business' => array(
                        'name' => 'price_business',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<input onchange="updatePriceBusiness(this,' . $data->id . ')" type="text" value="' . $data->price_business . '">';
                        }
                    ),
                    'currency',
                    'aff_percent' => array(
                        'header' => '% Triết khấu',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<input onchange="update(this,' . $data->id . ')" type="text" value="' . $data->aff_percent . '">';
                        },
                        'htmlOptions' => array('width' => '30px',),
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),

                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function ($data) {
                            return ($data->created_time) ? date('d-m-Y', $data->created_time) : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {_copy}  {delete}',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("/content/news/update", array("id" => $data->news_id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
//                                'url' => 'Yii::app()->createUrl("/content/news/delete", array("id" => $data->news_id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                            '_copy' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("economy/translateLanguage/copy", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-files-o', 'title' => 'Copy'),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 130px;',
                            'class' => 'button-column',
                        ),
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/translateLanguage/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>

<script>
    function update(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var aff_percent = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateLanguage/updateaffilate")?>";
        $.ajax({
            url: url,
            dataType: "json",
            data: {item_id: item_id, aff_percent: aff_percent},
            success: function (msg) {
                $(".loading-shoppingcart").hide();
                if (msg.code != 200) {
                    location.reload();
                }
            }
        });
    }
    function updatePriceBusiness(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var price = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateLanguage/updatePriceBusiness")?>";
        $.ajax({
            url: url,
            dataType: "json",
            data: {item_id: item_id, price: price},
            success: function (msg) {
                $(".loading-shoppingcart").hide();
                if (msg.code != 200) {
                    location.reload();
                }
            }
        });
    }
    function updatePriceStandard(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var price = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateLanguage/updatePriceStandard")?>";
        $.ajax({
            url: url,
            dataType: "json",
            data: {item_id: item_id, price: price},
            success: function (msg) {
                $(".loading-shoppingcart").hide();
                if (msg.code != 200) {
                    location.reload();
                }
            }
        });
    }
</script>
<style>
    input[type="text"] {
        width: 80px;
    }
</style>