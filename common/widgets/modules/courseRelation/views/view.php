<div class="featured-photos list-news-relation">
    <?php if ($show_widget_title) { ?>
        <div class="title">
            <h2><a onclick="javascript:void(0)"><?php echo $widget_title ?></a></h2>
            <div class="line"></div>
        </div>
    <?php } ?>
    <?php if (count($listcourse)) { ?>
        <div class="cont">
            <div id="demo">
                <div class="row">
                    <div class="span12">
                        <div id="owl-demo" class="owl-carousel owl-demo">
                            <?php foreach ($listcourse as $course) { ?>
                                <div class="item ">
                                    <div class="box-img"> 
                                        <a href="<?php echo $course['link'] ?>" title="<?php echo $course['name'] ?>">
                                            <img src="<?php echo ClaHost::getImageHost() . $course['image_path'] . 's160_0/' . $course['image_name'] ?>" alt="<?php echo $course['name'] ?>">
                                        </a> 
                                    </div>
                                    <div class="box-title"> 
                                        <a href="<?php echo $course['link'] ?>" title="<?php echo $course['name'] ?>"><?php echo $course['name'] ?></a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script>
    $(document).ready(function () {

        //Sort random function
        function random(owlSelector) {
            owlSelector.children().sort(function () {
                return Math.round(Math.random()) - 0.5;
            }).each(function () {
                $(this).appendTo(owlSelector);
            });
        }

        $(".owl-demo").owlCarousel({
            navigation: true,
            items: 3,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3],
            autoPlay: true,
            navigationText: [
                "<i class='icon-chevron-left icon-white'></i>",
                "<i class='icon-chevron-right icon-white'></i>"
            ],
            //Call beforeInit callback, elem parameter point to $("#owl-demo")
            beforeInit: function (elem) {
                random(elem);
            }

        });

    });
</script>