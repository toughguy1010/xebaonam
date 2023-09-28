<?php if ($show_widget_title) { ?>
    <div class="title">
        <h2>
            <a href="javascript:void(0)"><?php echo $widget_title ?></a>
        </h2>
    </div>
<?php } ?>
<?php if (isset($cars) && count($cars)) { ?>
    <div class="cont">
        <div id="demo">
            <div id="owl-demo" class="owl-carousel">
                <?php foreach ($cars as $car) { ?>
                    <div class="item">
                        <div class="box-img">
                            <a href="<?php echo $car['link'] ?>" title="<?php echo $car['name'] ?>">
                                <img src="<?php echo ClaHost::getImageHost(), $car['avatar_path'], 's200_200/', $car['avatar_name']; ?>" alt="<?php echo $car['name'] ?>" >
                            </a>
                        </div>
                        <div class="box-more">
                            <div class="title-products">
                                <h4><a href="<?php echo $car['link'] ?>" title="<?php echo $car['name'] ?>"><?php echo $car['name'] ?></a></h4>
                            </div>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
