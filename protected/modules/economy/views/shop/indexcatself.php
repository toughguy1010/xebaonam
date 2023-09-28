<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('category', 'category_product'); ?>
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/productcategory/addcat', array('pa' => ClaCategory::CATEGORY_ROOT)); ?>" class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                <?php echo Yii::t('category', 'category_add_new'); ?>
            </a>
            <a href="<?php echo Yii::app()->createUrl('economy/productcategory/delallcat'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="news-categories-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>
    </div>
    <div class="widget-body">
        <div class="widget-main">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'news-categories-grid',
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
                        'value' => '$data["cat_id"]',
                        'selectableRows' => 150,
                        'htmlOptions' => array('width' => 5,),
                    ),
                    'cat_name' => array(
                        'header' => Yii::t("category", "category_name"),
                        'name' => 'cat_name',
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
                ),
                    )
            );
            ?>
        </div>
    </div>
</div>