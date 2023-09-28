<div  class="col-lg-4 col-md-4 col-sm-4 col-xs-12" id="tours-form">
    <div class="form-search-tour">
        <form action="<?php echo Yii::app()->createUrl('tour/tour') ?>" method="GET">
            <h3>Tìm kiếm tour</h3>
            <p>Hãy tìm những Tour hấp dẫn cho những hành trình khó quên dành cho bạn!</p>
            <?php if (isset($options) && $options) { ?>
                <div class="form-group">
                    <label>Danh mục tour</label>
                    <select name="category_id">
                        <?php foreach ($options as $cat_id => $option) { ?>
                            <option <?= $category_id == $cat_id ? 'selected' : '' ?> value="<?php echo $cat_id ?>"><?php echo $option ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="form-group">
                <label>Tên tuor</label>
                <input type="text" name="name" class="plh-fff" value="<?= $name_filter ?>" />
            </div>
            <div class="form-group">
                <label>Địa điểm</label>
                <input type="text" name="destination" class="plh-fff" value="<?= $destination ?>" />
            </div>
            <div class="form-group input-append date form_datetime">
                <label>Ngày khỏi hành</label>
                <input type="text" name="departure_at" class="plh-fff" value="<?= $departure_at ?>" />
                <i class="fa fa-calendar" aria-hidden="true"></i>
            </div>
            <div class="form-group">
                <?php $prices = Tour::arrayPriceFilter(); ?>
                <label>Giá tour</label>
                <select name="price">
                    <?php foreach ($prices as $value => $price_text) { ?>
                        <option <?= $price == $value ? 'selected' : '' ?> value="<?= $value ?>"><?= $price_text ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="center">
                <input class="hover-mo" type="submit" value="Tìm kiếm">
            </div>
        </form> 
    </div>
</div>