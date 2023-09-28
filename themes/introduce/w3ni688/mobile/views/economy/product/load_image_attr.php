<?php $themUrl = Yii::app()->theme->baseUrl; ?>

<?php
$first = reset($images) ? reset($images) : '';
?>
<div class="list-img-detail">
    <ul class="main-img-detail">
        <li>
            <img src="<?php echo ClaHost::getImageHost(), $first['path'], 's500_500/', $first['name'] ?>"
                 class="img-responsive" alt="<?php echo $first['alias'] ?>">
        </li>
        <?php foreach ($images as $key => $image) : ?>
            <li>
                <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's500_500/', $image['name'] ?>"
                     class="img-responsive" alt="<?php echo $first['alias'] ?>">
            </li>
        <?php endforeach ?>
    </ul>
</div>
<div class="list-img-thumbs">
    <ul class="thumbs-img-detail">
        <?php foreach ($images as $key => $image) : ?>
            <li>
                <p>
                    <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's150_150/', $image['name'] ?>"
                         class="img-responsive" alt="<?php echo $first['alias'] ?>">
                </p>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<script type="text/javascript" src="<?= $themUrl ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?= $themUrl ?>/js/slick.min.js"></script>
<script>
    $(document).ready(function () {
        $('.main-img-detail').slick({
            dots: false,
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            asNavFor: '.thumbs-img-detail',
            fade: true,
            arrows: false,
            autoplay: false,

        });
        $('.thumbs-img-detail').slick({
            dots: false,
            infinite: true,
            adaptiveHeight: true,
            centerMode: true,
            slidesToShow: 3,
            asNavFor: '.main-img-detail',
            arrows: false,
            focusOnSelect: true,
            autoplay: false,
        })
    });
</script>
