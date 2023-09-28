<?php
$menuTypes = Menus::getMenuTypes();
$selectedType = (isset($info) && isset($info['t'])) ? $info['t'] : false;
?>
<div class="tabbable tabs-left">
    <ul class="nav nav-tabs" id="tabChoiceMenu">
        <?php foreach ($menuTypes as $key => $text) { ?>
            <li class="<?php if ($selectedType == $key || $selectedType === false) {
            echo 'choiced';
        } ?>">
                <a data-toggle="tab" href="#type<?php echo $key; ?>" data-link="<?php echo Yii::app()->createUrl('interface/menu/getmenulink', array('type' => $key)); ?>">
                    <i class="pink icon-bookmark bigger-110"></i>
            <?php echo $text; ?>
                </a>
            </li>
            <?php
            if ($selectedType === false) {
                $selectedType = '';
            }
        }
        ?>
    </ul>

    <div class="tab-content">
<?php foreach ($menuTypes as $key => $text) { ?>
            <div id="type<?php echo $key; ?>" class="tab-pane"></div>
<?php } ?>
    </div>
</div>
<script>
    setTimeout(function () {
        var afirst = jQuery('#tabChoiceMenu li.choiced').find('a');
        afirst.trigger('click');
    }, 100);
    jQuery('#tabChoiceMenu li a').on('click', function () {
        var _this = jQuery(this);
        var _id = _this.attr('href');
        if (!jQuery(_id).html()) {
            var url = _this.attr('data-link');
            if (url) {
                jQuery.ajax({
                    url: url,
                    data: {value:'<?php echo $value; ?>'},
                    type: 'POST',
                    dataType: 'JSON',
                    beforeSend: function () {
                        w3ShowLoading(_this, 'right', 20, 0);
                    },
                    success: function (res) {
                        if (res.code) {
                            if (res.html) {
                                jQuery(_id).html(res.html);
                            }
                        }
                        w3HideLoading();
                    },
                    error: function () {
                        w3HideLoading();
                    }
                });
            }
        }
    });
</script>