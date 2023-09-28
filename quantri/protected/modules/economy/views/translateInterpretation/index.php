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
            <?php echo Yii::t('translate', 'translate_interpretation_manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/translateInterpretation/create'); ?>"
               class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('translate', 'translate_interpretation_create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/translateInterpretation/deleteall'); ?>"
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

                    'country' => array(
                        'name' => 'country',
                        'value' => function ($data) {
                            if ($data->country)
                                return ClaLanguage::getCountryName($data->country);
                            return '';
                        }
                    ),
                    'from_lang' => array(
                        'name' => 'from_lang',
                        'value' => function ($data) {
                            if ($data->from_lang)
                                return ClaLanguage::getCountryName($data->from_lang) . ' <-> ' . ClaLanguage::getCountryName($data->to_lang);
                            return '';
                        }
                    ),
                    'escort_negotiation_inter_price' => array(
                        'name' => 'escort_negotiation_inter_price',
                        'type'=>'raw',
                        'value' => function ($data) {
                            return '<input onchange="updateEscort(this,' . $data->id . ')" type="text" value="' . $data->escort_negotiation_inter_price . '">';
//                            if ($data->escort_negotiation_inter_price)
//                                return HtmlFormat::money_format($data->escort_negotiation_inter_price);
//                            return '';
                        }
                    ),
                    'consecutive_inter_price' => array(
                        'name' => 'consecutive_inter_price',
                        'type'=>'raw',
                        'value' => function ($data) {
                            return '<input onchange="updateConsecutive(this,' . $data->id . ')" type="text" value="' . $data->consecutive_inter_price . '">';
//                            if ($data->consecutive_inter_price)
//                                return HtmlFormat::money_format($data->consecutive_inter_price);
//                            return '';
                        }
                    ),
                    'simultaneous_inter_price' => array(
                        'name' => 'simultaneous_inter_price',
                        'type'=>'raw',
                        'value' => function ($data) {
                            return '<input onchange="updateSimultaneous(this,' . $data->id . ')" type="text" value="' . $data->simultaneous_inter_price . '">';
//                            if ($data->simultaneous_inter_price)
//                                return HtmlFormat::money_format($data->simultaneous_inter_price);
//                            return '';
                        }
                    ),
                    'currency'
                ,
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
                                'url' => 'Yii::app()->createUrl("economy/translateInterpretation/copy", array("id" => $data->id))',
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
                ),
            ));
            ?>
        </div>
    </div>
</div>

<script>
    //
    function updateSimultaneous(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var price = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateInterpretation/updateSimultaneous")?>";
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
    //
    function updateEscort(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var price = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateInterpretation/updateEscort")?>";
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
    //
    function updateConsecutive(e, item_id) {
        $(".loading-shoppingcart").show();
        var item_id = item_id;
        var price = e.value;
        var url = "<?php echo Yii::app()->createUrl("/economy/translateInterpretation/updateConsecutive")?>";
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