<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#jobs-apply-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('work', 'list_apply'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('work/jobsApply/exportcsv/'); ?>" class="btn btn-xs btn-success" style="margin-right: 20px;">
                <i class="icon-cogs"></i>
                <?php echo Yii::t('common', 'contact_exportcsv'); ?>
            </a>
        </div>

    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px;">
            </div><!-- search-form -->
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'jobs-apply-grid',
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
//                    array(
//                        'class' => 'CCheckBoxColumn',
//                        'selectableRows' => 100,
//                        'htmlOptions' => array('width' => 5,),
//                    ),
                    'avatar' => array(
                        'header' => '',
                        'type' => 'raw',
                        'value' => function($data) {
                            if ($data->avatar_path && $data->avatar_name)
                                return '<img src="' . ClaHost::getImageHost() . $data->avatar_path . 's50_50/' . $data->avatar_name . '" />';
                            return '';
                        }
                    ),
                    'name',
                    'hotline',
                    'email',
                    'job_id' => array(
                        'name' => 'job_id',
                        'value' => function ($data) {
                            $job = Jobs::model()->findByPk($data->job_id);
                            return isset($job->position) ? $job->position : '';
                        }
                    ),
                    'created_time' => array(
                        'name' => 'created_time',
                        'value' => function($data) {
                            return isset($data->created_time) ? date('H', $data->created_time) . 'h' . date(':i d/m/Y', $data->created_time) : '';
                        }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {view} {delete}',
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
