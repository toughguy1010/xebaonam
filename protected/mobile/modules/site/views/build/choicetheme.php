<div class="themes">
    <div class="promotion" style="margin-bottom: 0px;">
        <div class="promotion-box">
            <div class="promotion-text">
                <a>CHỌN MỘT GIAO DIỆN PHÙ HỢP NHẤT VỚI BẠN</a>
            </div>
        </div>
    </div>
    <div class="theme-header">
        <div class="container">
            <?php
            $this->renderPartial('themecategory', array(
                'data' => $data,
                'level' => 0,
            ));
            ?>
        </div>
    </div>
    <div class="container">
        <div class="theme-title">
            <h4>BẮT ĐẦU</h4>
            <h5>BẠN CÓ THỂ THAY ĐỔI GIAO DIỆN BẤT CỨ LÚC NÀO CHỈ CẦN 1 CLICK ĐỂ CHỌN GIAO DIỆN ƯNG Ý</h5>
        </div>
        <div class="row list-theme">
            <?php
            if (count($themes)) {
                foreach ($themes as $theme) {
                    $this->renderPartial('themeItem', array('theme' => $theme));
                }
                ?>
                <div class="col-xs-4 theme-item">
                    <div class="theme-box">
                        <div class="theme-request">
                            <div class="theme-request-title">
                                <p>Nếu bạn chưa ưng ý với giao diện hiện có, vui lòng gửi yêu cầu thiết kế của bạn cho chúng tôi.</p>
                                <p class="theme-font-red"><i>Nanoweb xin chân thành cảm ơn</i></p>
                            </div>
                            <div class="theme-request-banner">
                                <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/theme-build.png" />
                                <a class="theme-send-request" href="<?php echo Yii::app()->createUrl('/site/request/create'); ?>">
                                </a>
                            </div>
                            <div class="theme-request-hotline">
                                Hotline tư vấn thiết kế: <span class="theme-font-red"><a onclick="goog_report_conversion('tel:0948854888')">0948 854 888</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="w3pager" align="">
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalItems,
                'pageSize' => $pagesize,
                'header' => '',
                'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">fbq('track', 'ViewContent');</script>