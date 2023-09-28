<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#rentproduct-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
jQuery(document).on('change','.updateorder',function(){
var url = jQuery(this).attr('rel');
var or  = jQuery(this).val();
   jQuery.ajax({
        type: 'POST',
        url: url,
        data: {or: or},
        success: function(){
            $.fn.yiiGridView.update('rentproduct-grid');
        }
   }); 
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('rent', 'manager'); ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/rentproductcategory'); ?>" class="btn btn-xs btn-success"
               style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('category', 'category_manager'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/rentproduct/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('rent', 'create_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/rentproduct/deleteall'); ?>"
               class="btn btn-xs btn-danger delAllinGrid" grid="rentproduct-grid">
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
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                        $this->widget('common.extensions.PageSize.PageSize', array(
                            'mGridId' => 'rentproduct-grid', //Gridview id
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
                'id' => 'rentproduct-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'filter' => null,
                'enableSorting' => true,
                'summaryText' => false,
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
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    //'id',
                    'title' => array(
                        'name' => 'title',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return '<a href="' . Yii::app()->createUrl('economy/rentproduct/update', array('id' => $data->id)) . '">' . $data->name . '</a>';
                        }
                    ),
                    'price' => array(
                        'name' => 'price',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return HtmlFormat::money_format($data->price) . ' VNĐ';
                        }
                    ),
                    'category_id' => array(
                        'name' => 'category_id',
                        'value' => function ($data) {
                            return Yii::app()->controller->category->getCateName($data->category_id);
                        }
                    ),

                    'destination_id' => array(
                        'name' => 'destination_id',
                        'value' => function ($data) {
                            return Destinations::model()->findByPk($data->destination_id)->name;
                        }
                    ),
                    'publicdate' => array(
                        'name' => 'publicdate',
                        'value' => function ($data) {
                            return date('d-m-Y H:i:s', $data->publicdate);
                        }
                    ),
                    'status' => array(
                        'name' => 'status',
                        'value' => function ($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data->status]) ? $status[$data->status] : '';
                        }
                    ),
                    'order' => array(
                        'header' => Yii::t('category', 'category_order'),
                        'name' => 'order',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::textField('order', $data['order'], array('class' => 'updateorder', 'style' => 'width: 50px;', 'rel' => Yii::app()->createUrl('economy/rentproduct/updateorder', array('id' => $data['id'],))));
                        },
                        'htmlOptions' => array('style' => 'width: 50px;'),
                    ),
                    //'poster',
                    'viewed',
                    'user_id' => array(
                        'name' => 'user_id',
                        'value' => function ($data) {
                            $usera = UsersAdmin::model()->findByPk($data->user_id);
                            return isset($usera->user_name) ? $usera->user_name : '';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function ($data) {
                            return date('d-m-Y H:i:s', $data->created_time);
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{_preview} {update}  {delete} {_copy}',
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                        'buttons' => array(
                            //
                            '_preview' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'type' => 'raw',
                                'url' => function ($data) {
                                    $api = new ClaAPI();
                                    $respon = $api->createUrl(array(
                                        'basepath' => '/economy/rentproduct/detail',
                                        'params' => json_encode(array('id' => $data->id, 'alias' => $data->alias)),
                                        'absolute' => 'true',
                                    ));
                                    if ($respon) {
                                        return $respon['url'];
                                    }
                                },
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-search', 'title' => 'Preview', 'target' => '_blank'),
                            ),
                            //
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/economy/rentproduct/update", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            //
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/economy/rentproduct/delete", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                            //
                            '_copy' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("/economy/rentproduct/copy", array("id" => $data->id))',
                                'options' => array('style' => 'padding: 0px 5px;font-size: 15px;', 'class' => 'icon-files-o', 'title' => 'Copy'),
                            ),
                        ),
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::showTranslateButton() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/rentproduct/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>