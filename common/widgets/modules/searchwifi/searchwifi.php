<?php

class searchwifi extends WWidget
{

    protected $view = 'view';
    protected $name = 'searchwifi'; // name of widget
    public $option_product = []; // name of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }

//        $model = new BillingRent();

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));

        if ($viewname != '') {
            $this->view = $viewname;
        }

        $this->option_product = RentProduct::getAllProductNotlimit('id, name');
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'option_product' => $this->option_product,
        ));
    }

}
