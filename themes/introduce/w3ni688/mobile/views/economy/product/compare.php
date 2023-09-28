<?php
if ($model && count($model) > 1) {
    ?>

    <div class = "content clearfix">
        <div class = "page-compare">
            <div class = "container">
                <div class = "title-page-compare">
                    <h1>So sánh <?php if ($model['name'][0]) echo '<span>', $model['name'][0], '</span>'; ?>  <?php if ($model['name'][1]) echo 'và <span>', $model['name'][1], '</span>'; ?></h1>
                </div>
                <div class = "cont">
                    <div class = "box-compare avartar clearfix">
                        <ul class = "clearfix">
                            <li></li>
                            <li><a href = "<?php echo Yii::app()->createUrl('/economy/product/detail', array('id' => $model['id'][0], 'alias' => $model['alias'][0])); ?>" title = "<?php echo $model['name'][0] ?>">
                                    <div class = "box-avatar"><img src="<?php echo ClaHost::getImageHost(), $model['avatar_path'][0], $model['avatar_name'][0] ?>" /></div>
                                    <div class = "box-info-compare">
                                        <p class = "name-product"><?php echo $model['name'][0] ?></p>
                                        <p class = "price-compare"><?php
                                            if ($model['price'][0] && $model['price'][0] != 0) {
                                                echo HtmlFormat::money_format($model['price'][0]), 'Đ';
                                            }
                                            ?></p>

                                    </div>
                                </a></li>
                            <li><a href = "<?php echo Yii::app()->createUrl('/economy/product/detail', array('id' => $model['id'][1], 'alias' => $model['alias'][1])); ?>" title = "<?php echo $model['name'][1]; ?>">
                                    <div class = "box-avatar"><img src = "<?php echo ClaHost::getImageHost(), $model['avatar_path'][1], $model['avatar_name'][1] ?>"></div>
                                    <div class = "box-info-compare">
                                        <p class = "name-product"><?php echo $model['name'][1]; ?></p>
                                        <p class = "price-compare"><?php
                                            if ($model['price'][1] && $model['price'][1] != 0) {
                                                echo HtmlFormat::money_format($model['price'][1]), 'Đ';
                                            }
                                            ?></p>

                                    </div>
                                </a></li>
                        </ul>
                    </div>
                    <?php if (!empty($model['product_sortdesc'][0]) || !empty($model['product_sortdesc'][1])) { ?>
                        <div class = "box-compare sale-compare clearfix">
                            <table class = "table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope = "row"><p>KHUYẾN MÃI</p></th>
                                <td>
                                    <?php echo nl2br($model['product_sortdesc'][0]); ?>
                                </td>
                                <td>
                                    <?php echo nl2br($model['product_sortdesc'][1]); ?>
                                </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php } ?>
                    <?php if (!empty($compare_att)) { ?>
                        <div class = "box-compare clearfix">
                            <h2 class = "title-box-compare">THÔNG SỐ KĨ THUẬT</h2>
                            <table class = "table table-bordered">
                                <tbody>
                                    <?php
                                    foreach ($compare_att as $key => $val) {
                                        ?>
                                        <tr>
                                            <th scope = "row"><?php echo $key ?></th>
                                            <td><?php echo $val[0] ?></td>
                                            <td><?php echo $val[1] ?></td>

                                        </tr>
                                    <?php }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    <?php } ?>


                    <div class = "box-compare image-product clearfix">
                        <table class = "table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope = "row"><p>Hình ảnh nổi bật</p></th>
                            <td>
                                <?php
                                $images = $arr_product[0]->getImages();
                                ?>
                                <?php if ($images && count($images)) { ?>
                                    <?php if ($images && count($images)) { ?>

                                        <div id="slider1_container" style="position: relative; width: 430px;
                                             height: 289px; overflow: hidden;">

                                            <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 430px; height:289px;
                                                 overflow: hidden;">
                                                 <?php foreach ($images as $img) { ?>
                                                    <div>
                                                        <a u=image href="#">
                                                            <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>" />
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div u="navigator" class="jssorb01" style="bottom: 16px; right: 10px;">
                                                <div u="prototype"></div>
                                            </div>
                                            <span u="arrowleft" class="jssora05l" style="top: 123px; left: 8px;">
                                            </span>
                                            <span u="arrowright" class="jssora05r" style="top: 123px; right: 8px;">
                                            </span>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php
                                $images = $arr_product[1]->getImages();
                                ?>
                                <?php if ($images && count($images)) { ?>
                                    <?php if ($images && count($images)) { ?>

                                        <div id = "slider2_container" style = "position: relative; width: 430px;
                                             height: 289px; overflow: hidden;">
                                            <div u = "slides" style = "cursor: move; position: absolute; left: 0px; top: 0px; width: 430px; height:289px;
                                                 overflow: hidden;">
                                                 <?php foreach ($images as $img) { ?>
                                                    <div>
                                                        <a u=image href="#">
                                                            <img src="<?php echo ClaHost::getImageHost() . $img['path'] . 's800_600/' . $img['name']; ?>" />
                                                        </a>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div u="navigator" class="jssorb01" style="bottom: 16px; right: 10px;">
                                                <div u="prototype"></div>
                                            </div>
                                            <span u="arrowleft" class="jssora05l" style="top: 123px; left: 8px;">
                                            </span>
                                            <span u="arrowright" class="jssora05r" style="top: 123px; right: 8px;">
                                            </span>
                                        </div>


                                    <?php } ?>
                                <?php } ?>

                            </td>
                            </tr>
                            </tbody>
                        </table>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php $themUrl = Yii::app()->theme->baseUrl; ?>
    <script type="text/javascript" src="<?= $themUrl ?>/js/jssor.js"></script> 
    <script type="text/javascript" src="<?= $themUrl ?>/js/jssor.slider.js"></script>
    <script>
        jQuery(document).ready(function ($) {
            //Reference http://www.jssor.com/development/slider-with-slideshow-jquery.html
            //Reference http://www.jssor.com/development/tool-slideshow-transition-viewer.html

            var _SlideshowTransitions = [
                //Extrude Replace
                {$Duration: 1600, x: -0.2, $Delay: 40, $Cols: 12, $During: {$Left: [0.4, 0.6]}, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: {$Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad}, $Opacity: 2, $Outside: true, $Round: {$Top: 0.5}, $Brother: {$Duration: 1000, x: 0.2, $Delay: 40, $Cols: 12, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 1028, $Easing: {$Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad}, $Opacity: 2, $Round: {$Top: 0.5}}}
            ];

            var _CaptionTransitions = [
                //B|IB
                {$Duration: 900, y: -0.6, $Easing: {$Top: $JssorEasing$.$EaseInOutBack}, $Opacity: 2},
            ];

            var options = {
                $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $SlideshowOptions: {//[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$, //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions, //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1, //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },
                $CaptionSliderOptions: {//[Optional] Options which specifies how to animate caption
                    $Class: $JssorCaptionSlider$, //[Required] Class to create instance to animate caption
                    $CaptionTransitions: _CaptionTransitions, //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
                    $PlayInMode: 1, //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                    $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
                },
                $BulletNavigatorOptions: {//[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10, //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 10, //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(Math.min(parentWidth, 430));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            //Reference http://www.jssor.com/development/slider-with-slideshow-jquery.html
            //Reference http://www.jssor.com/development/tool-slideshow-transition-viewer.html

            var _SlideshowTransitions = [
                //Extrude Replace
                {$Duration: 1600, x: -0.2, $Delay: 40, $Cols: 12, $During: {$Left: [0.4, 0.6]}, $SlideOut: true, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 260, $Easing: {$Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad}, $Opacity: 2, $Outside: true, $Round: {$Top: 0.5}, $Brother: {$Duration: 1000, x: 0.2, $Delay: 40, $Cols: 12, $Formation: $JssorSlideshowFormations$.$FormationStraight, $Assembly: 1028, $Easing: {$Left: $JssorEasing$.$EaseInOutExpo, $Opacity: $JssorEasing$.$EaseInOutQuad}, $Opacity: 2, $Round: {$Top: 0.5}}}
            ];

            var _CaptionTransitions = [
                //B|IB
                {$Duration: 900, y: -0.6, $Easing: {$Top: $JssorEasing$.$EaseInOutBack}, $Opacity: 2},
            ];

            var options = {
                $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
                $AutoPlayInterval: 4000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, //[Optional] Space between each slide in pixels, default value is 0
                $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $SlideshowOptions: {//[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$, //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions, //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1, //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                },
                $CaptionSliderOptions: {//[Optional] Options which specifies how to animate caption
                    $Class: $JssorCaptionSlider$, //[Required] Class to create instance to animate caption
                    $CaptionTransitions: _CaptionTransitions, //[Required] An array of caption transitions to play caption, see caption transition section at jssor slideshow transition builder
                    $PlayInMode: 1, //[Optional] 0 None (no play), 1 Chain (goes after main slide), 3 Chain Flatten (goes after main slide and flatten all caption animations), default value is 1
                    $PlayOutMode: 3                                 //[Optional] 0 None (no play), 1 Chain (goes before main slide), 3 Chain Flatten (goes before main slide and flatten all caption animations), default value is 1
                },
                $BulletNavigatorOptions: {//[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                    $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 0, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                    $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 10, //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 10, //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                },
                $ArrowNavigatorOptions: {
                    $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider2_container", options);
            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth)
                    jssor_slider1.$ScaleWidth(Math.min(parentWidth, 430));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });
    </script>
    
<?php }
?>
