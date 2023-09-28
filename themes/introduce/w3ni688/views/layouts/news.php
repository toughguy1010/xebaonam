<?php $this->beginContent('//layouts/main'); ?>
<style>
    body {
        background: #fff;
    }
</style>
<div class="container clearfix">
    <div class="page-news news-bike">
        <?php // $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_CENTER));
        ?>
        <div class="row">
            <div class="col-xs-6">
                <style type="text/css">.box-store {
                        margin-top: 20px;
                    }
                    .box-img-store img {
                        position: absolute;
                        top: 0;
                        left: 0;
                        bottom: auto;
                        right: auto;
                        margin: auto;
                    }
                </style>
                <?php
                echo $content;
                ?>
            </div>
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-5">
                        <?php
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK3));
                        ?>
                    </div>
                    <div class="col-xs-7">
                        <?php
                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK5));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!--    <div class="page-list-news clearfix">
                <div class="col-left">

                </div>
                <div class="col-right">

                </div>
            </div>-->
        <?php
//            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT));
        ?>
    </div>
    <?php $this->endContent(); ?>