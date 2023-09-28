<?php
$themUrl = Yii::app()->theme->baseUrl;
$time_comings =  $components['time_coming'];
$places =  $components['place'];
$dears =  $components['dear'];
?>
<style type="text/css">
    .click, .check-ckeck {
        cursor: pointer;
    }
    #box-lck {
        display: none;
    }
    .list-cate input[type=checkbox] {
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
<script type="text/javascript">
    
    $(document).on('click', '.check-ckeck span', function () {
        $(this).parent().find('input').click();
    });
    $(document).on('click', '#list-car-try-v2 .sm_checkbox label', function () {
        id = $(this).attr('data');
        list = ($('#list-id-compare').val() == '') ? (new Array()) : $('#list-id-compare').val().split(",");
        if (list.indexOf(id) == -1) {
            if (list.length >= 3) {
                alert('Số sản phẩm chọn đã đạt mức tối đa là 3 sản phẩm.');
                return false;
            }
            list[list.length] = id;
            $('.list-id-compare').val(list.join(','));
            $('#box-selected-car').append('<div class="col-lg-3 col-md-3 col-sm-4" id="slected-car-'+id+'">'+$('#car-item-'+id).html()+'</div>');
            $('#slected-car-'+id+' #checkbox-'+id).attr('checked', 'true');
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
            $('#slected-car-'+id).remove();
        }
    });
    $(document).on('click', '#box-selected-car .sm_checkbox label', function () {
        $('#list-car-try-v2 .sm_checkbox label[data='+$(this).attr('data')+']').click();
    });
    $(document).ready(function () {
        $('#next-2').click(function () {
            $('#tab-2').click();
        });

        $('#next-3').click(function () {
            $('#tab-3').click();
        });

        $('#summit-form').click(function () {
            $('#tab-4').click();
        });

        $('#tab-1').click(function() {
            targetTab($(this));
            $('#box-lck').css('display', 'none');
            return false;
        });
        $('#tab-2').click(function() {
            if(checkTab1()) {
                targetTab($(this));
                $('#box-lck').css('display', 'block');
            }
            return false;
        });
        $('#tab-3').click(function() {
            if(checkTab2()) {
                targetTab($(this));
                $('#box-lck').css('display', 'block');
            }
            return false;
        });
        $('#tab-4').click(function() {
            if(checkTab3()) {
                loadAjax('',$('#form-regiter-trydrv2').serialize() , $('#tab_dangkydichvu_04'), 'POST');
                targetTab($(this));
                $('#box-lck').css('display', 'none');
            }
            return false;
        });
    });
    function checkTab1() {
        if($('#list-id-compare').val() == '') {
            alert('Vui lòng chọn tối thiểu 1 mẫu xe!');
            $('#tab-1').click();
            return false;
        }
        return true;
    }
    function checkTab2() {
        if(checkTab1()) {
            if($('#date_coming').val() == '') {
                alert('Vui lòng nhập ngày dự kiến!');
                $('#tab-2').click();
                return false;
            }
            if($('#time_coming').val() == '') {
                alert('Vui lòng nhập thời gian dự kiến!');
                $('#tab-2').click();
                return false;
            }
            if($('#place').val() == '') {
                alert('Vui lòng nhập địa điểm!');
                $('#tab-2').click();
                return false;
            }
            return true;
        }
        return false;
    }
    function checkTab3() {
        if(checkTab2()) {
            if($('#dear').val() == '') {
                alert('Vui lòng nhập danh xưng!');
                $('#tab-3').click();
                return false;
            }
            if($('#first_name').val() == '') {
                alert('Vui lòng nhập đầy đủ họ tên!');
                $('#tab-3').click();
                return false;
            }
            if($('#last_name').val() == '') {
                alert('Vui lòng nhập đầy đủ họ tên!');
                $('#tab-3').click();
                return false;
            }
            if($('#try_car_phone').val() == '') {
                alert('Vui lòng nhập số điện thoại!');
                $('#tab-3').click();
                return false;
            } else {
                if(isNaN($('#try_car_phone').val()) || $('#try_car_phone').val().length < 9 || $('#try_car_phone').val().length > 20) {
                    alert('Số điện thoại nhập không đúng!');
                    return false;
                }
            }
            if(!$('#is_rule').is(':checked')) {
                alert('Vui lòng xác nhận quý khách đã có giấy phép lái xe hợp lệ!');
                $('#tab-3').click();
                return false;
            }
            
            return true;
        }
        return false;
    }
</script>
<div class="dangky_xe">
    <div class="page_title">
        <div class="target target2">
            <div class="container">
                <h2 class="right-align">Đặt lịch hẹn dịch vụ</h2>
            </div>
        </div>
    </div>
    <div class="content_dangky">
        <div class="container">
            <form id="form-regiter-trydrv2" >
                <input type="hidden" id="list-id-compare" class="list-id-compare" name="CarTryDriver[car_id]">
                <div class="tabs click_tabs">
                    <ul>
                        <li id="tab-1" class="active clicks" data-target="tab_dangkydichvu_01">
                            <a class="click">
                                <p>01</p>
                                <p>Chọn dịch vụ</p>
                            </a>
                        </li>
                        <li id="tab-2" data-target="tab_dangkydichvu_02">
                            <a class="click">
                                <p>02</p>
                                <p>Đặt lịch hẹn</p>
                            </a>
                        </li>
                        <li id="tab-3"  data-target="tab_dangkydichvu_03">
                            <a class="click">
                                <p>03</p>
                                <p>Thông tin</p>
                            </a>
                        </li>
                        <li  id="tab-4" data-target="tab_dangkydichvu_04">
                            <a class="click">
                                <p>04</p>
                                <p>Hoàn tất</p>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="content_tabs">
                    <div class="items active" id="tab_dangkydichvu_01">
                        <div class="content-tab">
                            <div class="inner">
                                <div class="heading_dt" data-text="01">
                                    <p class="txt1" data-text="Chọn dịch vụ">Bước 1</p>
                                    <p class="txt2">Chọn mẫu xe</p>
                                    <p class="btn_next btn_next_pc"><a class="next_btn_1" id="next-2">Tiếp theo</a></p>
                                </div>
                                <div class="content_tab tool_pg">
                                    <div class="list-car-try-v2 list-cate" id="list-car-try-v2">    
                                        <?php 
                                            if ($data) foreach ($data as $car) { ?>
                                            <div class="col-lg-3 col-md-3 col-sm-4"  id="car-item-<?= $car['id'] ?>">
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
                    <div class="items" id="tab_dangkydichvu_02">
                        <div class="content-tab">
                           <div class="inner">
                                <div class="heading_dt" data-text="01">
                                    <p class="txt1" data-text="Chọn dịch vụ">Bước 2</p>
                                    <p class="txt2">Đặt lịch hẹn</p>
                                    <p class="btn_next btn_next_pc"><a class="next_btn_1" id="next-3">Tiếp theo</a></p>
                                </div>
                            </div>
                            <div class="content_tab">
                                <div class="form_1 form_dk">
                                    <div class="lab_for">
                                        <span class="lbl"> Ngày dự kiến (*)</span>
                                    </div>
                                    <div class="input_f">
                                        <input id="date_coming" type="date" name="CarTryDriver[date_coming]">
                                    </div>
                                </div>
                                <div class="form_1 form_dk">
                                    <div class="lab_for">
                                        <span class="lbl"> Thời gian dự kiến (*)</span>
                                    </div>
                                    <div class="input_f">
                                        <select id="time_coming" name="CarTryDriver[time_coming]">
                                            <?php foreach ($time_comings as $key => $value) { ?>
                                                <option value="<?= $key ?>"><?= $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form_1 form_dk">
                                    <div class="lab_for">
                                        <span class="lbl"> Địa điểm (*)</span>
                                    </div>
                                    <div class="input_f">
                                        <select id="place" name="CarTryDriver[place]">
                                            <?php foreach ($places as $key => $value) { ?>
                                                <option value="<?= $key ?>"><?= $value ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <p><i>Quý khách vui lòng điền đầy đủ các thông tin có dấu (*)</i></p>
                            </div>
                        </div>
                    </div>
                    <div class="items" id="tab_dangkydichvu_03">
                        <div class="content-tab">
                           <div class="inner">
                                <div class="heading_dt" data-text="01">
                                    <p class="txt1" data-text="Chọn dịch vụ">Bước 3</p>
                                    <p class="txt2">Thông tin khách hàng</p>
                                    <p class="btn_next btn_next_pc"><a class="next_btn_1" id="summit-form">Tiếp theo</a></p>
                                </div>
                            </div>
                            <div class="content_tab">
                                <div class="list_forms">
                                    <div class="list_form">
                                        <div class="form1">
                                            <div class="lab_for">
                                                <span class="lbl">Danh xưng(*)</span>
                                            </div>
                                            <div class="input_f">
                                                <select id="dear" name="CarTryDriver[dear]">
                                                    <?php foreach ($dears as $key => $value) { ?>
                                                        <option value="<?= $key ?>"><?= $value ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form1">
                                            <div class="lab_for">
                                                <span class="lbl"> Họ tên (*)</span>
                                            </div>
                                            <div class="input_f">
                                                <div class="left">
                                                    <input id="first_name" type="text" placeholder="Nguyễn Văn" name="CarTryDriver[first_name]">
                                                </div>
                                                <div class="right">
                                                    <input id="last_name" placeholder="Nam" type="text"  name="CarTryDriver[last_name]">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form1">
                                            <div class="lab_for">
                                                <span class="lbl"> Email</span>
                                            </div>
                                            <div class="input_f">
                                                <input id="try_car_email" name="CarTryDriver[email]" type="email" name="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list_form">
                                        <div class="form1">
                                            <div class="lab_for">
                                                <span class="lbl">Số điện thoại (*)</span>
                                            </div>
                                            <div class="input_f">
                                                <input id="try_car_phone" name="CarTryDriver[phone]" type="text" name="">
                                            </div>
                                        </div>
                                        <div class="form1">
                                            <div class="lab_for">
                                                <span class="lbl"> Ghi chú</span>
                                            </div>
                                            <div id="try_car_note" class="input_f">
                                                <textarea name="CarTryDriver[note]"></textarea>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="clear">
                                        <div class="check-ckeck">
                                            <input  id="is_rule" value="1" type="checkbox" name="CarTryDriver[is_rule']">
                                            <span>Tôi đã có giấy phép lái xe ô tô hợp lệ (*)</span>
                                        </div>
                                        <p><i>Quý khách vui lòng điền đầy đủ các thông tin có dấu (*)</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="items" id="tab_dangkydichvu_04">
                        <div class="content-tab">
                            Đang trong quá trình đăng ký. Vui lòng chờ trong giây lát.
                        </div>
                    </div>
                    <div id="box-lck" class="box-lck clear">
                        <div class="heading_dt">
                            <p class="txt1">Mẫu xe đã chọn</p>
                        </div>
                        <div class="content_tab tool_pg">
                            <div class="list-car-try-v2 list-cate" id="box-selected-car"> 
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo $themUrl ?>/js/jquery.nice-select.js"></script>