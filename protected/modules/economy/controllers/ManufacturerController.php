<?php
/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 9/28/2018
 * Time: 4:30 PM
 */


class ManufacturerController extends PublicController
{

    public $layout = '//layouts/manufacturer';
    public $view_category = 'category';
    protected $dataManufacturerChild = [];
    public $parent_child_id = 0;

    public function actionCategory($id)
    {
        $this->layoutForAction = '//layouts/manufacturer';
//
        $category = ManufacturerCategories::model()->findByPk($id);

        if (!$category)
            $this->sendResponse(404);
        if ($category->site_id != $this->site_id)
            $this->sendResponse(404);

        if(isset($category->product_id) && (int)$category->product_id){
                $product = Product::model()->findByPk((int)$category->product_id);
                if($product){
                    $this->redirect(Yii::app()->createUrl('economy/product/detail', array('id' => $product->id, 'alias' => $product->alias,'v'=>'brand')));
                }
        }
        //
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        if ($category['image_path'] && $category['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $category['image_path'] . 's1000_1000/' . $category['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->parent_child_id = Yii::app()->request->getParam('id', 0); //get id
        // check canonical link
        $detailLink = Yii::app()->createAbsoluteUrl('economy/manufacturer/category', array('id' => $category['cat_id'], 'alias' => $category['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false && (Yii::app()->controller->site_id != 1142)) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
// get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
//
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/economy/manufacturer/category', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
//
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = '';
//
        $products = Product::getProductsInManufacturer($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
        ));
//Layout custom
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/product_category';
        }
//
        $this->viewForAction = '//economy/product/' . $category->view_action;
        if (($viewFile = $this->getLayoutFile($this->viewForAction)) === false) {
            $this->viewForAction = $this->view_category;
        }
//
        $totalitem = Product::countProductsInManufacturer($id, $where);
//
        $this->render($this->viewForAction, array(
            'products' => $products,
            'category' => $category->attributes,
            'categoryClass' => $categoryClass,
            'totalitem' => $totalitem,
            'limit' => $pagesize,
        ));
    }
    public function actionCategoryChild($id)
    {
        $this->layoutForAction = '//layouts/manufacturer';
//
        $category = ManufacturerCategories::model()->findByPk($id);

        if (!$category)
            $this->sendResponse(404);
        if ($category->site_id != $this->site_id)
            $this->sendResponse(404);
        $this->metakeywords = $this->metaTitle = $this->pageTitle = $category->cat_name;
        $this->metadescriptions = $category->cat_description;
        if (isset($category->meta_keywords) && $category->meta_keywords) {
            $this->metakeywords = $category->meta_keywords;
        }
        if (isset($category->meta_description) && $category->meta_description) {
            $this->metadescriptions = $category->meta_description;
        }
        if (isset($category->meta_title) && $category->meta_title) {
            $this->metaTitle = $category->meta_title;
        }
        if ($category['image_path'] && $category['image_name']) {
            $this->addMetaTag(ClaHost::getImageHost() . $category['image_path'] . 's1000_1000/' . $category['image_name'], 'og:image', null, array('property' => 'og:image'));
        }
        $this->parent_child_id = Yii::app()->request->getParam('id', 0); //get id
        // check canonical link
        $detailLink = Yii::app()->createAbsoluteUrl('economy/manufacturer/categorychild', array('id' => $category['cat_id'], 'alias' => $category['alias']));
        if (strpos(ClaSite::getFullCurrentUrl(), $detailLink) === false && (Yii::app()->controller->site_id != 1142)) {
            ClaSite::redirect301ToUrl($detailLink);
        }
        // add link canonical
        $this->linkCanonical = $detailLink;
        // get product category
        $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
        $categoryClass->application = 'public';
        $tracks = $categoryClass->getTrackCategory($id);
        //
        foreach ($tracks as $tr) {
            $this->breadcrumbs [$tr['cat_name']] = Yii::app()->createUrl('/economy/manufacturer/categorychild', array('id' => $tr['cat_id'], 'alias' => $tr['alias']));
        }
        $this->layoutForAction = '//layouts/' . $category->layout_action;
        if (($layoutFile = $this->getLayoutFile($this->layoutForAction)) === false) {
            $this->layoutForAction = '//layouts/product_category';
        }
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();
        $order = ProductHelper::helper()->getOrderQuery();
//
        $where = '';

//        $products = ManufacturerCategories::getCategoryByParentChild($this->parent_child_id);
        $products = Product::getProductsInManufacturer($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
            'order' => $order,
            'condition' => $where,
        ));
        $code = "";
        if (Yii::app()->request->getParam('code', 0)) {
            $code = Yii::app()->request->getParam('code', 0);
        }
        $this->dataManufacturerChild = ManufacturerCategories::getCategoryByParentChild($this->parent_child_id, ['code' => $code]);
        $this->render('category_child', array(
            'dataManufacturerChild' => $this->dataManufacturerChild,
            'category' => $category->attributes,
            'categoryClass' => $categoryClass,
            'products' => $products,
        ));
    }

    public function actionGetChildrenCategory()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $cat_parent = Yii::app()->request->getParam('cat_parent', 0);
            $manufacturerCategory = ManufacturerCategories::model()->findByPk($cat_parent);
            $url = '';
            if (isset($manufacturerCategory) && $manufacturerCategory) {
                $url = Yii::app()->createUrl('/economy/manufacturer/category', ['id' => $manufacturerCategory['cat_id'], 'alias' => $manufacturerCategory['alias']]);
            }
            $data = ManufacturerCategories::getCategoryByParent($cat_parent);
            if (isset($data) && $data) {
                $this->jsonResponse(200, [
                    'categories' => $data,
                    'url' => $url
                ]);
            } else {
                $this->jsonResponse(200, [
                    'categories' => [],
                    'url' => $url
                ]);
            }
        }
    }

}