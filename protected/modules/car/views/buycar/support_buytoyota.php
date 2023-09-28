<?php
$themUrl = Yii::app()->theme->baseUrl;
$years =  $components['year'];
$types =  $components['type'];
$interests =  $components['interest'];
$earn_min_types =  $components['earn_min_type'];
$payment_methods =  $components['payment_method'];
?>
<?php 
    $count = count($data);
?>
<style type="text/css">
    body .input_f input {
        border: 1px solid rgb(169, 169, 169);
        background: unset;
        padding-left: 10px;
    }
    .show-t2 {
        display: none;
    }
    *:disabled {
      background: #dddddd;
    }
    .center {
        text-align: center;
    }
    .btn-bottom {
        height: 40px;
        margin-bottom: 30px;
    }
    select {
        width: 100%;
        height: 40px;
    }
    select option {
        /*height: 40px;*/
        padding: 15px !important
    }
    .nav-item {
        cursor: pointer;
    }
    .li-st-2-tg {
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
    .page_SuportBuy .toolleft .collapsible .collapsible-header, .page_SuportBuy .toolleft .ttl {
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
    .page_SuportBuy .toolleft .collapsible .collapsible-header, .page_SuportBuy .toolleft .ttl {
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

    .tabs-top-SuportBuy li {
        float: left;
        width: 176px;
        margin-right: 10px;
    }
    .tabs-top-SuportBuy li a {
        display: block;
        background: #ededed;
    }
    .tabs-top-SuportBuy li a .up {
        display: block;
        text-align: center;
        font-size: 21px;
        font-weight: bold;
    }
    .tabs-top-SuportBuy li a .under {
        display: block;
        text-align: center;
        font-size: 14px;
        margin-top: -7px;
    }
    body .nav-tabs {
        border-bottom: 0px;
    }
    .tabs-top-SuportBuy .nav-tabs {
        padding: 15px 0px;
    }
    .tabs-top-SuportBuy .nav-tabs>li>a{
        border-bottom: 4px solid !important;
        border-radius: 2px;
        border-color: #c1adad;
    }
    .tabs-top-SuportBuy .nav-tabs>li.active>a {
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
    .waiting-SuportBuy {
        height: 400px;
    }

    .suport-buycar .sum_price {
        border-top: 1px solid #eee;
        border-bottom: 1px solid #eee;
        position: relative;
        margin-top: 1rem;
        text-align: center;
        margin-bottom: 2rem;
    }
    .suport-buycar .price_lg {
        font-size: 3.3rem;
        font-weight: 600;
        text-align: center;
        color: #c8102e;
        display: inline-block;
    }
    .suport-buycar .unit {
        color: #000;
        font-weight: 400;
        font-size: 13px;
        color: #000;
        font-weight: 400;
        position: absolute;
        top: 3px;
        left: 100%;
        margin-left: -23px;
    }
    .btn_wrap .btn-primary {
        background-color: #c8102e;
        letter-spacing: 0px;
        text-decoration: none;
        text-align: center;
        width: 100%;
        color: #fff;
        display: block;
        white-space: nowrap;
        -webkit-box-shadow: inset 0 -3px 0 0 rgba(0, 0, 0, 0.2);
        box-shadow: inset 0 -3px 0 0 rgba(0, 0, 0, 0.2);
        padding-bottom: 3px;
        border: 0;
        -webkit-transition: all 0.4s;
        -o-transition: all 0.4s;
        transition: all 0.4s;
        padding: 10px;
        cursor: pointer;
    }
    .btn-bottom .btn_wrap {
        width: 48.5%;
        float: left;
    }

    .select-ul li {
        width: 100%;
        height: 35px;
        padding: 10px 10px;
        cursor: pointer;
    }
    select {
        padding-left: 10px;
    }
    .box-select-ul {
        position: relative;
        width: 100%;
    }
    .select-ul {
        border:1px solid rgb(169, 169, 169);
        position: absolute;
        width: 100%;
        height: 40px;
    }
     .select-ul.open .option {
        display: block;
        background: #fff;
        border: 1px solid  rgb(169, 169, 169);
        margin-top: -1px;
        border: 1px solid #ebebeb;
    }
    .color-item {
        display: inline-block;
        width: 20px;
        height: 20px;
        float: right;
        margin-top: -5px;
        border: 1px solid #ebebeb;
    }
    .select-ul li.option:hover {
        background: #ebebeb;
    }
    .select-ul .option {
        display: none;
    }
    .select-ul.open .selected {
        display: none;
    }
    .select-ul .selected {
        font-weight: bold;
        /*border: 1px solid #9E9E9E;*/
    }

    .content-tab-right .txt1 {
        font-weight: 600;
        /*font-size: 1.7em;*/
        color: #7d7d7d;
        border-bottom: 3px solid #c8102e;
    }
    .content-tab-right .col:first-of-type {
        color: #888;
        /*font-size: 1rem;*/
        font-weight: 400;
    }
    .right-align {
        float: right;
    }
    body .form_dk {
        width: 700px;
    }
</style>
<div id="banner02">
    <div class="page_title">
        <div class="target target2">
            <div class="container">
                <h2 class="right-align">Hỗ trợ tài chính</h2>
            </div>
        </div>
    </div>
</div>
<div class="suport-buycar tool_pg" id="suport-buycar">
    <div class="container">
        <div class="tabs_lg tabs-top-SuportBuy">
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
                    <a class="li-st-2-tg">
                        <span class="up">
                            02
                        </span>
                        <span class="under">Cách tính</span>
                    </a>
                    <a style="display: none;" id="li-st-2" href="#st-2" data-toggle="tab"></a>
                </li>
                <li class="nav-item tab" >
                    <a class="li-st-3-tg">
                        <span class="up">
                            03
                        </span>
                        <span class="under">Hoàn tất</span>
                    </a>
                    <a style="display: none;" id="li-st-3" href="#st-3" data-toggle="tab"></a>
                </li>
            </ul>
        </div>  
        <div class="tab-content" id="myTabContent">
            <div id="select_car"  class="content-tab tab-pane fade active in" role="tabpanel">
                <div class="heading_dt" data-text="01">
                    <p class="txt1" data-text="Chọn phiên bản xe">Bước 1 : Chọn phiên bản xe</p>
                </div>
                <div class="content_tab">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-4">
                            <div class="toolleft">
                                <div class="box1">
                                    <div id="open_menu_dt"></div>
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
                                                    <input type="checkbox" id="checkbox-<?= $car['id'] ?>">
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
            <div id="st-2"  class="content-tab tab-pane fade" role="tabpanel">
                <div class="inner">
                    <div class="heading_dt" data-text="01">
                        <p class="txt1" data-text="Cách tính">Bước 2</p>
                        <p class="btn_next btn_next_pc li-st-3-tg"><a class="next_btn_1" id="next-3">Tiếp theo</a></p>
                    </div>
                </div>
                <form id="form-suport-buycar">
                    <input id="car-id" type="hidden" class="car-id" value="" name="car_id">
                    <input id="car-price" type="hidden"  class="car-price" value="" name="car_price">
                    <input type="hidden" id="car-earnest-min" name="car_earnest_min">
                    <div class="content-tab col-md-9">
                        <div class="content_tab">
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Chọn màu xe (*)</span>
                                </div>
                                <div class="input_f">
                                    <div class="box-select-ul">
                                        <input type="hidden" id="car-color-id" name="car_color_id" name="">
                                        <input type="hidden" id="car-color-name" name="car_color_name" name="">
                                        <ul id="car-color-box" class="select-ul">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Giá phụ kiện</span>
                                </div>
                                <div class="input_f">
                                    <input class="text-money" id="car-component-price" type="text" value="0" name="car_component_price">
                                </div>
                            </div>
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Sản phẩm tài chính (*)</span>
                                </div>
                                <div class="input_f">
                                    <select id="car-suport-type" name="car_suport_type">
                                        <?php foreach ($types as $key => $value) { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Thời gian vay (*)</span>
                                </div>
                                <div class="input_f">
                                    <select id="car-suport-year" name="car_suport_year">
                                        <?php foreach ($years as $key => $value) { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Hình thức thanh toán (*)</span>
                                </div>
                                <div class="input_f">
                                    <select id="car-payment-methods" name="car_payment_method">
                                        <?php foreach ($payment_methods as $key => $value) { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form_1 form_dk">
                                <div class="lab_for">
                                    <span class="lbl"> Số tiền trả trước (<span id="earn_min_type"><?= $earn_min_types[1]*100 ?></span>%)</span>
                                </div>
                                <div class="input_f">
                                    <input class="text-money" id="car-earnest" type="text" name="car_earnest" placeholder="" value="">
                                </div>
                            </div>
                            <p><i>Quý khách vui lòng điền đầy đủ các thông tin có dấu (*)</i></p>
                        </div>
                        <div id="box-lck" class="box-lck clear">
                            <div class="heading_dt">
                                <p class="txt1">Mẫu xe đã chọn</p>
                            </div>
                            <div class="content_tab tool_pg">
                                <div class="list-car-try-v2 list-cate" id="box-selected-car"> 
                                    <div class="col-lg-3 col-md-3 col-sm-4">
                                        <div class="inner">
                                            <div class="sm_checkbox">
                                                <label>
                                                    <span class="img with12-5" style="height: 126px;">
                                                        <img class="box-img-miss" src="">
                                                    </span>
                                                    <span class="txt">
                                                        <span class="txt1"><span class="check"></span></span>
                                                        <span class="txt2">
                                                            <span class="name">COROLLA ALTIS 2.0V LUXURY (CVT)</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-tab-right col-md-3">
                        <div class="box_right left-align">
                            <p class="txt1">Thông tin</p>
                            <div class="txt3">
                                <p class="txt_tt">Phiên bản xe</p>
                                <p class="row-s">
                                    <span class="col s6 spResultTitle"></span>
                                    <span class="col s6 right-align spResultPrice"></span>
                                </p>
                            </div>
                            <div class="txt3">
                                <p class="txt_tt">Màu xe</p>
                                <p class="row-s">
                                    <span class="col box-color-miss"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="st-3"  class="content-tab tab-pane fade" role="tabpanel">
                <div class="inner">
                    <div class="heading_dt" data-text="03">
                        <p class="txt1" data-text="Hoàn tất">Hoàn tất</p>
                        <p class="txt2">Hỗ trợ tài chính</p>
                        <p class="btn_next btn_next_pc"><a href="/">Về trang chủ</a></p>
                    </div>
                    <div class="content_tab">
                        <div class="row">
                            <div class="list_product_select">
                                <div class="col-md-4">
                                    <div class="vols last">
                                        <div class="chitiet_dutoan">
                                            <div class="show-t1">
                                                <p class="spTruyenThong spBalloon"><b>Số tiền trả tháng đầu tiên</b></p>
                                                <p class="sum_price">
                                                    <span class="inner_sum_price">
                                                        <span class="price_lg spPriceTotal spTruyenThong"></span>
                                                        <sup class="unit">VND</sup>
                                                    </span>
                                                </p>
                                                <p class="spTruyenThong spBalloon"><b>Khoản tín dụng</b></p>
                                                <p class="sum_price spTruyenThong spBalloon">
                                                    <span class="inner_sum_price">
                                                        <span>  <span class="price_lg" id="spOwnPrice"></span></span>
                                                        <sup class="unit">VND</sup>
                                                    </span>
                                                </p>
                                            </div>
                                            <p class="spTruyenThong spBalloon"><b>Lãi suất vay năm</b></p>
                                            <p class="sum_price spTruyenThong spBalloon">
                                                <span class="inner_sum_price">
                                                    <span>  <span class="price_lg" id="lxn"><?= $interests[1] ?></span></span>
                                                    <sup class="unit">%</sup>
                                                </span>
                                            </p>
                                            <div class="show-t2">
                                                <p class="spTruyenThong spBalloon"><b>Gốc và lãi cuối kì</b></p>
                                                <p class="sum_price">
                                                    <span class="inner_sum_price">
                                                        <span class="price_lg spPriceTotal spTruyenThong">2.132.232</span>
                                                        <sup class="unit">VND</sup>
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="btn-bottom">
                                                <div class="btn_wrap" style="margin-right: 2%">
                                                    <a class="btnc btn-primary btnDownloadFiles" data-text="Chi tiết bảng tính"> <span class="btn_overlay"> </span><span class="btn_text">Chi tiết bảng tính</span></a>
                                                </div>
                                                <div class="btn_wrap">
                                                    <a class="btnc btn-primary bg-light-grey various show-data btnSendEmail" data-text="Nhận email" data-target="HOTROTAICHINH"><span class="btn_overlay"> </span><span class="btn_text">Nhận email</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <p class="img">
                                        <img class="box-img-miss" src="" alt="Image_Result">
                                        <span class="obj_title spResultTitle">Yaris G CVT</span>
                                    </p>
                                </div>
                                <div class="col-md-3 content-tab-right" id="listthongtin">
                                    <div class="box_right left-align">
                                        <p class="txt1">Thông tin</p>
                                        
                                        <div class="txt3">
                                            <p class="txt_tt">Phiên bản xe</p>
                                            <p class="row-s">
                                                <span class="col s6 spResultTitle">Yaris G CVT</span>
                                                <br/>
                                                <span class="col s6">Giá</span>
                                                <span class="col s6 right-align spResultPrice"></span>
                                            </p>
                                        </div>
                                        <div class="txt3">
                                            <p class="txt_tt">Phụ kiện</p>
                                            <p class="row-s">
                                                <span class="col s6">Giá</span>
                                                <span class="col s6 right-align spResultAccesoryPrice"></span>
                                            </p>
                                        </div>
                                        <div class="txt3">
                                            <p class="txt_tt">Màu xe</p>
                                            <p class="row-s">
                                                <span class="col s6 right-align colorOfCarSelectedTool"></span>
                                            </p>
                                        </div>
                                        <div class="txt3" style="box-shadow: none">
                                            <p class="txt_tt">Trả trước</p>
                                            <p class="row-s">
                                                <span class="col s6">Số tiền</span>
                                                <span class="col s6 right-align spResultFirstPrice"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-money-bank">
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.with12-5').each(function (e) {
            $(this).height($(this).width() * 8 / 12);
        })
    });
    $(document).on('click', '#box-car-index .sm_checkbox label', function () {
        $('.sm_checkbox input').prop('checked', false);
        id = $(this).attr('data');
        $('#car-id').val(id);
        $('.spResultTitle').html($(this).find('.name').first().html());
        var price = $(this).find('.price span').first().html();
        $('.spResultPrice').html($(this).find('.price span').first().html());
        $('#car-earnest-min').val(formatMoneyback(price)*formatMoneyback($('#earn_min_type').html())/100);
        $('#car-price').val(formatMoneyback(price));
        $('#car-earnest').attr('placeholder', 'Tối thiểu '+ formatMoney(formatMoneyback(price)*formatMoneyback($('#earn_min_type').html())/100,0, ',', '.'));
        $('#li-st-2').click();
    });
    $(document).on('click', '#li-st-2', function () {
        $('.box-money-bank').html('');
        if ($(this).attr('load') != '1') {
            // $(this).attr('load', '1');
            $.ajax({
                url: '<?= Yii::app()->createUrl("car/car/getcarcolor/") ?>',
                data: {id :$('#car-id').val()},
                success: function (result) {
                    colors =  Object.values(JSON.parse(result, true));
                    html = '';
                    for (var i = 0; i < colors.length; i++) {
                        if(i == 0) {
                            $('.box-img-miss').attr('src', colors[i].avatar);
                            $('.box-color-miss').html(colors[i].name+'<span class="color-item" style="background: '+colors[i].code_color+'"></span>');
                            $('#car-color-id').val(colors[i].id);
                            $('#car-color-name').val(colors[i].name);
                            html += '<li class="selected" data-value="'+colors[i].name+'">'+colors[i].name+'<span class="color-item" style="background: '+colors[i].code_color+'"></span></li>';
                        }
                        html += '<li class="option" data-avatar="'+colors[i].avatar+'" data-id="'+colors[i].id+'" data-value="'+colors[i].name+'">'+colors[i].name+'<span class="color-item" style="background: '+colors[i].code_color+'"></span> </li>';
                    }
                    $('#car-color-box').html(html);
                }
            });
        }
    });
    $(document).on('click', '.li-st-2-tg', function () {
        if($('#car-id').val()) {
            $('#li-st-2').click();
        } else {
            alert('Vui lòng chọn trước 1 phiên bản xe!');
        }
        return false;
    });
    $(document).on('click', '.li-st-3-tg', function () {
        var sum = (formatMoneyback($('#car-price').val())) + formatMoneyback($('#car-component-price').val());
        var ern = formatMoneyback($('#car-earnest').val());
        var ern_min = (sum *formatMoneyback($('#earn_min_type').html())/100);
        if(ern < ern_min) {
             alert('Số tiền trả trước tối thiểu là '+formatMoney(ern_min, 0, ',', '.')+' !');
            return false;
        } else if(ern > sum) {
            alert('Quý khách đã nhập số tiền trả trước quá số tổng giá trị xe và phụ kiện, vui lòng nhập lại!');
            return false;
        }
        $('#li-st-3').click();
        return false;
    });
    $(document).on('click', '#li-st-3', function () {
        $('.spResultAccesoryPrice').html(formatMoney(formatMoneyback($('#car-component-price').val()),0,',','.'));
        var td = formatMoneyback($('#car-price').val()) + formatMoneyback($('#car-component-price').val()) - formatMoneyback($('#car-earnest').val())
        $('#spOwnPrice').html(formatMoney(td, 0, ',', '.'));
        $('.colorOfCarSelectedTool').html($('#car-color-box').find('.selected').first().html());
        $('.spResultFirstPrice').html(formatMoney(formatMoneyback($('#car-earnest').val()),0,',','.'));
        var interests = new Array();
        <?php foreach ($interests as $key => $value) { ?>
            interests[<?= $key ?>] = <?= $value ?>;
        <?php } ?>
        var interest = interests[formatMoneyback($('#car-suport-type').val())];
        if($('#car-suport-type').val() == '1') {
            var cnld = (td +(td/100)*interest)/(formatMoneyback($('#car-suport-year').val())*12);
        } else {
            var cnld = td +(td/100)*interest;
        }
        $('#lxn').html(interest);
        $('.spPriceTotal').html(formatMoney(cnld,0,',','.'));
    });
    $(document).on('click', '.btnDownloadFiles', function () {
        if ($(this).attr('load') != '1') {
            $('.box-money-bank').html('Vui lòng đợi trong giây lát. Dữ liệu đang được sử lý....');
            $.ajax({
                url: '<?= Yii::app()->createUrl("car/buycar/caltoyata") ?>',
                data: $('#form-suport-buycar').serialize(),
                success: function (result) {
                    $('.box-money-bank').html(result);
                }
            });
        }
    });
    $(document).on('change', '#car-suport-type', function () {
        var earn_min_type = new Array();
        <?php foreach ($earn_min_types as $key => $value) { ?>
            earn_min_type[<?= $key ?>] = <?= $value ?>*100;
        <?php } ?>
        var sum = (formatMoneyback($('#car-price').val())) + formatMoneyback($('#car-component-price').val());
        var ern = earn_min_type[formatMoneyback($(this).val())];
        $('#earn_min_type').html(ern);
        $('#car-earnest').attr('placeholder', 'Tối thiểu '+ formatMoney(sum*ern/100,0, ',', '.'));
        if($(this).val() == '2') {
            $('#car-payment-methods').attr('disabled', 'true');
            $('#car-suport-year').attr('disabled', 'true');
            $('.show-t2').css('display', 'block');
            $('.show-t1').css('display', 'none');
        } else {
            $('#car-payment-methods').removeAttr('disabled');
            $('#car-suport-year').removeAttr('disabled');
            $('.show-t2').css('display', 'none');
            $('.show-t1').css('display', 'block');
        }
    });
    $(document).ready(function () {
        $('#car-component-price').keydown(function(e) {
            setTimeout(function(){
                var sum = (formatMoneyback($('#car-price').val())) + formatMoneyback($('#car-component-price').val());
                var ern =formatMoneyback($('#earn_min_type').html());
                $('#car-earnest').attr('placeholder', 'Tối thiểu '+ formatMoney(sum*ern/100,0, ',', '.'));
            }, 100);
        });
    });
    
    
    $(document).on('click', '.active-child', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
        }
    });

    $(document).on('click', '.select-ul', function (e) {
        $(this).addClass('open');
        e.stopPropagation();
    });
    $(document).on('click', '.select-ul .option', function (e) {
        $(this).parent().removeClass('open');
        selected = $(this).parent().find('.selected');
        selected.attr('data-value', $(this).attr('data-value'));
        selected.html($(this).html());
        e.stopPropagation();
    });

    $(document).on('click', '.select-ul .option', function (e) {
        $('.box-img-miss').attr('src', $(this).attr('data-avatar'));
        $('.box-color-miss').html($(this).html());
        $('#car-color-id').val($(this).attr('data-id'));
        $('#car-color-name').val($(this).attr('data-name'));
    });

    function isAlphaNum(_this, a) {
        var txt = (_this.val()+a).replace( /^\D+/g, '');
        var numb;
        if(txt != '') {
            var numb = txt.match(/\d/g);
            numb = numb.join("");
        }
        if(numb == null) {
            numb = 0;
        }
        return numb;
    }
    function formatMoneyback(a) {
        a = a ? parseInt(a.replace(/\./g,"")) : 0;
        return a ? a : 0;
    }
    function formatMoney(a,c, d, t){
        var n = a, 
        c = isNaN(c = Math.abs(c)) ? 2 : c, 
        d = d == undefined ? "." : d, 
        t = t == undefined ? "," : t, 
        s = n < 0 ? "-" : "", 
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
        j = (j = i.length) > 3 ? j % 3 : 0;
       return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
    $(document).ready(function () {
        $('.text-money').keydown(function(e) {
            var keyCode = (e.keyCode ? e.keyCode : e.which);
            if(!isAlphaNum($(this), String.fromCharCode(e.keyCode))) {
                return false;
            }
            if(keyCode != 8 && keyCode != 46) {
                var number = isAlphaNum($(this), String.fromCharCode(e.keyCode));
                // $(this).val(formatMoney(number, 0, ',', '.'));
                // return false;
            }
            _this = $(this);
            setTimeout(function() {
                tg = formatMoneyback(_this.val());
                _this.val(tg > 0 ? formatMoney(tg, 0, ',', '.') : '');
            }, 100);
        });
    });
</script>

<!-- popup -->
<style type="text/css">
    .show-data .box-data {
        display: none;
    }
    .show-data {
        cursor: pointer;
    }
    .box-fix-all {
        position: fixed;
        z-index: 1;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100vh;
        overflow: hidden;
        display: none;
    }
    .box-fix-all .content {
        max-width: 600px;
        max-height: 400px;
        margin: auto;
        width: 90%;
        height: 90vh;
        /*max-width: 1000px;*/
        background: #fff;
        /*padding: 40px 84px;*/
        position: relative;
    }
    .close-box-fix-all {
        position: absolute;
        right: 0px;
        top: 0px;
        border: 1px solid #ebebeb;
        color: red;
        padding: 3px 10px;
        font-weight: bold;
        cursor: pointer;
    }
    .box-fix-all.active {
        display: flex;
        background: #00000061;
    }
    .box-fix-all .box-data {
        width: 100%;
        height: 100%;
    }
</style>
<script type="text/javascript">
    $(document).on('click', '.show-data', function () {
        // $('#box-fix-all .box-data').html($(this).find('.box-data').html());
        $('#box-fix-all').addClass('active');
        $('html').attr('style', 'overflow: hidden');
    });

    $(document).on('click', '.close-box-fix-all', function () {
        $('#box-fix-all').removeClass('active');
        $('html').attr('style', '');
    });
    $(document).keyup(function(e) {
         if (e.key === "Escape") { // escape key maps to keycode `27`
            $('#box-fix-all').removeClass('active');
            $('html').attr('style', '');
        }
    });
    $(document).ready( function () {
        $('#sort-folder').change(function(){
            $('#form-subimt-folder').submit();
        });
    });
</script>
<div id="box-fix-all" class="box-fix-all">
    <div class="content">
        <div class="close-box-fix-all">x</div>
        <div class="box-data">
            <form action="<?= Yii::app()->createUrl("car/buycar/sendMailSuportBuy/") ?>" method="POST" class="form-subimt-email" id="form-subimt-email" >
                <span class="text-top">Gửi thông tin đến email</span>
                <div class="box-in">
                    <p class="text-main"><?= Yii::app()->siteinfo['site_title']; ?></p>
                    <input type="" placeholder="Họ và tên" name="name">
                    <input type="" id="input-email" placeholder="Email của quý khách(*)" name="email">
                    <div id="waiting-send">
                        <a onclick="sendMailSP()" class="btnSendEmailForm">
                            Gửi
                        </a>
                        <p><i>Quý khách vui lòng điền đầy đủ các thông tin có dấu (*)</i></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function sendMailSP() {
            var mail = $('#input-email').val();
            if(!mail) {
                alert('Vui lòng nhập email.');
                return false;
            }
            if(!ValidateEmail(mail)) {
                alert('Vui lòng nhập đúng email.');
                return false;
            }
            $('#waiting-send').html('<center style="color: blue">Đang gửi thông tin. Quý khách vui lòng chờ trong giấy lát...</center>');
            $.ajax({
                url: $('#form-subimt-email').attr('action'),
                data: $('#form-subimt-email').serialize()+'&'+$('#form-suport-buycar').serialize(),
                type: 'POST',
                success: function (result) {
                    $('.close-box-fix-all').click();
                    $('#waiting-send').html('<center style="color: green">'+result+'</center>');
                    $('.btnSendEmail.show-data').attr('href', '/');
                    $('.btnSendEmail.show-data').html('Về trang chủ');
                    $('.btnSendEmail.show-data').removeClass('show-data');
                }
            });
            
            return false;
    }
    function ValidateEmail(mail) 
    {
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(mail)) {
            return false;
        }
        return true;
    }
</script>
<style type="text/css">
    .form-subimt-email .text-top {
        text-align: center;
        display: block;
        font-weight: bold;
        font-size: 16px;
        padding: 5px;
        background: #ebebeb;
    }
    .form-subimt-email .text-main{
        font-size: 26px;
        padding: 10px 0px;
    }
    .form-subimt-email .box-in {
        padding: 15px 20px 0px;
    }
    .form-subimt-email .box-in input {
        width: 100%;
        background: #ebebeb;
        padding: 10px 15px;
        margin-bottom: 20px;
        border: 0px;
        border-radius: 3px;
    }
    .form-subimt-email .box-in  .btnSendEmailForm {
        background-color: #c8102e;
        letter-spacing: 0px;
        text-decoration: none;
        text-align: center;
        padding: 10px 40px;
        font-size: 16px;
        color: #fff;
        display: inline-block;
        white-space: nowrap;
        border: 0px;
        border-radius: 5px;
        margin-bottom: 10px;
        cursor: pointer;
    }
    .form-subimt-email .box-in  .btnSendEmailForm:hover {
        opacity: 0.7;
    }
</style>
