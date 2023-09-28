<?php
/**
 * Created by PhpStorm.
 * User: Quang TS
 * Date: 10/15/2020
 * Time: 5:33 PM
 */?>
<?php
$count_full = SitesAdmin::getCountDisk(1);
$count_warning = SitesAdmin::getCountDisk(2);
$count_large = SitesAdmin::getCountDisk(3);
$count_normal = SitesAdmin::getCountDisk(4);
?>
<style>
    .dropdown_storage .dropdown-content {
        float: left;
        width: 100%;
        padding: 0;
        background: none;
    }

    .dropdown_storage .dropdown-header {
        text-align: center;
    }

    .dropdown_storage ul .dropdown-menu {
        display: block;
        position: relative;
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        width: 100%;
    }

    .dropdown_storage .progress.active .progress-bar.red {
        background-color: #f00;
    }
    .progress-bar-danger-max {
        background-color: #AF4E96;
    }
</style>

<li class="grey dropdown-modal dropdown_storage">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
        <i class="ace-icon icon-tasks"></i>
        <span class="badge badge-grey"><?=$count_full?></span>
    </a>

    <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
        <li class="dropdown-header">
            Tổng hợp dung lượng
        </li>

        <li class="dropdown-content">
            <ul class="dropdown-menu dropdown-navbar">
                <li class="red">
                    <a href="<?=Yii::app()->createUrl('/site/viewStorage',['SitesAdmin[disk]' => 1])?>">
                        <div class="clearfix">
                            <span class="pull-left"><i
                                    class="ace-icon icon-exclamation-triangle red bigger-130"></i> Full disk</span>
                            <span class="pull-right"><?=$count_full?> sites</span>
                        </div>

                        <div class="progress progress-mini progress-striped active">
                            <div style="width:100%" class="progress-bar progress-bar-danger-max"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?=Yii::app()->createUrl('/site/viewStorage',['SitesAdmin[disk]' => 2])?>">
                        <div class="clearfix">
                            <span class="pull-left">>80% disk</span>
                            <span class="pull-right"><?=$count_warning?> sites</span>
                        </div>

                        <div class="progress progress-mini progress-striped active">
                            <div style="width:100%" class="progress-bar progress-bar-danger"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="<?=Yii::app()->createUrl('/site/viewStorage',['SitesAdmin[disk]' => 3])?>">
                        <div class="clearfix">
                            <span class="pull-left">>40% disk</span>
                            <span class="pull-right"><?=$count_large?> sites</span>
                        </div>

                        <div class="progress progress-mini progress-striped active">
                            <div style="width:60%" class="progress-bar"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="<?=Yii::app()->createUrl('/site/viewStorage',['SitesAdmin[disk]' => 4])?>">
                        <div class="clearfix">
                            <span class="pull-left"><40% disk</span>
                            <span class="pull-right"><?=$count_normal?> sites</span>
                        </div>

                        <div class="progress progress-mini progress-striped active">
                            <div style="width:20%" class="progress-bar progress-bar-success"></div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="dropdown-footer">
            <a href="<?= Yii::app()->createUrl('/site/viewStorage') ?>">
                Xem tất cả
                <i class="ace-icon icon-arrow-right"></i>
            </a>
        </li>
    </ul>
</li>
