<div class="widget-box">
    <div class="widget-header">
        <h4>
            <?php echo Yii::t('form', 'form_statistic_user'); ?>
        </h4>

<!--        <div class="widget-toolbar no-border">
            <a href="<?php echo Yii::app()->createUrl('custom/customform/deleteallfs'); ?>" class="btn btn-xs btn-danger delAllinGrid" grid="customform-grid">
                <i class="icon-remove"></i>
                <?php echo Yii::t('common', 'delete'); ?>
            </a>
        </div>-->
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <div class="search-active-form" style="position: relative; margin-top: 10px; min-height: 30px;">
                <div class="pageSizebox" style="position: absolute; right: 0px; top: 0px;">
                    <div class="pageSizealign">
                        <?php
                            echo $pagesize_widget;
                        ?>
                    </div>
                </div>
            </div><!-- search-form -->
            <?php
            Yii::import('common.extensions.LinkPager.LinkPager');
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'customform-grid',
                'dataProvider' => $dataProvider,
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
                'columns' => $gridColumns,
            ));
            ?>
        </div>
    </div>
</div>