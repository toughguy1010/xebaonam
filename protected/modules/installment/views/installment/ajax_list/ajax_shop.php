<?php if ($list_shop) { ?>
    <h1 class="titleresult">
        <span id="store-title">Có <?= count($list_shop) ?> chi nhánh phù hợp</span>
    </h1>
    <div id="lstShop">
        <ul class="listshop">
            <?php $i=0; foreach ($list_shop as $shop) { $i++;?>
                <li>
                    <h3>
                        <a class="n1 name" href="javascript:void(0)">
                            <label for="st<?=$shop['id']?>">
                                <input id="st<?=$shop['id']?>" type="radio" value="<?=$shop['id']?>" name="InstallmentOrder[shop_id]" <?=($i==1) ? 'checked' : ''?>>
                                <span class="store-address"><?=$shop['name']?></span>
                            </label>

                        </a>
                    </h3>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } else { ?>
    <input type="hidden" value="" name="InstallmentOrder[shop_id]"?>
    <p class="shop_none">Không có chi nhánh nào phù hợp!</p>
<?php } ?>
