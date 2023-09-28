<?php $this->beginContent('//layouts/main'); ?>
<div class="container clearfix">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="page-list-news clearfix">
        <div class="page-news-detail">
            <div class="row">
                <div class="col-xs-8">
                    <?php
                    echo $content;
                    ?>
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
                    ?>
                </div>
                <div class="col-xs-4">
                    <div class="box-news-left">
                        <div class="menu-news-left clearfix">
                            <ul role="tablist" id="myTabs">
                                <li class="active" role="presentation"><a aria-expanded="true" aria-controls="tin-tuc" data-toggle="tab" role="tab" id="tin-tuc-tab" href="#tin-tuc">tin tức</a></li>
                                <li role="presentation"><a aria-controls="video" data-toggle="tab" id="video-tab" role="tab" href="#video">video</a></li>
                                <li role="presentation"><a aria-controls="hoi-dap" data-toggle="tab" id="hoi-dap-tab" role="tab" href="#hoi-dap">hỏi đáp</a></li>
                                <li role="presentation"><a aria-controls="facebook" data-toggle="tab" id="facebook-tab" role="tab" href="#facebook">facebook</a></li>
                            </ul>
                        </div>
                        <div class="cont-menu-left">
                            <div class="tab-content" id="myTabContent">
                                <div aria-labelledby="tin-tuc-tab" id="tin-tuc" class="tab-pane fade in active" role="tabpanel">
                                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_BOTTOM)); ?>
                                </div>
                                <div aria-labelledby="video-tab" id="video" class="tab-pane fade" role="tabpanel">
                                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_LEFT)); ?>

                                </div>
                                <div aria-labelledby="hoi-dap-tab" id="hoi-dap" class="tab-pane fade" role="tabpanel">
                                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_HEADER_RIGHT)); ?>

                                </div>
                                <div aria-labelledby="facebook-tab" id="facebook" class="tab-pane fade" role="tabpanel">
                                    <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER_BLOCK2)); ?>  
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
                    ?>

                </div>
            </div>
        </div>
    </div>
    <?php
//            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT));
    ?>
</div>
<?php $this->endContent(); ?>