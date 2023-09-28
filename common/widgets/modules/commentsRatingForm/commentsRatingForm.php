<?php

class commentsRatingForm extends WWidget
{

    public $data = array();
    public $link = '';
    public $limit = 5;
    public $assets = '';
    public $view = 'view'; // view of widget
    public $type = 0;
    protected $name = 'commentsRatingForm';
    protected $object_id = '';
    protected $grouprating = '';
    protected $comment = array();
    protected $linkkey = [
        CommentRating::COMMENT_PRODUCT => 'economy/product/detail',
        CommentRating::COMMENT_NEWS => 'news/news/detail',
        CommentRating::COMMENT_COURSE => 'economy/course/detail',
        CommentRating::COMMENT_ADVENTURE => 'economy/advanture/detail',
        CommentRating::COMMENT_TOUR => 'tour/tour/detail',
        CommentRating::COMMENT_HOTEL => 'tour/tourHotel/detailRoom',
    ];
    protected $action = '';

    public function init()
    {
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $ratingcommentprd = new config_commentsRatingForm('', array('page_widget_id' => $this->page_widget_id));
        if ($ratingcommentprd) {
            $this->widget_title = $ratingcommentprd->widget_title;
        }
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        // Set name for widget, default is class name
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->object_id = Yii::app()->request->getParam('id');
        }
        //Get object_id && set name for widget, default is class names
        if (in_array(ClaSite::getLinkKey(), $this->linkkey)) {
            $this->object_id = Yii::app()->request->getParam('id');
            $this->type = array_search(ClaSite::getLinkKey(), $this->linkkey);
            $this->action = Yii::app()->createUrl('economy/commentRating/addrating', array('object_id' => $this->object_id));
        }
        //
        if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_PRODUCT]) {
            $model = Product::model()->findByPk($this->object_id);
        } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_COURSE]) {
            $model = Course::model()->findByPk($this->object_id);
        } else if (ClaSite::getLinkKey() == $this->linkkey[CommentRating::COMMENT_ADVENTURE]) {
            $model = Advanture::model()->findByPk($this->object_id);
        }
        if ($model) {
            $this->grouprating = CommentRating::getAllCommentRatingScore($this->object_id, array(
                'type' => $this->type
            ));
        }
        //
//        $this->comment = CommentRating::getAllCommentRating($this->object_id,
//            array(
//                'limit' => $this->limit,
//                '_object_id' => $this->object_id,
//                'type' => $this->type)
//        );
        //Add rateyo
        $this->registerClientScript();
        $viewname = $this->getViewAlias(array(
            'view' => $this->view,
            'name' => $this->name,
        ));
        if ($viewname != '') {
            $this->view = $viewname;
        }
    }

    public function run()
    {
        $this->render($this->view, array(
            'model' => new CommentRating(),
            'link' => $this->link,
            'action' => $this->action,
            'object_id' => $this->object_id,
            'type' => $this->type,
        ));
    }

    public function registerClientScript()
    {
        $this->assets = $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
        $client = Yii::app()->clientScript;
        $client->registerScriptFile($assets . "/js/jquery.rateyo.min.js", CClientScript::POS_END);
        $client->registerCssFile($assets . "/css/jquery.rateyo.min.css");
    }

}
