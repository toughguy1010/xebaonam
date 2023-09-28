<?php
if (isset($images) && $images) {
    foreach ($images as $image) {
        ?>
        <div>
            <img src="<?= ClaHost::getImageHost(), $image['path'], 300, $image['name'] ?>" />
        </div>
        <?php
    }
}
?>