<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . "/css/category/category.css");
//
$array = array('' => Yii::t('product', 'choicategory'));
$option = $category->createOptionArray(ClaCategory::CATEGORY_ROOT, ClaCategory::CATEGORY_STEP, $array);
//
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/horsey/horsey.js"></script>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/horsey/horsey.css" />

<style type="text/css">
    .div-hidden{
        display: none !important;
    }
    .fl .form-group{
        float: left;
    }
    .fl .form-group label{
        display: block;
    }
    .form-group{
        display: block;
    }
    .form-horizontal .form-group{
        margin: 0px;
        margin-right: 15px;
    }
    #div_discountvalue_fixed, #div_discountvalue_percent, #minimumOrderAmount{
        width: 100px;
    }
    #CouponCampaign_coupon_type, #CouponCampaign_applies_to_resource{
        width: 140px;
    }
    #minimumOrderAmount .input-group{
        width: 100px;
    }
</style>
<div class="">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'coupon-campaign-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <h4>Chi tiết khuyến mãi</h4>
                    <p class="text-muted"> Tên của chiến dịch giảm giá của bạn (sẽ không được hiển thị cho khách hàng của bạn) và số lần sử dụng cho một mã giảm giá.</p>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="panel panel-default panel-light">
                        <div class="panel-body">
                            <div class="col-sm-12 no-padding">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'name', array('class' => '')); ?>
                                    <div class="controls">
                                        <?php echo $form->textField($model, 'name', array('class' => 'span10 col-sm-12')); ?>
                                        <?php echo $form->error($model, 'name'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 no-padding">
                                <div class="form-group">
                                    <?php echo $form->labelEx($model, 'usage_limit', array('class' => '')); ?>
                                    <div class="se input-group  limit-input-group ps-relative" style="width: 222px;">
                                        <?php echo $form->textField($model, 'usage_limit', array('readonly' => true, 'class' => 'form-control')); ?>
                                        <span class="input-group-addon drop-price-addon">
                                            <?php echo $form->checkBox($model, 'no_limit'); ?>
                                            <?php echo Yii::t('coupon', 'no_limit'); ?>
                                        </span>                                   
                                    </div>
                                    <div>
                                        <?php echo $form->error($model, 'usage_limit'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <h4>Loại khuyến mãi</h4>
                    <p class="text-muted">Chọn loại khuyến mãi và những điều kiện đi kèm.</p>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="panel panel-default panel-light">
                        <div class="panel-body">
                            <div class="form-inline col-sm-12 no-padding">
                                <div class="fl sr">
                                    <div class="form-group">
                                        <label>Loại khuyến mãi</label>
                                        <?php echo $form->dropDownList($model, 'coupon_type', CouponCampaign::couponTypeArray(), array('class' => 'form-control')); ?>
                                    </div>
                                    <div class="form-group">
                                        <div id="div_discountvalue_fixed">
                                            <label>Giảm</label>
                                            <div class="input-group">
                                                <?php echo $form->textField($model, 'coupon_value_fixed', array('class' => 'form-control')); ?>
                                                <span class="input-group-addon drop-price-addon">đ</span>
                                            </div>
                                        </div>
                                        <div id="div_discountvalue_percent" class="div-hidden">
                                            <label>Giảm</label>
                                            <div class="input-group">
                                                <?php echo $form->textField($model, 'coupon_value_percent', array('class' => 'form-control')); ?>                    
                                                <span class="input-group-addon drop-price-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="div_AppliesToResource">
                                        <?php echo $form->labelEx($model, 'applies_to_resource', array('class' => '')); ?>
                                        <?php echo $form->dropDownList($model, 'applies_to_resource', CouponCampaign::appliesToResourceArray(), array('class' => 'form-control')); ?>
                                    </div>
                                    <div id="minimumOrderAmount" class="form-group div-hidden">
                                        <label>Giá từ</label>
                                        <div class="input-group">
                                            <?php echo $form->textField($model, 'minimum_order_amount', array('class' => 'form-control')); ?>
                                            <span class="input-group-addon drop-price-addon">đ</span>
                                        </div>
                                    </div>

                                    <div class="form-group div-hidden" id="div_product">
                                    <div class="form-group div-hidden" id="div_product">
                                        <label>Chọn sản phẩm</label>
                                        <div class="input-group parent">
                                            <?php echo $form->textField($model, 'product_id', array('class' => 'form-control')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'product_id'); ?>
                                    </div>
                                    <div class="form-group div-hidden" id="div_category">
                                        <label>Chọn danh mục</label>
                                        <div class="input-group">
                                            <?php echo $form->dropDownList($model, 'category_id', $option, array('class' => 'form-control')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'category_id'); ?>
                                    </div>
                                    <div class="form-group div-hidden" id="div_value_shipping">
                                        <label>Với mức phí nhỏ hơn hoặc bằng</label>
                                        <div class="input-group">
                                            <?php echo $form->textField($model, 'value_shipping', array('class' => 'form-control')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'value_shipping'); ?>
                                    </div>
                                    <div class="form-group div-hidden" id="div_province_id">
                                        <label>Áp dụng cho</label>
                                        <div class="input-group">
                                            <?php echo $form->dropDownList($model, 'province_id', $listprovince, array('class' => 'form-control')); ?>
                                        </div>
                                        <?php echo $form->error($model, 'province_id'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-inline col-sm-12 margin-md-top">
                                <div class="sst align-with-input form-group div-hidden" id="div_appliesOnce">
                                    <?php echo $form->labelEx($model, 'applies_one', array('class' => '')); ?>
                                    <?php echo $form->dropDownList($model, 'applies_one', CouponCampaign::appliesOneArray(), array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'applies_one'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    var suggestions = [];
                    horsey(document.querySelector('#CouponCampaign_product_id'), {
                        suggestions: [
<?php foreach ($products as $product) { ?>
                                {value: '<?php echo $product['name'] ?>', text: '<?php echo $product['name'] ?> trong <?php echo $product['cat_name'] ?>', src: '<?php echo ClaHost::getImageHost(), $product['avatar_path'], 's50_50/', $product['avatar_name'] ?>'},
<?php } ?>
                                    ],
                                    limit: 5,
                                    render: function (li, suggestion) {
                                        var image = '<img class="autofruit" src="' + suggestion.src + '" /> ';
                                        li.innerHTML = image + suggestion.text;
                                    }
                                });
                </script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#CouponCampaign_no_limit').click(function () {
                            if ($(this).is(':checked')) {
                                $('#CouponCampaign_usage_limit').attr('readonly', 'readonly');
                            } else {
                                $('#CouponCampaign_usage_limit').removeAttr('readonly');
                            }
                        });

                        $('#CouponCampaign_coupon_type').change(function () {
                            var coupon_type = $(this).val();
                            if (coupon_type == 'fixed_amount') {
                                $('#div_discountvalue_fixed').removeClass('div-hidden');
                                $('#div_discountvalue_percent').removeClass('div-hidden');
                                $('#div_discountvalue_fixed').show();
                                $('#div_discountvalue_percent').hide();
                                $('#div_AppliesToResource').show();
                                $('#div_value_shipping').hide();
                                $('#div_province_id').hide();
                            } else if (coupon_type == 'percentage') {
                                $('#div_discountvalue_fixed').removeClass('div-hidden');
                                $('#div_discountvalue_percent').removeClass('div-hidden');
                                $('#div_discountvalue_fixed').hide();
                                $('#div_discountvalue_percent').show();
                                $('#div_AppliesToResource').show();
                                $('#div_value_shipping').hide();
                                $('#div_province_id').hide();
                            } else if (coupon_type == 'shipping') {
                                $('#div_discountvalue_fixed').hide();
                                $('#div_discountvalue_percent').hide();
                                $('#div_AppliesToResource').hide();
                                $('#div_category').hide();
                                $('#div_product').hide();
                                $('#div_appliesOnce').hide();
                                $('#div_value_shipping').removeClass('div-hidden');
                                $('#div_province_id').removeClass('div-hidden');
                                $('#div_value_shipping').show();
                                $('#div_province_id').show();
                            }
                        });

                        $('#CouponCampaign_applies_to_resource').change(function () {
                            var apply_resource = $(this).val();
                            if (apply_resource == 'minimum_order_amount') {
                                // nếu chọn loại khuyến mãi áp dụng cho giá trị đơn hàng từ
                                $('#minimumOrderAmount').removeClass('div-hidden');
                                $('#minimumOrderAmount').show();
                                $('#div_category').hide();
                                $('#div_product').hide();
                                $('#div_appliesOnce').hide();
                            } else if (apply_resource == 'custom_category') {
                                // nếu chọn loại khuyến mãi áp dụng cho danh mục sản phẩm
                                $('#div_category').removeClass('div-hidden');
                                $('#div_appliesOnce').removeClass('div-hidden');
                                $('#minimumOrderAmount').hide();
                                $('#div_category').show();
                                $('#div_product').hide();
                                $('#div_appliesOnce').show();
                            } else if (apply_resource == 'product') {
                                // nếu chọn loại khuyến mãi áp dụng cho sản phẩm
                                $('#div_product').removeClass('div-hidden');
                                $('#div_appliesOnce').removeClass('div-hidden');
                                $('#minimumOrderAmount').hide();
                                $('#div_category').hide();
                                $('#div_product').show();
                                $('#div_appliesOnce').show();
                            } else if (apply_resource == 'all') {
                                $('#minimumOrderAmount').hide();
                                $('#div_category').hide();
                                $('#div_product').hide();
                                $('#div_appliesOnce').hide();
                            }
                        });
                    });
                </script>
            </div>
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <h4>Thời gian áp dụng</h4>
                    <p class="text-muted">Chọn thời gian bắt đầu, kết thúc của khuyến mãi.</p>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="panel panel-default panel-light">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <?php echo $form->labelEx($model, 'released_date', array('class' => 'strong')); ?>
                                    <div class="input-group date margin-right">
                                        <?php
                                        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                            'model' => $model, //Model object
                                            'name' => 'CouponCampaign[released_date]', //attribute name
                                            'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                            'value' => ((int) $model->released_date > 0 ) ? date('d-m-Y H:m:s', (int) $model->released_date) : date('d-m-Y H:m'),
                                            'language' => 'vi',
                                            'options' => array(
                                                'showSecond' => true,
                                                'dateFormat' => 'dd-mm-yy',
                                                'timeFormat' => 'HH:mm',
                                                'controlType' => 'select',
                                                'stepHour' => 1,
                                                'stepMinute' => 1,
                                                'stepSecond' => 1,
                                                'showSecond' => false,
                                                'changeMonth' => true,
                                                'changeYear' => false,
                                                'tabularLevel' => null,
                                            ), // jquery plugin options
                                            'htmlOptions' => array(
                                                'class' => 'span12 col-sm-12',
                                            )
                                        ));
                                        ?>
                                        <span class="input-group-addon padding-lg-right">
                                            <i class="fa fa-calendar">
                                            </i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <?php echo $form->labelEx($model, 'expired_date', array('class' => 'strong')); ?>
                                    <div class="input-group date margin-right">
                                        <?php
                                        $this->widget('common.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
                                            'model' => $model, //Model object
                                            'name' => 'CouponCampaign[expired_date]', //attribute name
                                            'mode' => 'datetime', //use "time","date" or "datetime" (default)
                                            'value' => ((int) $model->expired_date > 0 ) ? date('d-m-Y', (int) $model->expired_date) : date('d-m-Y H:m'),
                                            'language' => 'vi',
                                            'options' => array(
                                                'showSecond' => true,
                                                'dateFormat' => 'dd-mm-yy',
                                                'timeFormat' => 'HH:mm:ss',
                                                'controlType' => 'select',
                                                'stepHour' => 1,
                                                'stepMinute' => 1,
                                                'stepSecond' => 1,
                                                //'showOn' => 'button',
                                                'showSecond' => false,
                                                'changeMonth' => true,
                                                'changeYear' => false,
                                                'tabularLevel' => null,
                                            //'addSliderAccess' => true,
                                            //'sliderAccessArgs' => array('touchonly' => false),
                                            ), // jquery plugin options
                                            'htmlOptions' => array(
                                                'class' => 'span12 col-sm-12',
                                            )
                                        ));
                                        ?>
                                        <span class="input-group-addon padding-lg-right">
                                            <i class="fa fa-calendar">
                                            </i>
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <h4>Tên và số lượng mã giảm giá</h4>
                    <p class="text-muted">Tùy chọn loại mã và số lượng mã giảm giá được tạo ra.</p>
                </div>
                <div class="col-md-8 col-lg-9">
                    <div class="panel panel-default panel-light">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="control-label strong">Tạo mã tự động  hoặc nhập thủ công?</label>
                                    <div class="controls">
                                        <label>
                                            <input type="radio" id="radio-generate" name="CouponCampaign[import-or-generate]" value="generate" checked="" onchange=""> Tạo mã giảm giá sử dụng một tiền tố
                                        </label>
                                    </div>
                                    <div class="controls">
                                        <label>
                                            <input type="radio" id="radio-import" name="CouponCampaign[import-or-generate]" value="import"> Nhập mã giảm giá thủ công
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                            </div>
                            <div id="discount-prefixes" class="row">
                                <div class="col-md-6">
                                    <?php echo $form->labelEx($model, 'coupon_prefix', array('class' => 'control-label strong')); ?>
                                    <?php echo $form->textField($model, 'coupon_prefix', array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'coupon_prefix'); ?>
                                    <label class="text-muted" style="margin-top:10px;">Ví dụ mã dựa trên tiền tố của bạn:</label><br>
                                    <label class="text-muted" id="discount_prefix">Y41H992V-VDOZWERG</label>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $form->labelEx($model, 'coupon_number', array('class' => 'control-label strong')); ?>
                                    <?php echo $form->textField($model, 'coupon_number', array('class' => 'form-control')); ?>
                                    <?php echo $form->error($model, 'coupon_number'); ?>
                                </div>
                            </div>
                            <div id="discount-import" class="row div-hidden">
                                <div class="col-sm-12">
                                    <label class="control-label strong">
                                        Nhập mã thủ công theo ý bạn <span class="text-muted">(cho tất cả các dòng giảm giá sẽ được tạo ra)</span>
                                    </label>
                                    <textarea class="form-control" style="height:120px" id="discount_set_import_codes" name="CouponCampaign[discountset_import]" placeholder="Enter xuống dòng để tạo thêm mã giảm giá"></textarea>
                                </div>
                                <div class="col-sm-12">
                                    <br>
                                    <label class="control-label strong">Số mã giảm giá sẽ được tạo ra</label>
                                    <p id="discount-counter" name="DiscountCounter"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('#radio-generate').click(function () {
                            $('#discount-import').hide();
                            $('#discount-prefixes').show();
                        });
                        $('#radio-import').click(function () {
                            $('#discount-import').removeClass('div-hidden');
                            $('#discount-import').show();
                            $('#discount-prefixes').hide();
                        });

                        $('#discount_set_import_codes').keypress(function () {
                            var key = window.event.keyCode;
                            // If the user has pressed enter
                            if (key == 13) {
                                var import_codes = $(this).val();
                                var list_import = import_codes.split("\n");
                                var list_import = list_import.filter(function (v) {
                                    return v !== ''
                                });
                                console.log(list_import);
                                $('#discount-counter').text(list_import.length);
                            }
                        });

                    });
                </script>
            </div>
        </div>
        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('coupon', 'create') : Yii::t('coupon', 'update'), array('class' => 'btn btn-primary', 'id' => 'btnAddCate')); ?>
        </div>
        <?php
        $this->endWidget();
        ?>
    </div>
</div>

