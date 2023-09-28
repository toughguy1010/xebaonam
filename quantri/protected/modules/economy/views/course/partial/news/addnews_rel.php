<div class="widget widget-box no-border">
    <div class="widget-header"><h4>
            <?php echo Yii::t('product', 'product_add_rel_news') . " '" . $model->name . "'"; ?>
        </h4></div>
    <div class="widget-body" style="border: none;">
        <div class="widget-main">
            <div class="row" style="overflow: hidden;">
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-7">
                                <div class="widget-box" id="searchproduct">
                                    <div class="widget-header header-color-grey">
                                        <h4 class="lighter smaller"><?php echo Yii::t('news', 'news_search'); ?></h4>
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main padding-8">
                                            <div class="search-active-form" style="position: relative; margin-top: 10px;">
                                                <?php
                                                $this->renderPartial('partial/news/_searchnews', array(
                                                    'newsModel' => $newsModel,
                                                ));
                                                ?>
                                            </div><!-- search-form -->
                                            <?php
                                            /* @var $this NewsController */
                                            /* @var $model News */

                                            Yii::app()->clientScript->registerScript('search', "
                                            $('.search-active-form form').submit(function(){
                                                    $('#news-grid').yiiGridView('update', {
                                                            data: $(this).serialize()
                                                    });
                                                    return false;
                                            });
                                            ");
                                            ?>
                                            <?php
                                            Yii::import('common.extensions.LinkPager.LinkPager');
                                            $this->widget('zii.widgets.grid.CGridView', array(
                                                'id' => 'news-grid',
                                                'summaryText' => '',
                                                'dataProvider' => $newsModel->search(),
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
                                                    'news_title' => array(
                                                        'name' => 'news_title',
                                                        'htmlOptions' => array(
                                                            'style' => 'padding-top:0px; padding-bottom:0px; font-size: 12px;',
                                                        ),
                                                    ),
                                                    'action' => array(
                                                        'header' => '',
                                                        'type' => 'raw',
                                                        'htmlOptions' => array('style' => 'width: 60px; text-align:center; font-size: 20px; padding: 0px;'),
                                                        'value' => function($data) {
                                                            return '<a href="#" onclick="return AddToChoice(\'' . $data['news_id'] . '\',this); return false;" title="' . Yii::t('product', 'product_add') . '"><i class="icon-chevron-right"></i></a>'
                                                                . '<a class="hidden" style="color: #AC0912;" href="#" onclick="return RemoveChoice(\'' . $data['news_id'] . '\',this); return false;" title="' . Yii::t('product', 'product_add') . '"><i class="icon-remove"></i></a>';
                                                        }
                                                    ),
                                                ),
                                            ));
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5" id="choicednews">
                                <?php
                                $form = $this->beginWidget('CActiveForm', array(
                                    'id' => 'news-groups-form',
                                    'htmlOptions' => array('class' => 'form-horizontal'),
                                    'enableAjaxValidation' => false,
                                ));
                                ?>
                                <div class="widget-box">
                                    <div class="widget-header header-color-green2">
                                        <h4 class="lighter smaller"><?php echo Yii::t('product', 'choiced_product') ?></h4>
                                        <div class="widget-toolbar no-border">
                                            <?php echo CHtml::submitButton(Yii::t('product', 'choiced_product_save'), array('class' => 'btn btn-xs btn-primary', 'id' => 'btnNewsSave')); ?>
                                        </div>

                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main padding-8">
                                            <table class="table table-bordered table-hover vertical-center news">
                                                <thead>
                                                <tr>
                                                    <th id="news-grid_c0">
                                                        <?php echo $newsModel->getAttributeLabel('news_title'); ?>
                                                    </th>
                                                    <th id="news-grid_caction">&nbsp;</th></tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                echo CHtml::hiddenField('rel_news', '', array('id' => 'choicedNews'));
                                ?>
                                <?php
                                $this->endWidget();
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->renderPartial('partial/news/script', array('isAjax' => $isAjax)); ?>