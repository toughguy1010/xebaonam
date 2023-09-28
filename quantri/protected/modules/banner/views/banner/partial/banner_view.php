<?php
if (floatval($model->banner_width)) {
    $width = (floatval($model->banner_width) > 200) ? 200 : $model->banner_width;
    $height = $width * (float) $model->banner_height / (floatval($model->banner_width));
} else {
    $width = 200;
    $height = 0;
}
if ($model->banner_type == Banners::BANNER_TYPE_IMAGE) {
    ?>
    <img src="<?php echo $model->banner_src ?>" <?php if ($height) { ?> height="<?php echo $height ?>" <?php
    }
    if ($width) {
        ?> width="<?php echo $width;?>" <?php } ?> style="max-width: 200px;" />
<?php } else { ?>
    <object <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> >
        <param name="wmode" value="transparent">
        <param name="movie" value="<?php echo $model->banner_src ?>">
        <embed <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width ?>" <?php } ?> src="<?php echo $model->banner_src ?>" wmode="transparent">
    </object>
<?php } ?>

