<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#jobs-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('work', 'work_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('work/jobs/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('work', 'job_create'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('work/jobs/deleteall'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="jobs-grid">
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
                            'mGridId' => 'jobs-grid', //Gridview id
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
                'id' => 'jobs-grid',
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
                    'position',
                    'degree' => array(
                        'name' => 'degree',
                        'value' => function($data)use($degrees) {
                    return isset($degrees[$data['degree']]) ? $degrees[$data['degree']] : '';
                }
                    ),
                    'trade_id' => array(
                        'name' => 'trade_id',
                        'value' => function($data) use ($trades) {
                    return isset($trades[$data->trade_id]) ? $trades[$data->trade_id] : '';
                }
                    ),
                    'location' => array(
                        'name' => 'location',
                        'value' => function($data) use ($provinces) {
                    $locations = $data->getLocations();
                    return Jobs::getListLocationText($locations, array('provinces' => $provinces));
                }
                    ),
                    /*
                      'typeofwork',
                      'location',
                      'quantity',
                      'salaryrange',
                      'currency',
                      'salary_min',
                      'salary_max',
                      'description',
                      'experience',
                      'level',
                      'includes',
                      'expirydate',
                      'created_time',
                      'alias',
                      'contact_username',
                      'contact_email',
                      'contact_phone',
                     */
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
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
                        'visible' => ClaSite::isMultiLanguage() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/work/jobs/update', 'params' => array('id' => $data->id)));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>
