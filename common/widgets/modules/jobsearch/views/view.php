<?php
$i = Yii::app()->request->getParam('i', 0);
$v = Yii::app()->request->getParam('v', 0);
?>
<div class="tool-search">
    <input type="text" id="searchInput" class="width-full" placeholder="Nhập chức danh, vị trí, kỹ năng..." autocomplete="off" spellcheck="false">
    <?php
    if (isset($trades) && count($trades)) {
        ?>
        <div class="box-select width-full">
            <span class="position-select"><i class="fa fa-list" aria-hidden="true"></i></span>
            <select onchange="searchJob(this)">
                <option class="first-select" <?php echo $i == 0 ? 'selected="selected"' : '' ?> value="">Tất cả ngành nghề</option>
                <?php
                foreach ($trades as $trade) {
                    if ($v == 0) {
                        $alias = 'viec-lam-' . HtmlFormat::parseToAlias($trade['trade_name']);
                        $url = Yii::app()->createUrl('work/job/search', array('i' => $trade['trade_id'], 'alias' => $alias));
                    } else {
                        $location_current = isset($locations[$v]) ? $locations[$v] : '';
                        $alias = 'viec-lam-' . HtmlFormat::parseToAlias($trade['trade_name']) . '-tai-' . HtmlFormat::parseToAlias($location_current['province_name']);
                        $url = Yii::app()->createUrl('work/job/search', array(
                            'i' => $trade['trade_id'],
                            'v' => $v,
                            'alias' => $alias
                        ));
                    }
                    ?>
                    <option value="<?php echo $url ?>" <?php echo $i == $trade['trade_id'] ? 'selected="selected"' : '' ?>><?php echo $trade['trade_name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($locations) && count($locations)) {
        ?>
        <div class="box-select width-full">
            <span class="position-select"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
            <select onchange="searchJob(this)">
                <option class="first-select" value="" <?php echo $v == 0 ? 'selected="selected"' : '' ?>>Tất cả địa điểm</option>
                <?php
                foreach ($locations as $province_id => $location) {
                    if ($i == 0) {
                        $alias = 'viec-lam-tai-' . HtmlFormat::parseToAlias($location['province_name']);
                        $url = Yii::app()->createUrl('work/job/search', array('v' => $province_id, 'alias' => $alias));
                    } else {
                        $trade_current = isset($trades[$i]) ? $trades[$i] : '';
                        $alias = 'viec-lam-' . HtmlFormat::parseToAlias($trade_current['trade_name']) . '-tai-' . HtmlFormat::parseToAlias($location['province_name']);
                        $url = Yii::app()->createUrl('work/job/search', array(
                            'i' => $i,
                            'v' => $province_id,
                            'alias' => $alias
                        ));
                    }
                    ?>
                    <option value="<?php echo $url ?>" <?php echo $v == $province_id ? 'selected="selected"' : '' ?>><?php echo $location['province_name'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
    }
    ?>
    <div class="btn-submit-job width-full">
        <a href="javascript:void(0)">Tìm việc</a>
    </div>
</div>
<script type="text/javascript">
    function searchJob(_this) {
        location.href = jQuery(_this).val();
    }
    
    var timeOut = null;
    var time = 500;
    var keyWordTemp = '';
    jQuery('#searchInput').on('keyup', function () {
        var keyword = jQuery.trim(jQuery(this).val());
        isAppend = false;
        if (keyword && keyword != keyWordTemp) {
            keyWordTemp = keyword;
            if (timeOut) {
                clearTimeout(timeOut);
            }
            timeOut = setTimeout(function () {
                search(keyword);
            }, time);
        }
//        else if (!keyword) {
//            jQuery('#searchResults').fadeOut(200);
//        }
    });
    //
    function search(keyword) {
        $.getJSON(
                '<?php echo Yii::app()->createUrl('work/job/search') ?>',
                {keyword: keyword},
                function (result) {
                    $('#wrap-content-filter').html(result.html);
                    $(".content-requirment").width($(".item-job-company").width() - $(".logo-company").width() - 30);
                }
        );
    }
</script>