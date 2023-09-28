<?php if (isset($data) && $data) { ?>
    <div class="fl div-menunhieu-<?= $model['cat_id'] ?> parent-id-<?= $model['cat_parent'] ?>"" currentid="<?= $model['cat_id'] ?>">
        <h6><?= $model['cat_name'] ?></h6>
        <select class="menunhieu" multiple="multiple" >
            <?php foreach ($data as $item) { ?>
                <option value="<?= $item['cat_id'] ?>"><?= $item['cat_name'] ?>⇒</option>
            <?php } ?>
        </select>
    </div>
<?php } ?>