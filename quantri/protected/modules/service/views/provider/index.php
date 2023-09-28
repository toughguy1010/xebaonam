<?php
/* @var $this NewsController */
/* @var $model News */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#service-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('service', 'provider_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('service/provider/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('service', 'provider_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('service/provider/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="service-grid">
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
                            'mGridId' => 'service-grid', //Gridview id
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
                'id' => 'service-grid',
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
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => 100,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name' => array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function($data) {
                            return '<a href="' . Yii::app()->createUrl('service/provider/update', array('id' => $data->id)) . '">' . $data->name . '</a>';
                        }
                            ),
                            'email',
                            'order',
                            'status' => array(
                                'name' => 'status',
                                'value' => function($data) {
                                    $status = ActiveRecord::statusArray();

                                    return isset($status[$data->status]) ? $status[$data->status] : '';
                                }
                            ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update}  {delete} ',
                                'htmlOptions' => array(
                                    'style' => 'width: 150px;',
                                    'class' => 'button-column',
                                ),
                                'buttons' => array(
                                    'update' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("/service/provider/update", array("id" => $data->id))',
                                        'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("/service/provider/delete", array("id" => $data->id))',
                                        'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                    ),
                                ),
                            ),
                            'translate' => array(
                                'header' => Yii::t('common', 'translate'),
                                'type' => 'raw',
                                'visible' => ClaSite::showTranslateButton() ? true : false,
                                'htmlOptions' => array('class' => 'button-column'),
                                'value' => function($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/service/provider/update', 'params' => array('id' => $data->id), 'model' => $data));
                        }
                            ),
                        ),
                    ));
                    ?>     
        </div>
    </div>
</div>