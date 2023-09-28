<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-form form').submit(function(){
	$('#menus-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('banner', 'banner_group_manager') . ' ' . $bannergroup->banner_group_name; ?>
        </h4>
        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('/banner/banner/create', array('bgid' => $bannergroup->banner_group_id)) ?>" class="btn btn-xs btn-primary" style="margin-right: 0px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('banner', 'banner_create') ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <?php
            $model = new Banners();
            $model->unsetAttributes();
            $model->banner_group_id = $bannergroup->banner_group_id;
//
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'menus-grid',
                'itemsCssClass' => 'table table-bordered table-hover',
                'dataProvider' => $model->search(),
                'filter' => null,
                'columns' => array(
                    'banner_link' => array(
                        'header' => 'Banner',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align: center;'),
                        'value' => function($data) {
                    return $this->renderPartial('partial/banner_view', array('model' => $data), true);
                }
                    ),
                    'banner_name' => array(
                        'header' => Yii::t('menu', 'banner_name'),
                        'name' => 'banner_name',
                        'type' => 'raw',
                        'value' => function($data) {
                    return ($data['actived'] . '' != '' . ActiveRecord::STATUS_ACTIVED) ? '<span style="color:#aaa;">' . $data['banner_name'] . '</span>' : $data['banner_name'];
                }
                    ),
                    'banner_group_id' => array(
                        'name' => 'banner_group_id',
                        'value' => function($data) use ($bannergroup) {
                    return $bannergroup->banner_group_name;
                },
                    ),
                    'actived' => array(
                        'name' => 'actived',
                        'type' => 'raw',
                        'htmlOptions' => array('style' => 'text-align:center;'),
                        'value' => function($data) {
                    return ($data->actived == ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
                }
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update}  {delete} ',
                        'viewButtonLabel' => '',
                        'updateButtonOptions' => array('class' => 'icon-edit'),
                        'updateButtonImageUrl' => false,
                        'updateButtonLabel' => '',
                        'updateButtonUrl' => 'Yii::app()->createUrl("banner/banner/update", array("id" => $data->banner_id,"bgid"=>$data->banner_group_id))',
                        'deleteButtonOptions' => array('class' => 'icon-trash'),
                        'deleteButtonImageUrl' => false,
                        'deleteButtonLabel' => '',
                        'deleteButtonUrl' => 'Yii::app()->createUrl("banner/banner/delete",array("id"=>$data->banner_id))',
                    ),
                    'translate' => array(
                        'header' => Yii::t('common', 'translate'),
                        'type' => 'raw',
                        'visible' => ClaSite::isMultiLanguage() ? true : false,
                        'htmlOptions' => array('class' => 'button-column'),
                        'value' => function($data) {
                    $this->widget('application.widgets.translate.translate', array('baseUrl' => '/banner/banner/update', 'params' => array('id' => $data->banner_id)));
                }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>