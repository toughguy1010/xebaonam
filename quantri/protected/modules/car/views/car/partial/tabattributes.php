<style type="text/css">
    .item-option-attribute{
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ddd;
    }
</style>
<?php
$groups = CarAttributeGroup::getAllGroup();
$dataExist = json_decode($model->data_attributes, true);
?>
<?php foreach ($groups as $group) { ?>
    <div class="well well-lg clearfix">
        <h4 class="blue"><?= $group['name'] ?></h4>
        <?php
        $att_categories = CarAttributeCategory::getAllCatByGroup($group['id']);
        ?>
        <?php foreach ($att_categories as $cat) { ?>
            <div class="col-xs-12">
                <h6><b><?= $cat['name'] ?></b></h6>
                <?php
                $options = CarAttributeCategory::getAllOptions($cat['id']);
                ?>
                <div class="col-xs-12">

                    <?php foreach ($options as $option) { ?>
                        <div class="item-option-attribute col-xs-12">
                            <div class="col-xs-4">
                                <label><?= $option['name'] ?></label>
                            </div>
                            <div class="col-xs-6">
                                <input name="CarAttribute[<?= $option['id'] ?>]" value="<?= isset($dataExist[$option['id']]) ? $dataExist[$option['id']] : '' ?>" type="text" class="form-control" />
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>



