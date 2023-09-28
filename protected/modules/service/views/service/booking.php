<!-- Modal content-->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Confirm Appointment</h4>
</div>
<div class="modal-body">
    <h2><strong><?php echo Yii::app()->siteinfo['site_title']; ?></strong></h2>
    <?php
    $data = isset($data) ? $data : array();
    foreach ($data as $info) {
        ?>
        <div class="cont-order">
            <p style="width:100%;">
                Date: <span><?php echo date('l, M-d-Y', $info['date']); ?></span>
            </p>
            <div class="group-p">
                <p>
                    Service: <span><?php echo $info['service']['name']; ?></span>
                </p>
                <p>
                    Time: <span> <?php echo gmdate('g:i A', $info['start_time']); ?></span>
                </p>
            </div>
            <div class="group-p">
                <p>
                    Provider: <span><?php echo $info['provider']['name']; ?></span>
                </p>
                <?php if ($info['providerService']['price'] > 0) { ?>
                    <p>
                        *Price: <span>$<?php echo HtmlFormat::money_format($info['providerService']['price']); ?></span>
                    </p>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="comment-customer">
        <label>Comment:</label>
        <textarea name="note"></textarea>
    </div>
    <div class="note">
        <label>* Prices and Duration are starting point quotes.</label>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-login" href="<?php
    echo Yii::app()->createUrl('service/service/booking', array(
        'service_id' => $service_id,
        'provider_id' => $provider_id,
        'key' => $key,
        'date' => $date,
        'start_time' => $start_time,
        'type' => 'book',
    ))
    ?>" id="btnBooking">Book</button>
    <button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
</div>
<script type="text/javascript">
    jQuery(document).on('click', '#btnBooking', function () {
        var _this = jQuery(this);
        if (jQuery(_this).hasClass('disable')) {
            return false;
        }
        jQuery(_this).addClass('disable');
        var url = _this.attr('href');
        if (url) {
            jQuery.ajax({
                url: url,
                method: 'post',
                data: _this.closest('.modal-content').find('select, textarea, input').serialize(),
                dataType: 'JSON',
                beforeSend: function () {
                    w3ShowLoading(jQuery('#btnSearch'), 'right', 20, 0);
                },
                success: function (res) {
                    if (res.code == 200) {
                        if (res.message) {
                            alert(res.message);
                        }
                        jQuery(_this).closest('li').remove();
                    } else {
                        jQuery(_this).removeClass('disable');
                        if (res.message) {
                            alert(res.message);
                        }
                    }
                    window.location.href = window.location.href;
                    w3HideLoading();
                },
                error: function () {
                    jQuery(_this).removeClass('disable');
                    w3HideLoading();
                }
            });
        }
        return false;
    });
</script>