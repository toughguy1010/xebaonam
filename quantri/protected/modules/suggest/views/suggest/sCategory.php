<?php

if ($options) {
    foreach ($options as $key=>$name) {
        ?>
        <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
        <?php
    }
}
?>