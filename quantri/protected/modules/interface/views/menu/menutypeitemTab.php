<?php
$tabKey = ClaGenerate::getUniqueCode();
?>
<div class="box-bookly-staff innerContent1" id="tab<?php echo $tabKey; ?>">
    <script type="text/javascript">
        function mainTab2<?php echo $tabKey; ?>(obj) {
            for (i = 0; i <= 14; i++) {
                $(".shootContent<?php echo $tabKey; ?>" + i).hide();
                $("#shoot<?php echo $tabKey; ?>" + i).removeClass("active");
            }
            $(".shootContent<?php echo $tabKey; ?>" + obj).show();
            $("#shoot<?php echo $tabKey; ?>" + obj).addClass("active");
        };
        var pos = parseInt(jQuery('input[type=radio][name=linkmenu]:checked').closest('.cont-info-staff').data('position'));
        if(pos){
            jQuery('#shoot<?php echo $tabKey; ?>'+pos).trigger('click');
        }
    </script>
    <div class="nav-tab-staff" style="margin-bottom: 15px;">
        <ul class="__MB_NEWS_TAB" style="margin:0px;">
            <?php
            $count = 1;
            $active = 'active';
            foreach ($data as $group => $items) {
                if ($count != 1) {
                    $active = '';
                }
                ?>
                <li class="<?php echo $active; ?>" onclick="mainTab2<?php echo $tabKey; ?>(<?php echo $count; ?>)" id="shoot<?php echo $tabKey; ?><?php echo $count; ?>" style="width: auto;">
                    <a href="javascript:;"> <i class=" icon-info-sign"></i><?php echo $group; ?></a>
                </li>
                <?php
                $count++;
            }
            ?>
        </ul>
    </div>
    <?php
    $count = 1;
    $active = 'active';
    foreach ($data as $group => $items) {
        if ($count != 1) {
            $active = '';
        }
        ?>
        <div class="cont-info-staff shootContent<?php echo $tabKey; ?><?php echo $count; ?> <?php if (!$active) echo 'noDisplay'; ?>" <?php if ($active) { ?> style="display: block;" <?php } ?> data-position="<?php echo $count; ?>">
            <div class="wishlist-table table-responsive">
                <div class="form-horizontal">
                    <?php
                    if ($items) {
                        foreach ($items as $key => $text) {
                            ?>
                            <div class="radio col-xs-6">
                                <label>
                                    <input name="linkmenu" type="radio" class="ace linkmenu" value='<?php echo $key; ?>' <?php if($value==$key) echo 'checked="checked"'; ?>>
                                    <span class="lbl"><?php echo $text; ?></span>
                                </label>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        $count++;
    }
    ?>
</div>