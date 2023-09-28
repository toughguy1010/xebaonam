<?php $this->beginContent('//layouts/main'); ?>
<?php
$themUrl = Yii::app()->theme->baseUrl;
?>
<div class="xemaydien-landing">
    <div class="section1">
        <div class="img1">
            <img src="<?php echo $themUrl; ?>/images/pic1.png" alt="">
        </div>
        <div class="img2">
            <div class="vertical">
                <div class="middle">
                    <img src="<?php echo $themUrl; ?>/images/text.png" alt="">
                </div>
            </div>
        </div>
        <div class="bg-color"></div>
    </div>
    <div class="section2">
        <div class="img1">
            <img src="<?php echo $themUrl; ?>/images/pic4.png" alt="">
        </div>
        <div class="img2">
            <img src="<?php echo $themUrl; ?>/images/thongso.jpg" alt="">
        </div>
    </div>

    <div class="section3">
        <div class="vector">
            <img src="<?php echo $themUrl; ?>/images/union.png" alt="">
        </div>
        <div class="img1">
            <img src="<?php echo $themUrl; ?>/images/text2.png" alt="">
        </div>
        <div class="img2">
            <img src="<?php echo $themUrl; ?>/images/pic5.png" alt="">
        </div>
    </div>

    <div class="section4">
        <div class="bg-img">
            <img src="<?php echo $themUrl; ?>/images/bg-pic4.png" alt="">
        </div>
        <div class="vector">
            <img src="<?php echo $themUrl; ?>/images/union.png" alt="">
        </div>
        <div class="img1">
            <img src="<?php echo $themUrl; ?>/images/circle1.png" alt="">
        </div>
        <div class="img2">
            <img src="<?php echo $themUrl; ?>/images/text3.png" alt="">
        </div>
    </div>
    <div class="section5">
        <div class="img1">
            <img src="<?php echo $themUrl; ?>/images/section5.jpg" alt="">
        </div>
    </div>
</div>
<div style="display: none">
    <?php
    echo $content;
?>
</div>

<style>
    #main{
        padding-bottom: 0;
    }
    .vertical{
        display: table;
        width: 100%;
            height: 100%;
    }
    .middle{
        display: table-cell;
        vertical-align: middle;
    }
    .xemaydien-landing{
        width: 100%;
        max-width: 1920px;
        margin:  0 auto;
    }
    .section1{
        float: left;
        width: 100%;
        position: relative;
        box-shadow: 0px 12px 11px #a29c9c6b;
        overflow: hidden;
        margin-bottom: 70px;
    }
    .section1 .img1{
        float: left;
        position: relative;
        z-index: 2;
        margin-top: 170px;
        max-width: 80%;
    }
    .section1 .img2 {
        position: absolute;
        right: 0;
        width: 100%;
        height: 100%;
        max-width: 40%;
        z-index: 3;
        text-align: center;
        padding-right: 50px;
        top: -50px;
    }
    .section1 .bg-color{
        position: absolute;
        right: 0;
        background: #9d0000;
        width: 100%;
        height: 100%;
        max-width: 45%;
        z-index: 1;
        top: -50px;
    }

    .section2{
        float: left;
        width: 100%;
        box-shadow: 0px 12px 11px #a29c9c6b;
            background: #fff;
    }
    .section2 .img1{
        float: left;
        width: 62.3%;
    }
    .section2 .img2{
        float: left;
        width: 37.7%;
    }

    .section3{
        float: left;
        width: 100%;
        padding-left: 234px;
        position: relative;
        padding-top: 210px;
            box-shadow: 0px 12px 11px #a29c9c6b;
    }
    .section3 .vector{
        position: absolute;
        width: 100%;
        max-width: 234px;
        bottom: 0px;
        left: 0;
    }
    .section3 .img1{
        float: left;
        width: 60%;
        padding: 0px 60px;
        margin-bottom: 150px;
    }
    .section3 .img2{
        float: left;
        width: 40%;
        overflow: hidden;
    }
    .section3 .img2 img{
            width: 120%;
    max-width: 140%;
    }
    .xemaydien-landing img{
        margin: 0px;
    }
    .section4{
        float: left;
        width: 100%;
        padding-right: 234px;
        position: relative;
        padding-top: 150px;
        box-shadow: 0px 12px 11px #a29c9c6b;
    }
    .section4 .vector{
        position: absolute;
        width: 100%;
        max-width: 234px;
        bottom: 0px;
        right: 0;
    }
    .bg-img{
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        opacity: .5;
        text-align: center;
    }
    .section4 .img2{
        float: left;
        width: 50%;
        padding: 0 60px 0px 20px;
        margin-bottom: 150px;
    }
    .section4 .img1{
        float: left;
        width: 50%;
        overflow: hidden;
        text-align: center;
        margin-bottom: 120px;
    }
    /*.section4 .img2 img{
        width: 120%;
        max-width: 140%;
    }*/
    .section5{
        float: left;
        width: 100%;
        padding: 50px 0 0 0;
        position: relative;
        text-align: center;
        box-shadow: 0px 12px 11px #a29c9c6b;
            background: #fff;
    }
    header {
        margin-bottom: 0;
    }

    @media (max-width: 991px){
        .section3 .vector, .section4 .vector {
            max-width: 125px;
        }
        .section3 {
            padding-left: 125px;
        }
        .section3 .img1 {
            padding: 0px 20px;
        }
        .section4 {
            padding-right: 125px;
        }
        .section4 .img2 {
            padding: 0 20px 0px 20px;
        }
    }

    @media (max-width: 767px){
        .section1 {
            margin-bottom: 30px;
        }
        .section1 .img2 {
            position: relative;
            right: 0;
            width: 100%;
            height: 100%;
            max-width: 100%;
            z-index: 3;
            text-align: center;
            padding-right: 0;
            top: 0;
            padding: 40px 30px;
            text-align: left;
            float: left;

        }
        .section1 .img2 img{
            max-width: 100%;
        }
        .section1 .bg-color {
            position: absolute;
            right: 0;
            background: #9d0000;
            width: 100%;
            height: 100%;
            max-width: 100%;
            z-index: 1;
            top: 0;
        }
        .section1 .img1 {
            float: left;
            position: relative;
            z-index: 2;
            margin-top: 0;
            max-width: 100%;
        }
        .section2 .img1, .section2 .img2 {
            float: left;
            width: 100%;
        }
        
        .section3 .vector, .section4 .vector{
            display: none;
        }
        .section3 {
            padding-left: 0;
            padding-top: 40px;
        }
        .section3 .img1 {
            padding: 0px 20px;
            width: 100%;
            margin-bottom: 30px;
        }
        .section3 .img2 {
            float: left;
            width: 100%;
            overflow: hidden;
            padding-left: 0;
        }
        .section4 {
            padding-right: 0;
            padding-top: 40px;
        }
        .section4 .img1 {
            float: left;
            width: 100%;
            overflow: hidden;
            text-align: center;
            margin-bottom: 50px;
        }
        .section4 .img2 {
            padding: 0 30px 0px 30px;
            width: 100%;
            margin-bottom: 50px;
        }
    }
</style>
<?php $this->endContent(); ?>