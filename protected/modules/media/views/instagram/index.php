<?php if ($data) { ?>
    <div class="gallery-index">
        <div class="ctn-gallery-instagram">
            <ul class="clearfix">
                <?php
                foreach ($data['data'] as $post) {
                    $pic_text = $post['caption']['text'];
                    $pic_link = $post['link'];
                    $pic_like_count = $post['likes']['count'];
                    $pic_comment_count = $post['comments']['count'];
                    $pic_src = str_replace("http://", "https://", $post['images']['standard_resolution']['url']);
                    $pic_created_time = date("F j, Y", $post['caption']['created_time']);
                    $pic_created_time = date("F j, Y", strtotime($pic_created_time . " +1 days"));
                    ?>
                    <li>
                        <a href="<?php echo $pic_link; ?>" title="<?php echo $pic_text; ?>" target="_blank">
                            <img u="image" alt="<?php echo $image['name'] ?>" src="<?php echo $pic_src; ?>"
                                 alt="<?php echo $pic_text; ?>"/>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <a id="btn-load-more" data-maxid="<?php echo $max_id ?>" href="javascript::void(0)" onclick="loadmore(this)">loadmore</a>
    </div>
<?php } ?>
<!--JS-->
<script type="text/javascript">
    function loadmore(ev) {
        var max_id = $(ev).attr('data-maxid');
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl('/media/instagram/loadmore'); ?>",
            dataType: "json",
            data: {max_id: max_id},
            success: function (msg) {
                if (msg.code = 200) {
                    $('.ctn-gallery-instagram ul').append(msg.html);
                    $('#btn-load-more').attr('data-maxid', msg.max_id);
                    if(!msg.html){
                        $('#btn-load-more').hide();
                    }
                }
            }
        });
    }
</script>
