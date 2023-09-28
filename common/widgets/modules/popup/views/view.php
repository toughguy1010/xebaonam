<?php if (count($popups)) { ?>
    <?php if (isset($popups[0]) && count($popups[0])) { ?>
        <div style="<?= ($popups[0]['popup_width'] && $popups[0]['popup_width'] > 0) ? ('width:' . ($popups[0]['popup_width']) . 'px;') : '' ?>
        <?= ($popups[0]['popup_height'] && $popups[0]['popup_height'] > 0) ? 'height:' . ($popups[0]['popup_height'] . 'px;') : '' ?>"
             class="modal popup-modal"
             id="popupModal0" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="" style=" z-index: 99999;position: absolute;right: 15px;top: 15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-content" style="" data-backdrop="true" data-keyboard="true">
                    <div class="modal-body">
                        <?php echo '<div  id="c-all">' . $popups[0]['popup_description'] . '</div>'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($popups[1]) && count($popups[1])) { ?>
        <div style="<?= ($popups[1]['popup_width']) ? ('width:' . ($popups[1]['popup_width']) . 'px;') : '' ?>
        <?= ($popups[1]['popup_height']) ? 'height:' . ($popups[1]['popup_height'] . 'px;') : '' ?>"
             class="modal popup-modal"
             id="popupModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="" style=" z-index: 99999;position: absolute;right: 15px;top: 15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-content" data-backdrop="true" data-keyboard="true">
                    <div class="modal-body">
                        <?php echo '<div  id="c-f-time">' . $popups[1]['popup_description'] . '</div>'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($popups[2]) && count($popups[2])) { ?>
        <div style="<?= ($popups[2]['popup_width']) ? ('width:' . ($popups[2]['popup_width']) . 'px;') : '' ?>
        <?= ($popups[2]['popup_height']) ? 'height:' . ($popups[2]['popup_height'] . 'px;') : '' ?>"
             class="modal popup-modal"
             id="popupModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="" style=" z-index: 99999;position: absolute;right: 15px;top: 15px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-content" data-backdrop="true" data-keyboard="true">
                    <div class="modal-body">
                        <?php echo '<div id="c-s-time">' . $popups[2]['popup_description'] . '</div>'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if (isset($popups[3]) && count($popups[3])) { ?>
        <div style="<?= ($popups[3]['popup_width']) ? ('width:' . ($popups[3]['popup_width']) . 'px;') : '' ?>
        <?= ($popups[3]['popup_height']) ? 'height:' . ($popups[3]['popup_height'] . 'px;') : '' ?>"
             class="modal popup-modal"
             id="popupModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="" style=" z-index: 99999;position: absolute;right: 15px;top: 15px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-dialog" role="document">
                <div class="modal-content" data-backdrop="true" data-keyboard="true">

                    <div class="modal-body">
                        <?php echo '<div id="c-member">' . $popups[3]['popup_description'] . '</div>'; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        function setCookie(key, value, expert_time = (30 * 30 * 1000)) {
            var expires = new Date();
            expires.setTime(expires.getTime() + expert_time);
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function getCookie(key) {
            var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
            return keyValue ? true : false;
        }

        jQuery('document').ready(function () {
            <?php if (Yii::app()->user->isGuest) { ?>
            //Not Member - FirstTime
            if (jQuery("#c-f-time").length && !getCookie('popup<?= $popups[1]['id']?>')) {
                setCookie('popup<?=($popups[1]['id'])?>', true,<?= $popups[1]['store_time_unix']?>);
                jQuery('#popupModal1').removeClass('popup-modal').modal('show');
            }
            //Not Member - Second Time
            if (jQuery("#c-s-time").length && getCookie('popup<?= $popups[1]['id']?>') && !getCookie('popup<?= $popups[2]['id']?>')) {
                setCookie('popup<?=($popups[2]['id'])?>', true,<?= $popups[2]['store_time_unix']?>);
                jQuery('#popupModal2').removeClass('popup-modal').modal('show');
            }
            //Not Member - All Time
            if ((jQuery("#c-all").length && !jQuery("#c-f-time").length && !getCookie('popup<?= $popups[1]['id'] ?>') && !getCookie('popup<?= $popups[0]['id'] ?>'))
                || (jQuery("#c-all").length && !jQuery("#c-s-time").length && getCookie('popup<?= $popups[1]['id']?>') && !getCookie('popup<?= $popups[0]['id'] ?>') )) {
                jQuery('#popupModal0').removeClass('popup-modal').modal('show');
                setCookie('popup<?=($popups[0]['id'])?>', true,<?= $popups[0]['store_time_unix']?>);
            }
            <?php }else{ ?>
            //            //Member
            //            if (jQuery("#c-member").length) {
            //                jQuery('#popupModal3').removeClass('popup-modal').modal('show');
            //                setCookie('popup', 1);
            //            } else if (jQuery("#c-all").length) {
            //                jQuery('#popupModal0').removeClass('popup-modal').modal('show');
            //                setCookie('popup', 1);
            //            }
            <?php } ?>
            jQuery('.popup-modal').html('');
        });
    </script>
    <style>
        #c-all {
            overflow: hidden;
        }

        #c-all p, #c-all img, #c-all iframe, #c-all table, #c-all ul {
            max-width: 100%;
            display: inline-block;
        }

        @media (min-width: 768px) {
            .modal-dialog {
                width: auto;
                margin: 30px 15px;
            }
        }

        #popupModal0,
        #popupModal1,
        #popupModal2,
        #popupModal3 {
            max-width: 100%;
        }

        #popupModal0 .modal-content,
        #popupModal1 .modal-content,
        #popupModal2 .modal-content,
        #popupModal3 .modal-content {
            box-shadow: 0 5px 15px rgba(255, 255, 255, 0.5);
            position: relative;
            background-color: #fff;
            -webkit-background-clip: padding-box;
            background-clip: padding-box;
            border-radius: 6px;
            outline: 0;
            overflow: hidden;
            display: inline-block;
            border: none;
            box-shadow: 3px 3px 3px #000;
        }

        #popupModa0 .close,
        #popupModal .close,
        #popupModa2 .close,
        #popupModa3 .close,
        {
            position: absolute;
            float: right;
            top: -10px;
            right: 0;
            font-weight: 700;
            line-height: 1;
            text-shadow: 0 1px 0 #fff;
            filter: alpha(opacity=20);
            font-size: 40px;
            opacity: .9;
            color: red;
        }

        #popupModal0 .modal-body,
        #popupModal1 .modal-body,
        #popupModal2 .modal-body,
        #popupModal3 .modal-body,
        {
            position: relative;
            padding: 20px;
            background: #f1f1f1;
            display: inline-block;
        }

        #popupModal0 .modal-body img,
        #popupModal1 .modal-body img,
        #popupModal2 .modal-body img,
        #popupModal3 .modal-body img {
            height: auto !important;
        }

        .close {
            font-size: 30px;
            opacity: .9;
            color: #ffffff;
            height: 30px;
            width: 30px;
            background: #5b3810 !important;
            border-radius: 100%;
            line-height: 30px;
            left: 0;
            right: 0;
            margin: 0;
            padding: 0;
        }

        @media screen and (max-width: 992px) {
            #popupModal0 .modal-dialog,
            #popupModal1 .modal-dialog,
            #popupModal2 .modal-dialog,
            #popupModal3 .modal-dialog {
                max-width: 100% !important;
            }

        }
    </style>
<?php } ?>
