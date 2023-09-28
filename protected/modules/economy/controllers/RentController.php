<?php

class RentController extends PublicController
{

    public $layout = '//layouts/rent';

    /**
     * Index
     * Author : Hatv
     */
    public function actionIndex()
    {
        $this->layoutForAction = '//layouts/rent';

        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_RENTAL);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
//
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );
        $claCategory = new ClaCategory(array('create' => true, 'type' => 'rent', 'selectFull' => true));
        $claCategory->application = false;
        $category = $claCategory->getSubCategory(0);

        $model = RentProduct::getAllRentProduct();
        $this->render('index', array(
            'model' => $model,
            'category' => $category,
        ));
    }

    /**
     * Rent detail
     * @author: Hatv
     */
    public function actionDetail($id)
    {
        $this->layoutForAction = '//layouts/rent';
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/detail'),
        );
        //
        $rentProduct = RentProduct::model()->findByPk($id);
        if (!$rentProduct) {
            $this->sendResponse(404);
        }
        if ($rentProduct->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->render('detail', array(
            'model' => $rentProduct,
        ));
    }

    /**
     * Rent detail in Destination
     * @author: Hatv
     */
    public function actionDestination($id)
    {
        $this->layoutForAction = '//layouts/destination';
        //
        $destination = Destinations::model()->findByPk($id);

        if (!$destination) {
            $this->sendResponse(404);
        }
        if ($destination->site_id != $this->site_id) {
            $this->sendResponse(404);
        }

        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
            Yii::t('rent', $destination->name) => Yii::app()->createUrl('/economy/rent/destination', array('alias' => $destination->alias, 'id' => $destination->id)),
        );

        $pagesize = ProductHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listRent = RentProduct::getRentProductInDestination($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RentProduct::countRentProductInCate($id);

        $this->render('destination', array(
            'model' => $destination,
            'totalitem' => $totalitem,
            'listRent' => $listRent,
            'pagesize' => $pagesize,
            'page' => $page,
        ));
    }

    /**
     * Rent detail in Destination
     * @author: Hatv
     */
    public function actionDestinationList()
    {
        $this->layoutForAction = '//layouts/destination_list';
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent/destinationList'),
        );
        //
        $pagesize = ProductHelper::helper()->getPageSize();
        $page = ProductHelper::helper()->getCurrentPage();

        $destinations = Destinations::model()->findAllByAttributes(
            array(
                'site_id' => Yii::app()->siteinfo['site_id']),
            array('limit' => $pagesize * $page)
        );

        $data = [];
        if (count($destinations)) {
            foreach ($destinations as $key => $destination) {
                $data[$destination->id] = $destination->attributes;
                $data[$destination->id]['link'] = Yii::app()->createUrl('/economy/rent/destination', array('id' => $destination->id, 'alias' => $destination->alias));
            }
        }

        $this->render('destination_list', array(
            'data' => $data,
        ));
    }

    /**
     * Rent detail Category
     * @author: Hatv
     */
    public function actionCategory($id)
    {
        $this->layoutForAction = '//layouts/rent_category';
        //
        $category = RentCategories::model()->findByPk($id);
        if (!$category) {
            $this->sendResponse(404);
        }
        if ($category->site_id != $this->site_id) {
            $this->sendResponse(404);
        }
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
            Yii::t('rent', $category->cat_name) => Yii::app()->createUrl('/economy/rent/category', array('alias' => $category->alias, 'id' => $category->cat_id)),
        );

        $pagesize = ProductHelper::helper()->getPageSize();
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        //
        $listRent = RentProduct::getRentProductInCategory($id, array(
            'limit' => $pagesize,
            ClaSite::PAGE_VAR => $page,
        ));
        //
        $totalitem = RentProduct::countRentProductInCate($id);
        //

        $this->render('category', array(
            'model' => $category,
            'totalitem' => $totalitem,
            'listRent' => $listRent,
            'pagesize' => $pagesize,
            'page' => $page,
        ));
    }

    /**
     *
     */
    public function actionRegisRent()
    {
        $this->layoutForAction = '//layouts/rent';
        $this->pageTitle = $this->metakeywords = Yii::t('shoppingcart', 'rentcart');

        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );
        //In Rent
//        $pir_id = Yii::app()->request->getParam('pir_id');
        //In Product In Rent
//        $productInRent = ProductRent::getProductInRent($rent_id, array('pir_id' => $prd_in_rent));
        $shoppingcart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        $usermodel = null;
        if (!Yii::app()->user->isGuest) {
            $usermodel = ClaUser::getUserInfo(Yii::app()->user->id);
        }
        $model = new OrderRent();
        $model->unsetAttributes();
//        $model->rent_id = $rent_id;
//        $model->prd_in_rent = $productInRent['id'];
        $model->email = $usermodel ? $usermodel['email'] : null;
        $model->phone = $usermodel ? $usermodel['phone'] : null;
        $model->address = $usermodel ? $usermodel['address'] : null;
        $model->name = $usermodel ? $usermodel['name'] : null;
        if (isset($_POST['OrderRent']) && $_POST['OrderRent']) {
            $model->attributes = $_POST['OrderRent'];
            if ($model->save()) {
                foreach ($shoppingcart->products as $k => $v) {
                    $order_detail = new OrderRentDetail();
                    $order_detail->order_id = $model->id;
                    $order_detail->rent_id = $v['more']['rid'];
                    $order_detail->product_id = $v['product_id'];
                    $order_detail->quantity = $v['qty'];
                    $order_detail->rent_from = $v['more']['rent_from'];
                    $order_detail->rent_to = $v['more']['rent_to'];
                    $order_detail->product_code = $v['code'];
                    $order_detail->save();
                }
                $mailSetting = MailSettings::model()->findByAttributes(array(
                    'mail_key' => 'rent_mail',
                ));
                if ($mailSetting) {
                    $data = array(
                        'link' => '<a href="' . Yii::app()->request->hostInfo . Yii::app()->createUrl('quantri/economy/productRent/rentrequest') . '">Link' . '</a>'
                    );
//
                    $content = $mailSetting->getMailContent($data);
                    $subject = $mailSetting->getMailSubject($data);
//
                    if ($content && $subject) {
//                        var_dump();die;
                        if (Yii::app()->mailer->send('', Yii::app()->siteinfo['admin_email'], $subject, $content)) {
                            Yii::app()->mailer->send('umove', 'huy.hvd@gmail.com', $subject, $content);
                        }
                    }
                }
                Yii::app()->customer->deleteShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
                $this->redirect(Yii::app()->createUrl('economy/rent/rentsuccess'));
            }
        }
        $this->render('regis_product_rent', array(
            'model' => $model,
            'shoppingcart' => $shoppingcart,
//            'attributes' => $attributesShow,
            'usermodel' => $usermodel ? $usermodel : null
        ));
    }

    /**
     *
     */
    public function actionRentsuccess()
    {
        $this->layoutForAction = '//layouts/rent';
        $this->pageTitle = $this->metakeywords = Yii::t('shoppingcart', 'rentcart');
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );

        $this->render('rent_success');
    }

    /**
     * @param bool $id
     */
    public function actionRentProductDetail($id = false)
    {
        //
        $active_id = '';
        if (isset($id)) {
            $active_id = $id;
        };
        //
        $this->layoutForAction = '//layouts/rent';
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );
        if (Yii::app()->request->isAjaxRequest) {
            //In Rent
            $pir_id = Yii::app()->request->getParam('pir_id');
            //In Product In Rent
            $productInRent = ProductRent::getProductInRent($id, array('pir_id' => $pir_id));
            //Info product
            $product = Product::model()->findByPk($productInRent['product_id']);
            //Get cat => track
            $categoryClass = new ClaCategory(array('type' => ClaCategory::CATEGORY_PRODUCT, 'create' => true));
            $categoryClass->application = 'public';
            $track = $categoryClass->getItem($product->product_category_id);
            if ($track) {
                $attribute_set_id = $track['attribute_set_id'];
            }

            //Get Att
            $attributesShowInSet = ProductAttributeSet::model()->getAttributesBySet($attribute_set_id);
            // hiển thị thêm các thuộc tính hệ thống
            $attributesShow = FilterHelper::helper()->getAttributesSystemFilter(array('isArray' => true));
            if (is_null($attributesShow)) {
                $attributesShow = array();
            }
            $attributesShow = ClaArray::AddArrayToEnd($attributesShow, $attributesShowInSet);
//            $attributes = AttributeHelper::helper()->getDynamicProduct($product, $attributesShow);
            //Render HTML
            $html = $this->renderPartial('ajax_product_rent', array(
                'productInRent' => $productInRent,
                'model' => $product,
                'attributes' => $attributesShow,
            ), true);

            $this->jsonResponse(200, array(
                'html' => $html,
            ));
        } else {
            $aryGroup = ProductRent::getProductGroupAndProduct();
            $this->render('rent_detail', array(
                'data' => $aryGroup,
                'active_id' => $active_id,
            ));
        }
    }

    /**
     * Rent Product
     */
    public function actionRentProduct()
    {
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_RENTAL);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->metaTitle = $seo->meta_title;
        }
//
//
        $this->layoutForAction = '//layouts/rent';
//
        $this->breadcrumbs = array(
            Yii::t('rent', 'rent') => Yii::app()->createUrl('/economy/rent'),
        );

        $aryGroup = ProductRent::getProductGroupAndProduct();
        $this->render('rent', array(
            'data' => $aryGroup,
        ));
    }

    /**
     * Cho thuê đò
     */
    public function actionCalculateCost()
    {
        $product_id = (int)Yii::app()->request->getParam('id');
        $productInRent = (int)Yii::app()->request->getParam('rid');
        $qty = (int)Yii::app()->request->getParam('qty', 1);
        $rentfrom = Yii::app()->request->getParam('rentstart', date('d/m/Y', time()));
        $rentto = Yii::app()->request->getParam('rentend', date('d/m/Y', strtotime('+1 day', time())));
        $rentfrom = strtotime($rentfrom);
        $rentto = strtotime($rentto);
        if (!$product_id) {
            $this->jsonResponse(404);
            Yii::app()->end();
        }
        $returnUrl = Yii::app()->request->getParam('returnUrl');
        $product = Product::model()->findByPk($product_id);
        $key = $product->id;
        $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        //
        $total = 0;
        $days = ceil(abs($rentfrom - $rentto) / 86400);
        if ($days == 0) {
            $days = 1;
        }
        $priceRent = ProductToRent::model()->findByAttributes(array('rent_id' => $productInRent, 'product_id' => $product_id));
        switch ($days) {
            case 1: {
                $total = $priceRent->price_day_1 * $qty;
            }
                break;
            case 2: {
                $total = ($priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
            }
                break;
            case 3: {
                $total = ($priceRent->price_day_3 + $priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
            }
                break;
            default:
                $total = (($priceRent->price_day_3 * ($days - 2)) + $priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
                break;
        }
        //

        $result = HtmlFormat::money_format($total) . ' VND';

        $this->jsonResponse('200', array(
            'html' => $result,
        ));
    }

    /**
     * Delete
     */
    public function actionDelete()
    {
        $key = Yii::app()->request->getParam('key');
//        $key = (is_numeric($key)) ? $key : (int) $key;
        if ($key) {
            $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
            $cartInfo = $shoppingCart->getInfoByKey($key);
            if ($cartInfo && isset($cartInfo['product_id'])) {
                $product = Product::model()->findByPk($cartInfo['product_id']);
                if ($product && $product->site_id == $this->site_id) {
                    $shoppingCart->remove($key);
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                            'total' => Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY)->countProducts(),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('/economy/rent/rentcart'));
                }
            }
        }
        $this->sendResponse(400);
    }

    /**
     *
     */
    public function actionUpdate()
    {
        $key = Yii::app()->request->getParam('key');
        $quantity = (int)Yii::app()->request->getParam('qty');
        if ($quantity <= 0)
            $quantity = 1;
        if ($key && $quantity) {
            $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
            $cartInfo = $shoppingCart->getInfoByKey($key);
            if ($cartInfo && isset($cartInfo['product_id'])) {
                $product = Product::model()->findByPk($cartInfo['product_id']);
                if ($product && $product->site_id == $this->site_id) {
                    $shoppingCart->update($key, array('qty' => $quantity, 'price' => $product->price, 'product_id' => $product['id']));
                    //
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                            'total' => Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY)->countProducts(),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('/economy/rent/rentcart'));
                }
            }
        }

        $this->sendResponse(400);
    }

    /**
     *
     */
    public function actionUpdateRentdate()
    {
        $key = Yii::app()->request->getParam('key');
        $rentfrom = Yii::app()->request->getParam('rentstart', date('d-m-Y', time()));
        $rentto = Yii::app()->request->getParam('rentend', date('d-m-Y', strtotime('+1 day', time())));
        $rentfrom = strtotime($rentfrom);
        $rentto = strtotime($rentto);
        if ($key && $rentfrom && $rentto) {
            $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
            $cartInfo = $shoppingCart->getInfoByKey($key);
            if ($cartInfo && isset($cartInfo['product_id'])) {
                $product = Product::model()->findByPk($cartInfo['product_id']);
                if ($product && $product->site_id == $this->site_id) {
                    $shoppingCart->update($key, array('price' => $product->price, 'product_id' => $product['id'], ClaShoppingCart::MORE_INFO => array(
                        'rent_from' => $rentfrom,
                        'rent_to' => $rentto,
                    )));
                    //
                    if (Yii::app()->request->isAjaxRequest) {
                        $this->jsonResponse('200', array(
                            'message' => 'success',
                            'total' => Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY)->countProducts(),
                        ));
                    } else
                        $this->redirect(Yii::app()->createUrl('/economy/rent/rentcart'));
                }
            }
        }
    }

    /**
     *
     */
    public function actionGetrentcartshort()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        $this->jsonResponse('200', array(
            'html' => $this->renderPartial('rent_cart_short', array('shoppingcart' => $shoppingCart, 'total_price' => $shoppingCart->getTotalPrice(), 'products' => $shoppingCart->getProducts()), true)
        ));
    }

    /**
     *
     */
    public function actionGetrentcartshortindex()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        $html = $this->renderPartial('rent_cart_short_index', array('shoppingcart' => $shoppingCart, 'total_price' => $shoppingCart->getTotalPrice(), 'products' => $shoppingCart->getProducts()), true);
        $this->jsonResponse('200', array(
            'html' => $html
        ));
    }

    /**
     *
     */
    public function actionCart()
    {
        $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        $seo = SiteSeo::getSeoByKey(SiteSeo::KEY_RENTAL);
        if (isset($seo->meta_keywords) && $seo->meta_keywords) {
            $this->metakeywords = $seo->meta_keywords;
        }
        if (isset($seo->meta_description) && $seo->meta_description) {
            $this->metadescriptions = $seo->meta_description;
        }
        if (isset($seo->meta_title) && $seo->meta_title) {
            $this->pageTitle = $this->metaTitle = $seo->meta_title . ' | ' . $this->metakeywords = Yii::t('shoppingcart', 'shoppingcart');
        }
//
        $this->layoutForAction = '//layouts/rent';
        $this->render('rent_cart', array(
            'shoppingCart' => $shoppingCart
        ));
    }

    /**
     * Cho thuê đò
     */
    public function actionRenttocart()
    {
        $product_id = (int)Yii::app()->request->getParam('id');
        $productInRent = (int)Yii::app()->request->getParam('rid');
        $qty = (int)Yii::app()->request->getParam('qty', 1);
        $rentfrom = Yii::app()->request->getParam('rentstart', date('d/m/Y', time()));
        $rentto = Yii::app()->request->getParam('rentend', date('d/m/Y', strtotime('+1 day', time())));
        $rentfrom = strtotime($rentfrom);
        $rentto = strtotime($rentto);
        if (!$product_id) {
            $this->jsonResponse(404);
            Yii::app()->end();
        }
        $returnUrl = Yii::app()->request->getParam('returnUrl');
        $product = Product::model()->findByPk($product_id);
        $key = $product->id;
        $shoppingCart = Yii::app()->customer->getShoppingCart(ClaShoppingCart::PRODUCT_RENT_KEY);
        //
        $total = 0;
        $days = ceil(abs($rentfrom - $rentto) / 86400);
        $priceRent = ProductToRent::model()->findByAttributes(array('rent_id' => $productInRent, 'product_id' => $product_id));
        switch ($days) {
            case 1: {
                $total = $priceRent->price_day_1 * $qty;
            }
                break;
            case 2: {
                $total = ($priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
            }
                break;
            case 3: {
                $total = ($priceRent->price_day_3 + $priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
            }
                break;
            default:
                $total = (($priceRent->price_day_3 * ($days - 2)) + $priceRent->price_day_2 + $priceRent->price_day_1) * $qty;
                break;
        }
        //
        $shoppingCart->add($key, array(
            'product_id' => $product_id,
            'code' => $product->code,
            'qty' => $qty,
            'price' => $total,
            ClaShoppingCart::MORE_INFO => array(
                'rent_from' => $rentfrom,
                'rent_to' => $rentto,
                'rid' => $productInRent
            ),
        ));

        $count = count($shoppingCart->getProducts());
        if (Yii::app()->request->isAjaxRequest) {
            $this->jsonResponse('200', array(
                'qty' => $count
            ));
        } else {
            $this->redirect((isset($returnUrl) && $returnUrl) ? $returnUrl : Yii::app()->createUrl('/economy/rent/rentcart'));
        }
    }


}
