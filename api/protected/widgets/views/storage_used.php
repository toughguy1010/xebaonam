<?php
$admin_info = SitesAdmin::model()->findByPk(Yii::app()->siteinfo['site_id']);
$storage_limit = $admin_info->storage_limit * 1024 * 1024;
$discount = round($admin_info->storage / $storage_limit, 2) * 100;
$yesterday = $admin_info->storage - $admin_info->storage_used;
$discount_yesterday = round(($admin_info->storage - $admin_info->storage_used) / $admin_info->storage_used, 2) * 100;
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
<?php if ($admin_info->storage) { ?>
    <div class="storage_site">
        <a href="<?=Yii::app()->createUrl('/site/detailStorage',['id'=> $admin_info->site_id])?>">
            <div class="infobox infobox-blue2 storage_used">
                <div class="infobox-progress">
                    <div class="easy-pie-chart percentage" data-percent="<?= $discount ?>" data-size="46">
                        <span class="percent"><?= $discount ?></span>%
                    </div>
                </div>

                <div class="infobox-data">
                    <span class="infobox-text"><?= Yii::t('site', 'storage') ?></span>

                    <div class="infobox-content">
                        <strong><?= ClaStorage::format_size($admin_info->storage) . ' / ' . ClaStorage::format_size($storage_limit) ?></strong>
                    </div>
                </div>
            </div>
        </a>
        <div class="infobox infobox-green storage_used yesterday">
            <div class="infobox-data">
                <span class="infobox-data-number"><?= Yii::t('site', 'yesterday') ?></span>
                <div class="infobox-content"><?= ClaStorage::format_size($yesterday) ?></div>
            </div>
            <div class="stat stat-success"><?= $discount_yesterday ?>%</div>
        </div>
        <?php if ($discount >= 80 && $discount < 100) { ?>
            <p class="storage_warning"><?= Yii::t('site', 'is_almost_over') ?></p>
        <?php } ?>

        <?php if ($discount > 100) { ?>
            <p class="storage_warning"><?= Yii::t('site', 'over') ?></p>
        <?php } ?>
    </div>

    <style>
        .storage_warning {
            border-top: 1px dotted #d8d8d8;
            padding: 15px;
            float: left;
            width: 100%;
            color: #d15b47;
            padding-bottom: 0;
            padding-top: 5px;
            font-weight: 600;
        }

        .storage_site {
            float: left;
            width: 100%;
            margin-top: 15px;
            box-shadow: 0px 0px 3px 0px #abbac3;
        }

        .storage_used {
            float: left;
            width: 100%;
            background: #f9f9f9;
            text-align: center;
            border: none;
        }

        .storage_used .infobox-data {
            min-width: inherit;
        }

        .storage_used.infobox-blue2 {
            color: <?=$color?>;
            border-color: <?=$color?>;
        }

        .yesterday > .infobox-data > .infobox-data-number {
            font-size: 18px;
        }

        .yesterday {
            border-top: 1px dotted;
        }

        .yesterday .infobox-data {
            float: left;
            width: 100%;
        }
    </style>
    <script src="/quantri/js/jquery.easy-pie-chart.min.js"></script>
    <script>
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
    </script>
<?php } ?>