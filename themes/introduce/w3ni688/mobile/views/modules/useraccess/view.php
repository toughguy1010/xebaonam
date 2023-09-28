<div class="statistical">
    <?php if ($show_widget_title) { ?>
        <div class="title">
            <h2><?php echo $widget_title ?></h2>
        </div>
    <?php } ?>
    <div class="cont">
        <p class="luottruycap"><?php echo Yii::t('common', 'statistic_totalaccess'); ?>: <span><?php echo number_format($totalAccess); ?></span></p>
        <p class="dangonline"><?php echo Yii::t('common', 'statistic_online'); ?>: <span><?php echo number_format($online); ?></span></p>
        <p class="tong"><?php echo Yii::t('common', 'statistic_today'); ?>: <span><?php echo number_format($today); ?></span></p>
    </div>
</div>