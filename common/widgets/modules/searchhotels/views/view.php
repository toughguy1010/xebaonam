<section class="booking">
    <article class="search-hotel">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl('tour/tourHotel/search'),
            'method' => 'GET',
            'htmlOptions' => array('class' => 'form-horizontal'),
        ));
        ?>
        <div class="form-group w3-form-group">
            <div class="width-option w3-form-field">
                <i>
                    <input class="form-control w3-form-input input-text " type="text" value="" name="name" id="TourHotel_name" placeholder="Nhập tên khách sạn">
                </i>
            </div>
        </div>

        <div class="form-group w3-form-group option">
            <div class="width-option w3-form-field">
                <select class="form-control" name="province_id" id="TourHotel_province_id">
                    <?php
                    if (isset($listprovince) && count($listprovince)) {
                        foreach ($listprovince as $province_id => $province_name) {
                            ?>
                            <option value="<?php echo $province_id ?>"><?php echo $province_name ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="form-group w3-form-group option">
            <div class="width-option w3-form-field">
                <select class="form-control" name="district_id" id="TourHotel_district_id">
                    <option value=''>Chọn quận huyện</option>
                    <?php
                    if (isset($listdistrict) && count($listdistrict)) {
                        foreach ($listdistrict as $district_id => $district_name) {
                            ?>
                            <option value="<?php echo $district_id ?>"><?php echo $district_name ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="w3-form-group form-group" style="margin-top: 45px;">
            <div class=" col-xs-12 w3-form-button">
                <div class="registered-action1">
                    <button type="submit" class="btn btn-primary" ><span>Tìm kiếm</span></button>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </article>
</section>
<script type="text/javascript">

    jQuery(document).on('change', '#TourHotel_province_id', function () {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getdistrict') ?>',
            data: 'pid=' + jQuery('#TourHotel_province_id').val() + '&allownull=1&filter=1',
            dataType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#TourHotel_district_id').html(res.html);
                }
                getWard();
            },
            error: function () {
            }
        });
    });

    jQuery(document).on('change', '#TourHotel_district_id', function () {
        getWard();
    });

    jQuery(document).on('change', '#TourHotel_ward_id', function () {
        setFilterWard();
    });

    function setFilterWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/setFilterWard') ?>',
            data: 'ward_id=' + jQuery('#TourHotel_ward_id').val() + '&filter=1',
            dateType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
            },
            error: function () {
            }
        });
    }

    function getWard() {
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getward') ?>',
            data: 'did=' + jQuery('#TourHotel_district_id').val() + '&allownull=1&filter=1',
            dataType: 'JSON',
            beforeSend: function () {
            },
            success: function (res) {
                if (res.code == 200) {
                    jQuery('#TourHotel_ward_id').html(res.html);
                }
            },
            error: function () {
            }
        });
    }
</script>