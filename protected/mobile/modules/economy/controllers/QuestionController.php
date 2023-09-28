<?php

class QuestionController extends PublicController {

    public $layout = '//layouts/question';
    public $view_category = 'category';

    /**
     * Index
     */
    public function actionIndex($status = null) {
        $this->breadcrumbs = array(
            Yii::t('question', 'question') => Yii::app()->createUrl('/economy/question'),
        );
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (isset($status) && (int)$status == ActiveRecord::STATUS_QUESTION_NOT_ANSWER) {
            $questions = QuestionAnswer::getAllNews(array('limit' => 8, ClaSite::PAGE_VAR => $page, 'status' => $status));
        } else {
            $questions = QuestionAnswer::getAllNews(array('limit' => 8, ClaSite::PAGE_VAR => $page));
        }
        $this->pageTitle = 'Hỏi đáp về dich vụ và sản phẩm';
        //$this->render('index');
//        $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
//        $themename = Yii::app()->theme->name;
//        $configs = ClaTheme::getThemeConfigFollowPos($sitetypename . '.' . $themename, Widgets::POS_CENTER);
//        $linkkey = ClaSite::getLinkKey();
//        $widgets = isset($configs[$linkkey]) ? $configs[$linkkey] : array();


        $this->render('index', array(
            'questions' => $questions,
        ));
    }

    /**
     * news home
     */
    public function actionHome() {
        $this->breadcrumbs = array(
            Yii::t('question', 'question') => Yii::app()->createUrl('/economy/question'),
        );
        $this->render('home', array());
    }

    /**
     * View news detail
     */
    public function actionDetail($id) {
        //
        $this->layoutForAction = '//layouts/question_detail';
        //
        $question = QuestionAnswer::getQuestionDetaial($id);
        if (!$question || $question['status'] == ActiveRecord::STATUS_DEACTIVED) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        if ($question['site_id'] != $this->site_id)
            $this->sendResponse(404);
        //
        $this->pageTitle = $this->metakeywords = $question['news_title'];
        $this->metadescriptions = $question['question_content'];
        if (isset($question['meta_keywords']) && $question['meta_keywords'])
            $this->metakeywords = $question['meta_keywords'];
        if (isset($question['meta_description']) && $question['meta_description'])
            $this->metadescriptions = $question['meta_description'];
        if (isset($question['meta_title']) && $question['meta_title'])
            $this->metaTitle = $question['meta_title'];
        if ($question['image_path'] && $question['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $question['image_path'] . 's1000_1000/' . $question['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->addMetaTag('article', 'og:type', null, array('property' => 'og:type'));
        //
        $category = NewsCategories::model()->findByPk($question['news_category_id']);

        if ($category) {
            // get product category
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_NEWS, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->saveTrack($question['news_category_id']);

            $track = array_reverse($track);
            //
            foreach ($track as $tr) {
                $item = $categoryClass->getItem($tr);
                if (!$item)
                    continue;
                $this->breadcrumbs[$item['cat_name']] = Yii::app()->createUrl('/news/news/category', array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            //
        }
//        $this->breadcrumbs = array(
//            $category->cat_name => Yii::app()->createUrl('/news/news/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
//        );


        $this->render('detail', array(
            'question' => $question,
            'category' => $category
                )
        );
    }

    /**
     * @hungtm
     * get news ajax
     * joytour
     */
    public function actionCategoryAjax() {
        $id = Yii::app()->request->getParam('id', 0);
        $limit = Yii::app()->request->getParam('limit', 1);
        //
        $category = NewsCategories::model()->findByPk($id);

        if (!$category) {
            $this->sendResponse(404);
        }
        //
        //
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listnews = News::getNewsInCategory($id, array(
                    'limit' => $limit,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        //
        $html = $this->renderPartial('ajax_news_html', array(
            'listnews' => $listnews,
                ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * View follow category
     */
    public function actionSubmit() {
        if (Yii::app()->request->isAjaxRequest) {
            $fielddata = Yii::app()->request->getPost('QuestionAnswer');
            if (count($fielddata)) {
                $model = new QuestionAnswer();
                $model->attributes = $_POST['QuestionAnswer'];
                $model->site_id = $this->site_id;
                $model->user_id = 0;
                $model->created_time = time();
                $model->type = ActiveRecord::TYPE_QUESTION_QUESTION;
                $model->status = ActiveRecord::STATUS_QUESTION_NOT_ANSWER;
                $model->alias = HtmlFormat::parseToAlias(HtmlFormat::subCharacter($fielddata['question_content'], ' ', 20, 0, ''));
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', Yii::t('common', 'sendsuccess'));
                    $this->jsonResponse(200);
                }
            }
        }
    }

}
