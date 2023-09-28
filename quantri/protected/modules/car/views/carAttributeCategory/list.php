<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('car', 'manager_attribute_category'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('car/carAttributeCategory/create'); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('car', 'create'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'car-categories-grid',
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
                        'header' => 'Tên danh mục thuộc tính',
                        'name' => 'name',
                        'type' => 'raw',
                    ),
                    'group_id' => [
                        'header' => 'Nhóm thuộc tính',
                        'name' => 'group_id',
                        'value' => function($model) {
                            $group = CarAttributeGroup::model()->findByPk($model->group_id);
                            return isset($group->name) ? $group->name : '';
                        }
                    ],
                    'order' => array(
                        'header' => 'Sắp xếp',
                        'name' => 'order',
                        'type' => 'raw',
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{update} {delete} ',
                        'buttons' => array(
                            'update' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("car/carAttributeCategory/update", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                            ),
                            'delete' => array(
                                'label' => '',
                                'imageUrl' => false,
                                'url' => 'Yii::app()->createUrl("car/carAttributeCategory/delete", array("id" => $data["id"]))',
                                'options' => array('class' => 'icon-trash', 'title' => Yii::t('common', 'delete')),
                            ),
                        ),
                        'htmlOptions' => array(
                            'style' => 'width: 150px;',
                            'class' => 'button-column',
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>