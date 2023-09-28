<?php

class commentbox extends WWidget {

    public $data = array();
    public $link = '';
    public $limit = 5;
    public $type = 0;
    public $object_id = null;
    public $view = 'view';
    protected $name = 'commentbox';
    protected $show_rating_star = 0;
    protected $total_votes = '';
    protected $total_comment = 0;
    protected $totalitem = 0;
    protected $total_page = 1;
    protected $comment = array();
    protected $ajaxupload = false;
    public $checkCaptcha = true;

    // List link key init
    public function linkkey() {
        return array(
            Comment::COMMENT_PRODUCT => 'economy/product/detail',
            Comment::COMMENT_NEWS => 'news/news/detail',
            Comment::COMMENT_QUESTION => 'economy/question/detail',
            Comment::COMMENT_CATEGORY_NEWS => 'news/news/category',
            Comment::COMMENT_EVENT => 'economy/event/detail',
            Comment::COMMENT_VIDEO => 'media/video/detail',
            Comment::COMMENT_CATEGORY_VIDEO => 'media/video/category',
            Comment::COMMENT_VIDEO_ALL => 'media/video/all',
            Comment::COMMENT_JOB => 'work/job/detail',
            Comment::COMMENT_COURSE => 'economy/course/detail',
        );
    }

    public function init() {

        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $ratingcommentprd = new config_commentbox('', array('page_widget_id' => $this->page_widget_id));

        if ($ratingcommentprd->widget_title) {
            $this->widget_title = $ratingcommentprd->widget_title;
        }
        if (isset($ratingcommentprd->show_wiget_title)) {
            $this->show_widget_title = $ratingcommentprd->show_wiget_title;
        }
        if ($ratingcommentprd->limit) {
            $this->limit = $ratingcommentprd->limit;
        }
        if (isset($ratingcommentprd->ajaxupload)) {
            $this->ajaxupload = $ratingcommentprd->ajaxupload;
        }
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();

        // set name for widget, default is class name
        if ($this->type && $this->object_id) {
            
        } else if (false !== $key = array_search(ClaSite::getLinkKey(), $this->linkkey())) {
            $this->object_id = Yii::app()->request->getParam('id');
            if (ClaSite::getLinkKey() == Comment::COMMENT_VIDEO_ALL) {
                $this->object_id = 1;
            }
            $this->type = $key;
        }
        //Query All comment
//            $this->registerClientScript();

        $this->comment = Comment::getAllComment($this->type, $this->object_id, array(
                    'limit' => $this->limit,
                    ClaSite::PAGE_VAR => 1,
                    'order' => 'liked DESC,id DESC',
        ));
        if ($this->comment) {
            $this->total_comment = Comment::countCommentInObject($this->type, $this->object_id);
            $this->total_page = ceil($this->total_comment / $this->limit);
        }

        $comment_id = array_filter(array_column($this->comment, 'id'));
        if (count($comment_id)) {

            $rating_answer = CommentAnswer::getAnswerByCommentIds($comment_id, CommentAnswer::COMMENT_ANS);
            if (count($rating_answer)) {
                foreach ($this->comment as $key => $each_rating) {
                    foreach ($rating_answer as $key2 => $each_ans) {
                        if ($each_rating['id'] == $each_ans['comment_id']) {
                            $this->comment[$key]['answers'][] = $each_ans;
                            unset($rating_answer[$key2]);
                        }
                    }
                }
            }
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
        $this->render($this->view, array(
            'total_comment' => $this->total_comment,
            'total_votes' => $this->total_votes,
            'comment' => $this->comment,
            'link' => $this->link,
            'total_page' => $this->total_page,
            'object_id' => $this->object_id,
            'limit' => $this->limit,
            'type' => $this->type,
            'checkCaptcha' => $this->checkCaptcha,
        ));
    }

    //ADD upload ajax
    public function registerClientScript() {
        $client = Yii::app()->clientScript;
        $client->registerScriptFile(Yii::app()->getBaseUrl(true) . '/js/upload/ajaxupload.min.js', CClientScript::POS_END);
    }

}
