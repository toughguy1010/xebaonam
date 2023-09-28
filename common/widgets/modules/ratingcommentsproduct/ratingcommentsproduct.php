<?php

class ratingcommentsproduct extends WWidget {

    public $data = array();
    public $link = '';
    public $limit = 5;
    protected $view = 'view';
    protected $name = 'ratingcommentsproduct';
    protected $product_id = '';
    protected $product_rating = '';
    protected $show_rating_star = 0;
    protected $show_rating_answer = 0;
    protected $total_votes = '';
    protected $totalitem = 0;
    protected $total_page = 0;
    protected $grouprating = array();
    protected $comment = array();
    protected $linkkey = 'economy/product/detail';

    public function init() {

        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        // Load config
        $ratingcommentprd = new config_ratingcommentsproduct('', array('page_widget_id' => $this->page_widget_id));

        if ($ratingcommentprd) {
            $this->widget_title = $ratingcommentprd->widget_title;
        }
        if ($ratingcommentprd) {
            $this->show_rating_star = $ratingcommentprd->show_rating_star;
        }
        if ($ratingcommentprd) {
            $this->show_rating_answer = $ratingcommentprd->show_rating_answer;
        }
        if ($ratingcommentprd) {
            $this->limit = $ratingcommentprd->limit;
        }
        if (!$this->link)
            $this->link = ClaSite::getFullCurrentUrl();
        // set name for widget, default is class name
        //Get product_id
        if ($this->linkkey == ClaSite::getLinkKey()) {
            $this->product_id = Yii::app()->request->getParam('id');
        }
        //
        if ($this->product_id) {
            $product = Product::model()->findByPk($this->product_id);
            $this->product_rating = (int) $product->product_info['total_rating'];
            $this->total_votes = (int) $product->product_info['total_votes'];
            $this->total_page = ceil($this->total_votes / $this->limit);
            if ($product) {
                $this->comment = ProductRating::getAllCommentRating($this->product_id, array('limit' => $this->limit, '_product_id' => $this->product_id));
                if (count($this->comment)) {
                    $id = array_filter(array_column($this->comment, 'user_id'));
                    //Số lượng vite trên từng điểm
                    $this->grouprating = array();
                    if ($this->show_rating_star) {
                        $this->grouprating = ProductRating::getAllCommentRatingScore($this->product_id);
                    }
                    if (!$this->show_rating_answer) {
                        $project_id = array_filter(array_column($this->comment, 'id'));
                        $rating_answer = CommentAnswer::getAnswerByCommentIds($project_id, CommentAnswer::COMMENT_RATING_ANS);
                        if (count($rating_answer)) {
                            foreach ($this->comment as $key => $each_rating) {
                                foreach ($rating_answer as $key2 => $each_ans) {
                                    if ($each_rating['id'] == $each_ans['comment_id']) {
                                        $this->comment[$key]['rating_answers'][] = $each_ans;
                                        unset($rating_answer[$key2]);
                                    }
                                }
                            }
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
            'product_rating' => $this->product_rating,
            'total_votes' => $this->total_votes,
            'comment' => $this->comment,
            'link' => $this->link,
            'total_page' => $this->total_page,
            'object_id' => $this->product_id,
            'limit' => $this->limit,
            'grouprating' => $this->grouprating,
        ));
    }

}
