<?php

class PostController extends PublicController {

    public $layout = '//layouts/post';

    /**
     * View follow category
     */
    public function actionCategory($id) {
        $category = PostCategories::model()->findByPk($id);
        if (!$category)
            $this->sendResponse(400);
        //
        $this->pageTitle = $category->cat_name;
        $this->metakeywords = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if ($category->meta_keywords)
            $this->metakeywords = $category->meta_keywords;
        if ($category->meta_description)
            $this->metadescriptions = $category->meta_description;
        //
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/content/post/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        //
        $pagesize = Yii::app()->params['defaultPageSize'];
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $posts = Posts::getPostsInCategory($id, array(
                    'limit' => $pagesize,
                    ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = Posts::countPostInCate($id);
        //
        $this->render('category', array(
            'category' => $category,
            'posts' => $posts,
            'limit' => $pagesize,
            'totalitem' => $totalitem,
        ));
    }

    /**
     * View post detail
     */
    public function actionDetail($id) {
        $post = Posts::getPostDetaial($id);
        if (!$post) {
            $this->sendResponse(404);
            Yii::app()->end();
        }
        //
        $this->pageTitle = $post['title'];
        $this->metakeywords = $post['title'];
        $this->metadescriptions = $post['sortdesc'];
        if ($post['meta_keywords'])
            $this->metakeywords = $post['meta_keywords'];
        if ($post['meta_description'])
            $this->metadescriptions = $post['meta_description'];
        //
        $category = PostCategories::model()->findByPk($post['category_id']);
        $this->breadcrumbs = array(
            $category->cat_name => Yii::app()->createUrl('/content/post/category', array('id' => $category->cat_id, 'alias' => $category->alias)),
        );
        $this->render('detail', array('post' => $post));
    }

    /**
     * @Hatv
     * get content post 
     * giavien
     */
    public function actionGetDetailAjax() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->request->getParam('id');
            $model = Posts::model()->findByPk($id);
            $lazyload_html_view = '//content/post/ajax_detail_html';
            if (($lazyFile = $this->getLayoutFile($lazyload_html_view)) === false) {
                $lazyload_html_view = 'ajax_detail_html';
            }
            if (count($model)) {
                $items = $this->renderPartial($lazyload_html_view, array(
                    'model' => $model,
                        ), true);
            }
            $this->jsonResponse(200, array(
                'items' => $items,
            ));
        }
    }

}
