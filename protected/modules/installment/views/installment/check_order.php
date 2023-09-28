<link href="<?php echo Yii::app()->request->baseUrl; ?>/installment/css/order.css" rel="stylesheet"/>
<?php
$papers = ClaInstallment::getPapers($count_price); //Hồ sơ cần có
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
<section id="wrap_cart">
    <!--#region Back link-->
    <div class="backinstall">
        <a href="<?= Yii::app()->createUrl('installment/installment/index', ['id' => $product['id']]) ?>"
           title="Quay lại">Quay lại</a>
        <span>Đặt mua trả góp</span>
    </div>
    <!--#endregion-->
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'installment-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => false,
        'htmlOptions' => array(
            'class' => 'form-horizontal frmorder',
        ),
    ));
    ?>
    <!--#region Thông tin sản phẩm-->
    <div class="infoproduct">
        <a class="linksp">
            <img width="40" height="40"
                 src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's80_80/' . $product['avatar_name'] ?>"
                 alt="<?= $product['name'] ?>">
        </a>
        <div>Mua trả góp <a
                    href="<?= Yii::app()->createUrl('economy/product/detail', ['id' => $product->id, 'alias' => $product->alias]) ?>"
                    title="<?= $product['name'] ?> target=" _blank"><?= $product['name'] ?></a></div>
        <div id="price-Product">
            <?php if ($product['price_market']) {
                $discount = 'Giảm ' . ClaInstallment::getDiscount($product['price_market'], $product['price']) . '%';
                ?>
                <i>-<?= $discount ?></i> Giá sản phẩm
                <span class="line-price"><?= number_format($product['price_market'], 0, '', '.') . '₫' ?></span>
            <?php } ?>
            <strong><?= number_format($product['price'], 0, '', '.') . '₫' ?> </strong>
        </div>
        <div class="km">Chi tiết khuyến mãi</div>
        <!-- Khuyến mãi -->
        <div class="boxShowKM" style="display: none;">
            <?= $product->product_info->product_sortdesc ?>
            <label>* Khuyến mãi không áp dụng đồng thời cho trả góp 0%</label>
        </div>
    </div>
    <ul class="listorder">
        <li class="tragop-price">
            <span class="text-left">Gói trả góp:</span>
            <span class="text-right"><b>TỰ CHỌN</b></span>
            <span class="text-left">Trả trước ( <?= $count_pre * 100 ?>% ):</span>
            <span class="text-right"><strong><?= number_format($count_price * $count_pre, 0, '', '.') . '₫' ?></strong></span>
            <span class="text-left">Góp mỗi tháng (trong <?= $number_month ?> tháng):</span>
            <span class="text-right"><strong><?= number_format($interes_home_cre['every_month'], 0, '', '.') . '₫' ?></strong></span>
            <span class="text-left"><b>TỔNG TIỀN:</b></span>
            <span class="text-right"><strong><b style="font-size: 16px"
                                                id="div-total"><?= number_format($interes_home_cre['total'], 0, '', '.') . '₫' ?></b></strong></span>
            <div class="clear"></div>
        </li>
        <li class="tragop-info">
            <span>Giấy tờ cần có: <b><?= $papers ?></b></span>
            <span>
         Công ty tài chính: <b><?= $arr_bank->name ?></b></span>
        </li>
    </ul>
    <div class="infouser">
        <div class="malefemale">
            <label for="male">
                <input id="male" type="radio" value="0" name="InstallmentOrder[sex]" checked="">
                Anh
            </label>
            <label for="female">
                <input id="female" type="radio" value="1" name="InstallmentOrder[sex]">
                Chị
            </label>
            <?php echo $form->error($model, 'sex'); ?>
        </div>
        <div class="areainfo">
            <div class="left">
                <?php echo $form->textField($model, 'username', array('class' => 'saveinfo', 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('username'))); ?>
                <?php echo $form->error($model, 'username'); ?>
            </div>
            <div class="right">
                <?php echo $form->textField($model, 'phone', array('class' => 'saveinfo', 'maxlength' => 11, 'placeholder' => $model->getAttributeLabel('phone'))); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
            <div class="clear"></div>
            <div class="left">
                <?php echo $form->textField($model, 'identity_code', array('class' => 'saveinfo', 'maxlength' => 12, 'placeholder' => $model->getAttributeLabel('identity_code'))); ?>
                <?php echo $form->error($model, 'identity_code'); ?>
            </div>
            <div class="right">
                <div class="input-nam" name="input-nam">
                    <?php
                    $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                        'model' => $model, //Model object
                        'name' => 'InstallmentOrder[birthday]', //attribute name
                        'mode' => 'datetime', //use "time","date" or "datetime" (default)
                        'value' => '1/1/1996',
                        'language' => 'vi',
                        'options' => array(
                            'dateFormat' => 'dd-mm-yy',
                            'timeFormat' => '',
                            'controlType' => 'select',
                            'stepHour' => 1,
                            'stepMinute' => 1,
                            'stepSecond' => 1,
                            'showSecond' => true,
                            'changeMonth' => true,
                            'changeYear' => false,
                            'tabularLevel' => null,
                        ), // jquery plugin options
                        'htmlOptions' => array(
                            'class' => 'span12 col-sm-12 saveinfo',
                            'placeholder' => $model->getAttributeLabel('birthday')
                        )
                    ));
                    ?>
                    <?php echo $form->error($model, 'birthday'); ?>
                </div>
            </div>
            <div class="clear"></div>
            <div class="left">
                <?php echo $form->emailField($model, 'email', array('class' => 'saveinfo', 'maxlength' => 50, 'placeholder' => $model->getAttributeLabel('email'))); ?>
                <?php echo $form->error($model, 'email'); ?>
            </div>
            <div class="right">
                <?php echo $form->textField($model, 'monthly_income', array('class' => 'saveinfo numberFormat', 'maxlength' => 15, 'placeholder' => $model->getAttributeLabel('monthly_income'))); ?>
                <?php echo $form->error($model, 'monthly_income'); ?>
            </div>
            <div class="clear"></div>
            <div class="citydis">
                <label class="small-text"><b>Địa chỉ hộ khẩu</b></label>
                <div class="city" id="city">
                    <?php
                    echo $form->dropDownList($model, 'province_id', $listprivince, array('class' => 'span9 form-control',));
                    ?>
                    <?php echo $form->error($model, 'province_id'); ?>
                </div>
                <div class="dist" id="dist">
                    <?php
                    echo $form->dropDownList($model, 'district_id', $listdistrict, array('class' => 'span9 form-control', 'prompt' => 'Chọn quận/huyện'));
                    ?>
                    <?php echo $form->error($model, 'district_id'); ?>
                </div>
            </div>
            <div class="clear"></div>
            <?php echo $form->textField($model, 'address', array('class' => 'saveinfo txtaddress', 'placeholder' => $model->getAttributeLabel('address'))); ?>
            <?php echo $form->error($model, 'address'); ?>
            <div class="clear"></div>
        </div>
    </div>
    <div class="infouser store">
        <div class="areainfo">
            <div class="citydis">
                <label class="small-text">
                    <b>Chọn siêu thị để duyệt hồ sơ</b>
                </label>
                <div class="city" id="cityshock">
                    <select class="span9 form-control" id="province_" data-check="1">
                        <?php foreach ($listprivince as $key => $value) { ?>
                            <option value="<?=$key?>"><?=$value?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="dist " id="distshock">
                    <select class="span9 form-control" id="district_" data-check="0">
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="sieuthi">
            <div class="shop">
                <input type="hidden" value="" name="InstallmentOrder[shop_id]">
            </div>
            <?php echo $form->error($model, 'shop_id'); ?>
        </div>
    </div>
    <button class="cart-btt " id="btn-complete" type="submit">
        <b>đặt mua trả góp</b>
    </button>
    <p class="label-tttg">Thông tin bạn cung cấp sẽ được chuyển cho công ty tài chính để làm hồ sơ góp</p>
    <?php $this->endWidget();
    ?>
    <div class="note-tos show">
        <a title="Điều khoản sử dụng" target="_blank" href="<?=ClaHost::getServerHost()?>">Bằng cách đặt hàng, bạn
            đồng ý với Điều khoản sử dụng của xebaonam</a>
    </div>
</section>
<div class="loading-cart">
    <span class="cswrap">
        <span class="csdot"></span>
        <span class="csdot"></span>
        <span class="csdot"></span>
    </span>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/installment/js/main.js"></script>
<script type="text/javascript">
    jQuery(document).on('change', '#InstallmentOrder_province_id', function() {
        var province = jQuery(this).val();
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/installment/installment/getdistrict') ?>',
            data: {pid:province,allownull:1},
            dataType: 'JSON',
            beforeSend: function() {
                $('.loading-cart').show();
            },
            success: function(res) {
                if (res.code == 200) {
                    jQuery('#InstallmentOrder_district_id').html(res.html);
                }
                $('.loading-cart').hide();
            },
            error: function() {
                $('.loading-cart').hide();
            }
        });
    });

    jQuery(document).on('change', '#province_,#district_', function() {
        var province = jQuery('#province_').val();
        var district = jQuery('#district_').val();
        var check = jQuery(this).attr('data-check');
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/installment/installment/getdistrict') ?>',
            data: {pid:province,district:district,allownull:1,viewshop:1},
            dataType: 'JSON',
            beforeSend: function() {
                $('.loading-cart').show();
            },
            success: function(res) {
                if (res.code == 200) {
                    if (res.html && check==1) {
                        jQuery('#district_').html(res.html);
                    }
                    if (res.viewshop) {
                        jQuery('.sieuthi .shop').html(res.viewshop);
                    }
                }
                $('.loading-cart').hide();
            },
            error: function() {
                $('.loading-cart').hide();
            }
        });
    });
</script>