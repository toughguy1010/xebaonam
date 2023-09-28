<style type="text/css">
    .li-compare-car-tg {
        cursor: pointer;
    }
    .toolleft .collapsible [type=checkbox]+label {
        font-size: inherit;
        line-height: 16px;
        padding-left: 25px;
    }
    .toolleft label {
        display: inherit;
        color: #555;
    }
    [type=checkbox]+label {
        position: relative;
        padding-left: 35px;
        cursor: pointer;
        display: inline-block;
        height: 25px;
        line-height: 25px;
        font-size: 1rem;
        -webkit-user-select: none;
        -moz-user-select: none;
        -khtml-user-select: none;
        -ms-user-select: none;
    }
    .toolleft .collapsible [type=checkbox]+label:before, .toolleft .collapsible [type=checkbox]:not(.filled-in)+label:after {
        border-width: 1px;
        border-color: #fff;
        height: 13px;
        width: 13px;
        background-color: #FFF;
    }
    [type=checkbox]+label:before, [type=checkbox]:not(.filled-in)+label:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 18px;
        height: 18px;
        z-index: 0;
        border: 2px solid #5a5a5a;
        border-radius: 1px;
        margin-top: 2px;
        -webkit-transition: .2s;
        transition: .2s;
    }
    .toolleft .collapsible [type=checkbox]+label:before, .toolleft .collapsible [type=checkbox]:not(.filled-in)+label:after {
        border-width: 1px;
        border-color: #fff;
        height: 13px;
        width: 13px;
        background-color: #FFF;
    }
    [type=checkbox]:not(.filled-in)+label:after {
        border: 0;
        -webkit-transform: scale(0);
        -ms-transform: scale(0);
        transform: scale(0);
    }
    [type=checkbox]:checked, [type=checkbox]:not(:checked) {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }
    input[type=checkbox], input[type=radio] {
        box-sizing: border-box;
        padding: 0;
    }
    .page_compare .toolleft .collapsible .collapsible-header, .page_compare .toolleft .ttl {
        background-color: #F9F9F9;
    }
    .toolleft .collapsible .collapsible-header {
        border: 0;
        line-height: inherit!important;
        padding: 10px 20px;
        background: transparent;
        border-bottom: 0px solid #eee;
        position: relative;
        margin-bottom: 0px;
        font-weight: 700;
        /*background-color: #FFF;*/
        text-transform: uppercase;
        color: #545454;
        font-weight: 400;
    }
    .toolleft .collapsible {
        -webkit-box-shadow: none;
        box-shadow: none;
        border: solid 0px #ccc;
        margin-top: 0;
    }
    ul:not(.browser-default) {
        padding-left: 0;
        list-style-type: none;
    }

    .toolleft .ttl {
        letter-spacing: 0.5px;
        height: 45px;
        line-height: 45px;
        background: #fff;
        color: #545454;
        padding-left: 20px;
        font-weight: 700;
        font-size: 1.7rem;
    }
    .toolleft .collapsible .collapsible-body {
        border-bottom: 0px solid #eee;
        background-color: #EDEDED;
        padding-top: 10px;
        color: #989898;
    }
    .toolleft .collapsible [type=checkbox]:checked+label:before {
        border-top: 0;
        border-left: 0;
        border-right-color: #EC1B30!important;
        border-bottom-color: #EC1B30!important;
        width: 8px;
        height: 15px;
        top: -2px;
        left: 0;
        border-width: 2px;
        background-color: transparent;
    }
    [type=checkbox]:checked+label:before {
        top: -4px;
        left: -5px;
        width: 12px;
        height: 22px;
        border-top: 2px solid transparent;
        border-left: 2px solid transparent;
        border-right: 2px solid #EF5350;
        border-bottom: 2px solid #EF5350;
        -webkit-transform: rotate(40deg);
        -ms-transform: rotate(40deg);
        transform: rotate(40deg);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transform-origin: 100% 100%;
        -ms-transform-origin: 100% 100%;
        transform-origin: 100% 100%;
    }
    ul:not(.browser-default) li {
        list-style-type: none;
    }
    .toolleft .collapsible .collapsible-header:after, .toolleft .collapsible .collapsible-header:before {
        position: absolute;
        right: 7%;
        top: 50%;
        height: 2px;
        width: 10px;
        background: #777;
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-transition-property: -webkit-transform;
        transition-property: -webkit-transform;
        -o-transition-property: transform;
        transition-property: transform;
        transition-property: transform, -webkit-transform;
        -webkit-transition-duration: 0.2s;
        -o-transition-duration: 0.2s;
        transition-duration: 0.2s;
        content: "";
    }
    .toolleft .collapsible .collapsible-header:before {
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        background-color: #c8102e;
        margin-right: 3px;
    }
    .toolleft .collapsible .collapsible-header:after {
        -webkit-transform: rotate(-45deg);
        -ms-transform: rotate(-45deg);
        transform: rotate(-45deg);
        background-color: #c8102e;
        margin-right: -3px;
    }
    .page_compare .toolleft .collapsible .collapsible-header, .page_compare .toolleft .ttl {
        background-color: #F9F9F9;
    }
    .btn_next>* {
        background-color: #4D4D4D;
        background-color: #c8102e;
        -webkit-box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 -3px 0 rgba(0, 0, 0, 0.2);
        padding-bottom: 3px;
        color: #fff;
        text-align: center;
        min-width: 140px;
        line-height: 35px;
        display: inline-block;
        padding-left: 2rem;
        padding-right: 2rem;
        font-size: 1.2rem;
        display: block;
        width: 100%;
    }
    .btn_next a {
        cursor: pointer!important;
        outline: none;
    }
    .heading_dt {
        position: relative;
        padding-top: 10px;
    }
    .heading_dt {
        margin-bottom: 1rem;
    }
    .btn_next_pc {
        position: absolute;
        top: 0;
        right: 0;
    }
    .btn_next {
        cursor: pointer;
    }
    .heading_dt .txt1 {
        font-size: 1.7rem;
        font-weight: 300;
        border-bottom: 1px solid #000;
        padding-bottom: 0.5rem;
        text-transform: uppercase;
        font-family: Arial;
    }
    .isDesktop .hide-pc, .isDesktop .only-show-mb {
        display: none;
    }
    .list-cate  .sm_checkbox label .img {
        text-align: center;
        display: block;
        width: 100%;
    }
    .list-cate  .sm_checkbox label .txt {
        margin: inherit;
        padding: inherit;
        top: inherit;
        padding-left: 0;
        display: -webkit-box!important;
        display: -ms-flexbox!important;
        display: flex!important;
        padding-top: 0.3em;
    }
    .list-cate .sm_checkbox [type=checkbox]+label .check {
        border: 1px solid #aaa;
        margin: 0;
        width: 15px;
        height: 15px;
        top: 1px;
        display: inline-block;
        margin-right: 5px;
        position: relative;
        -webkit-transition: all 0.3s;
        -o-transition: all 0.3s;
        transition: all 0.3s;
    }
    .tool_pg .list-cate .sm_checkbox label .txt .price {
        padding-left: 0!important;
        padding-top: 0.3em;
        color: #555;
        font-size: 0.9em;
        font-weight: 400;
        letter-spacing: 1px;
    }
    .tool_pg .list-cate .sm_checkbox label .txt2>span {
        display: inline-block;
        width: 100%;
        height: auto!important;
        margin: 0!important;
    }
    .tool_pg .list-cate  .sm_checkbox label .txt .price {
        padding-left: 0!important;
        padding-top: 0.3em;
        color: #555;
        font-size: 0.9em;
        font-weight: 400;
        letter-spacing: 1px;
    }
    .tool_pg .list-cate .sm_checkbox label .txt2>span {
        display: inline-block;
        width: 100%;
        height: auto!important;
        margin: 0!important;
    }
    .tool_pg .list-cate .sm_checkbox label .txt {
        margin: inherit;
        padding: inherit;
        top: inherit;
        padding-left: 0;
        display: -webkit-box!important;
        display: -ms-flexbox!important;
        display: flex!important;
        padding-top: 0.3em;
    }
    .tool_pg .list-cate .sm_checkbox label {
        margin: 0;
        padding: 0;
        font-size: 1em;
        text-align: left;
    }
    .sm_checkbox [type=checkbox]+label {
        display: inherit;
        margin: 0;
        height: auto;
        line-height: inherit;
        color: #000;
        font-size: 1rem;
        padding-left: 22px;
        font-weight: 600;
    }
    .tool_pg .list-cate .sm_checkbox [type=checkbox]:checked+label .check:before {
        border-color: #c8102e;
        -webkit-transform: rotate(40deg);
        -ms-transform: rotate(40deg);
        transform: rotate(40deg);
    }
    .tool_pg .list-cate .sm_checkbox [type=checkbox]+label .check:before {
        display: block;
        position: absolute;
        content: '';
        height: 13px;
        width: 9px;
        top: -2px;
        left: 2px;
        margin: auto;
        border: solid 3px transparent;
        -webkit-transition: all 0.1s;
        -o-transition: all 0.1s;
        transition: all 0.1s;
        border-top: 0;
        border-left: 0;
    }
    .tool_pg .list-cate .sm_checkbox [type=checkbox]+label:before, .tool_pg .list-cate .sm_checkbox  [type=checkbox]:not(.filled-in)+label:after {
        content: unset;
    }
    .list-cate .col-lg-3 {
        margin-bottom: 15px;
    }	
</style>
<style type="text/css">
    .tabs-top-compare li {
        float: left;
        width: 176px;
        margin-right: 10px;
    }
    .tabs-top-compare li a {
        display: block;
        background: #ededed;
    }
    .tabs-top-compare li a .up {
        display: block;
        text-align: center;
        font-size: 21px;
        font-weight: bold;
    }
    .tabs-top-compare li a .under {
        display: block;
        text-align: center;
        font-size: 14px;
        margin-top: -7px;
    }
    body .nav-tabs {
        border-bottom: 0px;
    }
    .tabs-top-compare .nav-tabs {
        padding: 15px 0px;
    }
    .tabs-top-compare .nav-tabs>li>a{
        border-bottom: 4px solid !important;
        border-radius: 2px;
        border-color: #c1adad;
    }
    .tabs-top-compare .nav-tabs>li.active>a {
        background: #c8102e !important;
        color: #fff !important;
        border-color:#8e0c0c !important;
    }
    .collapsible-body {
        /*max-height: 0px;*/
        padding: 0px 10px;
        overflow: hidden;
    }
    .collapsible-accordion > li {
        background: #ededed8a;
        border-bottom: 1px solid #ebebeb;
    }
    li.active .collapsible-body {
        display: block;
    }
    .waiting-compare {
        height: 400px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('.with12-5').each(function (e) {
            $(this).height($(this).width() * 8 / 12);
        })
        $('.executeCompare').click(function () {
            list = ($('#list-id-compare').val() == '') ? (new Array()) : $('#list-id-compare').val().split(",");
            if (list.length < 2) {
                alert('Vui lòng chọn ít nhất 2 sản phẩm để so sánh');
                return false;
            }
            $('#form-compare').submit();
        });
    });
    $(document).on('click', '.sm_checkbox label', function () {
        id = $(this).attr('data');
        list = ($('#list-id-compare').val() == '') ? (new Array()) : $('#list-id-compare').val().split(",");
        if (list.indexOf(id) == -1) {
            if (list.length >= 3) {
                alert('Số sản phẩm so sánh đã đạt mức tối đa là 3 sản phẩm.');
                return false;
            }
            list[list.length] = id;
            $('.list-id-compare').val(list.join(','));
        } else {
            var list_new = new Array();
            for (var i = 0; i < list.length; i++) {
                if (i < list.indexOf(id)) {
                    list_new[i] = list[i];
                } else {
                    if (i < list.length - 1) {
                        list_new[i] = list[i + 1];
                    }
                }
            }
            $('.list-id-compare').val(list_new.join(','));
        }
    });
    $(document).on('click', '#li-select-car', function () {
        $('#li-compare-car').attr('load', '0');
    });
    $(document).on('click', '#li-compare-car', function () {
        if ($(this).attr('load') != '1') {
            $('#compare_car').html('<div class="waiting-compare"></div>');
            $(this).attr('load', '1');
            $.ajax({
                url: $('#form-compare').attr('action'),
                data: $('#form-compare').serialize(),
                success: function (result) {
                    $('#compare_car').html(result);
                }
            });
        }
    });
    $(document).on('click', '.li-compare-car-tg', function () {
        list = ($('#list-id-compare').val() == '') ? (new Array()) : $('#list-id-compare').val().split(",");
        if (list.length < 2) {
            alert('Vui lòng chọn ít nhất 2 sản phẩm để so sánh');
            return false;
        }
        $('#li-compare-car').click();
    });
    $(document).on('click', '.active-child', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });
</script>
<form id="form-compare" style="display: none;" method="POST" action="<?= Yii::app()->createUrl("car/car/compare/") ?>">
    <input id="list-id-compare"  class="list-id-compare" value="<?= implode(',', $selected_car) ?>" name="id">
</form>
<div id="banner02">
    <div class="page_title">
        <div class="target target2">
            <div class="container">
                <h2 class="right-align">So sánh</h2>
            </div>
        </div>
    </div>
</div>
<div class="add-compare tool_pg" id="add-compare">
    <div class="container">
        <div class="tabs_lg tabs-top-compare">
            <ul class="nav nav-tabs">
                <li class="nav-item tab active" >
                    <a id="li-select-car" href="#select_car" data-toggle="tab">
                        <span class="up">
                            01
                        </span>
                        <span class="under">Chọn xe</span>
                    </a>
                </li>
                <li class="nav-item tab" >
                    <a class="li-compare-car-tg">
                        <span class="up">
                            02
                        </span>
                        <span class="under">So sánh</span>
                    </a>
                    <a style="display: none;" id="li-compare-car" href="#compare_car" data-toggle="tab"></a>
                </li>
            </ul>
        </div>	
        <div class="tab-content" id="myTabContent">
            <div id="select_car"  class="content-tab tab-pane fade active in" role="tabpanel">
                <div class="heading_dt" data-text="01">
                    <p class="txt1" data-text="Chọn phiên bản xe">Bước 1 : Chọn phiên bản xe</p>
                    <p class="btn_next btn_next_pc li-compare-car-tg">
                        <a>So sánh</a>
                    </p>
                </div>
                <div class="content_tab">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="toolleft">
                                <div class="box1">
                                    <div id="open_menu_dt"></div>
                                    <!-- <div class="btn-bottom hide-pc">
                                            <span class="btn-cancel">
                                                    Đóng
                                            </span>
                                            <span class="btn-filter-tools">
                                                    Chọn
                                            </span>
                                    </div> -->
                                    <div class="inner-box list_car_full">
                                        <div class="ttl">Bộ lọc</div>
                                        <?php
                                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK2));
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8">
                            <div class="row">
                                <div class="list-cate all" id="box-car-index" loading="0">
                                    <?php if ($data) foreach ($data as $car) { ?>
                                        <div class="col-lg-3 col-md-3 col-sm-4">
                                            <div class="inner">
                                                <div class="sm_checkbox">
                                                    <input <?= (in_array($car['id'], $selected_car)) ? 'checked' : '' ?> type="checkbox" id="checkbox-<?= $car['id'] ?>">
                                                    <label for="checkbox-<?= $car['id'] ?>"  data="<?= $car['id'] ?>">
                                                        <span class="img with12-5">
                                                            <img src="<?= ClaUrl::getImageUrl($car['avatar2_path'], $car['avatar2_name'], array('width' => 250, 'height' => 250)); ?>">
                                                        </span>
                                                        <span class="txt">
                                                            <span class="txt1"><span class="check"></span></span>
                                                            <span class="txt2">
                                                                <span class="name"><?= $car['name'] ?></span>
                                                                <span class="price">
                                                                    Giá từ: <span><?= $car['price'] > 0 ? number_format($car['price'], 0, ',', '.') : 'Liên hệ'; ?></span> <sup>VND</sup>
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="compare_car"  class="content-tab tab-pane fade" role="tabpanel">
            </div>
        </div>	
    </div>
</div>
<style type="text/css">

</style>