<?php
$themUrl = Yii::app()->theme->baseUrl;
$serviceOptions = array('' => 'Select Service') + SeServices::buildOptions();
?>
<script>
    $(document).ready(function () {
        // The maximum number of options
        var MAX_OPTIONS = 5;
        var max_items = <?php echo ClaService::max_filter_service_length; ?>;
        $(document)
                // Add button click handler
                .on('click', '.addButton', function () {
                    var $template = $('#optionTemplate'),
                            $clone = $template
                            .clone()
                            .removeClass('hide')
                            .removeAttr('id')
                            .insertAfter(jQuery('.item-booking:last'));
                    if ($('#serviceForm .item-booking').length >= max_items) {
                        $(this).addClass('hidden');
                    }
                })

                // Remove button click handler
                .on('click', '.removeButton', function () {
                    var $row = $(this).parents('.item-booking');
                    // Remove element containing the option
                    $row.remove();
                    if ($('#serviceForm .item-booking').length < max_items) {
                        $('.addButton').removeClass('hidden');
                    }
                })

                // Called after adding new field
                .on('added.field.fv', function (e, data) {
                    // data.field   --> The field name
                    // data.element --> The new field element
                    // data.options --> The new field options

                    if (data.field === 'option[]') {
                        if ($('#surveyForm').find(':visible[name="option[]"]').length >= MAX_OPTIONS) {
                            $('#surveyForm').find('.addButton').attr('disabled', 'disabled');
                        }
                    }
                })

                // Called after removing the field
                .on('removed.field.fv', function (e, data) {
                    if (data.field === 'option[]') {
                        if ($('#surveyForm').find(':visible[name="option[]"]').length < MAX_OPTIONS) {
                            $('#surveyForm').find('.addButton').removeAttr('disabled');
                        }
                    }
                });
    });
</script>
<div class="item-booking hide" id="optionTemplate">
    <div class="removeButton">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/remove-service-icon-new.png">
    </div>
    <div class="group-select">
        <?php
        echo CHtml::dropDownList('service_id[]', null, $serviceOptions, array('class' => 'selService'));
        ?>
    </div>
    <div class="group-select">
        <?php
        $providerOptions = array('' => 'Select Provider') + $providersOptions = ClaArray::builOptions(SeProviders::getProviders(), 'id', 'name');
        echo CHtml::dropDownList('provider_id[]', null, $providerOptions, array('class' => 'selProvider'));
        ?>
    </div>
</div>
<form id="serviceForm" method="post" class="form-horizontal" action="<?php echo Yii::app()->createUrl('service/service/filter'); ?>">
    <div class="item-booking">
        <div class="group-select">
            <label>Service(required)</label>
            <?php
            echo CHtml::dropDownList('service_id[]', $service_id, $serviceOptions, array('class' => 'selService'));
            ?>
        </div>
        <div class="group-select">
            <label>Service Provider (optional)</label>
            <?php
            $providerOptions = array('' => 'Select Provider') + $providersOptions = ClaArray::builOptions(SeProviders::getProviders(), 'id', 'name');
            echo CHtml::dropDownList('provider_id[]', $provider_id, $providerOptions, array('class' => 'selProvider'));
            ?>
        </div>
        <div class="group-select box-date">
            <label>Date</label>
            <input type="text" class="form-control" name="date" id="selDate">
        </div>
        <span class="fa fa-calendar"></span>
        <button class="btn-search" id="btnSearch">Search</button>
    </div>
    <div class="add-services addButton">
        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/add-service-icon-new.png"> Add Another service
    </div>
</form>
<div class="infor-booking">
</div>
<div id="Time11h" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    new WOW().init();
    $('.box-date input').datepicker({
        startDate: "dateToday"
    });
    $(document).ready(function () {

    });
</script>
<script type="text/javascript">
<?php if ($service_id) { ?>
        setTimeout(function(){
            jQuery('.selService').trigger('change');
        },200);
<?php } ?>
    jQuery(document).on('click', '.bookTime', function () {
        if (jQuery('#Time11h').html()) {
            var _this = jQuery(this);
            jQuery.ajax({
                url: _this.attr('href'),
                beforeSend: function () {
                    w3ShowLoading(_this, 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == '200') {
                        jQuery('#Time11h .modal-content').html(res);
                    } else if (res.code == '400') {
                        window.location.href = "<?php echo Yii::app()->createUrl('login/login/login'); ?>";
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        }
        return true;
    });
    jQuery(document).on('change', '.selService', function () {
        var _this = jQuery(this);
        jQuery.ajax({
            url: '<?php echo Yii::app()->createUrl('/suggest/suggest/getprovider') ?>',
            data: 'sid=' + _this.val(),
            dataType: 'JSON',
            beforeSend: function () {
                w3ShowLoading(_this, 'right', 20, 0);
            },
            success: function (res) {
                if (res.code == 200) {
                    var seProvider = jQuery(_this).closest('.item-booking').find('.selProvider');
                    var sePval = seProvider.val();
                    seProvider.html(res.html);
                    if (sePval) {
                        seProvider.val(sePval);
                    }
                }
                w3HideLoading();
            },
            error: function () {
                w3HideLoading();
            }
        });
    });
    jQuery(document).on('submit', '#serviceForm', function () {
        var _this = jQuery(this);
        var url = _this.attr('action');
        if (url) {
            jQuery.ajax({
                url: url,
                data: _this.serialize(),
                type: 'POST',
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#btnSearch'), 'right', 20, 0);
                    jQuery('.infor-booking').html('');
                },
                success: function (res) {
                    if (res.code == 200) {
                        jQuery('.infor-booking').html(res.html);
                    } else if (res.code == 202) {
                        if (res.date) {
                            jQuery('#selDate').val(res.date);
                            alert(res.message);
                            jQuery('#btnSearch').trigger('click');
                        }
                    }
                    w3HideLoading();
                },
                error: function () {
                    w3HideLoading();
                }
            });
        }
        return false;
    });
    jQuery(document).on('click', '#btnSearch', function () {
        var form = jQuery('#serviceForm');
        if (validate()) {
            form.submit();
        }
        return false;
    });
    function validate() {
        var validate = true;
        jQuery.each(jQuery('#serviceForm .selService'), function (index, element) {
            if (!jQuery(element).val()) {
                alert('Please select a service');
                validate = false;
                return validate;
            }
        });
        if (validate) {
            jQuery.each(jQuery('#serviceForm .selProvider'), function (index, element) {
                if (jQuery(element).find('option').length <= 1) {
                    var serviceText = jQuery(element).closest('.item-booking').find('.selService option:selected').text();
                    var messTran = '<?php echo Yii::t('service', 'notice_service_empty_provider'); ?>';
                    var mess = messTran.replace('{service}', serviceText);
                    alert(mess);
                    validate = false;
                    return validate;
                }
            });
        }
        return validate;
    }
</script>