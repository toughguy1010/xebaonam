<div class="choice-step-one" style="display:block">
    <form id="from_gear">
        <div class="container">
            <div class="list-item-gear product-attr-grear">
                <div class="item-gear-explore choice-address-gear">
                    <h2 class="active">
                        <a href="">
                            <span class="number">01</span>
                            <span>Địa điểm <spam>THỜI GIAN</spam></span>
                        </a>
                    </h2>
                    <div class="box-select">
                        <?php
                        echo CHtml::dropDownList('woeid', 'woeid', $aryListProvince, array('class' => 'form-control', 'name' => 'woeid'));
                        ?>
                    </div>
                    <div class="box-select">
                        <select class="wide form-control" name="date">
<!--                            <option data-display="THỜI GIAN">THỜI GIAN</option>-->
                            <?php
                            $startdate=strtotime("today");
                            $enddate=strtotime("+10 day", $startdate);
                            $n = 0;
                            while ($startdate < $enddate) {
                                echo '<option value="'.$n++.'">'.date("d/m/Y",$startdate).'</option>';
                                $startdate = strtotime("+1 day", $startdate);
                            }
                            ?>

                        </select>
                    </div>
                    <!--                    <span class="note">* Không có dữ liệu *</span>-->
                </div>
                <?php
                if (count($attributes)) { ?>
                    <?php
                    foreach ($attributes as $key => $att) { ?>
                        <?php
                        if ($att['att']->code == 'hoat-dong-cua-umove') { ?>
                            <div class="item-gear-explore choice-umove-gear">
                                <h2>
                                    <a href="">
                                        <span class="number">02</span>
                                        <span>CÁC Hoạt động <spam>CỦA UMOVE</spam></span>
                                    </a>
                                </h2>
                                <div class="list-umove-actives">
                                    <ul>
                                        <?php
                                        if (count($att['options'])) { ?>
                                            <?php foreach ($att['options'] as $item) { ?>
                                                <li>
                                                    <a onclick="add_value(this)" href="javascript:voi(0)"
                                                       data-index="<?php echo 'fi_' . $key; ?>"
                                                       data-value="<?php echo $item['index_key']; ?>"
                                                       data-parent="list-umove-actives">
                                                        <?php if ($item['name'] == 'Cắm trại') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/parks.png)"></spam>
                                                        <?php } else if ($item['name'] == 'Leo núi') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/walker.png)"></spam>
                                                        <?php } else if ($item['name'] == 'Đạp xe') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/bycylcer.png)"></spam>
                                                        <?php } else if ($item['name'] == 'Chèo thuyền') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/circle.png)"></spam>
                                                        <?php } else if ($item['name'] == 'Xe máy') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/motobike.png)"></spam>
                                                        <?php } else if ($item['name'] == 'Du lịch') { ?>
                                                            <spam style="background-image:url(<?php echo Yii::app()->theme->baseUrl ?>/images/human.png)"></spam>
                                                        <?php } ?>
                                                        <span><?php echo $item['name']; ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                        <input class="attrConfig-input-gear" id="<?php echo 'fi_' . $key; ?>"
                                               type="hidden"
                                               name="<?php echo 'fi_' . $key; ?>" value="">
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($att['att']->code == 'gioi-tinh-do-tuoi') { ?>
                            <?php if (count($att['options'])) { ?>
                                <div class="item-gear-explore choice-sex-gear">
                                    <h2>
                                        <a href="">
                                            <span class="number">03</span>
                                            <span>GIỚI TÍNH<spam>ĐỘ TUỔI</spam></span>
                                        </a>
                                    </h2>
                                    <ul>
                                        <?php
                                        if (count($att['options'])) { ?>
                                            <?php foreach ($att['options'] as $item) { ?>
                                                <li>
                                                    <a onclick="add_value(this)" href="javascript:voi(0)"
                                                       data-index="<?php echo 'fi_' . $key; ?>"
                                                       data-value="<?php echo $item['index_key']; ?>"
                                                       data-parent="choice-sex-gear">
                                                        <span><?php echo $item['name']; ?></span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                        <input class="attrConfig-input-gear" id="<?php echo 'fi_' . $key; ?>"
                                               type="hidden"
                                               name="<?php echo 'fi_' . $key; ?>" value="">
                                    </ul>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <div class="bg-result">
            <div class="arrow-black-full">
            </div>
            <div class="arrow-black-thin">
            </div>
            <div class="btn-result">
                <a href="javascript:void(0)" onclick="show_result()">KẾT QUẢ</a>
                <!--                <span>* Vui lòng chọn đủ thông tin *</span>-->
            </div>
        </div>
    </form>
</div>
<div class="choice-step-two" style="display: none">
    <div class="container">

    </div>
    <div class="bg-result-step2">
        <div class="arrow-black-full">
        </div>
        <div class="arrow-black-thin">
        </div>
        <div class="btn-result">
            <a href="javascript:void(0)" onclick="re_search()">Quay lại</a>
        </div>
    </div>
</div>
<script>
    function add_value(ev) {
        var id_key = $(ev).attr('data-index');
        var attr_value = $(ev).attr('data-value');
        var attr_parent = $(ev).attr('data-parent');
        $('input#' + id_key).val(attr_value);
        $('.' + attr_parent + ' ul li').removeClass('active');
        $(ev).parent().addClass('active');
    }
    function show_result() {
        var data_params = '#from_gear';
        if (data_params) {
            var data_params_object = jQuery(data_params);
            //
            if (data_params_object.find('.product-attr-grear').length) {
                var check = true;
                var text = '';
                data_params_object.find('.product-attr-grear').each(function () {
                    if (!$(this).find('.attrConfig-input-gear').val()) {
                        check = false;
                        if (!text)
                            text = $(this).attr('attr-title');
                        else
                            text += ', ' + $(this).attr('attr-title');
                    }
                });
                if (!check) {
                    alert('Vui lòng chọn thuộc tính');
//                    var attrError = data_params_object.find('.product-attr-error');
//                    attrError.show();
//                    attrError.find('b').html(text);
                    return false;
                } else
                    data_params_object.find('.product-attr-error').hide();
            }
//
            if (data_params_object.length) {
                data = data_params_object.find('input,select,textarea').serialize();
            }
            jQuery.ajax({
                type: 'get',
                url: '/economy/product/attributeGearSearch',
                data: data,
                dataType: "JSON",
                success: function (res) {
                    if (res.code == '200') {
//                        console.log(res);
                        $('.choice-step-two .container').html(res.html);
                        $('.choice-step-one').hide();
                        $('.choice-step-two').show();
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                    return false;
                }
            });
        }
    }
    function re_search() {
        $('.choice-step-two').hide();
        $('.choice-step-one').show();

    }
</script>

