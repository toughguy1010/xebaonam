<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-active-form form').submit(function(){
	$('#menu-groups-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/effects/masonry.min.js');
?>
<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('menu', 'menu_group_manager') ?>
        </h4>
        <?php if (ClaUser::isSupperAdmin()) { ?>
            <div class="widget-toolbar no-border">
                <a href="<?php echo Yii::app()->createUrl('interface/menugroup/create'); ?>" class="btn btn-xs btn-primary" style="">
                    <i class="icon-plus"></i>
                    <?php echo Yii::t('menu', 'menu_group_create') ?>
                </a>
            </div>
        <?php } ?>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $groupActiveRecord = $model->search();
                    $groups = $groupActiveRecord->getData();
                    ?>
                    <?php
                    $countGroup = count($groups);
                    if ($groups && $countGroup) {
                        $i = 0;
                        foreach ($groups as $data) {
                            if (!$data)
                                continue;
                            ?>
                            <div class="col-xs-12 col-sm-<?php echo ($countGroup == 1) ? '12' : '6'; ?> widget-container-span ui-sortable">
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h5><a href="<?php echo Yii::app()->createUrl('/interface/menugroup/list', array('mgid' => $data->menu_group_id)); ?>"><?php echo $data->menu_group_name; ?></a></h5>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up bigger-125"></i>
                                            </a>
                                            <a href="<?php echo Yii::app()->createUrl("interface/menugroup/update", array("id" => $data->menu_group_id)); ?>">
                                                <i class="icon-edit bigger-125"></i>
                                            </a>
                                            <?php if (ClaUser::isSupperAdmin()) { ?>
                                                <a href="<?php echo Yii::app()->createUrl("interface/menugroup/delete", array("id" => $data->menu_group_id)); ?>">
                                                    <i class="icon-remove bigger-125"></i>
                                                </a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-toolbox">
                                            <div class="btn-toolbar">
                                                <a style="margin-right: 20px;" class="btn btn-xs btn-primary pull-right no-margin-right" href="<?php echo Yii::app()->createUrl('/interface/menu/create', array('mgid' => $data->menu_group_id)); ?>">
                                                    <i class="icon-plus"></i>
                                                    <?php echo Yii::t('menu', 'menu_add'); ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body-inner" style="display: block;">
                                            <div class="widget-main no-padding">
                                                <?php
                                                $model = new Menus();
                                                $model->unsetAttributes();
                                                $model->menu_group = $data->menu_group_id;
                                                $dataProvider = $model->search();
                                                //
                                                $this->widget('zii.widgets.grid.CGridView', array(
                                                    'id' => 'menus-grid' . $data->menu_group_id,
                                                    'itemsCssClass' => 'table table-striped table-bordered table-hover vertical-center',
                                                    'dataProvider' => $dataProvider,
                                                    'summaryText' => '',
                                                    'htmlOptions' => array('class' => ''),
                                                    'filter' => null,
                                                    'columns' => array(
                                                        'number' => array(
                                                            'header' => '',
                                                            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                                                            'htmlOptions' => array('style' => 'width: 40px; text-align: center;')
                                                        ),
                                                        'menu_title' => array(
                                                            'header' => Yii::t('menu', 'menu_title'),
                                                            'name' => 'menu_title',
                                                            'type' => 'raw',
                                                            'value' => function($data) {
                                                                return ($data['status'] . '' != '' . ActiveRecord::STATUS_ACTIVED) ? '<span style="color:#aaa;">' . $data['menu_title'] . '</span>' : $data['menu_title'];
                                                            }
                                                        ),
                                                        'status' => array(
                                                            'header' => Yii::t('common', 'status'),
                                                            'name' => 'status',
                                                            'type' => 'raw',
                                                            'htmlOptions' => array('style' => 'text-align:center; width:90px'),
                                                            'value' => function($data) {
                                                        return ($data['status'] . '' == '' . ActiveRecord::STATUS_ACTIVED) ? '<i class="icon-eye"></i>' : '<i class="icon-eye-slash"></i>';
                                                    }
                                                        ),
                                                        array(
                                                            'class' => 'CButtonColumn',
                                                            'template' => '{update} {delete} ',
                                                            'buttons' => array(
                                                                'update' => array(
                                                                    'label' => '',
                                                                    'imageUrl' => false,
                                                                    'url' => 'Yii::app()->createUrl("interface/menu/update", array("id" => $data["menu_id"],"mgid"=>$data["menu_group"]))',
                                                                    'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                                                ),
                                                                'delete' => array(
                                                                    'label' => '',
                                                                    'imageUrl' => false,
                                                                    'url' => 'Yii::app()->createUrl("interface/menu/delete", array("id" => $data["menu_id"],"mgid"=>$data["menu_group"]))',
                                                                    'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                                                ),
                                                            ),
                                                            'htmlOptions' => array(
                                                                'style' => 'width: 75px; text-align: center;',
                                                                'class' => 'button-column',
                                                            ),
                                                        ),
                                                        'translate' => array(
                                                            'header' => Yii::t('common', 'translate'),
                                                            'type' => 'raw',
                                                            'visible' => ClaSite::showTranslateButton() ? true : false,
                                                            'htmlOptions' => array('class' => 'button-column', 'style' => 'width: 50px; text-align:center;'),
                                                            'value' => function($data) {
                                                        $this->widget('application.widgets.translate.translate', array('baseUrl' => '/interface/menu/update', 'params' => array('id' => $data['menu_id'], "mgid" => $data["menu_group"]), 'model' => Menus::model()->findByPk($data['menu_id'])));
                                                    }
                                                        ),
                                                    ),
                                                ));
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function () {
        $('#algalley .alimglist').masonry({
            itemSelector: '.alimgitem',
            isAnimated: true
        });
    });
</script>