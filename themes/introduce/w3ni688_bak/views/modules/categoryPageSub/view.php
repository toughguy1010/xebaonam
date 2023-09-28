<?php
if (isset($data) && count($data)) {
    ?>
    <div class="layout-category-cate">
        <?php
        if (isset($data['children_category']) && count($data['children_category'])) {
            $children_category = $data['children_category'];
            ?>
            <ul class="content-lcc">
                <?php foreach ($children_category as $category) { ?>
                    <li class="<?php echo ($category['active']) ? 'active' : '' ?>">
                        <a href="<?php echo $category['link'] ?>"
                           title="<?php echo $category['cat_name'] ?>"><?php echo $category['cat_name'] ?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
<?php } ?>