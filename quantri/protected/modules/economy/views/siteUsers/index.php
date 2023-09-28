<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#news-categories-grid').yiiGridView('update', {
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
            $.fn.yiiGridView.update('news-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('user', 'manager_user'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/siteUsers/create', array('id' => ClaCategory::CATEGORY_ROOT)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('common', 'add'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'site-users-grid',
                'dataProvider' => $model->search(),
                'itemsCssClass' => 'table table-bordered table-hover vertical-center',
                'summaryText' => false,
                'filter' => null,
                'enableSorting' => false,
                'columns' => array(
                    'number' => array(
                        'header' => '',
                        'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                        'htmlOptions' => array('style' => 'width: 50px; text-align: center;')
                    ),
                    array(
                        'class' => 'CCheckBoxColumn',
                        'value' => '$data["id"]',
                        'selectableRows' => 150,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'name' => array(
                        'header' => Yii::t("user", "name"),
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'phone' => array(
                        'header' => Yii::t("common", "phone"),
                        'name' => 'phone',
                        'type' => 'raw',
                    ),
                    'email' => array(
                        'header' => Yii::t("common", "email"),
                        'name' => 'email',
                        'type' => 'raw',
                    ),
                    'skype' => array(
                        'header' => Yii::t("common", "skype"),
                        'name' => 'skype',
                        'type' => 'raw',
                    ),
                    'yahoo' => array(
                        'header' => Yii::t("common", "yahoo"),
                        'name' => 'skype',
                        'type' => 'raw',
                    ),
                    'status' => array(
                        'name' => 'status',
                        'header' => Yii::t('common', 'status'),
                        'value' => function($data) {
                            $status = ActiveRecord::statusArray();
                            return isset($status[$data['status']]) ? $status[$data['status']] : '';
                        },
                        'htmlOptions' => array('style' => 'width: 100px;text-align: center;'),
                    ),
                            array(
                                'class' => 'CButtonColumn',
                                'template' => '{update} {delete} ',
                                'buttons' => array(
                                    'update' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("economy/siteUsers/update", array("id" => $data["id"]))',
                                        'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                    ),
                                    'delete' => array(
                                        'label' => '',
                                        'imageUrl' => false,
                                        'url' => 'Yii::app()->createUrl("economy/siteUsers/delete", array("id" => $data["id"]))',
                                        'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                                    ),
                                ),
                                'htmlOptions' => array(
                                    'style' => 'width: 150px;',
                                    'class' => 'button-column',
                                ),
                            ),
                            'translate' => array(
                                'header' => Yii::t('common', 'translate'),
                                'type' => 'raw',
                                'visible' => ClaSite::showTranslateButton() ? true : false,
                                'htmlOptions' => array('class' => 'button-column'),
                                'value' => function($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/economy/siteUsers/update', 'params' => array('id' => $data['id'])));
                        }
                            ),
                        ),
                    ));
                    ?>
        </div>
    </div>
</div>