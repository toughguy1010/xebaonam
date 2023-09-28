<?php if (count($dataManufacturer)) { ?>
    <?php foreach ($dataManufacturer as $option) { ?>
        <div class="item-mlb">
            <div class="box-img-mlb box-img-center">
                <a href="<?php echo $option['checked'] ? 'javascript:void(0)' : $option['link'] ?>"
                   title="<?php echo $option['name']; ?>">
                    <img class="img-fluid img-center img-zoom"
                         src="<?php echo ClaHost::getImageHost() . $option['image_path'] . 's150_150/' . $option['image_name']; ?>"
                         alt="<?php echo $option['name']; ?>" title="<?php echo $option['name']; ?>">
                </a>
            </div>
        </div>
    <?php } ?>
<?php } ?>
