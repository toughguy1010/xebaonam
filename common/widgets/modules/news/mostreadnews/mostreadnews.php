<?php

class mostreadnews extends WWidget
{

     public $data;
     public $limit = 5;
     public $totalitem = 0;
     protected $name = 'mostreadnews'; // name of widget
     protected $view = 'view'; // view of widget
     public $category = null;

    /**
     * @author: Hatv
     */
    public function init()
     {
          // set name for widget, default is class name
          if ($this->name == '') {
               $this->name = get_class($this);
          }
          $config_mostreadnews = new config_mostreadnews('', array('page_widget_id' => $this->page_widget_id));
          if (isset($config_mostreadnews->limit))
               $this->limit = (int)$config_mostreadnews->limit;
          if ($config_mostreadnews->widget_title)
               $this->widget_title = $config_mostreadnews->widget_title;
          if (isset($config_mostreadnews->show_wiget_title))
               $this->show_widget_title = $config_mostreadnews->show_wiget_title;

          // get hot news
          $viewname = $this->getViewAlias(array(
               'view' => $this->view,
               'name' => $this->name,
          ));
          if ($viewname != '') {
               $this->view = $viewname;
          }

         // get hot news
         $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
         if (!$page)
             $page = 1;
         //
         // get hot news
         $this->data = News::getAllNews(array(
             'mostread' => true,
             'limit' => $this->limit,
             ClaSite::PAGE_VAR => $page,
         ));
         //
         $this->totalitem = News::getAllNews('',true);

         parent::init();
     }

    public function run() {
        $this->render($this->view, array(
            'data' => $this->data,
            'limit' => $this->limit,
            'totalitem' => $this->totalitem,
        ));
    }

}
