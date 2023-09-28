<?php if (isset($reviews) && $reviews) { ?>
    <div class="cyclo cyclo5 clearfix">
        <div class="container">
            <div class="cyclo-content cyclo5-content clearfix">
                <div class="cyclo5-content1 clearfix">
                    <div id="demo">
                        <div id="owl-demo" class="owl-carousel">
                            <?php foreach($reviews as $review) { ?>
                            <div class="item-cus">
                                <div class="box-opinion clearfix">
                                    <div class="box-img img-opinion">
                                        <a href="javascript:void(0)">
                                            <img src="<?php echo ClaHost::getImageHost(), $review['avatar_path'], $review['avatar_name'] ?>" alt="<?php echo $review['review'] ?>"/>
                                        </a>
                                    </div>
                                    <div class="box-info">
                                        <i class="dgq"></i>
                                        <p class="description clearfix">
                                            <span>
                                                <?php echo $review['review'] ?>
                                            </span>
                                            <i class="mgq"></i>
                                        </p>
                                    </div>
                                    <p class="name-opinion"><?php echo $review['customer_name'] ?></p>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="cyclo5-content2 clearfix">
                    <?php if ($show_widget_title) { ?>
                        <div class="title">
                            <h3><a href="javascript:void(0)" title="<?php echo $widget_title ?>"><?php echo $widget_title ?></a></h3>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="cyclo5_r">

        </div>
        <script>
            $(document).ready(function () {
                var owl = $("#owl-demo");
                owl.owlCarousel({
                    itemsCustom: [
                        [0, 1],
                        [450, 1],
                        [600, 1],
                    ],
                    navigation: true,
                    autoPlay: false,
                });
            });
        </script>
    </div>
<?php } ?>