<?php 
    $dx = $model->dear.' <b class="uppercase">'.$model->first_name.' '.$model->last_name.'</b>';
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.with12-5').each(function (e) {
            $(this).height($(this).width() * 8 / 12);
        });
        $('#list-id-compare').val('');
        $('#box-selected-car').html('');
    });
    document.getElementById("form-regiter-trydrv2").reset();
</script>
<div class="inner">
    <div class="heading_dt" data-text="✔">
        <p class="txt1" data-text="Hoàn tất">Hoàn tất đăng ký</p>
        <p class="txt2">Cảm ơn <?= $dx ?> đã đăng ký lái thử</p>
        <p class="btn_next btn_next_pc"><a href="/">Về trang chủ</a></p>
    </div>
    <div class="content_tab">
        <div class="finished_step">

            <p>
                Xin cảm ơn <?= $dx ?> đã tin tưởng và sử dụng dịch vụ của chúng tôi.<br>
                Chúng tôi xin xác nhận thông tin đăng ký của <?= $dx ?> như sau:
            </p>
            <div style="margin: 2rem 0">
                <p><span style="font-weight: bold">Thông tin đăng ký</span></p>
                <p>- Họ tên: <span class="fullname" id="fullname"><?= $dx ?></span></p>
                <p>- Số điện thoại: <span class="phone" id="phone"><?= $model->phone ?></span></p>
                <?php if($model->email) { ?>
                    <p>- Email: <span class="email" id="email"><?= $model->email ?></span></p>
                <?php } ?>
                <p>- Thời gian: <span class="date" id="spDate"><?= date('d-m-Y', $model->date_coming) ?></span> lúc <span class="time" id="spTime"><?= $model->time_coming ?></span></p>
                <p>- Địa điểm: <span class="address" id="address"><?= $model->place ?></span></p>
                <p>- Ghi chú: <span class="ghichu" id="ghichu"><?= $model->note ?></span></p>
            </div>
        </div>
    </div>
    <div class="heading_dt hide-mb">
        <p class="txt1">Mẫu xe đã chọn</p>
    </div>
    <div class="content_tab hide-mb">
        <div class="list_cate_selected">
            <div class="list-cate all">
                <?php 
                    if ($data) foreach ($data as $car) { ?>
                    <div class="col-lg-3 col-md-3 col-sm-4"  id="car-item-<?= $car['id'] ?>">
                        <div class="inner">
                            <div class="sm_checkbox">
                                <label>
                                    <span class="img with12-5">
                                        <img src="<?= ClaUrl::getImageUrl($car['avatar2_path'], $car['avatar2_name'], array('width' => 250, 'height' => 250)); ?>">
                                    </span>
                                    <span class="txt">
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
    <p class="clear">
        Nhân viên tư vấn bán hàng sẽ liên hệ với Quý khách để xác nhận lịch hẹn trong thời gian sớm nhất.<br>
        Xin trân trọng cảm ơn!
    </p>
</div>