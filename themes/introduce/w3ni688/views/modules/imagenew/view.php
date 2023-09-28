<?php if (count($images)) { ?>
    <div class="album">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><a href="/album"><?php echo $widget_title ?></a></h2>
            </div>
        <?php } ?>
        <div class="cont">
            <div id="slider3_container" style="position: relative; top: 0px; left: 0px; width: 326px;
                 height: 190px;">
                <!-- Slides Container -->
                <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 326px; height: 190px; overflow: hidden;">
                    <?php foreach ($images as $image) { ?>
                        <div>
                            <a href="<?php echo Yii::app()->createUrl('/media/album/detail', array('id' => $image['album_id'])); ?>">
                                <img u="image"  alt="<?php echo $image['name'] ?>" src="<?php echo ClaHost::getImageHost() . $image['path'] . 's350_350/' . $image['name']; ?>"/>
                            </a>
                            <div u="thumb">
                                <img alt="<?php echo $image['name'] ?>" src="<?php echo ClaHost::getImageHost() . $image['path'] . 's150_150/' . $image['name']; ?>"/>
                            </div>
                        </div>
                    <?php } ?>
                </div>  
                <div u="thumbnavigator" class="jssort12" style="cursor: default; position: absolute; width: 326px; height: 100px; left:0px; bottom: -80px;">

                    <!-- Thumbnail Item Skin Begin -->
                    <style>
                        #slider3_container a{ display:block;}
                        /* jssor slider thumbnail Navigator Skin 12 css */
                        /*
                        .jssort12 .p            (normal)
                        .jssort12 .p:hover      (normal mouseover)
                        .jssort12 .pav          (active)
                        .jssort12 .pav:hover    (active mouseover)
                        .jssort12 .pdn          (mousedown)
                        */
                        .jssort12 .p img {
                            FILTER: alpha(opacity=55);
                            opacity: 1;
                            transition: opacity .6s;
                            -moz-transition: opacity .6s;
                            -webkit-transition: opacity .6s;
                            -o-transition: opacity .6s;
                        }

                        .jssort12 .pav img, .jssort12 .pav:hover img, .jssort12 .p:hover img {
                            FILTER: alpha(opacity=100);
                            opacity: 1;
                            transition: none;
                            -moz-transition: none;
                            -webkit-transition: none;
                            -o-transition: none;
                        }

                        .jssort12 .pav:hover img, .jssort12 .p:hover img {
                            FILTER: alpha(opacity=70);
                            opacity: .7;
                        }

                        .jssort12 .title, .jssort12 .title_back {
                            position: absolute;
                            top: 70px;
                            left: 0px;
                            width: 200px;
                            height: 30px;
                            line-height: 30px;
                            text-align: center;
                            color: #000;
                            font-size: 20px;
                        }

                        .jssort12 .title_back {
                            background-color: #fff;
                            filter: alpha(opacity=50);
                            opacity: .5;
                        }

                        .jssort12 .pav:hover .title_back, .jssort12 .p:hover .title_back {
                            filter: alpha(opacity=40);
                            opacity: .4;
                        }

                        .jssort12 .pav .title_back {
                            background-color: #000;
                            filter: alpha(opacity=50);
                            opacity: .5;
                        }

                        .jssort12 .pav .title {
                            color: #fff;
                        }
                    </style>
                    <div u="slides" style="cursor: move;">
                        <div u="prototype" class=p style="POSITION: absolute; WIDTH: 108px; HEIGHT: 60px; TOP: 0; LEFT: 0;">
                            <div u="thumbnailtemplate" style="WIDTH: 108px; HEIGHT: 60px; border: none; position: absolute; TOP: 0; LEFT: 0; "></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>  


    <script>
        jssor_slider3_starter = function (containerId) {
            var options = {
                $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

                $ThumbnailNavigatorOptions: {
                    $Class: $JssorThumbnailNavigator$, //[Required] Class to create thumbnail navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always

                    $ActionMode: 1, //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
                    $AutoCenter: 3, //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
                    $Lanes: 1, //[Optional] Specify lanes to arrange thumbnails, default value is 1
                    $SpacingX: 0, //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
                    $SpacingY: 0, //[Optional] Vertical space between each thumbnail in pixel, default value is 0
                    $DisplayPieces: 3, //[Optional] Number of pieces to display, default value is 1
                    $ParkingPosition: 0, //[Optional] The offset position to park thumbnail
                    $Orientation: 1, //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
                    $DisableDrag: false                            //[Optional] Disable drag or not, default value is false
                }
            };

            var jssor_slider1 = new $JssorSlider$(containerId, options);
        };
    </script>
    <script>
        jssor_slider3_starter('slider3_container');
    </script>
<?php } ?>
