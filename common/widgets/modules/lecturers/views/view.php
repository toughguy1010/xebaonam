<?php if ($show_widget_title) { ?>
    <div class="title">
        <h2><a onclick="javascript:void(0)"><?php echo $widget_title ?></a></h2>
        <div class="line"></div>
    </div>
<?php } ?>
<?php if (count($lecturers)) { ?>
    <div class="cont">
        <div id="demo" >
            <div class="row">
                <div class="span12">
                    <div id="owl-demo" class="owl-carousel owl-demo">
                        <?php foreach ($lecturers as $lecturer) { ?>
                            <div class="item ">
                                <div class="box-img">
                                    <div class="bg-img">
                                        <a title="<?php echo $lecturer['name'] ?>" href="<?php echo $lecturer['link'] ?>">
                                            <img src="<?php echo Yii::app()->theme->baseUrl ?>/css/img/bg-img.png">
                                        </a>
                                    </div>
                                    <div class="box-img-cont">
                                        <a title="<?php echo $lecturer['name'] ?>" href="<?php echo $lecturer['link'] ?>">
                                            <img src="<?php echo ClaHost::getImageHost() . $lecturer['avatar_path'] . 's180_180/' . $lecturer['avatar_name']; ?>" alt="#">
                                        </a>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <p class="chucdanh"><?php echo $lecturer['job_title'] ?></p>
                                    <p class="name"><?php echo $lecturer['name'] ?></p>
                                    <p class="company"><?php echo $lecturer['company'] ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

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
            items: 4,
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
