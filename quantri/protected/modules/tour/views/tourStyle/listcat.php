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
            $.fn.yiiGridView.update('tour-categories-grid');
        }
   }); 
});

");
?>

<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('tour', 'tour_style_manager'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('tour/tourStyle/create'); ?>" class="btn btn-xs btn-primary"
               style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('tour', 'add_tour_style'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'tour-categories-grid',
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
                        'header' => Yii::t("tour", "name"),
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => ' {update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("tour/tourStyle/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("tour/tourStyle/delete", array("id" => $data["id"]))',
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
                        'value' => function ($data) {
                            $this->widget('application.widgets.translate.translate', array('baseUrl' => '/tour/tourStyle/update', 'params' => array('id' => $data['id']), 'model' => TourStyle::model()->findByPk($data['id'])));
                        }
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>