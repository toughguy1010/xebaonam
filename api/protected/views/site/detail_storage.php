<?php
$count_product = number_format(Product::countAll($site_admin->site_id), 0, '', '.'); //Số lượng sản phẩm
$count_news = number_format(News::countAllNews($site_admin->site_id), 0, '', '.'); //Số lượng tin tức
$num_order = number_format(Orders::getCountOrder($site_admin->site_id), 0, '', '.'); //Số lượng đơn hàng mới
$count_album = number_format(Albums::countAllAlbum($site_admin->site_id), 0, '', '.'); //Số lượng album
$count_tour = number_format(Tour::countAll($site_admin->site_id), 0, '', '.'); //Số lượng album
$count_user = number_format(Users::countAll($site_admin->site_id), 0, '', '.'); //Số lượng album

$userAccess = new ClaUserAccess($site_admin->site_id);
$statistic = (isset($userAccess) && $userAccess->statistic()) ? $userAccess->statistic() : []; //Tổng lượt truy cập

$storage_limit = $site_admin->storage_limit * 1024 * 1024;
$discount = round($site_admin->storage / $storage_limit, 2) * 100;
$color = 'lightgreen';
if ($discount >= 100) {
    $color = '#AF4E96';
}
if ($discount < 100 && $discount >= 80) {
    $color = '#DA5430';
}
if ($discount < 80 && $discount >= 40) {
    $color = '#2a91d8';
}
if ($discount < 40) {
    $color = '#59a84b';
}
?>
<style>
    .grid3 {
        display: flex;
        align-items: center;
    }

    .widget-body {
        border: 1px solid #CCC;
        border-top: 0;
        background-color: #FFF;
        position: relative;
    }

    .title_tk {
        position: absolute;
        width: 88px;
        height: 88px;
        top: 40px;
        right: 20px;
        background-color: rgb(255, 255, 255);
        opacity: 0.85;
    }

    .statistical table {
        position: absolute;
        top: 40px;
        right: 20px;
        font-size: smaller;
        color: #545454;
    }

    #mycanvas {
        margin-left: 40px;
    }

    .storage_used2.infobox-blue2 {
        color: <?=$color?>;
        border-color: <?=$color?>;
    }

    .widget-box .grey {
        margin-right: 3px;
    }

    .box3 .infobox {
        width: 33.33%;
    }

    .widget-box {
        margin-top: 0;
    }

    .page-content h1 {
        background: linear-gradient(to right, #438eb9 0%, #0073b5 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
        line-height: inherit;
    }

    .profile-user-info {
        margin: 15px 0;
        margin-bottom: 30px;
        padding: 0;
    }

    .storage_warning strong {
        display: flex;
        align-items: center;
    }

    .storage_warning strong svg {
        margin-right: 5px;
    }

    .widget-header-small {
        padding: 8px 10px;
    }
    .widget-header.m-b-25 {
        margin-bottom: 25px;
    }

    .infobox .infobox-data .infobox-data-number {
        display: block;
        font-size: 22px;
        margin: 2px 0 4px;
        position: relative;
        text-shadow: 1px 1px 0 rgba(0, 0, 0, 0.15);
    }

    .infobox.link:hover {
        color: #34a1cb;
        cursor: pointer;
    }

    .infobox.link:hover .infobox-content {
        font-weight: 600;
    }

    .widget-header-small > :first-child {
        display: flex;
        align-items: center;
    }

    .profile-info-row {
        font-size: 14px;
    }

    .profile-user-info-striped .profile-info-value {
        text-align: left;
    }
    .add_service {
        position: absolute;
        right: 20px;
        background-color: #d62825 !important;
        border: 2px solid #d62825;
        border-radius: 0;
        outline: none;
        height: 30px;
    }
    .add_service:hover {
        background-color: #bf2725!important;
        border: 2px solid #d62825;
        border-radius: 0;
    }
</style>
<button class="btn-xs btn-danger add_service">
    <i class="ace-icon icon-plus bigger-110"></i>
    <?=Yii::t('storage','add_service')?>
</button>
<h1 class="text-center">Website: <?= $sites->domain_default ?></h1>
<div class="row">
    <?php if ($discount >= 80) { ?>
        <div class="space-6"></div>
        <div class="col-sm-12">
            <div class="widget-header widget-header-flat widget-header-small m-b-25">
                <?php if ($discount >= 80 && $discount < 100) { ?>
                    <p class="red storage_warning">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" class="" fill="#dd5a43">
                            <path d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"></path>
                        </svg>
                        <?= Yii::t('site', 'is_almost_over') ?>
                    </p>
                <?php } ?>

                <?php if ($discount > 100) { ?>
                    <p class="red storage_warning"><strong>
                            <svg width="24px" height="24px" viewBox="0 0 24 24" class="" fill="#dd5a43">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M11 17h2v-6h-2v6zm1-15C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zM11 9h2V7h-2v2z"></path>
                            </svg>
                            <?= Yii::t('site', 'over') ?></strong>
                    </p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="space-6"></div>

    <div class="<?= ($site_admin->storage) ? 'col-sm-7' : 'col-sm-12' ?> infobox-container box3">
        <?php if ($count_product) { ?>
            <div class="infobox infobox-green link" data-url="<?= Yii::app()->createUrl('/economy/product') ?>"
                 title="Tới trang sản phẩm">
                <div class="infobox-icon">
                    <i class="ace-icon icon-file-powerpoint-o"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $count_product ?></span>
                    <div class="infobox-content">Sản phẩm</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($count_news) { ?>
            <div class="infobox infobox-blue link" data-url="<?= Yii::app()->createUrl('/content/news') ?>"
                 title="Tới trang tin tức">
                <div class="infobox-icon">
                    <i class="ace-icon icon-file-text-o"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $count_news ?></span>
                    <div class="infobox-content">Tin tức</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($count_album) { ?>
            <div class="infobox infobox-grey link" data-url="<?= Yii::app()->createUrl('/media/album') ?>"
                 title="Tới trang tin tức">
                <div class="infobox-icon">
                    <i class="ace-icon icon-picture-o"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $count_album ?></span>
                    <div class="infobox-content">Album</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($count_tour) { ?>
            <div class="infobox infobox-green link" data-url="<?= Yii::app()->createUrl('/tour/tour') ?>"
                 title="Tới trang tin tức">
                <div class="infobox-icon">
                    <i class="ace-icon icon-plane"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $count_tour ?></span>
                    <div class="infobox-content">Tour du lịch</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($count_user) { ?>
            <div class="infobox infobox-blue link" data-url="<?= Yii::app()->createUrl('/content/users/indexNormal') ?>"
                 title="Tới trang tin tức">
                <div class="infobox-icon">
                    <i class="ace-icon icon-user"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $count_user ?></span>
                    <div class="infobox-content">Người dùng đăng ký</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($num_order) { ?>
            <div class="infobox infobox-pink link" data-url="<?= Yii::app()->createUrl('/economy/order') ?>"
                 title="Tới trang đơn hàng">
                <div class="infobox-icon">
                    <i class="ace-icon icon-shopping-cart"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= $num_order ?></span>
                    <div class="infobox-content">Đơn hàng mới</div>
                </div>
                <!--            <div class="stat stat-important">4%</div>-->
            </div>
        <?php } ?>

        <?php if ($statistic['today']) { ?>
            <div class="infobox infobox-red">
                <div class="infobox-icon">
                    <i class="ace-icon icon-user"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= number_format($statistic['today'], 0, '', '.') ?></span>
                    <div class="infobox-content">Truy cập hôm nay</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($statistic['totalAccess']) { ?>
            <div class="infobox infobox-orange2">
                <div class="infobox-icon">
                    <i class="ace-icon icon-users"></i>
                </div>

                <div class="infobox-data">
                    <span class="infobox-data-number"><?= number_format($statistic['totalAccess'], 0, '', '.') ?></span>
                    <div class="infobox-content">Tổng truy cập</div>
                </div>
            </div>
        <?php } ?>

        <?php if ($site_admin->storage) { ?>
            <div class="infobox infobox-blue2 storage_used2">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage" data-percent="<?= $discount ?>" data-size="46">
                        <span class="percent"><?= $discount ?></span>%
                    </div>
                </div>

                <div class="infobox-data">
                    <span class="infobox-text">Dung lượng</span>

                    <div class="infobox-content">
                        <span class="bigger-110">~</span>
                        <?= ClaStorage::format_size($site_admin->storage) . ' / ' . ClaStorage::format_size($storage_limit) ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="space-6"></div>
        <?php
        $current = time();
        $expiryDate = (int)$site_admin['expiration_date'];
        $dateCount = ceil(($site_admin['expiration_date'] - time()) / 86400);
        if ($expiryDate) {?>
            <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name"> Ngày tạo</div>

                    <div class="profile-info-value">
                        <span class="editable editable-click"><?= date('d/m/y H:i', $site_admin['created_time']) ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Ngày hết hạn</div>

                    <div class="profile-info-value">
                        <i class="fa fa-map-marker light-orange bigger-110"></i>
                        <span class="editable editable-click"><?= date('d/m/y H:i', $site_admin['expiration_date']) ?> (<?=$dateCount?> ngày)</span>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="vspace-12-sm"></div>

    <?php if ($site_admin->storage) { ?>
        <div class="col-sm-5">
            <div class="widget-box">
                <div class="widget-header widget-header-flat widget-header-small">
                    <h5 class="widget-title">
                        <i class="ace-icon icon-signal"></i>
                        Thống kê dung lượng website
                    </h5>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <canvas id="mycanvas" width="200" height="200"></canvas>
                        <div class="legend statistical">
                            <div class="title_tk"></div>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="legendColorBox">
                                        <div style="border:1px solid null;padding:1px">
                                            <div style="width:4px;height:0;border:5px solid lightgreen;overflow:hidden"></div>
                                        </div>
                                    </td>
                                    <td class="legendLabel">Chưa sử dụng</td>
                                </tr>
                                <tr>
                                    <td class="legendColorBox">
                                        <div style="border:1px solid null;padding:1px">
                                            <div style="width:4px;height:0;border:5px solid #59a84b;overflow:hidden"></div>
                                        </div>
                                    </td>
                                    <td class="legendLabel">Sử dụng ít</td>
                                </tr>
                                <tr>
                                    <td class="legendColorBox">
                                        <div style="border:1px solid null;padding:1px">
                                            <div style="width:4px;height:0;border:5px solid #2a91d8;overflow:hidden"></div>
                                        </div>
                                    </td>
                                    <td class="legendLabel">Mức trung bình</td>
                                </tr>
                                <tr>
                                    <td class="legendColorBox">
                                        <div style="border:1px solid null;padding:1px">
                                            <div style="width:4px;height:0;border:5px solid #DA5430;overflow:hidden"></div>
                                        </div>
                                    </td>
                                    <td class="legendLabel">Mức cảnh báo</td>
                                </tr>
                                <tr>
                                    <td class="legendColorBox">
                                        <div style="border:1px solid null;padding:1px">
                                            <div style="width:4px;height:0;border:5px solid #AF4E96;overflow:hidden"></div>
                                        </div>
                                    </td>
                                    <td class="legendLabel">Vượt giới hạn</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="hr hr8 hr-double"></div>

                        <div class="clearfix">
                            <div class="grid3">
                            <span class="grey">
                                Hiện tại:
                            </span>
                                <h4 class="bigger pull-right"><?= ClaStorage::format_size($site_admin->storage) ?></h4>
                            </div>

                            <div class="grid3">
                            <span class="grey">
                                Còn trống:
                            </span>
                                <h4 class="bigger pull-right"><?= (($storage_limit - $site_admin->storage) > 0) ? ClaStorage::format_size(($storage_limit - $site_admin->storage)) : '<strong class="red">-' . ClaStorage::format_size(($site_admin->storage - $storage_limit)) . '</strong>' ?></h4>
                            </div>

                            <div class="grid3">
                            <span class="grey">
                                Tổng dung lượng:
                            </span>
                                <h4 class="bigger pull-right"><?= ClaStorage::format_size($storage_limit) ?></h4>
                            </div>
                        </div>
                    </div><!-- /.widget-main -->
                </div><!-- /.widget-body -->
            </div><!-- /.widget-box -->
        </div><!-- /.col -->
        <script src="/quantri/js/flot/chart.js"></script>
        <script src="/quantri/js/jquery.easy-pie-chart.min.js"></script>
    <?php
    $discount_chart = ($discount > 100) ? 100 : $discount;
    $degree_used = $discount_chart * 3.6;
    $degree_empty = (100 - $discount_chart) * 3.6;
    ?>
        <script>
            $('.infobox.link').click(function () {
                var link = $(this).attr('data-url');
                location.href = link;
            })
            $('.add_service').click(function () {
                location.href = '<?=Yii::app()->createUrl("siteService/addService")?>';
            })
            $('.easy-pie-chart.percentage').each(function () {
                var $box = $(this).closest('.infobox');
                var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                var size = parseInt($(this).data('size')) || 50;
                $(this).easyPieChart({
                    barColor: barColor,
                    trackColor: trackColor,
                    scaleColor: false,
                    lineCap: 'butt',
                    lineWidth: parseInt(size / 10),
                    size: size
                });
            })
            $(document).ready(function () {
                var ctx = $("#mycanvas").get(0).getContext("2d");

                //pie chart data
                //sum of values = 360
                var data = [
                    {
                        value: <?=$degree_used?>,
                        color: "<?=$color?>",
                        highlight: "lightskyblue",
                        label: "Đã sử dụng",
                    },
                    {
                        value: <?=$degree_empty?>,
                        color: "lightgreen",
                        highlight: "yellowgreen",
                        label: "Chưa sử dụng",
                    },
                ];

                //draw
                var piechart = new Chart(ctx).Pie(data);
            });
        </script>
    <?php } ?>
</div><!-- /.row -->

