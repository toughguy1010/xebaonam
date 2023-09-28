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
            <img u="image"  alt="<?php echo $image['name'] ?>" src="<?php echo $pic_src; ?>" alt="<?php echo $pic_text; ?>"/>
        </a>
    </li>
    <?php
}
?>