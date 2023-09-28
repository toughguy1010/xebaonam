<?php if (isset($data) && count($data)) { ?>
    <div class="menu-lever2">
        <div class="panel panel-default categorybox">
            <div class="panel-heading">
                <h3><?php echo $data['category']->cat_name; ?></h3>
            </div>
            <?php 
            if (isset($data['children_category']) && count($data['children_category'])) {
                $children_category = $data['children_category'];
            ?>
            <div class="panel-body">
                <ul class="menu menu-list">
                    <?php foreach( $children_category as $category) { ?>
                        <li> 
                            <a href="<?php echo $category['link'] ?>" title="<?php echo $category['cat_name'] ?>"><?php echo $category['cat_name'] ?></a> 
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>