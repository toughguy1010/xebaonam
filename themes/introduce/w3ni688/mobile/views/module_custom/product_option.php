<?php if (count($products)) { ?>
    <div class="product-option version">
        <strong class="label">Lựa chọn phiên bản</strong>
        <div class="options" id="versionOption">
            <?php foreach ($products as $pr_) {
                $productModel = Product::model()->findAllByPk($pr_['id']);
                $category_id = $productModel[0]->product_category_id;
                if ($category_id != 39181) {
            ?>
                    <div class="item <?= ($pr_['id'] == $id) ? 'selected' : '' ?>">
                        <a href="<?= $pr_['link'] ?>">
                            <span><label><strong><?= ($pr_['barcode']) ? $pr_['barcode'] : $pr_['code'] ?></strong></label></span>
                            <strong><?php echo number_format($pr_['price']); ?> ₫</strong>
                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
<?php } ?>
<style>
    .text-danger {
        font-size: 18px;
        margin: 15px 0;
    }

    .product-option {
        float: left;
        width: 100%;
    }

    .product-option .label {
        display: block;
        color: #333;
        float: left;
        width: 100%;
        text-align: left;
        font-size: 14px;
        padding: 0;
        margin: 15px 0 10px;
    }

    .product-option .options {
        display: flex;
        flex-wrap: wrap;
        float: left;
        width: 100%;
    }

    .product-option .item {
        display: block;
        width: calc(33.33% - 10px);
        margin-right: 10px;
        margin-bottom: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
        background: #fff;
        position: relative;
    }

    .product-option a,
    .product-option a:link,
    .product-option a:visited {
        text-decoration: none;
        color: #f68a05;
        cursor: pointer;
    }

    .product-option .item span {
        display: flex;
        justify-content: left;
        justify-items: left;
        font-weight: 600;
        max-width: 100%;
        overflow: hidden;
        cursor: pointer;
    }

    .product-option .item span:before {
        content: "";
        display: block;
        min-width: 14px;
        height: 14px;
        border-radius: 14px;
        line-height: 14px;
        text-align: center;
        border: 1px solid #ccc;
        margin-right: 5px;
        margin-top: 2px;
    }

    .product-option .item span label {
        /* white-space: nowrap; */
        flex-basis: 100%;
        margin: 0;
    }

    .product-option .item strong {
        color: #fd475a;
        display: block;
    }

    .product-option .item span label strong {
        color: #333;
        line-height: 17px;
        font-weight: normal;
        cursor: pointer;
    }

    .product-option .selected {
        border: 2px solid #f68a05;
        padding: 4px;
    }

    .product-option .selected span:before {
        display: inline-block;
        font: normal normal normal 14px/12px FontAwesome;
        text-rendering: auto;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        font-size: 8px;
        background: #f68a05;
        color: #fff;
        border-color: #f68a05;
        content: "\f00c";
    }
</style>