<?php
if (count($banners)) {
    foreach ($banners as $banner) {
        ?>
                    <img <?php if ($height) { ?> height="<?php echo $height ?>" <?php } if ($width) { ?> width="<?php echo $width; ?>" <?php } ?> src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>">
  <?php
    }
}
