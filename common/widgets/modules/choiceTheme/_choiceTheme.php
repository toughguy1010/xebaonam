<?php

class choiceTheme extends WWidget
{

    public $themes;
    public $limit = 10;
    public $totalItems = 0;
    public $data = 0;
    protected $name = 'choiceTheme'; // name of widget
    protected $view = 'view'; // view of widget

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $config_choiceTheme = new config_choiceTheme('', array('page_widget_id' => $this->page_widget_id));
        if (isset($config_choiceTheme->limit))
            $this->limit = (int)$config_choiceTheme->limit;
        if ($config_choiceTheme->widget_title)
            $this->widget_title = $config_choiceTheme->widget_title;
        if (isset($config_choiceTheme->show_wiget_title))
            $this->show_widget_title = $config_choiceTheme->show_wiget_title;
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        $cat_id = null;
        $options = array(
            'limit' => $this->limit,
            ClaSite::PAGE_VAR => $page,
            'cat_id' => $cat_id,
        );
        $this->themes = Themes::getThemes($options);
        $this->totalItems = Themes::countThemes($options);

        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_THEME, 'create' => true));
        $this->data = $category->createArrayCategory();

        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
        parent::init();
    }

    public function run()
    {
        $this->render($this->view, array(
            'data' => $this->data,
            'themes' => $this->themes,
            'totalItems' => $this->totalItems,
        ));
    }
}
