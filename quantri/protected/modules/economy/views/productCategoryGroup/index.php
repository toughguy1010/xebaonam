<div class="widget-box">
    <div class="widget-header">
        <h4>
            Nhóm danh mục
        </h4>

        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('economy/productCategoryGroup/create', array('id' => ClaCategory::CATEGORY_ROOT)); ?>"
               class="btn btn-xs btn-primary" style="margin-right: 20px;">
                <i class="icon-plus"></i>
                Thêm nhóm
            </a>
        </div>
    </div>
    <div class="widget-main">
        <div class="search-active-form" style="position: relative; margin-top: 10px;">
            <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                <div class="pageSizealign">
                    <?php
                    $this->widget('common.extensions.PageSize.PageSize', array(
                        'mGridId' => 'product-grid', //Gridview id
                        'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
                        'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                    ));
                    ?>
                </div>
            </div>
        </div><!-- search-form -->
        <div class="widget-body">
            <div class="widget-main">

                <?php
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'banner-grid',
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
                            'header' => 'Tên nhóm',
                            'name' => 'name',
                            'type' => 'raw',
                        ),
                        'ids_group' => array(
                            'header' => 'Id các danh mục trong nhóm',
                            'name' => function($model) {
                                return $model->ids_group;
                            },
                            'type' => 'raw',
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => ' {update} {delete} ',
                            'buttons' => array(
                                'update' => array(
                                    'label' => '',
                                    'imageUrl' => false,
                                    'url' => 'Yii::app()->createUrl("economy/productCategoryGroup/update", array("id" => $data["id"]))',
                                    'options' => array('class' => 'icon-edit', 'title' => Yii::t('common', 'update')),
                                ),
                                'delete' => array(
                                    'label' => '',
                                    'imageUrl' => false,
                                    'url' => 'Yii::app()->createUrl("economy/productCategoryGroup/delete", array("id" => $data["id"]))',
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