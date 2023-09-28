<?php

class productattchangeprice extends WWidget {

    public $product;
    public $attribute_set_id;
    public $selecter_price = '.product-detail .product-price .pricetext'; // theo chuan jQuery
    public $currency_unit = ''; // đơn vị tiền tệ hiển thị chỗ giá
    protected $name = 'productattchangeprice'; // name of widget
    protected $view = 'view'; // view of widget  

    public function init() {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run() {
        if ($this->product && !$this->attribute_set_id) {
            $category = ProductCategories::model()->findByPk($this->product['product_category_id']);
            $this->attribute_set_id = ($category) ? $category->attribute_set_id : 0;
        }
        if ($this->attribute_set_id) {
            $attributes = AttributeHelper::helper()->getChangePriceProduct($this->product['id'],$this->attribute_set_id);
            $this->render($this->view, array(
                'product' => $this->product,
                'selecter_price' => $this->selecter_price,
                'currency_unit' => $this->currency_unit,
                'attributes' => $attributes,
            ));
        }
    }

}
