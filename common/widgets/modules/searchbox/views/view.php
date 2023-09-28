<div class="searchbox">
    <form method="<?php echo $method; ?>" action="<?php echo $action; ?>" class="searchform">
        <?php if ($showcat) { ?>
            <div class="search-category">
                <div class="search-category-select">
                    <span class="search-category-text">
                        <?php echo Yii::t('common', 'all'); ?>
                    </span>
                    <span class="down-arrow"></span>
                    <?php
                    echo $catOptions;
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="search-inputbox">
            <?php
            if ($this->type) {
                echo CHtml::hiddenField(ClaSite::SEARCH_TYPE, $type);
            }
            ?>
            <div class="search-input-submit">
                <input type="submit" value="<?php echo Yii::t('common', 'common_search'); ?>" class="submitForm"/>
            </div>
            <div class="search-input-content">
                <input type="text" class="form-control inputSearch keyword" name="<?php echo $keyName; ?>" value="<?php echo $keyWord; ?>" placeholder="<?php echo $placeHolder; ?>" autocomplete="off" />
            </div>
        </div>
    </form>
</div>