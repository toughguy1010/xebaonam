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
        height: 40px;
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
        });
    });
</script>
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
                        <span class="under">Nơi đăng ký trước bạ</span>
                    </a>
                </li>
                <li class="nav-item tab" >
                    <a class="li-compare-car-tg">
                        <span class="up">
                            03
                        </span>
                        <span class="under">Màu và phụ kiện</span>
                    </a>
                </li>
                <li class="nav-item tab" >
                    <a class="li-compare-car-tg">
                        <span class="up">
                            04
                        </span>
                        <span class="under">Hoàn tất</span>
                    </a>
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
                                    <div class="inner-box">
                                        <div class="ttl">Bộ lọc</div>
                                        <ul class="collapsible collapsible-accordion" data-collapsible="expandable">
                                            <li class="active-child active">
                                                <a class="collapsible-header active"><span>Mẫu xe</span></a>
                                                <div class="collapsible-body" >
                                                    <div class="inner-collapsible">
                                                        <div class="select-model">
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="800" id="Cat-00" type="checkbox">
                                                                <label for="Cat-00">Yaris</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="888" id="Cat-01" type="checkbox">
                                                                <label for="Cat-01">Wigo</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="801" id="Cat-02" type="checkbox">
                                                                <label for="Cat-02">Vios</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="821" id="Cat-03" type="checkbox">
                                                                <label for="Cat-03">Corolla Altis</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="802" id="Cat-04" type="checkbox">
                                                                <label for="Cat-04">Camry</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="823" id="Cat-05" type="checkbox">
                                                                <label for="Cat-05">Fortuner</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="824" id="Cat-06" type="checkbox">
                                                                <label for="Cat-06">Land Cruiser Prado</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="825" id="Cat-07" type="checkbox">
                                                                <label for="Cat-07">Land Cruiser</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="873" id="Cat-08" type="checkbox">
                                                                <label for="Cat-08">Alphard luxury</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="890" id="Cat-09" type="checkbox">
                                                                <label for="Cat-09">Rush</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="822" id="Cat-010" type="checkbox">
                                                                <label for="Cat-010">Innova</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="889" id="Cat-011" type="checkbox">
                                                                <label for="Cat-011">Avanza</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="827" id="Cat-012" type="checkbox">
                                                                <label for="Cat-012">Hiace</label>
                                                            </p>
                                                            <p>
                                                                <input class="ckCat ckDeclareNewTool" value="826" id="Cat-013" type="checkbox">
                                                                <label for="Cat-013">Hilux</label>
                                                            </p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="active-child">
                                                <a class="collapsible-header"><span>Giá</span></a>
                                                <div class="collapsible-body">
                                                    <div class="inner-collapsible">
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-01" value="0-500000000">
                                                            <label for="price-01">0 -500 triệu</label>
                                                        </p>
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-02" value="500000000-1000000000">
                                                            <label for="price-02">500 triệu - 1 tỉ</label>
                                                        </p>
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-03" value="1000000000-2000000000">
                                                            <label for="price-03">1 tỉ - 2 tỉ</label>
                                                        </p>
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-04" value="2000000000-3000000000">
                                                            <label for="price-04">2 tỉ - 3 tỉ</label>
                                                        </p>
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-05" value="3000000000-4000000000">
                                                            <label for="price-05">3 tỉ - 4 tỉ</label>
                                                        </p>
                                                        <p>
                                                            <input name="ckPriceTool" class="ckPriceTool ckDeclareNewTool" type="checkbox" id="price-06" value="4000000000">
                                                            <label for="price-06">Trên 4 tỉ</label>
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="active-child">
                                                <a class="collapsible-header"><span>Nhiên liệu</span></a>
                                                <div class="collapsible-body">
                                                    <div class="inner-collapsible">
                                                        <p>
                                                            <input name="groupFuel" class="ckFuel ckDeclareNewTool" value="40" id="Fuel-01" type="checkbox">
                                                            <label for="Fuel-01">Xăng</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupFuel" class="ckFuel ckDeclareNewTool" value="41" id="Fuel-02" type="checkbox">
                                                            <label for="Fuel-02">Dầu</label>
                                                        </p>

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="active-child">
                                                <a class="collapsible-header"><span>Số chỗ ngồi</span></a>
                                                <div class="collapsible-body">
                                                    <div class="inner-collapsible">
                                                        <p>
                                                            <input name="groupSeat" class="ckSeat ckDeclareNewTool" value="36" id="seat-01" type="checkbox">
                                                            <label for="seat-01">5 chỗ</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupSeat" class="ckSeat ckDeclareNewTool" value="37" id="seat-02" type="checkbox">
                                                            <label for="seat-02">7 chỗ</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupSeat" class="ckSeat ckDeclareNewTool" value="42" id="seat-03" type="checkbox">
                                                            <label for="seat-03">8 chỗ</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupSeat" class="ckSeat ckDeclareNewTool" value="67" id="seat-04" type="checkbox">
                                                            <label for="seat-04">15 chỗ</label>
                                                        </p>

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="active-child">
                                                <a class="collapsible-header"><span>Kiểu dáng</span></a>
                                                <div class="collapsible-body">
                                                    <div class="inner-collapsible">
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="44" id="style-01" type="checkbox">
                                                            <label for="style-01">Sedan</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="45" id="style-02" type="checkbox">
                                                            <label for="style-02">Hatchback</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="46" id="style-03" type="checkbox">
                                                            <label for="style-03">SUV</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="47" id="style-04" type="checkbox">
                                                            <label for="style-04">Đa dụng</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="48" id="style-05" type="checkbox">
                                                            <label for="style-05">Bán tải</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupStyle" class="ckStyle ckDeclareNewTool" value="64" id="style-06" type="checkbox">
                                                            <label for="style-06">Thương mại</label>
                                                        </p>

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="active-child">
                                                <a class="collapsible-header"><span>Xuất xứ</span></a>
                                                <div class="collapsible-body">
                                                    <div class="inner-collapsible">
                                                        <p>
                                                            <input name="groupMadeIn" class="ckMadeIn ckDeclareNewTool" value="62" id="MadeIn-01" type="checkbox">
                                                            <label for="MadeIn-01">Xe trong nước</label>
                                                        </p>
                                                        <p>
                                                            <input name="groupMadeIn" class="ckMadeIn ckDeclareNewTool" value="63" id="MadeIn-02" type="checkbox">
                                                            <label for="MadeIn-02">Xe nhập khẩu</label>
                                                        </p>

                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9 col-sm-8">
                            <div class="row">
                                <div class="list-cate all">
                                    <?php
                                    if ($cars) {
                                        foreach ($cars as $car) {
                                            ?>
                                            <div class="col-lg-3 col-md-3 col-sm-4">
                                                <div class="inner">
                                                    <div class="sm_checkbox">
                                                        <input <?= (in_array($car['id'], $selected_car)) ? 'checked' : '' ?> type="checkbox" id="checkbox-<?= $car['id'] ?>">
                                                        <label for="checkbox-<?= $car['id'] ?>"  data="<?= $car['id'] ?>">
                                                            <span class="img with12-5">
                                                                <img src="<?= ClaUrl::getImageUrl($car['avatar2_path'], $car['avatar2_name'], array('width' => 250, 'height' => 250)); ?>">
                                                            </span>
                                                            <span class="txt">
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
                                            <?php
                                        }
                                    }
                                    ?>
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