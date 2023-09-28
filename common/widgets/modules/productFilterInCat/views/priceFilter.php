<tr>
    <td class="attr-table-title">
        <h4>
            <?php echo Yii::t('product', 'price'); ?>
        </h4>
    </td>
    <td>
        <div class="row">
            <div class="col-xs-12 col-sm-5 priceItem">
                <div class="input-group">
                    <span class="input-group-addon"
                          style="min-width: 60px;"><?php echo Yii::t('common', 'from'); ?></span>
                    <input type="text" class="form-control fi_pmin isnumber priceFormat" name="fi_pmin"
                           value="<?php echo Yii::app()->request->getParam('fi_pmin') ?>"
                           aria-describedby="basic-addon1" autocomplete="false"/>
                </div>
                <div class="text-danger pull-right priceFormat-text" style="display: none"></div>
            </div>
            <div class="col-xs-12 col-sm-5 priceItem">
                <div class="input-group">
                    <span class="input-group-addon"
                          style="min-width: 60px;"><?php echo Yii::t('common', 'to'); ?></span>
                    <input type="text" class="form-control fi_pmax isnumber priceFormat" name="fi_pmax"
                           value="<?php echo (Yii::app()->request->getParam('fi_pmax')) ? (Yii::app()->request->getParam('fi_pmax')) : $highestPrice ?>"
                           aria-describedby="basic-addon1" autocomplete="false"/>
                </div>
                <div class="text-danger pull-right priceFormat-text" style="display: none"></div>
            </div>
            <div class="col-xs-12 col-sm-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="pull-right">
                            <button type="submit" class="btn btn-sm btn-primary"
                                    onclick="var url = '<?php echo $formUrl; ?>';
                                        url = addParamToUrl(url, 'fi_pmin', $(this).closest('.product-filter-box').find('.fi_pmin').val());
                                        url = addParamToUrl(url, 'fi_pmax', $(this).closest('.product-filter-box').find('.fi_pmax').val());
                                        window.location.href = url;
                                        return false;">
                                <?php echo Yii::t('product', 'filter_by_price'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>