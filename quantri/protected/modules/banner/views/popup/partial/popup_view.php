<?php
if (floatval($model->popup_width)) {
    $width = (floatval($model->popup_width) > 200) ? 200 : $model->popup_width;
    $height = $width * (float) $model->popup_height / (floatval($model->popup_width));
} else {
    $width = 200;
    $height = 0;
}
if ($model->popup_type == Banners::BANNER_TYPE_IMAGE) {
    ?>
    <img src="<?php echo $model->popup_src ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php
    }
    if ($width) {
        ?> width="<?php echo $width;?>" <?php } ?> style="max-width: 200px;" />
<?php } else { ?>
    <object <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> >
        <param name="wmode" value="transparent">
        <param name="movie" value="<?php echo $model->popup_src ?>">
        <embed <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> src="<?php echo $model->popup_src ?>" wmode="transparent">
    </object>
<?php } ?>

