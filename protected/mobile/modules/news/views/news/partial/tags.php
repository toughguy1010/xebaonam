<?php if ($data_tags && $data_tags != '') { ?>
    <div class="wrapper-tags clearfix">
        <div class="txt_tag">Tags</div>
        <?php
        $tags = explode(',', $data_tags);
        ?>
        <?php foreach ($tags as $tag) { ?>
            <a class="tag_item" title="<?php echo $tag ?>" href="<?php echo Yii::app()->createUrl('search/search/search', array(ClaSite::SEARCH_KEYWORD => $tag, ClaSite::SEARCH_TYPE => $search_type)); ?>"><?php echo $tag ?></a>
        <?php } ?>
    </div>
<?php } ?>