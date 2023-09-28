<?php if (count($banners)) {?>
   <?php foreach ($banners as $banner) {?>
    <div class="banner_qc">
        <a <?php echo Banners::getTarget($banner) ?> href="<?php echo $banner['banner_link'] ?>">
            <img src="<?php echo $banner['banner_src'] ?>" alt="<?php echo $banner['banner_name'] ?>">
        </a>
    </div>
<?php }?>

<?php }?>

