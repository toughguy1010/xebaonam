<div class="form-horizontal">
    <?php
    $data = isset($data) ? $data : array();
    if ($data) {
        foreach ($data as $group => $items) {
            ?>
            <?php
            if ($group) {
                ?>
                <div class="col-xs-12">
                    <strong class="text"><?php echo $group; ?></strong>
                </div>
            <?php } ?>
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
            <?php
        }
    }
    ?>
</div>