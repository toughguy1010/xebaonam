<?php

class ClaBuild {

    static function generatesql($site_id = '') {
//        ini_set('display_errors', 1);
//        error_reporting(E_ALL);
        // sql
        $sql = '';
        // mảng lưu trữ các biến và map giữa các biến trong php và mysql
        $store = array();
        //
        if (!$site_id) {
            $site_id = Yii::app()->controller->site_id;
        }
        //
        $siteInfo = ClaSite::getSiteInfo($site_id);
        $sql .= "UPDATE " . Yii::app()->params['tables']['site']
            . " SET site_logo=" . ClaGenerate::quoteValue($siteInfo['site_logo'])
            . ",avatar_path=" . ClaGenerate::quoteValue($siteInfo['avatar_path'])
            . ",avatar_name=" . ClaGenerate::quoteValue($siteInfo['avatar_name'])
            . ",language=" . ClaGenerate::quoteValue($siteInfo['language'])
            . ",admin_language=" . ClaGenerate::quoteValue($siteInfo['admin_language'])
            . ",footercontent=" . ClaGenerate::quoteValue($siteInfo['footercontent'])
            . ",contact=" . ClaGenerate::quoteValue($siteInfo['contact'])
            . ",admin_default=" . ClaGenerate::quoteValue($siteInfo['admin_default'])
            . ",pagesize=" . (int) $siteInfo['pagesize']
            . ",percent_vat=" . (int) $siteInfo['percent_vat']
            . ",dealers_discount=" . (int) $siteInfo['dealers_discount']
            . ",multi_store=" . (int) $siteInfo['multi_store']
            . ",store_default=" . (int) $siteInfo['store_default']
            . ",load_main_css=" . (int) $siteInfo['load_main_css']
            . ",se_settings=" . (int) $siteInfo['se_settings']
            . ",phone=" . ClaGenerate::quoteValue($siteInfo['phone'])
            . ",address=" . ClaGenerate::quoteValue($siteInfo['address'])
            . " WHERE site_id=[site_id];" . "\n\n";
        // Lấy giới thiệu website
        $introduce = SiteIntroduces::getIntroduce();
        if ($introduce && count($introduce)) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['site_introduce'] . " (site_id,user_id, title, sortdesc, description, image_path, image_name, meta_keywords, meta_description, meta_title, `history`, created_time, modified_time) "
                . "VALUES ([site_id],[user_id]," . ClaGenerate::quoteValue($introduce['title']) . ',' . ClaGenerate::quoteValue($introduce['sortdesc']) . ',' . ClaGenerate::quoteValue($introduce['description'])
                . ',' . ClaGenerate::quoteValue($introduce['image_path']) . ',' . ClaGenerate::quoteValue($introduce['image_name']) . ',' . ClaGenerate::quoteValue($introduce['meta_keywords'])
                . ',' . ClaGenerate::quoteValue($introduce['meta_description']) . ',' . ClaGenerate::quoteValue($introduce['meta_title']) . ',' . ClaGenerate::quoteValue($introduce['history'])
                . ',[now],[now]);';
            //
            $sql .= "\n\n";
        }
        //
        //Lấy hỗ trợ trực tuyến của site
        $support = SiteSupport::model()->findByPk($site_id);
        if ($support) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['site_support'] . " (site_id,user_id,`data`, created_time, modified_time) "
                . "VALUES ([site_id],[user_id]," . ClaGenerate::quoteValue($support['data']) . ',[now],[now]);';
            //
            $sql .= "\n\n";
        }
        //
        //Lấy bản đồ
        $maps = Maps::getMaps(array('limit' => 100));
        if ($maps && count($maps)) {
            foreach ($maps as $map) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['map'] . " (id,site_id, user_id, latlng, `name`, address, email, phone, website, headoffice, `order`, created_time, modified_time) ";
                $sql .= "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($map['latlng']) . ',' . ClaGenerate::quoteValue($map['name']) . ',' . ClaGenerate::quoteValue($map['address']) . ','
                    . ClaGenerate::quoteValue($map['email']) . ',' . ClaGenerate::quoteValue($map['phone']) . ',' . ClaGenerate::quoteValue($map['website']) . ',' . $map['headoffice'] . ',' . $map['order']
                    . ",[now],[now]);" . "\n";
                //$sql.= "set @" . Yii::app()->params['tables']['map'] . $map['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                //$store[Yii::app()->params['tables']['map']][$map['id']]['map'] = Yii::app()->params['tables']['map'] . $map['id'];
            }
            $sql .= "\n\n";
        }
        // Lấy baner group -> Và tạo ra bannder group
        $bannergroups = Banners::getAllBannerGroup();
        foreach ($bannergroups as $bg) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['banner_group'] . ' (banner_group_id, banner_group_name, banner_group_description, site_id, user_id, width, height, created_time) ' . " VALUES (null, " . ClaGenerate::quoteValue($bg['banner_group_name']) . ", " . ClaGenerate::quoteValue($bg['banner_group_description']) . ", '[site_id]', '[user_id]', '" . $bg['width'] . "', '" . $bg['height'] . "', '[now]');" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['banner_group'] . $bg['banner_group_id'] . " = LAST_INSERT_ID();" . "\n";
            $store[Yii::app()->params['tables']['banner_group']][$bg['banner_group_id']]['map'] = Yii::app()->params['tables']['banner_group'] . $bg['banner_group_id'];
        }
        $sql .= "\n\n";
        //Lấy banner
        $banners = Banners::getAllBanner();
        $bannercount = count($banners);
        if ($banners && $bannercount) {
            $i = 0;
            foreach ($banners as $banner) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['banner'] . " (banner_id, site_id, banner_group_id, banner_name, banner_description, banner_src, banner_width, banner_height, banner_link, banner_type, banner_order, banner_rules, banner_target, created_time, banner_showall) VALUES ";
                $sql .= "(null, [site_id]," . (isset($store[Yii::app()->params['tables']['banner_group']][$banner['banner_group_id']]['map']) ? "@" . $store[Yii::app()->params['tables']['banner_group']][$banner['banner_group_id']]['map'] : 0)
                    . ", " . ClaGenerate::quoteValue($banner['banner_name']) . "," . ClaGenerate::quoteValue($banner['banner_description']) . "," . ClaGenerate::quoteValue($banner['banner_src'])
                    . "," . $banner['banner_width'] . "," . $banner['banner_height'] . "," . ClaGenerate::quoteValue($banner['banner_link']) . "," . $banner['banner_type'] . "," . $banner['banner_order']
                    . "," . ClaGenerate::quoteValue($banner['banner_rules']) . "," . $banner['banner_target'] . ",[now]," . $banner['banner_showall']
                    . ");"
                    . "\n";
                //
                $sql .= "set @" . Yii::app()->params['tables']['banner'] . $banner['banner_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['banner']][$banner['banner_id']]['map'] = Yii::app()->params['tables']['banner'] . $banner['banner_id'];
            }
            $sql .= "\n\n";
        }
        // Banner partial
        $bannerPartials = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('banner_partial'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($bannerPartials && count($bannerPartials)) {
            foreach ($bannerPartials as $bannerP) {
                if (!isset($store[Yii::app()->params['tables']['banner']][$bannerP['banner_id']]['map']))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['banner_partial'] . " (`id`, `site_id`, `banner_id`, `name`, `path`, `created_time`, `modified_time`, `resizes`, `height`, `width`, `position`) VALUES ";
                $sql .= "(null, [site_id]," . "@" . $store[Yii::app()->params['tables']['banner']][$bannerP['banner_id']]['map']
                    . ", " . ClaGenerate::quoteValue($bannerP['name']) . "," . ClaGenerate::quoteValue($bannerP['path']) . ",[now],[now]," . ClaGenerate::quoteValue($bannerP['resizes'])
                    . "," . $bannerP['height'] . "," . $bannerP['width'] . "," . $bannerP['position']
                    . ");"
                    . "\n";
                //
            }
            $sql .= "\n\n";
        }
        //
        //Lấy danh mục tin tức
        $newscategories = NewsCategories::getAllCategory();
        foreach ($newscategories as $nc) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['newcategory'] . " (cat_id, site_id, user_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, layout_action, view_action) "
                . "VALUES (null,[site_id],[user_id]," . (isset($store[Yii::app()->params['tables']['newcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['newcategory']][$nc['cat_parent']]['map'] : 0)
                . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path'])
                . "," . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . "," . ClaGenerate::quoteValue($nc['meta_title'])
                . "," . ClaGenerate::quoteValue($nc['layout_action']) . "," . ClaGenerate::quoteValue($nc['view_action'])
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['newcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['newcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['newcategory'] . $nc['cat_id'];
        }
        //
        //Tin tức
        $news = News::getAllNews(array('limit' => 1000, 'full' => true, 'nl2br' => false));
        if ($news) {
            foreach ($news as $ne) {
                //process list store id
                $storeIds = $ne['store_ids'];
                $storeIdsTrack = array();
                if ($storeIds != '' && $storeIds != 'Array') {
                    $storeIds_temp = explode(' ', $storeIds);
                    if ($storeIds_temp) {
                        foreach ($storeIds_temp as $store_id)
                            if (isset($store[Yii::app()->params['tables']['shop_store']][$store_id])) {
                                array_push($storeIdsTrack, '@' . $store[Yii::app()->params['tables']['shop_store']][$store_id]['map']);
                            }
                    }
                }
                $storeIdsTrack = implode(",' ',", $storeIdsTrack);
                if ($storeIdsTrack != '')
                    $storeIdsTrack = "CONCAT(" . $storeIdsTrack . ")";
                else
                    $storeIdsTrack = ClaGenerate::quoteValue($storeIdsTrack);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['news'] . " (news_id, news_category_id, news_title, news_sortdesc, news_desc, `alias`, `status`, meta_keywords, meta_description, site_id, user_id, image_path, image_name, created_time, modified_time, modified_by, news_hot, news_source, poster, publicdate, `store_ids`) ";
                $sql .= "VALUES (null," . (isset($store[Yii::app()->params['tables']['newcategory']][$ne['news_category_id']]) ? '@' . $store[Yii::app()->params['tables']['newcategory']][$ne['news_category_id']]['map'] : 0) . "," . ClaGenerate::quoteValue($ne['news_title'])
                    . "," . ClaGenerate::quoteValue($ne['news_sortdesc']) . "," . ClaGenerate::quoteValue($ne['news_desc'])
                    . "," . ClaGenerate::quoteValue($ne['alias']) . "," . $ne['status'] . "," . ClaGenerate::quoteValue($ne['meta_keywords']) . "," . ClaGenerate::quoteValue($ne['meta_description'])
                    . ",[site_id],[user_id]," . ClaGenerate::quoteValue($ne['image_path']) . "," . ClaGenerate::quoteValue($ne['image_name']) . ",[now], [now],[user_id],"
                    . $ne['news_hot'] . "," . ClaGenerate::quoteValue($ne['news_source']) . "," . ClaGenerate::quoteValue($ne['poster']) . ",[now]," . $storeIdsTrack
                    . ");";
                $sql .= "set @" . Yii::app()->params['tables']['news'] . $ne['news_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['news']][$ne['news_id']]['map'] = Yii::app()->params['tables']['news'] . $ne['news_id'];
            }
            $sql .= "\n\n";
        }
        //
        // Lấy danh mục bài viết
        $postscategories = PostCategories::getAllCategory();
        foreach ($postscategories as $nc) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['postcategory'] . " (cat_id, site_id, user_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title,`layout_action`, `view_action`) "
                . "VALUES (null,[site_id],[user_id]," . (isset($store[Yii::app()->params['tables']['postcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['postcategory']][$nc['cat_parent']]['map'] : 0)
                . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path'])
                . "," . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now],[now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . "," . ClaGenerate::quoteValue($nc['meta_title'])
                . "," . ClaGenerate::quoteValue($nc['layout_action']) . "," . ClaGenerate::quoteValue($nc['view_action'])
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['postcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['postcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['postcategory'] . $nc['cat_id'];
        }
        // Lấy bài viết
        $news = Posts::getAllPosts(array('limit' => 1000));
        if ($news) {
            foreach ($news as $ne) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['post'] . " (id, category_id, title, sortdesc, description, `alias`, `status`, meta_keywords, meta_description, site_id, user_id, image_path, image_name, created_time, modified_time, modified_by, publicdate, ishot, isnew) ";
                $sql .= "VALUES (null," . (isset($store[Yii::app()->params['tables']['postcategory']][$ne['category_id']]) ? '@' . $store[Yii::app()->params['tables']['postcategory']][$ne['category_id']]['map'] : 0) . "," . ClaGenerate::quoteValue($ne['title'])
                    . "," . ClaGenerate::quoteValue($ne['sortdesc']) . "," . ClaGenerate::quoteValue($ne['description'])
                    . "," . ClaGenerate::quoteValue($ne['alias']) . "," . $ne['status'] . "," . ClaGenerate::quoteValue($ne['meta_keywords']) . "," . ClaGenerate::quoteValue($ne['meta_description'])
                    . ",[site_id],[user_id]," . ClaGenerate::quoteValue($ne['image_path']) . "," . ClaGenerate::quoteValue($ne['image_name']) . ",[now], [now],[user_id],"
                    . "[now]," . $ne['ishot'] . "," . $ne['isnew']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['post'] . $ne['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['post']][$ne['id']]['map'] = Yii::app()->params['tables']['post'] . $ne['id'];
            }
            $sql .= "\n\n";
        }
        //
        // --------------------------------------------------- Shop - Gian hang -----------------------------------------------------------------
        // shop
        $shop = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($shop) {
            foreach ($shop as $sho) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['shop'] . " (`id`, `user_id`, `name`, `alias`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `image_path`, `image_name`, `avatar_path`, `avatar_name`, `phone`, `email`, `yahoo`, `skype`, `website`, `facebook`, `instagram`, `pinterest`, `twitter`, `field_business`, `status`, `created_time`, `modified_time`, `site_id`, `allow_number_cat`, `description`, `meta_keywords`, `meta_description`, `meta_title`, `avatar_id`, `time_open`, `time_close`, `day_open`, `day_close`, `type_sell`, `like`, `policy`, `contact`) "
                    . "VALUES (null,[user_id]"
                    . "," . ClaGenerate::quoteValue($sho['name']) . "," . ClaGenerate::quoteValue($sho['alias'])
                    . "," . ClaGenerate::quoteValue($sho['address']) . "," . ClaGenerate::quoteValue($sho['province_id'])
                    . "," . ClaGenerate::quoteValue($sho['province_name']) . "," . ClaGenerate::quoteValue($sho['district_id'])
                    . "," . ClaGenerate::quoteValue($sho['district_name']) . "," . ClaGenerate::quoteValue($sho['ward_id'])
                    . "," . ClaGenerate::quoteValue($sho['ward_name']) . "," . ClaGenerate::quoteValue($sho['image_path'])
                    . "," . ClaGenerate::quoteValue($sho['image_name']) . "," . ClaGenerate::quoteValue($sho['avatar_path'])
                    . "," . ClaGenerate::quoteValue($sho['avatar_name']) . "," . ClaGenerate::quoteValue($sho['phone'])
                    . "," . ClaGenerate::quoteValue($sho['email']) . "," . ClaGenerate::quoteValue($sho['yahoo'])
                    . "," . ClaGenerate::quoteValue($sho['skype']) . "," . ClaGenerate::quoteValue($sho['website'])
                    . "," . ClaGenerate::quoteValue($sho['facebook']) . "," . ClaGenerate::quoteValue($sho['instagram'])
                    . "," . ClaGenerate::quoteValue($sho['pinterest']) . "," . ClaGenerate::quoteValue($sho['twitter'])
                    . "," . ClaGenerate::quoteValue($sho['field_business']) . "," . (int) $sho['status'] . ",[now],[now],[site_id]" . "," . (int) $sho['allow_number_cat']
                    . "," . ClaGenerate::quoteValue($sho['description']) . "," . ClaGenerate::quoteValue($sho['meta_keywords'])
                    . "," . ClaGenerate::quoteValue($sho['meta_description']) . "," . ClaGenerate::quoteValue($sho['meta_title'])
                    . ",0," . (int) $sho['time_open'] . "," . (int) $sho['time_close'] . "," . (int) $sho['day_open'] . "," . (int) $sho['day_close'] . "," . (int) $sho['type_sell'] . "," . (int) $sho['like']
                    . "," . ClaGenerate::quoteValue($sho['policy']) . "," . ClaGenerate::quoteValue($sho['contact'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['shop'] . $sho['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['shop']][$sho['id']]['map'] = Yii::app()->params['tables']['shop'] . $sho['id'];
            }
            $sql .= "\n\n";
            //
            // shop_images
            $shop_images = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop_images'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($shop_images) {
                foreach ($shop_images as $si) {
                    if (!isset($store[Yii::app()->params['tables']['shop']][$si['shop_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['shop_images'] . " (`img_id`, `shop_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`) "
                        . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['shop']][$si['shop_id']]['map'] . "," . ClaGenerate::quoteValue($si['name']) . "," . ClaGenerate::quoteValue($si['path'])
                        . "," . ClaGenerate::quoteValue($si['display_name']) . "," . ClaGenerate::quoteValue($si['description'])
                        . "," . ClaGenerate::quoteValue($si['alias']) . ",[site_id],[user_id]," . $si['height'] . "," . $si['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($si['resizes']) . "," . $si['order']
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['shop_images'] . $si['img_id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['shop_images']][$si['img_id']]['map'] = Yii::app()->params['tables']['shop_images'] . $si['img_id'];
                }
                $sql .= "\n";
                // Update avatar_id for shop
                foreach ($shop as $sho) {
                    if (!isset($store[Yii::app()->params['tables']['shop_images']][$sho['avatar_id']]))
                        continue;
                    $sql .= "UPDATE " . Yii::app()->params['tables']['shop'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['shop_images']][$sho['avatar_id']]['map']
                        . " WHERE id=@" . $store[Yii::app()->params['tables']['shop']][$sho['id']]['map'] . ";\n";
                }
                //
                $sql .= "\n\n";
                //
            }
            //
            // shop_product_category
            $shop_product_category = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop_product_category'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($shop_product_category) {
                foreach ($shop_product_category as $spc) {
                    if (!isset($store[Yii::app()->params['tables']['shop']][$spc['shop_id']]) || !isset($store[Yii::app()->params['tables']['productcategory']][$spc['cat_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['shop_product_category'] . " (`id`, `shop_id`, `cat_id`, `site_id`) "
                        . "VALUES (null"
                        . "," . '@' . $store[Yii::app()->params['tables']['shop']][$spc['shop_id']]['map']
                        . "," . '@' . $store[Yii::app()->params['tables']['productcategory']][$spc['cat_id']]['map']
                        . ",[site_id]"
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
            //
        }
        // shop_store
        $shop_store = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop_store'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($shop_store) {
            foreach ($shop_store as $ss) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['shop_store'] . " (`id`, `name`, `status`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `hotline`, `phone`, `email`, `hours`, `avatar_path`, `avatar_name`, `created_time`, `modified_time`, `site_id`, `shop_id`, `latlng`, `group`, `order`, `meta_title`, `meta_keywords`,`meta_description`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($ss['name']) . "," . (int) $ss['status'] . "," . ClaGenerate::quoteValue($ss['address'])
                    . "," . ClaGenerate::quoteValue($ss['province_id']) . "," . ClaGenerate::quoteValue($ss['province_name'])
                    . "," . ClaGenerate::quoteValue($ss['district_id']) . "," . ClaGenerate::quoteValue($ss['district_name']) . "," . ClaGenerate::quoteValue($ss['ward_id'])
                    . "," . ClaGenerate::quoteValue($ss['ward_name']) . "," . ClaGenerate::quoteValue($ss['hotline']) . "," . ClaGenerate::quoteValue($ss['phone'])
                    . "," . ClaGenerate::quoteValue($ss['email']) . "," . ClaGenerate::quoteValue($ss['hours']) . "," . ClaGenerate::quoteValue($ss['avatar_path'])
                    . "," . ClaGenerate::quoteValue($ss['avatar_name']) . ",[now],[now],[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['shop']][$ss['shop_id']]) ? '@' . $store[Yii::app()->params['tables']['shop']][$ss['shop_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($ss['latlng']) . "," . (int) $ss['group'] . "," . (int) $ss['order']
                    . "," . ClaGenerate::quoteValue($ss['meta_title']) . "," . ClaGenerate::quoteValue($ss['meta_keywords']) . "," . ClaGenerate::quoteValue($ss['meta_description'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['shop_store'] . $ss['id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['shop_store']][$ss['id']]['map'] = Yii::app()->params['tables']['shop_store'] . $ss['id'];
            }
            $sql .= "\n";
            // shop_images
            $shop_store_images = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('shop_store_images'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($shop_store_images) {
                foreach ($shop_store_images as $si) {
                    if (!isset($store[Yii::app()->params['tables']['shop_store']][$si['store_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['shop_store_images'] . " (`img_id`, `store_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`) "
                        . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['shop_store']][$si['store_id']]['map'] . "," . ClaGenerate::quoteValue($si['name']) . "," . ClaGenerate::quoteValue($si['path'])
                        . "," . ClaGenerate::quoteValue($si['display_name']) . "," . ClaGenerate::quoteValue($si['description'])
                        . "," . ClaGenerate::quoteValue($si['alias']) . ",[site_id],[user_id]," . $si['height'] . "," . $si['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($si['resizes']) . "," . $si['order']
                        . ");" . "\n";
//                    $sql.= "set @" . Yii::app()->params['tables']['shop_store_images'] . $si['img_id'] . " = LAST_INSERT_ID();" . "\n";
//                    //
//                    $store[Yii::app()->params['tables']['shop_store_images']][$si['img_id']]['map'] = Yii::app()->params['tables']['shop_store_images'] . $si['img_id'];
                }
                $sql .= "\n\n";
                //
            }
        }
        // --------------------------------------------------- END Shop - Gian hang -----------------------------------------------------------------
        // attribute set
        $attributeSets = BuildHelper::helper()->getAllAttributeSetInSite(array('limit' => 1000));
        if ($attributeSets) {
            foreach ($attributeSets as $set) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_attribute_set'] . " (id, `name`, `code`, sort_order, site_id) "
                    . "VALUES (null," . ClaGenerate::quoteValue($set['name']) . "," . ClaGenerate::quoteValue($set['code']) . "," . $set['sort_order'] . ",[site_id]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['product_attribute_set'] . $set['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['product_attribute_set']][$set['id']]['map'] = Yii::app()->params['tables']['product_attribute_set'] . $set['id'];
            }
            $sql .= "\n";
        }
        //Danh mục sản phẩm
        $productcategories = ProductCategories::getAllCategory();
        if ($productcategories) {
            foreach ($productcategories as $nc) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['productcategory'] . " (cat_id, site_id, attribute_set_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, icon_path, icon_name, layout_action, view_action, size_chart_path, size_chart_name) "
                    . "VALUES (null,[site_id],"
                    . (isset($store[Yii::app()->params['tables']['product_attribute_set']][$nc['attribute_set_id']]) ? "@" . $store[Yii::app()->params['tables']['product_attribute_set']][$nc['attribute_set_id']]['map'] : 'NULL')
                    . "," . (isset($store[Yii::app()->params['tables']['productcategory']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['productcategory']][$nc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                    . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path'])
                    . "," . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description'])
                    . "," . ClaGenerate::quoteValue($nc['icon_path']) . "," . ClaGenerate::quoteValue($nc['icon_name'])
                    . "," . ClaGenerate::quoteValue($nc['layout_action']) . "," . ClaGenerate::quoteValue($nc['view_action'])
                    . "," . ClaGenerate::quoteValue($nc['size_chart_path']) . "," . ClaGenerate::quoteValue($nc['size_chart_name'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['productcategory'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['productcategory']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['productcategory'] . $nc['cat_id'];
            }
            $sql .= "\n";
        }
        //
        // Hãng sản xuất
        $manufacturers = Manufacturer::getFullManufacturersInSite();
        if ($manufacturers) {
            foreach ($manufacturers as $manufacturer) {
                //process category track
                $CategoryTrack = $manufacturer['category_track'];
                $tracks = array();
                if ($CategoryTrack != '') {
                    $tr_temp = explode(ClaCategory::CATEGORY_SPLIT, $CategoryTrack);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id)
                            if (isset($store[Yii::app()->params['tables']['productcategory']][$cat_id]))
                                array_push($tracks, '@' . $store[Yii::app()->params['tables']['productcategory']][$cat_id]['map']);
                    }
                }
                $tracks = implode(",'" . ClaCategory::CATEGORY_SPLIT . "',", $tracks);
                if ($tracks != '')
                    $tracks = "CONCAT(" . $tracks . ")";
                else
                    $tracks = ClaGenerate::quoteValue($tracks);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['manufacturers'] . " (`id`, `site_id`, `user_id`, `name`, `alias`, `order`, `image_path`, `image_name`, `created_time`, `modified_time`, `category_track`) ";
                $sql .= "VALUES (null,[site_id],[user_id]" . "," . ClaGenerate::quoteValue($manufacturer['name']) . "," . ClaGenerate::quoteValue($manufacturer['alias']) . "," . $manufacturer['order']
                    . "," . ClaGenerate::quoteValue($manufacturer['image_path']) . "," . ClaGenerate::quoteValue($manufacturer['image_name'])
                    . "," . "[now],[now]," . $tracks
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['manufacturers'] . $manufacturer['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['manufacturers']][$manufacturer['id']]['map'] = Yii::app()->params['tables']['manufacturers'] . $manufacturer['id'];
            }
            $sql .= "\n";
            // Manufacturer Info
            $manuInfos = ManufacturerInfo::getManufacturerInfoInSite(array('limit' => 1000));
            foreach ($manuInfos as $manuInfo) {
                //
                if (!$manuInfo['manufacturer_id'] || !isset($store[Yii::app()->params['tables']['manufacturers']][$manuInfo['manufacturer_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['manufacturer_info'] . " (`manufacturer_id`, `site_id`, `shortdes`, `description`, `address`, `phone`, `meta_title`, `meta_keywords`, `meta_description`) "
                    . "VALUES (" . "@" . $store[Yii::app()->params['tables']['manufacturers']][$manuInfo['manufacturer_id']]['map'] . ",[site_id]"
                    . "," . ClaGenerate::quoteValue($manuInfo['shortdes']) . "," . ClaGenerate::quoteValue($manuInfo['description']) . "," . ClaGenerate::quoteValue($manuInfo['address']) . "," . ClaGenerate::quoteValue($manuInfo['phone'])
                    . "," . ClaGenerate::quoteValue($manuInfo['meta_title']) . "," . ClaGenerate::quoteValue($manuInfo['meta_keywords']) . "," . ClaGenerate::quoteValue($manuInfo['meta_description'])
                    . ");" . "\n";
                //
            }
            $sql .= "\n";
        }
        //  Manufacturer Category
        $manufacturerCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('manufacturer_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($manufacturerCategories) {
            while ($cc = array_shift($manufacturerCategories)) {
                if (!isset($store[ClaTable::getTable('manufacturer_categories')][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($manufacturerCategories, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . ClaTable::getTable('manufacturer_categories') . " (cat_id, site_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, icon_path, icon_name, show_in_filter,  layout_action, view_action) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[ClaTable::getTable('manufacturer_categories')][$cc['cat_parent']]) ? "@" . $store[ClaTable::getTable('manufacturer_categories')][$cc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                    . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                    . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_keywords'])
                    . "," . ClaGenerate::quoteValue($cc['meta_description']) . "," . ClaGenerate::quoteValue($cc['meta_title'])
                    . "," . ClaGenerate::quoteValue($cc['icon_path']) . "," . ClaGenerate::quoteValue($cc['icon_name']) . "," . (int) ($cc['show_in_filter'])
                    . "," . ClaGenerate::quoteValue($cc['layout_action']) . "," . ClaGenerate::quoteValue($cc['view_action'])
                    . ");" . "\n";
                $sql .= "set @" . ClaTable::getTable('manufacturer_categories') . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[ClaTable::getTable('manufacturer_categories')][$cc['cat_id']]['map'] = ClaTable::getTable('manufacturer_categories') . $cc['cat_id'];
            }
            $sql .= "\n";
        }
        // video
        // Product attribute
        $productAttributes = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Yii::app()->params['tables']['product_attribute'])
            ->where('site_id=' . $site_id)
            ->queryAll();
        if ($productAttributes) {
            $productAttributesArr = array();
            if ($productAttributes && count($productAttributes)) {
                foreach ($productAttributes as $pro) {
                    $productAttributesArr[$pro['id']] = $pro;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_attribute'] . " (`id`, `name`, `code`, `attribute_set_id`, `type`, `frontend_input`, `frontend_label`, `default_value`, `is_configurable`, `is_filterable`, `field_product`, `is_frontend`, `is_system`, `sort_order`,`field_configurable`,`type_option`, `avatar_path`, `avatar_name`, `site_id`) "
                        . "VALUES (null," . ClaGenerate::quoteValue($pro['name']) . "," . ClaGenerate::quoteValue($pro['code']) . "," . (($pro['attribute_set_id']) ? "@" . $store[Yii::app()->params['tables']['product_attribute_set']][$pro['attribute_set_id']]['map'] : 0)
                        . "," . ClaGenerate::quoteValue($pro['type']) . "," . ClaGenerate::quoteValue($pro['frontend_input']) . "," . ClaGenerate::quoteValue($pro['frontend_label']) . "," . ClaGenerate::quoteValue($pro['default_value'])
                        . "," . $pro['is_configurable'] . "," . $pro['is_filterable'] . "," . $pro['field_product'] . "," . $pro['is_frontend'] . "," . $pro['is_system'] . "," . $pro['sort_order'] . "," . $pro['field_configurable'] . "," . $pro['type_option'] . "," . ClaGenerate::quoteValue($pro['avatar_path']) . "," . ClaGenerate::quoteValue($pro['avatar_name'])
                        . ",[site_id]"
                        . ");" . "\n";
                    //
                    $sql .= "set @" . Yii::app()->params['tables']['product_attribute'] . $pro['id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['product_attribute']][$pro['id']]['map'] = Yii::app()->params['tables']['product_attribute'] . $pro['id'];
                }
                unset($productAttributes);
                $sql .= "\n";
            }
        }
        //
        //product attribute option
        $productAttributeOptions = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Yii::app()->params['tables']['product_attribute_option'])
            ->where('site_id=' . $site_id)
            ->queryAll();
        if ($productAttributeOptions && count($productAttributeOptions)) {
            foreach ($productAttributeOptions as $pro) {
                //$index_key = (isset($productAttributesArr[$pro['attribute_id']]) && $productAttributesArr[$pro['attribute_id']]['frontend_input'] != 'multiselect') ? 0 : $pro['index_key'];
                if (!$pro['attribute_id'] || !isset($store[Yii::app()->params['tables']['product_attribute']][$pro['attribute_id']]))
                    continue;
                $index_key = $pro['index_key'];
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_attribute_option'] . " (`id`, `attribute_id`, `index_key`, `sort_order`, `value`,`ext`,`site_id`) "
                    . "VALUES (null," . "@" . $store[Yii::app()->params['tables']['product_attribute']][$pro['attribute_id']]['map']
                    . "," . $index_key . "," . $pro['sort_order'] . "," . ClaGenerate::quoteValue($pro['value']) . "," . ClaGenerate::quoteValue($pro['ext']) . ",[site_id]"
                    . ");" . "\n";
                //
                $sql .= "set @" . Yii::app()->params['tables']['product_attribute_option'] . $pro['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['product_attribute_option']][$pro['id']]['map'] = Yii::app()->params['tables']['product_attribute_option'] . $pro['id'];
                //
                if (isset($productAttributesArr[$pro['attribute_id']]) && $productAttributesArr[$pro['attribute_id']]['frontend_input'] != 'multiselect') {
                    $sql .= "UPDATE " . Yii::app()->params['tables']['product_attribute_option'] . " SET index_key=id"
                        . " WHERE id=@" . Yii::app()->params['tables']['product_attribute_option'] . $pro['id'] . ";\n";
                }
            }
            //
            $sql .= "\n";
        }
        //product attribute option index
        $productAttributeOptionIndex = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Yii::app()->params['tables']['product_attribute_option_index'])
            ->where('site_id=' . $site_id)
            ->queryAll();
        if ($productAttributeOptionIndex && count($productAttributeOptionIndex)) {
            foreach ($productAttributeOptionIndex as $pro) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_attribute_option_index'] . " (`attribute_id`, `value_key`,`site_id`) "
                    . "VALUES (" . (($pro['attribute_id'] && isset($store[Yii::app()->params['tables']['product_attribute']][$pro['attribute_id']])) ? "@" . $store[Yii::app()->params['tables']['product_attribute']][$pro['attribute_id']]['map'] : 0)
                    . "," . $pro['value_key'] . ",[site_id]"
                    . ");" . "\n";
                //
                //$sql.= "set @" . Yii::app()->params['tables']['product_attribute_option'] . $pro['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                //$store[Yii::app()->params['tables']['product_attribute_option']][$pro['id']]['map'] = Yii::app()->params['tables']['product_attribute_option'] . $pro['id'];
            }
            $sql .= "\n";
        }
        // Sản phẩm
        $products = Product::getAllProducts(array('limit' => 1000));
        if ($products) {
            foreach ($products as $pro) {
                //process category track
                $track = $pro['category_track'];
                $tracks = array();
                if ($track != '') {
                    $tr_temp = explode(' ', $track);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id)
                            if (isset($store[Yii::app()->params['tables']['productcategory']][$cat_id]))
                                array_push($tracks, '@' . $store[Yii::app()->params['tables']['productcategory']][$cat_id]['map']);
                    }
                }
                $tracks = implode(",' ',", $tracks);
                if ($tracks != '')
                    $tracks = "CONCAT(" . $tracks . ")";
                else
                    $tracks = ClaGenerate::quoteValue($tracks);
                //
                //process list store id
                $storeIds = $pro['store_ids'];
                $storeIdsTrack = array();
                if ($storeIds != '' && $storeIds != 'Array') {
                    $storeIds_temp = explode(' ', $storeIds);
                    if ($storeIds_temp) {
                        foreach ($storeIds_temp as $store_id)
                            if (isset($store[Yii::app()->params['tables']['shop_store']][$store_id])) {
                                array_push($storeIdsTrack, '@' . $store[Yii::app()->params['tables']['shop_store']][$store_id]['map']);
                            }
                    }
                }
                $storeIdsTrack = implode(",' ',", $storeIdsTrack);
                if ($storeIdsTrack != '')
                    $storeIdsTrack = "CONCAT(" . $storeIdsTrack . ")";
                else
                    $storeIdsTrack = ClaGenerate::quoteValue($storeIdsTrack);
                //
                //process list manufacturers category id
                $manufacturerCategoryIds = $pro['manufacturer_category_track'];
                $manufacturerCategoryIdsTrack = array();
                if ($manufacturerCategoryIds != '' && $manufacturerCategoryIds != 'Array') {
                    $manufacturerCategoryIds_temp = explode(' ', $manufacturerCategoryIds);
                    if ($manufacturerCategoryIds_temp) {
                        foreach ($manufacturerCategoryIds_temp as $manufacturer_category_id)
                            if (isset($store[ClaTable::getTable('manufacturer_categories')][$manufacturer_category_id])) {
                                array_push($manufacturerCategoryIdsTrack, '@' . $store[ClaTable::getTable('manufacturer_categories')][$manufacturer_category_id]['map']);
                            }
                    }
                }
                $manufacturerCategoryIdsTrack = implode(",' ',", $manufacturerCategoryIdsTrack);
                if ($manufacturerCategoryIdsTrack != '') {
                    $manufacturerCategoryIdsTrack = "CONCAT(" . $manufacturerCategoryIdsTrack . ")";
                } else {
                    $manufacturerCategoryIdsTrack = ClaGenerate::quoteValue($manufacturerCategoryIdsTrack);
                }
                //
                // process customfield
                for ($i = 1; $i <= 32; $i++) {
                    if ($pro['cus_field' . $i] && isset($store[Yii::app()->params['tables']['product_attribute_option']][$pro['cus_field' . $i]]))
                        $pro['cus_field' . $i] = '@' . $store[Yii::app()->params['tables']['product_attribute_option']][$pro['cus_field' . $i]]['map'];
                }
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['product'] . " (`id`, `attribute_set_id`, `name`, `code`, `alias`, `slogan`, `ishot`, `price`, `price_market`, `price_discount`, `price_discount_percent`, `avatar_id`, `avatar_path`, `avatar_name`, `currency`, `include_vat`, `quantity`, `position`, `product_category_id`, `category_track`, `status`, `state`, `created_user`, `created_time`, `modified_user`, `modified_time`, `site_id`, `isnew`, `manufacturer_id`, `type_product`, `weight`, `cus_field1`, `cus_field2`, `cus_field3`, `cus_field4`, `cus_field5`, `cus_field6`, `cus_field7`, `cus_field8`, `cus_field9`, `cus_field10`, `cus_field11`, `cus_field12`, `cus_field13`, `cus_field14`, `cus_field15`, `cus_field16`, `cus_field17`, `cus_field18`, `cus_field19`, `cus_field20`, `cus_field21`, `cus_field22`, `cus_field23`, `cus_field24`, `cus_field25`, `cus_field26`, `cus_field27`, `cus_field28`, `cus_field29`, `cus_field30`, `cus_field31`, `cus_field32`, `cus_field33`, `cus_field34`, `cus_field35`, `cus_field36`, `cus_field37`, `cus_field38`, `bonus_point`, `donate`, `province_id`,`store_ids`,`manufacturer_category_track`,`is_configurable`) "
                    . "VALUES (null," . (($pro['attribute_set_id']) ? "@" . $store[Yii::app()->params['tables']['product_attribute_set']][$pro['attribute_set_id']]['map'] : 'null') . "," . ClaGenerate::quoteValue($pro['name']) . "," . ClaGenerate::quoteValue($pro['code']) . "," . ClaGenerate::quoteValue($pro['alias']) . "," . ClaGenerate::quoteValue($pro['slogan'])
                    . "," . $pro['ishot'] . "," . $pro['price'] . "," . $pro['price_market'] . "," . $pro['price_discount'] . "," . $pro['price_discount_percent'] . ",0," . ClaGenerate::quoteValue($pro['avatar_path']) . "," . ClaGenerate::quoteValue($pro['avatar_name'])
                    . "," . ClaGenerate::quoteValue($pro['currency']) . "," . $pro['include_vat'] . "," . $pro['quantity'] . "," . $pro['position']
                    . "," . (($pro['product_category_id'] && isset($store[Yii::app()->params['tables']['productcategory']][$pro['product_category_id']])) ? "@" . $store[Yii::app()->params['tables']['productcategory']][$pro['product_category_id']]['map'] : 0) . "," . $tracks
                    . "," . $pro['status'] . "," . $pro['state'] . ",[user_id],[now],[user_id],[now],[site_id]" . "," . $pro['isnew']
                    . "," . (($pro['manufacturer_id'] && isset($store[Yii::app()->params['tables']['manufacturers']][$pro['manufacturer_id']])) ? "@" . $store[Yii::app()->params['tables']['manufacturers']][$pro['manufacturer_id']]['map'] : 0)
                    //. "," . (($pro['shop_id'] && isset($store[Yii::app()->params['tables']['shop']][$pro['shop_id']])) ? "@" . $store[Yii::app()->params['tables']['shop']][$pro['shop_id']]['map'] : 0)
                    . "," . (int) $pro['type_product'] . "," . floatval($pro['weight'])
                    . "," . $pro['cus_field1'] . "," . $pro['cus_field2'] . "," . $pro['cus_field3'] . "," . $pro['cus_field4'] . "," . $pro['cus_field5'] . "," . $pro['cus_field6'] . "," . $pro['cus_field7'] . "," . $pro['cus_field8'] . "," . $pro['cus_field9'] . "," . $pro['cus_field10'] . "," . $pro['cus_field11'] . "," . $pro['cus_field12']
                    . "," . $pro['cus_field13'] . "," . $pro['cus_field14'] . "," . $pro['cus_field15'] . "," . $pro['cus_field16'] . "," . $pro['cus_field17'] . "," . $pro['cus_field18'] . "," . $pro['cus_field19']
                    . "," . $pro['cus_field20'] . "," . $pro['cus_field21'] . "," . $pro['cus_field22'] . "," . $pro['cus_field23'] . "," . $pro['cus_field24'] . "," . $pro['cus_field25'] . "," . $pro['cus_field26'] . "," . $pro['cus_field27'] . "," . $pro['cus_field28'] . "," . $pro['cus_field29']
                    . "," . $pro['cus_field30'] . "," . $pro['cus_field31'] . "," . $pro['cus_field32'] . "," . $pro['cus_field33'] . "," . $pro['cus_field34'] . "," . $pro['cus_field35'] . "," . $pro['cus_field36'] . "," . $pro['cus_field37'] . "," . $pro['cus_field38']
                    . "," . (int) $pro['bonus_point'] . "," . (int) $pro['donate'] . "," . (int) $pro['province_id'] . "," . $storeIdsTrack
                    . "," . $manufacturerCategoryIdsTrack
                    . "," . (int) $pro['is_configurable']
                    . ");" . "\n";
                //
                $sql .= "set @" . Yii::app()->params['tables']['product'] . $pro['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['product']][$pro['id']]['map'] = Yii::app()->params['tables']['product'] . $pro['id'];
            }
            $sql .= "\n";
            //
            // Products Info
            $productsInfo = ProductInfo::getProductInfoInSite(array('limit' => 1000));
            foreach ($productsInfo as $pro) {
                // process dynamic field
                $dynamic = ($pro['dynamic_field']) ? json_decode($pro['dynamic_field'], true) : array();
                $dynamicArr = array();
                $replace = array();
                $dstr = '';
                if (!empty($dynamic)) {
                    foreach ($dynamic as $key => $dyn) {
                        // attribute id
                        $dynamicArr[$key]['id'] = "id" . $key . $dyn['id'];
                        $replace["id" . $key . $dyn['id']] = "',@" . $store[Yii::app()->params['tables']['product_attribute']][$dyn['id']]['map'] . ",'";
                        // attribute name
                        $dynamicArr[$key]['name'] = $dyn['name'];
                        // attribute code
                        $dynamicArr[$key]['code'] = $dyn['code'];
                        //
                        if ($dyn['index_key'] && !is_array($dyn['index_key']) && isset($store[Yii::app()->params['tables']['product_attribute_option']][$dyn['index_key']])) {
                            $dynamicArr[$key]['index_key'] = "indexkey" . $key . $dyn['index_key'];
                            $replace["indexkey" . $key . $dyn['index_key']] = "',@" . $store[Yii::app()->params['tables']['product_attribute_option']][$dyn['index_key']]['map'] . ",'";
                            $dynamicArr[$key]['value'] = "value" . $key . $dyn['value'];
                            $replace["value" . $key . $dyn['value']] = "',@" . $store[Yii::app()->params['tables']['product_attribute_option']][$dyn['index_key']]['map'] . ",'";
                        } else {
                            $dynamicArr[$key]['index_key'] = $dyn['index_key'];
                            $dynamicArr[$key]['value'] = $dyn['value'];
                        }
                    }
                }
                if (!empty($dynamicArr)) {
                    $dstr = json_encode($dynamicArr, JSON_UNESCAPED_UNICODE);
                    $dstr = "CONCAT('" . str_replace(array_keys($replace), $replace, $dstr) . "')";
                    $dstr = str_replace(array('\u', '\r', '\n', '\r\n', '\t', '\"'), array('\\\u', '\\\r', '\\\n', '\\\r\\\n', '\\\t', '\\\"'), $dstr);
                } else
                    $dstr = ClaGenerate::quoteValue('');
                //
                if (!$pro['product_id'] || !isset($store[Yii::app()->params['tables']['product']][$pro['product_id']]))
                    continue;
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['productinfo'] . " (product_id, product_sortdesc, product_desc, dynamic_field, meta_title, meta_keywords, meta_description, list_product_relate, site_id, total_rating, total_votes) "
                    . "VALUES (" . (($pro['product_id'] && $store[Yii::app()->params['tables']['product']][$pro['product_id']]) ? "@" . $store[Yii::app()->params['tables']['product']][$pro['product_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($pro['product_sortdesc']) . "," . ClaGenerate::quoteValue($pro['product_desc']) . "," . $dstr
                    . "," . ClaGenerate::quoteValue($pro['meta_title']) . "," . ClaGenerate::quoteValue($pro['meta_keywords']) . "," . ClaGenerate::quoteValue($pro['meta_description']) . "," . ClaGenerate::quoteValue($pro['list_product_relate'])
                    . ",[site_id]" . "," . (int) $pro['total_rating'] . "," . (int) $pro['total_votes']
                    . ");" . "\n";
                //
            }
            $sql .= "\n";
            $product_rating_detail = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_rating_detail'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($product_rating_detail) {
                foreach ($product_rating_detail as $prd) {
                    //
                    if (!$prd['product_id'] || !isset($store[Yii::app()->params['tables']['product']][$prd['product_id']]))
                        continue;
                    //
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_rating_detail'] . " (`id`, `product_id`, `created_user`, `site_id`, `created_time`, `rating`) "
                        . "VALUES (null," . (($prd['product_id'] && $store[Yii::app()->params['tables']['product']][$prd['product_id']]) ? "@" . $store[Yii::app()->params['tables']['product']][$prd['product_id']]['map'] : 0)
                        . ",[user_id],[site_id],[now]" . "," . (int) $prd['rating']
                        . ");" . "\n";
                    //
                }
                $sql .= "\n";
            }
            //
            //Thuộc tính tùy chọn
            $productConfigurables = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_configurable'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productConfigurables && count($productConfigurables)) {
                foreach ($productConfigurables as $pc) {
                    if (!$pc['product_id'] || !isset($store[Yii::app()->params['tables']['product']][$pc['product_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_configurable'] . " (`product_id`,`attribute1_id`,`attribute2_id`,`attribute3_id`,`site_id`) "
                        . "VALUES ("
                        . "@" . $store[Yii::app()->params['tables']['product']][$pc['product_id']]['map']
                        . "," . (($pc['attribute1_id'] && isset($store[Yii::app()->params['tables']['product_attribute']][$pc['attribute1_id']])) ? "@" . $store[Yii::app()->params['tables']['product_attribute']][$pc['attribute1_id']]['map'] : 0)
                        . "," . (($pc['attribute2_id'] && isset($store[Yii::app()->params['tables']['product_attribute']][$pc['attribute2_id']])) ? "@" . $store[Yii::app()->params['tables']['product_attribute']][$pc['attribute2_id']]['map'] : 0)
                        . "," . (($pc['attribute3_id'] && isset($store[Yii::app()->params['tables']['product_attribute']][$pc['attribute3_id']])) ? "@" . $store[Yii::app()->params['tables']['product_attribute']][$pc['attribute3_id']]['map'] : 0)
                        . ",[site_id]"
                        . ");" . "\n";
                    //
                }
                $sql .= "\n";
            }
            // Giá trị của thuộc tính tủy chọn
            $productConfigurableValues = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_configurable_value'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productConfigurableValues && count($productConfigurableValues)) {
                foreach ($productConfigurableValues as $pc) {
                    if (!$pc['product_id'] || !isset($store[Yii::app()->params['tables']['product']][$pc['product_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_configurable_value'] . " (`id`, `product_id`, `attribute1_value`, `attribute2_value`, `attribute3_value`, `price`, `price_market`, `multitext`,`code`,`barcode`,`id_product_link`,`site_id`) "
                        . "VALUES (null,"
                        . "@" . $store[Yii::app()->params['tables']['product']][$pc['product_id']]['map']
                        . "," . $pc['attribute1_value'] . "," . $pc['attribute2_value'] . "," . $pc['attribute3_value'] . "," . $pc['price'] . "," . $pc['price_market'] . "," . ClaGenerate::quoteValue($pc['multitext'])
                        . "," . ClaGenerate::quoteValue($pc['code']) . "," . ClaGenerate::quoteValue($pc['barcode']) . "," . ClaGenerate::quoteValue($pc['id_product_link'])
                        . ",[site_id]"
                        . ");" . "\n";
                    //
                    $sql .= "set @" . Yii::app()->params['tables']['product_configurable_value'] . $pc['id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['product_configurable_value']][$pc['id']]['map'] = Yii::app()->params['tables']['product_configurable_value'] . $pc['id'];
                    //
                    $sql .= "UPDATE " . Yii::app()->params['tables']['product_configurable_value'] . " SET id_product_link=CONCAT(@" . $store[Yii::app()->params['tables']['product']][$pc['product_id']]['map'] . ",\"_\",@" . $store[Yii::app()->params['tables']['product_configurable_value']][$pc['id']]['map'] . ")"
                        . " WHERE id=@" . $store[Yii::app()->params['tables']['product_configurable_value']][$pc['id']]['map'] . ";\n";
                }
                $sql .= "\n";
            }
            // Ảnh của thuộc tính tủy chọn
            $productConfigurableValueImages = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_configurable_images'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productConfigurableValueImages && count($productConfigurableValueImages)) {
                foreach ($productConfigurableValueImages as $pcv) {
                    if (!$pcv['product_id'] || !$pcv['pcv_id'] || !isset($store[Yii::app()->params['tables']['product']][$pcv['product_id']]) || !isset($store[Yii::app()->params['tables']['product_configurable_value']][$pcv['pcv_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_configurable_images'] . " (`img_id`, `product_id`, `pcv_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`) "
                        . "VALUES (null"
                        . "," . "@" . $store[Yii::app()->params['tables']['product']][$pcv['product_id']]['map']
                        . "," . "@" . $store[Yii::app()->params['tables']['product_configurable_value']][$pcv['pcv_id']]['map']
                        . "," . ClaGenerate::quoteValue($pcv['name']) . "," . ClaGenerate::quoteValue($pcv['path']) . "," . ClaGenerate::quoteValue($pcv['display_name'])
                        . "," . ClaGenerate::quoteValue($pcv['description']) . "," . ClaGenerate::quoteValue($pcv['alias']) . ",[site_id],[user_id]"
                        . "," . $pcv['height'] . "," . $pcv['width'] . ",[now],[now]," . ClaGenerate::quoteValue($pcv['resizes'])
                        . ");" . "\n";
                    //
                }
                $sql .= "\n";
            }
            //
            // Ảnh cho sản phẩm
            $productimages = Product::getAllImages();
            if ($productimages) {
                foreach ($productimages as $pi) {
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['productimage'] . " (img_id, product_id, `name`, `path`, display_name, description, `alias`, site_id, user_id, height, width, created_time, modified_time, resizes, `order`) "
                        . "VALUES (null," . (isset($store[Yii::app()->params['tables']['product']][$pi['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$pi['product_id']]['map'] : 0) . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                        . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                        . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($pi['resizes']) . "," . $pi['order']
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['productimage'] . $pi['img_id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['productimage']][$pi['img_id']]['map'] = Yii::app()->params['tables']['productimage'] . $pi['img_id'];
                }
                $sql .= "\n";
                // Cập nhật avatar_id for product
                foreach ($products as $pro) {
                    if (!isset($store[Yii::app()->params['tables']['productimage']][$pro['avatar_id']]))
                        continue;
                    $sql .= "UPDATE " . Yii::app()->params['tables']['product'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['productimage']][$pro['avatar_id']]['map']
                        . " WHERE id=@" . $store[Yii::app()->params['tables']['product']][$pro['id']]['map'] . ";\n";
                }
                //
                $sql .= "\n\n";
            }
            // Ảnh thuộc tính màu của sản phẩm
            $productimages = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('product_images_color'))
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productimages) {
                foreach ($productimages as $pi) {
                    if (!isset($store[Yii::app()->params['tables']['product']][$pi['product_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . ClaTable::getTable('product_images_color') . " (img_id, product_id, `name`, `path`, display_name, description, `alias`, site_id, user_id, height, width, created_time, modified_time, resizes, `color_code`, `is_avatar`) "
                        . "VALUES (null," . (isset($store[Yii::app()->params['tables']['product']][$pi['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$pi['product_id']]['map'] : 0)
                        . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                        . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                        . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($pi['resizes']) . "," . (int) $pi['color_code'] . "," . (int) $pi['is_avatar']
                        . ");" . "\n";
                    //
                }
                $sql .= "\n\n";
            }
            // Sản phẩm liên quan
            $productsRelation = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('product_relation'))
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productsRelation) {
                foreach ($productsRelation as $object) {
                    if (!isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) || !isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . ClaTable::getTable('product_relation') . " (product_id, product_rel_id, site_id, created_time, type) "
                        . "VALUES (" . (isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_id']]['map'] : 0)
                        . "," . (isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_rel_id']]['map'] : 0)
                        . "," . "[site_id],[now]," . (int) $object['type']
                        . ");" . "\n";
                    //
                }
            }
            if (Yii::app()->siteinfo['site_skin'] == 'w3ni700') {
                // Sản phẩm vật tư
                $productsRelation = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from(ClaTable::getTable('product_vt'))
                    ->where('site_id=' . $site_id)
                    ->queryAll();
                if ($productsRelation) {
                    foreach ($productsRelation as $object) {
                        if (!isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) || !isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']])) {
                            continue;
                        }
                        $sql .= "INSERT INTO " . ClaTable::getTable('product_vt') . " (product_id, product_rel_id, site_id, created_time, type) "
                            . "VALUES (" . (isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_id']]['map'] : 0)
                            . "," . (isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_rel_id']]['map'] : 0)
                            . "," . "[site_id],[now]," . (int) $object['type']
                            . ");" . "\n";
                        //
                    }
                }
                // Sản phẩm hộp mực
                $productsRelation = Yii::app()->db->createCommand()
                    ->select('*')
                    ->from(ClaTable::getTable('product_ink'))
                    ->where('site_id=' . $site_id)
                    ->queryAll();
                if ($productsRelation) {
                    foreach ($productsRelation as $object) {
                        if (!isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) || !isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']])) {
                            continue;
                        }
                        $sql .= "INSERT INTO " . ClaTable::getTable('product_ink') . " (product_id, product_rel_id, site_id, created_time, type) "
                            . "VALUES (" . (isset($store[Yii::app()->params['tables']['product']][$object['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_id']]['map'] : 0)
                            . "," . (isset($store[Yii::app()->params['tables']['product']][$object['product_rel_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$object['product_rel_id']]['map'] : 0)
                            . "," . "[site_id],[now]," . (int) $object['type']
                            . ");" . "\n";
                        //
                    }
                }
            }
        }
        //
        // Nhóm sản phẩm
        $productGroups = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Yii::app()->params['tables']['productgroups'])
            ->where('site_id=' . $site_id)
            ->queryAll();
        if ($productGroups && count($productGroups)) {
            foreach ($productGroups as $pg) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['productgroups'] . " (`group_id`, `site_id`, `user_id`, `name`, `description`, `status`, `alias`, `showinhome`, `meta_keywords`, `meta_description`, `meta_title`, `created_time`) "
                    . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($pg['name']) . "," . ClaGenerate::quoteValue($pg['description']) . ',' . $pg['status']
                    . ',' . ClaGenerate::quoteValue($pg['alias']) . "," . $pg['showinhome'] . "," . ClaGenerate::quoteValue('meta_keywords') . "," . ClaGenerate::quoteValue('meta_description') . "," . ClaGenerate::quoteValue('meta_title') . ",[now]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['productgroups'] . $pg['group_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['productgroups']][$pg['group_id']]['map'] = Yii::app()->params['tables']['productgroups'] . $pg['group_id'];
            }
            $sql .= "\n";
            $productToGroup = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_to_group'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($productToGroup && count($productToGroup)) {
                foreach ($productToGroup as $pTg) {
                    if (!isset($store[Yii::app()->params['tables']['product']][$pTg['product_id']]) || !isset($store[Yii::app()->params['tables']['productgroups']][$pTg['group_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_to_group'] . " (`id`, `group_id`, `product_id`, `site_id`, `created_time`) "
                        . "VALUES (null," . (isset($store[Yii::app()->params['tables']['productgroups']][$pTg['group_id']]) ? '@' . $store[Yii::app()->params['tables']['productgroups']][$pTg['group_id']]['map'] : 0)
                        . ',' . (isset($store[Yii::app()->params['tables']['product']][$pTg['product_id']]) ? '@' . $store[Yii::app()->params['tables']['product']][$pTg['product_id']]['map'] : 0)
                        . ',[site_id],[now]'
                        . ");" . "\n";
                    //
                }
                $sql .= "\n";
            }
        }
        // Banner cho danh mục sản phẩm
        if ($productcategories) {
            $product_categories_banner = Yii::app()->db->createCommand()
                ->select('*')
                ->from(Yii::app()->params['tables']['product_categories_banner'])
                ->where('site_id=' . $site_id)
                ->queryAll();
            if ($product_categories_banner) {
                foreach ($product_categories_banner as $pcb) {
                    if (!$pcb['category_id'] || !isset($store[Yii::app()->params['tables']['productcategory']][$pcb['category_id']]['map'])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['product_categories_banner'] . " (`id`, `name`, `image_path`, `image_name`, `category_id`, `link`, `status`, `order`, `created_time`, `modified_time`, `site_id`, `position`) "
                        . "VALUES (null"
                        . "," . ClaGenerate::quoteValue($pcb['name']) . "," . ClaGenerate::quoteValue($pcb['image_path']) . "," . ClaGenerate::quoteValue($pcb['image_name'])
                        . ',' . '@' . $store[Yii::app()->params['tables']['productcategory']][$pcb['category_id']]['map']
                        . "," . ClaGenerate::quoteValue($pcb['link']) . "," . (int) $pcb['status'] . "," . (int) $pcb['order']
                        . ",[now],[now],[site_id]" . "," . (int) $pcb['position']
                        . ");" . "\n";
                    //
                }
                $sql .= "\n";
            }
        }
        // Trang nội dung
        $pagecategory = CategoryPage::getAllCategoryPage(array('limit' => 1000));
        if ($pagecategory) {
            foreach ($pagecategory as $pc) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['categorypage'] . " (id, title, content, site_id, user_id, `alias`, created_time, modified_time, modified_by, meta_keywords, meta_description, meta_title, image_path, image_name, avatar_id, short_description, layout_action, view_action) "
                    . "VALUES (null," . ClaGenerate::quoteValue($pc['title']) . "," . ClaGenerate::quoteValue($pc['content']) . ",[site_id],[user_id]"
                    . "," . ClaGenerate::quoteValue($pc['alias']) . ",[now],[now],[user_id]"
                    . "," . ClaGenerate::quoteValue($pc['meta_keywords']) . "," . ClaGenerate::quoteValue($pc['meta_description']) . "," . ClaGenerate::quoteValue($pc['meta_title']) . "," . ClaGenerate::quoteValue($pc['image_path']) . "," . ClaGenerate::quoteValue($pc['image_name'])
                    . ",0," . ClaGenerate::quoteValue($pc['short_description'])
                    . "," . ClaGenerate::quoteValue($pc['layout_action']) . "," . ClaGenerate::quoteValue($pc['view_action'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['categorypage'] . $pc['id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['categorypage']][$pc['id']]['map'] = Yii::app()->params['tables']['categorypage'] . $pc['id'];
            }
            // Ảnh cho category page
            $categoryPageImages = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('categorypage_images'))
                ->where("site_id=$site_id")
                ->queryAll();
            foreach ($categoryPageImages as $pi) {
                if (!isset($store[Yii::app()->params['tables']['categorypage']][$pi['id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['categorypage_images'] . " (img_id, id, `name`, `path`, display_name, description, `alias`, site_id, user_id, height, width, created_time, modified_time, resizes, `order`,`type`) "
                    . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['categorypage']][$pi['id']]['map'] . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                    . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                    . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                    . "," . ClaGenerate::quoteValue($pi['resizes']) . "," . $pi['order'] . "," . $pi['type']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['productimage'] . $pi['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['categorypage_images']][$pi['img_id']]['map'] = Yii::app()->params['tables']['categorypage_images'] . $pi['img_id'];
            }
            $sql .= "\n";
            // Cập nhật avatar_id for categorypage
            foreach ($pagecategory as $pc) {
                if (!isset($store[Yii::app()->params['tables']['categorypage_images']][$pc['avatar_id']]))
                    continue;
                $sql .= "UPDATE " . Yii::app()->params['tables']['categorypage'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['categorypage_images']][$pc['avatar_id']]['map']
                    . " WHERE id=@" . $store[Yii::app()->params['tables']['categorypage']][$pc['id']]['map'] . ";\n";
            }
            //
            $sql .= "\n\n";
        }
        //
        // Video categories
        $videoCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('videos_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($videoCategories) {
            while ($cc = array_shift($videoCategories)) {
                if (!isset($store[Yii::app()->params['tables']['videos_categories']][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($videoCategories, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['videos_categories'] . " (cat_id, site_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, layout_action, view_action) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['videos_categories']][$cc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['videos_categories']][$cc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                    . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                    . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_keywords'])
                    . "," . ClaGenerate::quoteValue($cc['meta_description']) . "," . ClaGenerate::quoteValue($cc['meta_title'])
                    . "," . ClaGenerate::quoteValue($cc['layout_action']) . "," . ClaGenerate::quoteValue($cc['view_action'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['videos_categories'] . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['videos_categories']][$cc['cat_id']]['map'] = Yii::app()->params['tables']['videos_categories'] . $cc['cat_id'];
            }
            $sql .= "\n";
        }
        // video
        $videos = Videos::getVideoInSite(array('limit' => 100));
        if (count($videos)) {
            foreach ($videos as $video) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['video'] . " (video_id, site_id, user_id, video_title, video_description, video_link, video_embed, video_height, video_width, video_prominent, `status`, avatar_path, avatar_name, `alias`, `order`, meta_keywords, meta_description, created_time, modified_time, cat_id, product_id, video_short_description) "
                    . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($video['video_title']) . "," . ClaGenerate::quoteValue($video['video_description']) . "," . ClaGenerate::quoteValue($video['video_link'])
                    . "," . ClaGenerate::quoteValue($video['video_embed']) . "," . $video['video_height'] . "," . $video['video_width'] . "," . $video['video_prominent'] . "," . $video['status'] . "," . ClaGenerate::quoteValue($video['avatar_path']) . "," . ClaGenerate::quoteValue($video['avatar_name'])
                    . "," . ClaGenerate::quoteValue($video['alias']) . "," . $video['order'] . "," . ClaGenerate::quoteValue($video['meta_keywords']) . "," . ClaGenerate::quoteValue($video['meta_description']) . ",[now],[now]"
                    . "," . (isset($store[Yii::app()->params['tables']['videos_categories']][$video['cat_id']]) ? "@" . $store[Yii::app()->params['tables']['videos_categories']][$video['cat_id']]['map'] : 0)
                    . "," . (isset($store[Yii::app()->params['tables']['product']][$video['product_id']]) ? "@" . $store[Yii::app()->params['tables']['product']][$video['product_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($video['video_short_description'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['video'] . $video['video_id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['video']][$video['video_id']]['map'] = Yii::app()->params['tables']['video'] . $video['video_id'];
            }
            $sql .= "\n\n";
        }
        //
        // Tuyển dụng
        $jobs = Jobs::getJobInSite(array('limit' => 100));
        if (count($jobs)) {
            foreach ($jobs as $job) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['job'] . " (id, user_id, site_id, `position`, degree, trade_id, typeofwork, location, quantity, salaryrange, currency, salary_min, salary_max, description, experience, `level`, includes, requirement, benefit, expirydate, publicdate, created_time, modified_time, `alias`, contact_username, contact_email, contact_phone, contact_address, image_path, image_name, `ishot`, `order`, `company`) "
                    . "VALUES (null,[user_id],[site_id]," . ClaGenerate::quoteValue($job['position']) . "," . $job['degree'] . "," . ClaGenerate::quoteValue($job['trade_id']) . "," . ClaGenerate::quoteValue($job['typeofwork']) . "," . ClaGenerate::quoteValue($job['location']) . "," . $job['quantity']
                    . "," . $job['salaryrange'] . "," . $job['currency'] . "," . $job['salary_min'] . "," . $job['salary_max'] . "," . ClaGenerate::quoteValue($job['description']) . "," . $job['experience'] . "," . $job['level']
                    . "," . ClaGenerate::quoteValue($job['includes']) . "," . ClaGenerate::quoteValue($job['requirement']) . "," . ClaGenerate::quoteValue($job['benefit'])
                    . "," . $job['expirydate'] . "," . $job['publicdate'] . ",[now],[now]"
                    . "," . ClaGenerate::quoteValue($job['alias']) . "," . ClaGenerate::quoteValue($job['contact_username']) . "," . ClaGenerate::quoteValue($job['contact_email']) . "," . ClaGenerate::quoteValue($job['contact_phone']) . "," . ClaGenerate::quoteValue($job['contact_address'])
                    . "," . ClaGenerate::quoteValue($job['image_path']) . "," . ClaGenerate::quoteValue($job['image_name'])
                    . "," . (int) $job['ishot'] . "," . (int) $job['order'] . "," . ClaGenerate::quoteValue($job['company'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['job'] . $job['id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['job']][$job['id']]['map'] = Yii::app()->params['tables']['job'] . $job['id'];
            }
            $sql .= "\n\n";
        }
        if ($jobs) {
            $job_apply = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('job_apply'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($job_apply) {
                foreach ($job_apply as $object) {
                    if (!isset($store[Yii::app()->params['tables']['job']][$object['job_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['job_apply'] . " (`id`, `job_id`, `avatar_path`, `avatar_name`, `location`, `user_id`, `name`, `sex`, `birthday`, `birthplace`, `identity_card`, `married_status`, `address`, `hotline`, `email`, `province_id`, `district_id`, `desired_income`, `height`, `weight`, `reason_apply`, `school`, `major`, `qualification_type`, `certificate`, `site_id`, `created_time`, `modified_time`) "
                        . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['job']][$object['job_id']]['map']
                        . "," . ClaGenerate::quoteValue($object['avatar_path']) . "," . ClaGenerate::quoteValue($object['avatar_name']) . "," . ClaGenerate::quoteValue($object['location']) . ",[user_id]"
                        . "," . ClaGenerate::quoteValue($object['name']) . "," . (int) $object['sex'] . "," . ClaGenerate::quoteValue($object['birthday']) . "," . ClaGenerate::quoteValue($object['birthplace']) . "," . ClaGenerate::quoteValue($object['identity_card'])
                        . "," . (int) $object['married_status'] . "," . ClaGenerate::quoteValue($object['address']) . "," . ClaGenerate::quoteValue($object['hotline']) . "," . ClaGenerate::quoteValue($object['email'])
                        . "," . ClaGenerate::quoteValue($object['province_id']) . "," . ClaGenerate::quoteValue($object['district_id']) . "," . $object['desired_income']
                        . "," . ClaGenerate::quoteValue($object['height']) . "," . ClaGenerate::quoteValue($object['weight']) . "," . ClaGenerate::quoteValue($object['reason_apply'])
                        . "," . ClaGenerate::quoteValue($object['school']) . "," . ClaGenerate::quoteValue($object['major']) . "," . ClaGenerate::quoteValue($object['qualification_type']) . "," . ClaGenerate::quoteValue($object['certificate'])
                        . ",[site_id],[now],[now]"
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['job_apply'] . $object['id'] . " = LAST_INSERT_ID();" . "\n";
                    $store[Yii::app()->params['tables']['job_apply']][$object['id']]['map'] = Yii::app()->params['tables']['job_apply'] . $object['id'];
                }
//                // job_apply_files
//                $sql.="\n";
//                $job_apply_files = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('job_apply_files'))
//                        ->where("site_id=$site_id")
//                        ->queryAll();
//                if ($job_apply_files) {
//                    foreach ($job_apply_files as $object) {
//                        if (!isset($store[Yii::app()->params['tables']['job_apply']][$object['job_apply_id']])) {
//                            continue;
//                        }
//                        $sql.="INSERT INTO " . Yii::app()->params['tables']['job_apply_files'] . " (`id`, `job_apply_id`, `user_id`, `site_id`, `display_name`, `name`, `path`, `description`, `extension`, `size`, `created_time`, `modified_time`) "
//                                . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['job_apply']][$object['job_apply_id']]['map']
//                                . ",[user_id],[site_id]" . "," . ClaGenerate::quoteValue($object['display_name']) . "," . ClaGenerate::quoteValue($object['name']) . "," . ClaGenerate::quoteValue($object['path']) . "," . ClaGenerate::quoteValue($object['description'])
//                                . "," . ClaGenerate::quoteValue($object['extension']) . "," . (int) $object['size']
//                                . ",[now],[now]"
//                                . ");" . "\n";
//                    }
//                    $sql.="\n";
//                }
//                // job_apply_work_history
//                $job_apply_work_history = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('job_apply_work_history'))
//                        ->where("site_id=$site_id")
//                        ->queryAll();
//                if($job_apply_work_history){
//                     foreach ($job_apply_work_history as $object) {
//                        if (!isset($store[Yii::app()->params['tables']['job_apply']][$object['job_apply_id']])) {
//                            continue;
//                        }
//                        $sql.="INSERT INTO " . Yii::app()->params['tables']['job_apply_work_history'] . " (`id`, `job_apply_id`, `company`, `field_business`, `scale`, `degree`, `job_detail`, `time_work`, `reason_offwork`, `site_id`, `created_time`) "
//                                . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['job_apply']][$object['job_apply_id']]['map']
//                                . "," . ClaGenerate::quoteValue($object['company']) . "," . ClaGenerate::quoteValue($object['field_business']) . "," . (int)($object['scale'])
//                                . "," . ClaGenerate::quoteValue($object['degree']) . "," . ClaGenerate::quoteValue($object['job_detail'])
//                                . "," . ClaGenerate::quoteValue($object['time_work']) . "," . ClaGenerate::quoteValue($object['reason_offwork'])
//                                . ",[site_id],[now]"
//                                . ");" . "\n";
//                    }
//                    $sql.="\n";
//                }
            }
        }
        //
        // Danh muc anh
        //
        $albumcategories = AlbumsCategories::getAllCategory();
        foreach ($albumcategories as $nc) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['albums_categories'] . " (`cat_id`, `site_id`, `cat_parent`, `cat_name`, `alias`, `cat_order`, `cat_description`, `cat_countchild`, `image_path`, `image_name`, `status`, `created_time`, `modified_time`, `showinhome`, `meta_keywords`, `meta_description`, `meta_title`) "
                . "VALUES (null,[site_id]," . (isset($store[Yii::app()->params['tables']['albums_categories']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['albums_categories']][$nc['cat_parent']]['map'] : 0)
                . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path']) . ","
                . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . "," . ClaGenerate::quoteValue($nc['meta_title'])
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['albums_categories'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['albums_categories']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['albums_categories'] . $nc['cat_id'];
        }
        //
        // Album ảnh
        $albums = Albums::getAllAlbum(array('limit' => 100));
        if ($albums && count($albums)) {
            foreach ($albums as $album) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['album'] . " (album_id, album_name, album_description, album_type, photocount, `alias`, site_id, user_id, meta_keywords, meta_description, avatar_path, avatar_name, avatar_id, created_time, modified_time, cat_id,`order`) "
                    . "VALUES (null," . ClaGenerate::quoteValue($album['album_name']) . "," . ClaGenerate::quoteValue($album['album_description']) . "," . $album['album_type'] . "," . $album['photocount']
                    . "," . ClaGenerate::quoteValue($album['alias']) . ",[site_id],[user_id]" . "," . ClaGenerate::quoteValue($album['meta_keywords']) . "," . ClaGenerate::quoteValue($album['meta_description'])
                    . "," . ClaGenerate::quoteValue($album['avatar_path']) . "," . ClaGenerate::quoteValue($album['avatar_name']) . "," . $album['avatar_id'] . ",[now],[now]"
                    . "," . (isset($store[Yii::app()->params['tables']['albums_categories']][$album['cat_id']]) ? '@' . $store[Yii::app()->params['tables']['albums_categories']][$album['cat_id']]['map'] : 0)
                    . "," . $album['order']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['album'] . $album['album_id'] . " = LAST_INSERT_ID();" . "\n";
                $store[Yii::app()->params['tables']['album']][$album['album_id']]['map'] = Yii::app()->params['tables']['album'] . $album['album_id'];
            }
            $sql .= "\n\n";
            // Ảnh cho album
            $albumImages = Images::getImagesInSite(array('limit' => 100));
            foreach ($albumImages as $pi) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['image'] . " (img_id, album_id, `name`, `path`, display_name, description, `alias`, site_id, user_id, height, width, created_time, modified_time) "
                    . "VALUES (null," . (isset($store[Yii::app()->params['tables']['album']][$pi['album_id']]) ? '@' . $store[Yii::app()->params['tables']['album']][$pi['album_id']]['map'] : 0) . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                    . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                    . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['image'] . $pi['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['image']][$pi['img_id']]['map'] = Yii::app()->params['tables']['image'] . $pi['img_id'];
            }
            $sql .= "\n";
        }

        //
        // Edu_course
        // course category
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_course_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($categories && count($categories)) {
            foreach ($categories as $nc) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_course_categories'] . " (`cat_id`, `site_id`, `cat_parent`, `cat_name`, `alias`, `cat_order`, `cat_description`, `cat_countchild`, `image_path`, `image_name`, `status`, `created_time`, `modified_time`, `showinhome`, `meta_keywords`, `meta_description`, `meta_title`) "
                    . "VALUES (null,[site_id]," . (isset($store[Yii::app()->params['tables']['edu_course_categories']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['edu_course_categories']][$nc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . "," . $nc['cat_order']
                    . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild'] . "," . ClaGenerate::quoteValue($nc['image_path']) . ","
                    . ClaGenerate::quoteValue($nc['image_name']) . "," . $nc['status'] . ",[now], [now]," . $nc['showinhome'] . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description']) . "," . ClaGenerate::quoteValue($nc['meta_title'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['edu_course_categories'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['edu_course_categories']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['edu_course_categories'] . $nc['cat_id'];
            }
            $sql .= "\n\n";
        }
        // course
        $courses = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_course'))
            ->where("site_id=$site_id")
            ->order('order')
            ->queryAll();
        if ($courses && count($courses)) {
            foreach ($courses as $co) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_course'] . " (`id`, `site_id`, `cat_id`, `name`, `alias`, `price`, `price_market`, `status`, `order`, `image_path`, `image_name`, `created_time`, `modified_time`, `viewed`, `time_for_study`, `number_of_students`, `school_schedule`, `course_open`, `course_finish`, `sort_description`, `number_lession`, `ishot`) "
                    . "VALUES (null,[site_id]," . (isset($store[Yii::app()->params['tables']['edu_course_categories']][$co['cat_id']]) ? "@" . $store[Yii::app()->params['tables']['edu_course_categories']][$co['cat_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($co['name']) . "," . ClaGenerate::quoteValue($co['alias']) . "," . $co['price'] . "," . $co['price_market'] . "," . (int) $co['status'] . "," . (int) $co['order']
                    . "," . ClaGenerate::quoteValue($co['image_path']) . "," . ClaGenerate::quoteValue($co['image_name']) . ",[now], [now]," . $co['viewed'] . "," . ClaGenerate::quoteValue($co['time_for_study'])
                    . "," . (int) $co['number_of_students'] . "," . ClaGenerate::quoteValue($co['school_schedule']) . "," . $co['course_open'] . "," . (int) $co['course_finish'] . "," . ClaGenerate::quoteValue($co['sort_description']) . "," . (int) $co['number_lession'] . "," . (int) $co['ishot']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['edu_course'] . $co['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['edu_course']][$co['id']]['map'] = Yii::app()->params['tables']['edu_course'] . $co['id'];
            }
            $sql .= "\n\n";
        }
        // course info
        $courseInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_course_info'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($courseInfos && count($courseInfos)) {
            foreach ($courseInfos as $coi) {
                if (!isset($store[Yii::app()->params['tables']['edu_course']][$coi['course_id']])) {
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_course_info'] . " (`course_id`, `meta_keywords`, `meta_description`, `meta_title`, `description`, `site_id`) "
                    . "VALUES (" . "@" . $store[Yii::app()->params['tables']['edu_course']][$coi['course_id']]['map']
                    . "," . ClaGenerate::quoteValue($coi['meta_keywords']) . "," . ClaGenerate::quoteValue($coi['meta_description'])
                    . "," . ClaGenerate::quoteValue($coi['meta_title']) . "," . ClaGenerate::quoteValue($coi['description']) . ",[site_id]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        // course shift
        $courseShift = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_course_shift'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($courseShift && count($courseShift)) {
            foreach ($courseShift as $cos) {
                if (!isset($store[Yii::app()->params['tables']['edu_course']][$cos['course_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_course_shift'] . " (`site_id`, `course_id`, `time`, `shift`, `status`, `created_time`, `modified_time`) "
                    . "VALUES ([site_id]," . "@" . $store[Yii::app()->params['tables']['edu_course']][$cor['course_id']]['map']
                    . "," . $cos['time'] . "," . $cos['shift'] . "," . $cos['status'] . ",[now],[now]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        //
        // course register
        $courseRegis = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_course_register'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($courseRegis && count($courseRegis)) {
            foreach ($courseRegis as $cor) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_course_register'] . " (`id`, `site_id`, `course_id`, `name`, `email`, `phone`, `message`, `created_time`, `modified_time`) "
                    . "VALUES (null,[site_id]," . (isset($store[Yii::app()->params['tables']['edu_course']][$cor['course_id']]) ? "@" . $store[Yii::app()->params['tables']['edu_course']][$cor['course_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cor['name']) . "," . ClaGenerate::quoteValue($cor['email']) . "," . ClaGenerate::quoteValue($cor['phone'])
                    . "," . ClaGenerate::quoteValue($cor['message']) . ",[now],[now]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        // lecturer
        $lecturers = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_lecturer'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($lecturers && count($lecturers)) {
            foreach ($lecturers as $lec) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_lecturer'] . " (`id`, `site_id`, `name`, `bod`, `status`, `subject`, `level_of_education`, `avatar_path`, `avatar_name`, `sort_description`, `description`, `gender`, `add`, `phone`, `experience`, `facebook`, `email`, `job_title`, `company`) "
                    . "VALUES (null,[site_id]," . ClaGenerate::quoteValue($lec['name']) . "," . (int) $lec['bod'] . "," . (int) $lec['status'] . "," . ClaGenerate::quoteValue($lec['subject'])
                    . "," . ClaGenerate::quoteValue($lec['level_of_education']) . "," . ClaGenerate::quoteValue($lec['avatar_path']) . "," . ClaGenerate::quoteValue($lec['avatar_name']) . "," . ClaGenerate::quoteValue($lec['sort_description']) . "," . ClaGenerate::quoteValue($lec['description'])
                    . "," . (int) $lec['gender'] . "," . ClaGenerate::quoteValue($lec['add']) . "," . ClaGenerate::quoteValue($lec['phone']) . "," . (int) $lec['experience']
                    . "," . ClaGenerate::quoteValue($lec['facebook']) . "," . ClaGenerate::quoteValue($lec['email']) . "," . ClaGenerate::quoteValue($lec['job_title']) . "," . ClaGenerate::quoteValue($lec['company'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['edu_lecturer'] . $lec['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['edu_lecturer']][$lec['id']]['map'] = Yii::app()->params['tables']['edu_lecturer'] . $lec['id'];
            }
            $sql .= "\n\n";
        }
        //edu_rel_course_lecturer
        $lecturerRel = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('edu_rel_course_lecturer'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($lecturerRel && count($lecturerRel)) {
            foreach ($lecturerRel as $lec) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['edu_rel_course_lecturer'] . " (`id`, `site_id`, `course_id`, `lecturer_id`) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['edu_course']][$lec['course_id']]) ? "@" . $store[Yii::app()->params['tables']['edu_course']][$lec['course_id']]['map'] : 0)
                    . "," . (isset($store[Yii::app()->params['tables']['edu_lecturer']][$lec['lecturer_id']]) ? "@" . $store[Yii::app()->params['tables']['edu_lecturer']][$lec['lecturer_id']]['map'] : 0)
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        // -- BDS --
        //Danh mục tin tức bds
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        foreach ($categories as $nc) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_categories'] . " (`cat_id`, `site_id`, `cat_parent`, `cat_name`, `alias`, `created_time`, `modified_time`, `status`, `showinhome`, `image_path`, `image_name`, `meta_keywords`, `meta_description`, `meta_title`, `cat_order`, `cat_description`, `cat_countchild`) "
                . "VALUES (null,[site_id],"
                . "," . (isset($store[Yii::app()->params['tables']['real_estate_categories']][$nc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['real_estate_categories']][$nc['cat_parent']]['map'] : 0)
                . "," . ClaGenerate::quoteValue($nc['cat_name']) . "," . ClaGenerate::quoteValue($nc['alias']) . ",[now], [now]" . "," . $nc['status'] . "," . $nc['showinhome']
                . "," . ClaGenerate::quoteValue($nc['image_path']) . "," . ClaGenerate::quoteValue($nc['image_name']) . "," . ClaGenerate::quoteValue($nc['meta_keywords']) . "," . ClaGenerate::quoteValue($nc['meta_description'])
                . "," . ClaGenerate::quoteValue($nc['meta_title']) . "," . $nc['cat_order'] . "," . ClaGenerate::quoteValue($nc['cat_description']) . "," . $nc['cat_countchild']
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['real_estate_categories'] . $nc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['real_estate_categories']][$nc['cat_id']]['map'] = Yii::app()->params['tables']['real_estate_categories'] . $nc['cat_id'];
        }
        $sql .= "\n";
        // tin tức bds
        $bdsnews = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_news'))
            ->where("site_id=$site_id")
            ->queryAll();
        foreach ($bdsnews as $news) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_news'] . " (`id`, `site_id`, `name`, `alias`, `status`, `created_time`, `modified_time`, `user_id`, `sort_description`, `description`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `price`, `unit_price`, `area`, `image_path`, `image_name`, `cat_id`, `type`) "
                . "VALUES (null,[site_id]," . "," . ClaGenerate::quoteValue($news['name']) . "," . ClaGenerate::quoteValue($news['alias']) . "," . $news['status'] . ",[now], [now], [user_id]"
                . "," . ClaGenerate::quoteValue($news['sort_description']) . "," . ClaGenerate::quoteValue($news['description']) . "," . ClaGenerate::quoteValue($news['address']) . "," . ClaGenerate::quoteValue($news['province_id'])
                . "," . ClaGenerate::quoteValue($news['province_name']) . "," . ClaGenerate::quoteValue($news['district_id']) . "," . ClaGenerate::quoteValue($news['district_name']) . "," . ClaGenerate::quoteValue($news['price'])
                . "," . $news['unit_price'] . "," . $news['area'] . "," . ClaGenerate::quoteValue($news['image_path']) . "," . ClaGenerate::quoteValue($news['image_name'])
                . "," . (isset($store[Yii::app()->params['tables']['real_estate_categories']][$news['cat_id']]) ? "@" . $store[Yii::app()->params['tables']['real_estate_categories']][$news['cat_id']]['map'] : 0)
                . "," . $news['type']
                . ");" . "\n";
        }
        // BDS project
        $projects = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_project'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($projects) {
            foreach ($projects as $project) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_project'] . " (`id`, `site_id`, `name`, `alias`, `status`, `created_time`, `modified_time`, `user_id`, `image_path`, `image_name`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `sort_description`, `price_range`, `area`, `news_category_id`, `real_estate_cat_id`, `avatar_id`) "
                    . "VALUES (null,[site_id]" . "," . ClaGenerate::quoteValue($project['name']) . "," . ClaGenerate::quoteValue($project['alias']) . "," . $project['status'] . ",[now], [now], [user_id]"
                    . "," . ClaGenerate::quoteValue($project['image_path']) . "," . ClaGenerate::quoteValue($project['image_name']) . "," . ClaGenerate::quoteValue($project['address']) . "," . ClaGenerate::quoteValue($project['province_id'])
                    . "," . ClaGenerate::quoteValue($project['province_name']) . "," . ClaGenerate::quoteValue($project['district_id']) . "," . ClaGenerate::quoteValue($project['district_name'])
                    . "," . ClaGenerate::quoteValue($project['sort_description']) . "," . ClaGenerate::quoteValue($project['price_range']) . "," . ClaGenerate::quoteValue($project['area'])
                    . "," . (isset($store[Yii::app()->params['tables']['newcategory']][$project['news_category_id']]) ? '@' . $store[Yii::app()->params['tables']['newcategory']][$project['news_category_id']]['map'] : 0)
                    . "," . (isset($store[Yii::app()->params['tables']['real_estate_categories']][$project['real_estate_cat_id']]) ? '@' . $store[Yii::app()->params['tables']['real_estate_categories']][$project['real_estate_cat_id']]['map'] : 0)
                    . ",0"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['real_estate_project'] . $project['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['real_estate_project']][$project['id']]['map'] = Yii::app()->params['tables']['real_estate_project'] . $project['id'];
            }
            $sql .= "\n";
            // Project Infos
            $projectInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_project_info'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($projectInfos) {
                foreach ($projectInfos as $pinfo) {
                    if (!(isset($store[Yii::app()->params['tables']['real_estate_project']][$pinfo['project_id']])))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_project_info'] . " (`project_id`, `meta_keywords`, `meta_description`, `meta_title`, `description`, `site_id`, `map`, `traffic`, `target`) "
                        . "VALUES ("
                        . '@' . $store[Yii::app()->params['tables']['real_estate_project']][$pinfo['project_id']]['map']
                        . "," . ClaGenerate::quoteValue($pinfo['meta_keywords']) . "," . ClaGenerate::quoteValue($pinfo['meta_keywords'])
                        . "," . ClaGenerate::quoteValue($pinfo['meta_title']) . "," . ClaGenerate::quoteValue($pinfo['description']) . ",[site_id],"
                        . ClaGenerate::quoteValue($pinfo['map']) . "," . ClaGenerate::quoteValue($pinfo['traffic']) . "," . ClaGenerate::quoteValue($pinfo['target'])
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
            // Project Images
            $projectImages = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_images'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($projectImages) {
                foreach ($projectImages as $pi) {
                    if (!isset($store[Yii::app()->params['tables']['real_estate_project']][$pi['project_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_images'] . " (`img_id`, `project_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`, `type`) "
                        . "VALUES (null,"
                        . '@' . $store[Yii::app()->params['tables']['real_estate_project']][$pi['project_id']]['map'] . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                        . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                        . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($pi['resizes']) . "," . $pi['order'] . "," . $pi['type']
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['real_estate_images'] . $pi['img_id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['real_estate_images']][$pi['img_id']]['map'] = Yii::app()->params['tables']['real_estate_images'] . $pi['img_id'];
                }
                $sql .= "\n";
                // Update avatar_id for car
                foreach ($projects as $po) {
                    if (!isset($store[Yii::app()->params['tables']['real_estate_images']][$po['avatar_id']]))
                        continue;
                    $sql .= "UPDATE " . Yii::app()->params['tables']['real_estate_project'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['real_estate_images']][$po['avatar_id']]['map']
                        . " WHERE id=@" . $store[Yii::app()->params['tables']['real_estate_images']][$po['id']]['map'] . ";\n";
                }
                //
                $sql .= "\n\n";
                //
            }
        }
        // Project Register
        $proRegisters = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_project_register'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($proRegisters) {
            foreach ($proRegisters as $pinfo) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_project_register'] . " (`id`, `name`, `email`, `phone`, `project_id`, `message`, `created_time`, `modified_time`, `site_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($pinfo['name']) . "," . ClaGenerate::quoteValue($pinfo['meta_keywords']) . "," . ClaGenerate::quoteValue($pinfo['phone'])
                    . "," . (isset($store[Yii::app()->params['tables']['real_estate_project']][$pinfo['project_id']]) ? '@' . $store[Yii::app()->params['tables']['real_estate_project']][$pinfo['project_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($pinfo['message']) . ",[now],[now],[site_id]"
                    . ");" . "\n";
            }
        }
        // BDS
//        $estates = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate'))
//                ->where("site_id=$site_id")
//                ->queryAll();
//        foreach ($estates as $bds) {
//            $sql.="INSERT INTO " . Yii::app()->params['tables']['real_estate'] . " (`id`, `site_id`, `name`, `alias`, `status`, `created_time`, `modified_time`, `user_id`, `sort_description`, `description`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `price`, `unit_price`, `area`, `image_path`, `image_name`, `project_id`, `percent`, `type`, `contact_name`, `contact_phone`, `contact_email`) "
//                    . "VALUES (null,[site_id]" . "," . ClaGenerate::quoteValue($bds['name']) . "," . ClaGenerate::quoteValue($bds['alias']) . "," . $bds['status'] . ",[now], [now], [user_id]"
//                    . "," . ClaGenerate::quoteValue($bds['sort_description']) . "," . ClaGenerate::quoteValue($bds['description']) . "," . ClaGenerate::quoteValue($bds['address']) . "," . ClaGenerate::quoteValue($bds['province_id'])
//                    . "," . ClaGenerate::quoteValue($bds['province_name']) . "," . ClaGenerate::quoteValue($news['district_id']) . "," . ClaGenerate::quoteValue($news['district_name'])
//                    . "," . ClaGenerate::quoteValue($bds['province_name']) . "," . ClaGenerate::quoteValue($news['district_id']) . "," . ClaGenerate::quoteValue($news['district_name'])
//                    . ");" . "\n";
//        }
        // bds_project_config
        $bds_project_config = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('bds_project_config'))
            ->where("site_id=$site_id")
            ->queryAll();
        foreach ($bds_project_config as $bds) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['bds_project_config'] . " (`id`, `name`, `alias`, `ishot`, `province_id`, `district_id`, `ward_id`, `address`, `logo_path`, `logo_name`, `avatar_path`, `avatar_name`, `config1`, `config1_content`, `config1_image_path`, `config1_image_name`, `config2`, `config2_content`, `config2_image_path`, `config2_image_name`, `config3`, `config3_content`, `config3_image_path`, `config3_image_name`, `config4`, `config4_content`, `config4_image_path`, `config4_image_name`, `config5`, `config5_content`, `config5_image_path`, `config5_image_name`, `status`, `custom_number_1`, `custom_number_2`, `custom_number_3`, `short_description`, `created_time`, `modified_time`, `site_id`) "
                . "VALUES (null" . "," . ClaGenerate::quoteValue($bds['name']) . "," . ClaGenerate::quoteValue($bds['alias']) . "," . $bds['ishot'] . "," . ClaGenerate::quoteValue($bds['province_id'])
                . "," . ClaGenerate::quoteValue($bds['district_id']) . "," . ClaGenerate::quoteValue($bds['ward_id']) . "," . ClaGenerate::quoteValue($bds['address']) . "," . ClaGenerate::quoteValue($bds['logo_path']) . "," . ClaGenerate::quoteValue($bds['logo_name'])
                . "," . ClaGenerate::quoteValue($bds['avatar_path']) . "," . ClaGenerate::quoteValue($bds['avatar_name']) . "," . ClaGenerate::quoteValue($bds['config1']) . "," . ClaGenerate::quoteValue($bds['config1_content']) . "," . ClaGenerate::quoteValue($bds['config1_image_path'])
                . "," . ClaGenerate::quoteValue($bds['config1_image_name']) . "," . ClaGenerate::quoteValue($bds['config2']) . "," . ClaGenerate::quoteValue($bds['config2_content']) . "," . ClaGenerate::quoteValue($bds['config2_image_path']) . "," . ClaGenerate::quoteValue($bds['config2_image_name'])
                . "," . ClaGenerate::quoteValue($bds['config3']) . "," . ClaGenerate::quoteValue($bds['config3_content']) . "," . ClaGenerate::quoteValue($bds['config3_image_path']) . "," . ClaGenerate::quoteValue($bds['config3_image_name']) . "," . ClaGenerate::quoteValue($bds['config4'])
                . "," . ClaGenerate::quoteValue($bds['config4_content']) . "," . ClaGenerate::quoteValue($bds['config4_image_path']) . "," . ClaGenerate::quoteValue($bds['config4_image_name']) . "," . ClaGenerate::quoteValue($bds['config5']) . "," . ClaGenerate::quoteValue($bds['config5_content'])
                . "," . ClaGenerate::quoteValue($bds['config5_image_path']) . "," . ClaGenerate::quoteValue($bds['config5_image_name']) . "," . (int) $bds['status']
                . "," . (int) $bds['custom_number_1'] . "," . (int) $bds['custom_number_2'] . "," . (int) $bds['custom_number_3'] . "," . ClaGenerate::quoteValue($bds['short_description'])
                . ",[now], [now], [site_id]"
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['bds_project_config'] . $bds['id'] . " = LAST_INSERT_ID();" . "\n" . "\n";
            //
            $store[Yii::app()->params['tables']['bds_project_config']][$bds['id']]['map'] = Yii::app()->params['tables']['bds_project_config'] . $bds['id'];
        }

        // real_estate_consultant
        $real_estate_consultant = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_consultant'))
            ->where("site_id=$site_id")
            ->queryAll();
        foreach ($real_estate_consultant as $bds) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['real_estate_consultant'] . " (`id`, `site_id`, `name`, `bod`, `status`, `subject`, `level_of_education`, `avatar_path`, `avatar_name`, `sort_description`, `description`, `gender`, `add`, `phone`, `experience`, `facebook`, `email`, `job_title`, `company`, `order`, `modified_time`, `created_time`, `alias`, `background_name`, `background_path`) "
                . "VALUES (null,[site_id]" . "," . ClaGenerate::quoteValue($bds['name']) . "," . (int) $bds['bod'] . "," . (int) $bds['status'] . "," . ClaGenerate::quoteValue($bds['subject'])
                . "," . ClaGenerate::quoteValue($bds['level_of_education']) . "," . ClaGenerate::quoteValue($bds['avatar_path']) . "," . ClaGenerate::quoteValue($bds['avatar_name']) . "," . ClaGenerate::quoteValue($bds['sort_description']) . "," . ClaGenerate::quoteValue($bds['description'])
                . "," . (int) $bds['gender'] . "," . ClaGenerate::quoteValue($bds['add']) . "," . ClaGenerate::quoteValue($bds['phone']) . "," . (int) ($bds['experience']) . "," . ClaGenerate::quoteValue($bds['facebook'])
                . "," . ClaGenerate::quoteValue($bds['email']) . "," . ClaGenerate::quoteValue($bds['job_title']) . "," . ClaGenerate::quoteValue($bds['company']) . "," . (int) ($bds['order'])
                . ",[now], [now]"
                . "," . ClaGenerate::quoteValue($bds['alias']) . "," . ClaGenerate::quoteValue($bds['background_name']) . "," . ClaGenerate::quoteValue($bds['background_path'])
                . ");" . "\n";
            $sql .= "set @" . Yii::app()->params['tables']['real_estate_consultant'] . $bds['id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['real_estate_consultant']][$bds['id']]['map'] = Yii::app()->params['tables']['real_estate_consultant'] . $bds['id'];
        }
        // bds_project_config_consultant_relation
        $bds_project_config_consultant_relation = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('bds_project_config_consultant_relation'))
            ->where('site_id=' . $site_id)
            ->queryAll();
        if ($bds_project_config_consultant_relation && count($bds_project_config_consultant_relation)) {
            foreach ($bds_project_config_consultant_relation as $pTg) {
                if (!isset($store[Yii::app()->params['tables']['real_estate_consultant']][$pTg['consultant_id']]) || !isset($store[Yii::app()->params['tables']['bds_project_config']][$pTg['bds_project_config_id']])) {
                    continue;
                }
                $sql .= "INSERT INTO " . ClaTable::getTable('bds_project_config_consultant_relation') . " (`consultant_id`, `bds_project_config_id`, `site_id`, `created_time`, `order`) "
                    . "VALUES (" . '@' . $store[Yii::app()->params['tables']['real_estate_consultant']][$pTg['consultant_id']]['map']
                    . ',' . '@' . $store[Yii::app()->params['tables']['bds_project_config']][$pTg['bds_project_config_id']]['map']
                    . ',[site_id],[now]'
                    . "," . (int) $pTg['order']
                    . ");" . "\n";
            }
            $sql .= "\n";
        }

        // bds_project_config_images
        $bds_project_config_images = Yii::app()->db->createCommand()
            ->select('*')
            ->from(ClaTable::getTable('bds_project_config_images'))
            ->where('site_id=' . $site_id)
            ->queryAll();
        foreach ($bds_project_config_images as $pi) {
            if (!isset($store[Yii::app()->params['tables']['bds_project_config']][$pi['project_config_id']])) {
                continue;
            }
            $sql .= "INSERT INTO " . ClaTable::getTable('bds_project_config_images') . " (img_id, project_config_id, `name`, `path`, display_name, description, `alias`, site_id, user_id, height, width, created_time, modified_time, resizes, `order`, `type`) "
                . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['bds_project_config']][$pi['project_config_id']]['map'] . "," . ClaGenerate::quoteValue($pi['name']) . "," . ClaGenerate::quoteValue($pi['path'])
                . "," . ClaGenerate::quoteValue($pi['display_name']) . "," . ClaGenerate::quoteValue($pi['description'])
                . "," . ClaGenerate::quoteValue($pi['alias']) . ",[site_id],[user_id]," . $pi['height'] . "," . $pi['width'] . ",[now],[now]"
                . "," . ClaGenerate::quoteValue($pi['resizes']) . "," . (int) $pi['order'] . "," . (int) $pi['type']
                . ");" . "\n";
        }
        $sql .= "\n";
        // -- END BDS ---
        // --------------------------------------------------- Car -----------------------------------------------------------------
        // Danh mục ô tô
        $carCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($carCategories) {
            while ($cc = array_shift($carCategories)) {
                if (!isset($store[Yii::app()->params['tables']['car_categories']][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($carCategories, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_categories'] . " (cat_id, site_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, icon_path, icon_name) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['car_categories']][$cc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['car_categories']][$cc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                    . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                    . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_keywords']) . "," . ClaGenerate::quoteValue($cc['meta_description'])
                    . "," . ClaGenerate::quoteValue($cc['icon_path']) . "," . ClaGenerate::quoteValue($cc['icon_name'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['car_categories'] . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['car_categories']][$cc['cat_id']]['map'] = Yii::app()->params['tables']['car_categories'] . $cc['cat_id'];
            }
            $sql .= "\n";
        }
        // Ô tô
        $cars = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($cars) {
            foreach ($cars as $car) {
                //process category track
                $track = $car['category_track'];
                $tracks = array();
                if ($track != '') {
                    $tr_temp = explode(' ', $track);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id)
                            if (isset($store[Yii::app()->params['tables']['car_categories']][$cat_id]))
                                array_push($tracks, '@' . $store[Yii::app()->params['tables']['car_categories']][$cat_id]['map']);
                    }
                }
                $tracks = implode(",' ',", $tracks);
                if ($tracks != '')
                    $tracks = "CONCAT(" . $tracks . ")";
                else
                    $tracks = ClaGenerate::quoteValue($tracks);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['car'] . " (`id`, `name`, `code`, `price`, `price_market`, `include_vat`, `quantity`, `status`, `position`, `sortdesc`, `avatar_path`, `avatar_name`, `avatar2_path`, `avatar2_name`, `cover_path`, `cover_name`, `currency`, `avatar_id`, `site_id`, `created_user`, `modified_user`, `created_time`, `modified_time`, `car_category_id`, `category_track`, `ishot`, `alias`, `isnew`, `video_link`, `slogan`, `allow_try_drive`, `catalog_link`, `data_attributes`, `fuel`, `seat`, `style`, `madein`, `number_plate_fee`, `registration_fee`, `inspection_fee`, `road_toll`, `insurance_fee`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($car['name']) . "," . ClaGenerate::quoteValue($car['code']) . "," . $car['price'] . "," . $car['price_market'] . "," . $car['include_vat']
                    . "," . $car['quantity'] . "," . $car['status'] . "," . $car['position'] . "," . ClaGenerate::quoteValue($car['sortdesc'])
                    . "," . ClaGenerate::quoteValue($car['avatar_path']) . "," . ClaGenerate::quoteValue($car['avatar_name'])
                    . "," . ClaGenerate::quoteValue($car['avatar2_path']) . "," . ClaGenerate::quoteValue($car['avatar2_name'])
                    . "," . ClaGenerate::quoteValue($car['cover_path']) . "," . ClaGenerate::quoteValue($car['cover_name'])
                    . "," . ClaGenerate::quoteValue($car['currency']) . ",0,[site_id],[user_id],[user_id],[now],[now]"
                    . "," . (($car['car_category_id']) ? "@" . $store[Yii::app()->params['tables']['car_categories']][$car['car_category_id']]['map'] : $car['car_category_id']) . "," . $tracks
                    . "," . $car['ishot'] . "," . ClaGenerate::quoteValue($car['alias']) . "," . $car['isnew'] . "," . ClaGenerate::quoteValue($car['video_link']) . "," . ClaGenerate::quoteValue($car['slogan'])
                    . "," . (int) $car['allow_try_drive'] . "," . ClaGenerate::quoteValue($car['catalog_link'])
                    . "," . ClaGenerate::quoteValue($car['data_attributes']) . "," . (int) $car['fuel']
                    . "," . (int) $car['seat'] . "," . (int) $car['style'] . "," . (int) $car['madein'] . "," . (int) $car['number_plate_fee']
                    . "," . (int) $car['registration_fee'] . "," . (int) $car['inspection_fee'] . "," . (int) $car['road_toll'] . "," . (int) $car['insurance_fee']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['car'] . $car['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['car']][$car['id']]['map'] = Yii::app()->params['tables']['car'] . $car['id'];
            }
            $sql .= "\n";
            // ảnh cho ô tô
            $carImages = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_images'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carImages) {
                foreach ($carImages as $ci) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$ci['car_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_images'] . " (`img_id`, `car_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`, `type`, `title`) "
                        . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['car']][$ci['car_id']]['map'] . "," . ClaGenerate::quoteValue($ci['name']) . "," . ClaGenerate::quoteValue($ci['path'])
                        . "," . ClaGenerate::quoteValue($ci['display_name']) . "," . ClaGenerate::quoteValue($ci['description'])
                        . "," . ClaGenerate::quoteValue($ci['alias']) . ",[site_id],[user_id]," . $ci['height'] . "," . $ci['width'] . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($ci['resizes']) . "," . $ci['order'] . "," . $ci['type']
                        . "," . ClaGenerate::quoteValue($ci['title'])
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['car_images'] . $ci['img_id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['car_images']][$ci['img_id']]['map'] = Yii::app()->params['tables']['car_images'] . $ci['img_id'];
                }
                $sql .= "\n";
                // Update avatar_id for car
                foreach ($cars as $car) {
                    if (!isset($store[Yii::app()->params['tables']['car_images']][$car['avatar_id']]))
                        continue;
                    $sql .= "UPDATE " . Yii::app()->params['tables']['car'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['car']][$car['avatar_id']]['map']
                        . " WHERE id=@" . $store[Yii::app()->params['tables']['car']][$car['id']]['map'] . ";\n";
                }
                //
                $sql .= "\n\n";
                //
            }
            // Linh phụ kiện ô tô
            $carAccessories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_accessories'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carAccessories) {
                foreach ($carAccessories as $accessory) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$accessory['car_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO car_accessories (`id`, `car_id`, `name`, `price`, `avatar_path`, `avatar_name`, `description`, `site_id`, `type`, `order`) "
                        . "VALUES (null,"
                        . '@' . $store[Yii::app()->params['tables']['car']][$accessory['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($accessory['name']) . "," . $accessory['price']
                        . "," . ClaGenerate::quoteValue($accessory['avatar_path']) . "," . ClaGenerate::quoteValue($accessory['avatar_name'])
                        . "," . ClaGenerate::quoteValue($accessory['description'])
                        . ",[site_id]," . (int) $accessory['type'] . "," . (int) $accessory['order']
                        . ");" . "\n";
                }
            }
            // Car color
            $carColors = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_colors'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carColors) {
                foreach ($carColors as $color) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$color['car_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO car_colors (`id`, `car_id`, `name`, `code_color`, `avatar`, `site_id`) "
                        . "VALUES (null, "
                        . '@' . $store[Yii::app()->params['tables']['car']][$color['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($color['name']) . "," . ClaGenerate::quoteValue($color['code_color'])
                        . "," . ClaGenerate::quoteValue($color['avatar']) . ",[site_id]"
                        . ");" . "\n";
                }
            }
            // Car info
            $carInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_info'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carInfos) {
                foreach ($carInfos as $info) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$info['car_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_info'] . " (`car_id`, `meta_keywords`, `meta_description`, `meta_title`, `description`, `site_id`, `attribute`) "
                        . "VALUES ("
                        . '@' . $store[Yii::app()->params['tables']['car']][$info['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($info['meta_keywords']) . "," . ClaGenerate::quoteValue($info['meta_description'])
                        . "," . ClaGenerate::quoteValue($info['meta_title']) . "," . ClaGenerate::quoteValue($info['description'])
                        . ",[site_id]," . ClaGenerate::quoteValue($info['attribute'])
                        . ");" . "\n";
                }
                $sql .= "\n\n";
            }
            //
            //Car version
            $carVersions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_versions'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carVersions) {
                foreach ($carVersions as $version) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$version['car_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_versions'] . " (`id`, `car_id`, `name`, `price`, `price_market`, `status`, `description`, `created_time`, `modified_time`, `image_path`, `image_name`, `site_id`) "
                        . "VALUES (null,"
                        . '@' . $store[Yii::app()->params['tables']['car']][$version['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($version['name']) . "," . $version['price'] . "," . $version['price_market'] . "," . $version['status']
                        . "," . ClaGenerate::quoteValue($version['description']) . ",[now],[now]"
                        . "," . ClaGenerate::quoteValue($version['image_path']) . "," . ClaGenerate::quoteValue($version['image_name'])
                        . ",[site_id]"
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
            //car_receipt_fee
            $carReceipts = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_receipt_fee'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carReceipts) {
                foreach ($carReceipts as $re) {
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_receipt_fee'] . " (`id`, `name`, `number_plate_fee`, `registration_fee`, `site_id`, `inspection_fee`, `road_toll`, `insurance_fee`) "
                        . "VALUES (null"
                        . "," . ClaGenerate::quoteValue($re['name']) . "," . $re['number_plate_fee'] . "," . $re['registration_fee']
                        . ",[site_id]" . "," . (int) $re['number_plate_fee'] . "," . (int) $re['road_toll'] . "," . (int) $re['insurance_fee']
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
            // Car form
            $carForms = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_form'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carForms) {
                foreach ($carForms as $form) {
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_form'] . " (`id`, `car_id`, `title`, `user_name`, `address`, `phone`, `email`, `time`, `content`, `created_time`, `modified_time`, `type`, `site_id`) "
                        . "VALUES (null,"
                        . (isset($store[Yii::app()->params['tables']['car']][$form['car_id']]) ? '@' . $store[Yii::app()->params['tables']['car']][$form['car_id']]['map'] : 0)
                        . "," . ClaGenerate::quoteValue($form['title']) . "," . ClaGenerate::quoteValue($form['user_name']) . "," . ClaGenerate::quoteValue($form['address'])
                        . "," . ClaGenerate::quoteValue($form['phone']) . "," . ClaGenerate::quoteValue($form['email']) . "," . $form['time']
                        . "," . ClaGenerate::quoteValue($form['content']) . ",[now],[now]," . $form['type']
                        . ",[site_id]"
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
            // carpanorama_options
            $carpanorama_options = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_panorama_options'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carpanorama_options) {
                foreach ($carpanorama_options as $option) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$option['car_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_panorama_options'] . " (`id`, `car_id`, `name`, `path`, `site_id`, `type`, `folder`) "
                        . "VALUES (null,"
                        . '@' . $store[Yii::app()->params['tables']['car']][$option['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($option['name']) . "," . ClaGenerate::quoteValue($option['path'])
                        . ",[site_id]," . ClaGenerate::quoteValue($option['type']) . "," . ClaGenerate::quoteValue($option['folder'])
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['car_panorama_options'] . $option['id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['car_panorama_options']][$option['id']]['map'] = Yii::app()->params['tables']['car_panorama_options'] . $option['id'];
                }
                $sql .= "\n";
            }
            // car_images_panorama
            $carpanoramas = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('car_images_panorama'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($carpanoramas) {
                foreach ($carpanoramas as $carp) {
                    if (!isset($store[Yii::app()->params['tables']['car']][$carp['car_id']]) || !isset($store[Yii::app()->params['tables']['car_panorama_options']][$carp['option_id']]))
                        continue;
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['car_images_panorama'] . " (`id`, `car_id`, `image_name`, `is_default`, `option_id`, `path`, `site_id`) "
                        . "VALUES (null,"
                        . '@' . $store[Yii::app()->params['tables']['car']][$carp['car_id']]['map']
                        . "," . ClaGenerate::quoteValue($carp['image_name']) . "," . $carp['is_default']
                        . "," . '@' . $store[Yii::app()->params['tables']['car_panorama_options']][$carp['option_id']]['map']
                        . "," . ClaGenerate::quoteValue($carp['path']) . ",[site_id]"
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
        }
        //
        // --------------------------------------------------- END Car -----------------------------------------------------------------
        //
        // --------------------------------------------------- Tour ---------------------------------------------------------------------
        // Tour categories
        $tourCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tourCategories) {
            while ($cc = array_shift($tourCategories)) {
                if (!isset($store[Yii::app()->params['tables']['tour_categories']][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($tourCategories, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_categories'] . " (cat_id, site_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, icon_path, icon_name) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['tour_categories']][$cc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['tour_categories']][$cc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                    . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                    . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_keywords']) . "," . ClaGenerate::quoteValue($cc['meta_description'])
                    . "," . ClaGenerate::quoteValue($cc['meta_title']) . "," . ClaGenerate::quoteValue($cc['icon_path']) . "," . ClaGenerate::quoteValue($cc['icon_name'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_categories'] . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_categories']][$cc['cat_id']]['map'] = Yii::app()->params['tables']['tour_categories'] . $cc['cat_id'];
            }
            $sql .= "\n";
        }
        // tour_partners
        $tour_partners = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_partners'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_partners) {
            foreach ($tour_partners as $partner) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_partners'] . " (`id`, `name`, `address`, `phone`, `status`, `created_time`, `modified_time`, `site_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($partner['name']) . "," . ClaGenerate::quoteValue($partner['address']) . "," . ClaGenerate::quoteValue($partner['phone'])
                    . "," . $partner['status'] . ",[now], [now],[site_id]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_partners'] . $partner['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_partners']][$partner['id']]['map'] = Yii::app()->params['tables']['tour_partners'] . $partner['id'];
            }
            $sql .= "\n";
        }
        // tour_comforts
        $tour_comforts = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_comforts'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_comforts) {
            foreach ($tour_comforts as $comfort) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_comforts'] . " (`id`, `name`, `status`, `image_path`, `image_name`, `show_in_list`, `created_time`, `modified_time`, `site_id`, `type`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($comfort['name']) . "," . $comfort['status'] . "," . ClaGenerate::quoteValue($comfort['image_path'])
                    . "," . ClaGenerate::quoteValue($comfort['image_name']) . "," . $comfort['show_in_list'] . ",[now], [now],[site_id]" . "," . $comfort['type']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_comforts'] . $comfort['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_comforts']][$comfort['id']]['map'] = Yii::app()->params['tables']['tour_comforts'] . $comfort['id'];
            }
            $sql .= "\n";
        }
        // tour_province_info
        $tour_province_info = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_province_info'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($tour_province_info) {
            foreach ($tour_province_info as $proinfo) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_province_info'] . " (`id`, `province_id`, `status`, `showinhome`, `image_path`, `image_name`, `position`, `description`, `site_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($proinfo['province_id']) . "," . $proinfo['status'] . "," . $proinfo['showinhome']
                    . "," . ClaGenerate::quoteValue($proinfo['image_path']) . "," . ClaGenerate::quoteValue($proinfo['image_name']) . "," . $proinfo['position']
                    . "," . ClaGenerate::quoteValue($proinfo['description']) . ",[site_id]"
                    . ");" . "\n";
            }
            $sql .= "\n";
        }
        // Tour
        $tours = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tours) {
            foreach ($tours as $tour) {
                //process category track
                $track = $tour['category_track'];
                $tracks = array();
                if ($track != '') {
                    $tr_temp = explode(' ', $track);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id)
                            if (isset($store[Yii::app()->params['tables']['tour_categories']][$cat_id]))
                                array_push($tracks, '@' . $store[Yii::app()->params['tables']['tour_categories']][$cat_id]['map']);
                    }
                }
                $tracks = implode(",' ',", $tracks);
                if ($tracks != '')
                    $tracks = "CONCAT(" . $tracks . ")";
                else
                    $tracks = ClaGenerate::quoteValue($tracks);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour'] . " (`id`, `name`, `alias`, `price`, `price_market`, `departure_date`, `time`, `departure_at`, `destination`, `transport`, `partner_id`, `status`, `isnew`, `ishot`, `tour_category_id`, `category_track`, `avatar_path`, `avatar_name`, `avatar_id`, `position`, `created_time`, `modified_time`, `site_id`, `trip_map`, `tour_style_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($tour['name']) . "," . ClaGenerate::quoteValue($tour['alias']) . "," . $tour['price'] . "," . $tour['price_market']
                    . "," . ClaGenerate::quoteValue($tour['departure_date']) . "," . ClaGenerate::quoteValue($tour['time']) . "," . ClaGenerate::quoteValue($tour['departure_at'])
                    . "," . ClaGenerate::quoteValue($tour['destination']) . "," . ClaGenerate::quoteValue($tour['transport'])
                    . "," . (isset($store[Yii::app()->params['tables']['tour_partners']][$tour['partner_id']]) ? "@" . $store[Yii::app()->params['tables']['tour_partners']][$tour['partner_id']]['map'] : 0)
                    . "," . $tour['status'] . "," . $tour['isnew'] . "," . $tour['ishot']
                    . "," . (isset($store[Yii::app()->params['tables']['tour_categories']][$tour['tour_category_id']]) ? "@" . $store[Yii::app()->params['tables']['tour_categories']][$tour['tour_category_id']]['map'] : 0)
                    . "," . $tracks
                    . "," . ClaGenerate::quoteValue($tour['avatar_path']) . "," . ClaGenerate::quoteValue($tour['avatar_name']) . ",0," . $tour['position'] . ",[now],[now],[site_id]"
                    . "," . ClaGenerate::quoteValue($tour['trip_map'])
                    . "," . ClaGenerate::quoteValue($tour['tour_style_id'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour'] . $tour['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour']][$tour['id']]['map'] = Yii::app()->params['tables']['tour'] . $tour['id'];
            }
            $sql .= "\n";
        }
        //
        // tour_images
        $tour_images = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_images'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_images) {
            foreach ($tour_images as $ti) {
                if (!isset($store[Yii::app()->params['tables']['tour']][$ti['tour_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_images'] . " (`img_id`, `tour_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`) "
                    . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['tour']][$ti['tour_id']]['map'] . "," . ClaGenerate::quoteValue($ti['name']) . "," . ClaGenerate::quoteValue($ti['path'])
                    . "," . ClaGenerate::quoteValue($ti['display_name']) . "," . ClaGenerate::quoteValue($ti['description'])
                    . "," . ClaGenerate::quoteValue($ti['alias']) . ",[site_id],[user_id]," . $ti['height'] . "," . $ti['width'] . ",[now],[now]"
                    . "," . ClaGenerate::quoteValue($ti['resizes']) . "," . $ti['order']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_images'] . $ti['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_images']][$ti['img_id']]['map'] = Yii::app()->params['tables']['tour_images'] . $ti['img_id'];
            }
            $sql .= "\n";
            // Update avatar_id for tour
            foreach ($tours as $tour) {
                if (!isset($store[Yii::app()->params['tables']['tour_images']][$tour['avatar_id']]))
                    continue;
                $sql .= "UPDATE " . Yii::app()->params['tables']['tour'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['tour_images']][$tour['avatar_id']]['map']
                    . " WHERE id=@" . $store[Yii::app()->params['tables']['tour']][$tour['id']]['map'] . ";\n";
            }
            //
            $sql .= "\n\n";
            //
        }
        // tour_info
        $tour_info = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_info'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($tour_info) {
            foreach ($tour_info as $info) {
                if (!isset($store[Yii::app()->params['tables']['tour']][$info['tour_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_info'] . " (`tour_id`, `price_include`, `schedule`, `policy`, `meta_keywords`, `meta_description`, `meta_title`, `site_id`, `tour_plan`, `data_season_price`, `data_hotels_list`) "
                    . "VALUES ("
                    . '@' . $store[Yii::app()->params['tables']['tour']][$info['tour_id']]['map']
                    . "," . ClaGenerate::quoteValue($info['price_include']) . "," . ClaGenerate::quoteValue($info['schedule']) . "," . ClaGenerate::quoteValue($info['policy'])
                    . "," . ClaGenerate::quoteValue($info['meta_keywords']) . "," . ClaGenerate::quoteValue($info['meta_description']) . "," . ClaGenerate::quoteValue($info['meta_title'])
                    . ",[site_id]"
                    . "," . ClaGenerate::quoteValue($info['tour_plan'])
                    . "," . ClaGenerate::quoteValue($info['data_season_price'])
                    . "," . ClaGenerate::quoteValue($info['data_hotels_list'])
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        //tour hotel list
        $tour_hotels_list = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotels_list'))
            ->where("site_id=$site_id")
            ->queryAll();
        if($tour_hotels_list) {
            foreach($tour_hotels_list as $hotels_list) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotels_list'] . " (`id`, `name`, `description`, `site_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($hotels_list['name'])
                    . "," . ClaGenerate::quoteValue($hotels_list['description'])
                    . ",[site_id]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }

        // tour season
        $tour_season = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_season'))
            ->where("site_id=$site_id")
            ->queryAll();
        if($tour_season) {
            foreach($tour_season as $season) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_season'] . " (`id`, `name`, `site_id`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($season['name'])
                    . ",[site_id]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        // tour style
        $tour_style = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_style'))
            ->where("site_id=$site_id")
            ->queryAll();
        if($tour_style) {
            foreach($tour_style as $style) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_style'] . " (`id`, `name`, `description`, `site_id`, `alias`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($style['name'])
                    . "," . ClaGenerate::quoteValue($style['description'])
                    . ",[site_id]"
                    . "," . ClaGenerate::quoteValue($style['alias'])
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }

        // tour_hotel_group
        $tour_hotel_group = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_group'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_hotel_group) {
            foreach ($tour_hotel_group as $hgroup) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel_group'] . " (`id`, `name`, `alias`, `status`, `showinhome`, `image_path`, `image_name`, `sort_description`, `description`, `position`, `created_time`, `modified_time`, `site_id`, `meta_keywords`, `meta_description`, `meta_title`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($hgroup['name']) . "," . ClaGenerate::quoteValue($hgroup['alias']) . "," . $hgroup['status'] . "," . $hgroup['showinhome']
                    . "," . ClaGenerate::quoteValue($hgroup['image_path']) . "," . ClaGenerate::quoteValue($hgroup['image_name']) . "," . ClaGenerate::quoteValue($hgroup['sort_description'])
                    . "," . ClaGenerate::quoteValue($hgroup['description']) . "," . $hgroup['position'] . ",[now],[now],[site_id]"
                    . "," . ClaGenerate::quoteValue($hgroup['meta_keywords']) . "," . ClaGenerate::quoteValue($hgroup['meta_description']) . "," . ClaGenerate::quoteValue($hgroup['meta_title'])
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel_group'] . $hgroup['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_hotel_group']][$hgroup['id']]['map'] = Yii::app()->params['tables']['tour_hotel_group'] . $hgroup['id'];
            }
            $sql .= "\n\n";
        }
        // tour_tourist_destinations
        $tour_tourist_destinations = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_tourist_destinations'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_tourist_destinations) {
            foreach ($tour_tourist_destinations as $dest) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_tourist_destinations'] . " (`id`, `name`, `alias`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `description`, `created_time`, `modified_time`, `image_path`, `image_name`, `ishot`, `status`, `site_id`, `meta_keywords`, `meta_description`, `meta_title`, `showinhome`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($dest['name']) . "," . ClaGenerate::quoteValue($dest['alias']) . "," . ClaGenerate::quoteValue($dest['address'])
                    . "," . ClaGenerate::quoteValue($dest['province_id']) . "," . ClaGenerate::quoteValue($dest['province_name']) . "," . ClaGenerate::quoteValue($dest['district_id'])
                    . "," . ClaGenerate::quoteValue($dest['district_name']) . "," . ClaGenerate::quoteValue($dest['ward_id']) . "," . ClaGenerate::quoteValue($dest['ward_name'])
                    . "," . ClaGenerate::quoteValue($dest['description']) . ",[now],[now]," . ClaGenerate::quoteValue($dest['image_path']) . "," . ClaGenerate::quoteValue($dest['image_name'])
                    . "," . $dest['ishot'] . "," . $dest['status'] . ",[site_id]" . "," . ClaGenerate::quoteValue($dest['meta_keywords']) . "," . ClaGenerate::quoteValue($dest['meta_description'])
                    . "," . ClaGenerate::quoteValue($dest['meta_title']) . "," . $dest['showinhome']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_tourist_destinations'] . $dest['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_tourist_destinations']][$dest['id']]['map'] = Yii::app()->params['tables']['tour_tourist_destinations'] . $dest['id'];
            }
            $sql .= "\n\n";
        }
        // tour_hotel
        $tour_hotel = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_hotel) {
            foreach ($tour_hotel as $thotel) {
                //
                $comforts = $thotel['comforts_ids'];
                $comforts_ids = array();
                if ($comforts != '') {
                    $tr_temp = explode(',', $comforts);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cid)
                            if (isset($store[Yii::app()->params['tables']['tour_comforts']][$cid]))
                                array_push($comforts_ids, '@' . $store[Yii::app()->params['tables']['tour_comforts']][$cid]['map']);
                    }
                }
                $comforts_ids = implode(",',',", $comforts_ids);
                if ($comforts_ids != '')
                    $comforts_ids = "CONCAT(" . $comforts_ids . ")";
                else
                    $comforts_ids = ClaGenerate::quoteValue($comforts_ids);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel'] . " (`id`, `name`, `alias`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `image_path`, `image_name`, `avatar_id`, `sort_description`, `comforts_ids`, `status`, `site_id`, `created_time`, `modified_time`, `position`, `ishot`, `star`, `group_id`, `destination_id`, `min_price`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($thotel['name']) . "," . ClaGenerate::quoteValue($thotel['alias']) . "," . ClaGenerate::quoteValue($thotel['address']) . "," . ClaGenerate::quoteValue($thotel['province_id'])
                    . "," . ClaGenerate::quoteValue($thotel['province_name']) . "," . ClaGenerate::quoteValue($thotel['district_id']) . "," . ClaGenerate::quoteValue($thotel['district_name']) . "," . ClaGenerate::quoteValue($thotel['ward_id'])
                    . "," . ClaGenerate::quoteValue($thotel['ward_name']) . "," . ClaGenerate::quoteValue($thotel['image_path']) . "," . ClaGenerate::quoteValue($thotel['image_name']) . ",0," . ClaGenerate::quoteValue($thotel['sort_description'])
                    . "," . $comforts_ids
                    . "," . $thotel['status'] . ",[site_id],[now],[now]," . $thotel['position'] . "," . $thotel['ishot'] . "," . $thotel['star']
                    . "," . (isset($store[Yii::app()->params['tables']['tour_hotel_group']][$thotel['group_id']]) ? "@" . $store[Yii::app()->params['tables']['tour_hotel_group']][$thotel['group_id']]['map'] : 0)
                    . "," . (isset($store[Yii::app()->params['tables']['tour_tourist_destinations']][$thotel['destination_id']]) ? "@" . $store[Yii::app()->params['tables']['tour_tourist_destinations']][$thotel['destination_id']]['map'] : 0)
                    . "," . $thotel['min_price']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel'] . $thotel['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_hotel']][$thotel['id']]['map'] = Yii::app()->params['tables']['tour_hotel'] . $thotel['id'];
            }
            $sql .= "\n\n";
        }
        // tour_hotel_info
        $tour_hotel_info = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_info'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($tour_hotel_info) {
            foreach ($tour_hotel_info as $hoInfo) {
                if (!isset($store[Yii::app()->params['tables']['tour_hotel']][$hoInfo['hotel_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel_info'] . " (`hotel_id`, `meta_keywords`, `meta_description`, `meta_title`, `description`, `policy`, `site_id`) "
                    . "VALUES ("
                    . '@' . $store[Yii::app()->params['tables']['tour_hotel']][$hoInfo['hotel_id']]['map']
                    . "," . ClaGenerate::quoteValue($hoInfo['meta_keywords']) . "," . ClaGenerate::quoteValue($hoInfo['meta_description']) . "," . ClaGenerate::quoteValue($hoInfo['meta_title'])
                    . "," . ClaGenerate::quoteValue($hoInfo['description']) . "," . ClaGenerate::quoteValue($hoInfo['policy'])
                    . ",[site_id]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        // tour_hotel_images
        $tour_hotel_images = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_images'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_hotel_images) {
            foreach ($tour_hotel_images as $ti) {
                if (!isset($store[Yii::app()->params['tables']['tour_hotel']][$ti['hotel_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel_images'] . " (`img_id`, `hotel_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`) "
                    . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['tour_hotel']][$ti['hotel_id']]['map'] . "," . ClaGenerate::quoteValue($ti['name']) . "," . ClaGenerate::quoteValue($ti['path'])
                    . "," . ClaGenerate::quoteValue($ti['display_name']) . "," . ClaGenerate::quoteValue($ti['description'])
                    . "," . ClaGenerate::quoteValue($ti['alias']) . ",[site_id],[user_id]," . $ti['height'] . "," . $ti['width'] . ",[now],[now]"
                    . "," . ClaGenerate::quoteValue($ti['resizes']) . "," . $ti['order']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel_images'] . $ti['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_hotel_images']][$ti['img_id']]['map'] = Yii::app()->params['tables']['tour_hotel_images'] . $ti['img_id'];
            }
            $sql .= "\n";
            // Update avatar_id for tour
            foreach ($tour_hotel as $thotel) {
                if (!isset($store[Yii::app()->params['tables']['tour_images']][$thotel['avatar_id']]))
                    continue;
                $sql .= "UPDATE " . Yii::app()->params['tables']['tour_hotel'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['tour_hotel_images']][$thotel['avatar_id']]['map']
                    . " WHERE id=@" . $store[Yii::app()->params['tables']['tour_hotel']][$thotel['id']]['map'] . ";\n";
            }
            //
            $sql .= "\n\n";
            //
        }
        // tour_hotel_room
        $tour_hotel_room = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_room'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_hotel_room) {
            foreach ($tour_hotel_room as $thr) {
                if (!isset($store[Yii::app()->params['tables']['tour_hotel']][$thr['hotel_id']]))
                    continue;
                //
                $comforts = $thr['comforts_ids'];
                $comforts_ids = array();
                if ($comforts != '') {
                    $tr_temp = explode(',', $comforts);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cid)
                            if (isset($store[Yii::app()->params['tables']['tour_comforts']][$cid]))
                                array_push($comforts_ids, '@' . $store[Yii::app()->params['tables']['tour_comforts']][$cid]['map']);
                    }
                }
                $comforts_ids = implode(",',',", $comforts_ids);
                if ($comforts_ids != '')
                    $comforts_ids = "CONCAT(" . $comforts_ids . ")";
                else
                    $comforts_ids = ClaGenerate::quoteValue($comforts_ids);
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel_room'] . " (`id`, `name`, `alias`, `hotel_id`, `status`, `area`, `single_bed`, `double_bed`, `single_bed_bonus`, `double_bed_bonus`, `price`, `price_market`, `comforts_ids`, `image_path`, `image_name`, `avatar_id`, `sort_description`, `description`, `created_time`, `modified_time`, `site_id`, `position`, `ishot`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($thr['name']) . "," . ClaGenerate::quoteValue($thr['alias'])
                    . "," . '@' . $store[Yii::app()->params['tables']['tour_hotel']][$thr['hotel_id']]['map']
                    . "," . $thr['status'] . "," . $thr['area'] . "," . $thr['single_bed'] . "," . $thr['double_bed'] . "," . $thr['single_bed_bonus'] . "," . $thr['double_bed_bonus']
                    . "," . $thr['price'] . "," . $thr['price_market'] . "," . $comforts_ids
                    . "," . ClaGenerate::quoteValue($thr['image_path']) . "," . ClaGenerate::quoteValue($thr['image_name']) . ",0"
                    . "," . ClaGenerate::quoteValue($thr['sort_description']) . "," . ClaGenerate::quoteValue($thr['description'])
                    . ",[now],[now],[site_id]," . $thr['position'] . "," . (int) $thr['ishot']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel_room'] . $thr['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_hotel_room']][$thr['id']]['map'] = Yii::app()->params['tables']['tour_hotel_room'] . $thr['id'];
            }
            $sql .= "\n";
        }
        // tour_hotel_room_images
        $tour_hotel_room_images = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_hotel_room_images'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_hotel_room_images) {
            foreach ($tour_hotel_room_images as $ti) {
                if (!isset($store[Yii::app()->params['tables']['tour_hotel_room']][$ti['room_id']]))
                    continue;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_hotel_room_images'] . " (`img_id`, `room_id`, `name`, `path`, `display_name`, `description`, `alias`, `site_id`, `user_id`, `height`, `width`, `created_time`, `modified_time`, `resizes`, `order`) "
                    . "VALUES (null," . '@' . $store[Yii::app()->params['tables']['tour_hotel_room']][$ti['room_id']]['map'] . "," . ClaGenerate::quoteValue($ti['name']) . "," . ClaGenerate::quoteValue($ti['path'])
                    . "," . ClaGenerate::quoteValue($ti['display_name']) . "," . ClaGenerate::quoteValue($ti['description'])
                    . "," . ClaGenerate::quoteValue($ti['alias']) . ",[site_id],[user_id]," . $ti['height'] . "," . $ti['width'] . ",[now],[now]"
                    . "," . ClaGenerate::quoteValue($ti['resizes']) . "," . $ti['order']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel_room_images'] . $ti['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_hotel_room_images']][$ti['img_id']]['map'] = Yii::app()->params['tables']['tour_hotel_room_images'] . $ti['img_id'];
            }
            $sql .= "\n";
            // Update avatar_id for tour
            foreach ($tour_hotel_room as $thotelRoom) {
                if (!isset($store[Yii::app()->params['tables']['tour_hotel_room_images']][$thotelRoom['avatar_id']]))
                    continue;
                $sql .= "UPDATE " . Yii::app()->params['tables']['tour_hotel_room'] . " SET avatar_id=@" . $store[Yii::app()->params['tables']['tour_hotel_room_images']][$thotelRoom['avatar_id']]['map']
                    . " WHERE id=@" . $store[Yii::app()->params['tables']['tour_hotel_room']][$thotelRoom['id']]['map'] . ";\n";
            }
            //
            $sql .= "\n\n";
            //
        }
        // tour_booking
        $tour_booking = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('tour_booking'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($tour_booking) {
            foreach ($tour_booking as $tb) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['tour_booking'] . " (`booking_id`, `user_id`, `name`, `phone`, `email`, `address`, `province_id`, `payment_method`, `status_payment`, `status`, `coupon_code`, `note`, `ip_address`, `checking_in`, `checking_out`, `type`, `departure_date`, `created_time`, `modified_time`, `site_id`, `adults`, `children`, `age_children`, `bed_type`, `extra_bed`, `sex`, `company`, `transfer_request`, `arrival_time`, `travel_time`, `payment_methods`) "
                    . "VALUES (null,[user_id]"
                    . "," . ClaGenerate::quoteValue($tb['name']) . "," . ClaGenerate::quoteValue($tb['phone']) . "," . ClaGenerate::quoteValue($tb['email'])
                    . "," . ClaGenerate::quoteValue($tb['address']) . "," . ClaGenerate::quoteValue($tb['province_id']) . "," . ClaGenerate::quoteValue($tb['payment_method']) . "," . $tb['status_payment']
                    . "," . $tb['status'] . "," . ClaGenerate::quoteValue($tb['coupon_code']) . "," . ClaGenerate::quoteValue($tb['note']) . "," . ClaGenerate::quoteValue($tb['ip_address'])
                    . "," . $tb['checking_in'] . "," . $tb['checking_out'] . "," . $tb['type'] . "," . $tb['departure_date']
                    . ",[now],[now],[site_id]"
                    . "," . (int) $tb['adults'] . "," . (int) $tb['children'] . "," . (int) $tb['age_children'] . "," . (int) $tb['bed_type']
                    . "," . (int) $tb['extra_bed'] . "," . (int) $tb['sex'] . "," . ClaGenerate::quoteValue($tb['company']) . "," . (int) $tb['transfer_request']
                    . "," . (int) $tb['arrival_time'] . "," . (int) $tb['travel_time'] . "," . (int) $tb['payment_methods']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['tour_hotel_room_images'] . $ti['img_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['tour_booking']][$ti['booking_id']]['map'] = Yii::app()->params['tables']['tour_booking'] . $ti['booking_id'];
            }
            $sql .= "\n\n";
        }
        // --------------------------------------------------- END Tour -----------------------------------------------------------------
        //
        // --------------------------------------------------- Service -----------------------------------------------------------------
        // Danh mục services
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_categories'))) {
            $seCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_categories'))
                ->where("site_id=$site_id")
                ->order('created_time')
                ->queryAll();
            if ($seCategories) {
                while ($cc = array_shift($seCategories)) {
                    if (!isset($store[ClaTable::getTable('se_categories')][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                        $cc['browse'] = true;
                        array_push($seCategories, $cc);
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_categories'] . " (cat_id, site_id, cat_parent, cat_name, `alias`, cat_order, cat_description, cat_countchild, image_path, image_name, `status`, created_time, modified_time, showinhome, meta_title, meta_keywords, meta_description, icon_path, icon_name, user_id) "
                        . "VALUES (null,[site_id]"
                        . "," . (isset($store[Yii::app()->params['tables']['se_categories']][$cc['cat_parent']]) ? "@" . $store[Yii::app()->params['tables']['se_categories']][$cc['cat_parent']]['map'] : 0)
                        . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                        . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                        . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_title']) . "," . ClaGenerate::quoteValue($cc['meta_keywords']) . "," . ClaGenerate::quoteValue($cc['meta_description'])
                        . "," . ClaGenerate::quoteValue($cc['icon_path']) . "," . ClaGenerate::quoteValue($cc['icon_name'])
                        . ",[user_id]"
                        . ");" . "\n";
                    $sql .= "set @" . Yii::app()->params['tables']['se_categories'] . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                    //
                    $store[Yii::app()->params['tables']['se_categories']][$cc['cat_id']]['map'] = Yii::app()->params['tables']['se_categories'] . $cc['cat_id'];
                }
                $sql .= "\n";
            }
        }
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_categories'))) {
            // Services
            $services = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_services'))
                ->where("site_id=$site_id")
                ->queryAll();
        } else {
            $services = array();
        }
        if ($services) {
            foreach ($services as $object) {
                //process category track
                $track = $object['category_track'];
                $tracks = array();
                if ($track != '') {
                    $tr_temp = explode(' ', $track);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id)
                            if (isset($store[Yii::app()->params['tables']['se_categories']][$cat_id]))
                                array_push($tracks, '@' . $store[Yii::app()->params['tables']['se_categories']][$cat_id]['map']);
                    }
                }
                $tracks = implode(",' ',", $tracks);
                if ($tracks != '') {
                    $tracks = "CONCAT(" . $tracks . ")";
                } else {
                    $tracks = ClaGenerate::quoteValue($tracks);
                }
                //
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_services'] . " (`id`, `name`, `site_id`, `category_id`, `category_track`, `status`, `price`, `padding_left`, `padding_right`, `duration`, `order`, `alias`, `image_path`, `image_name`, `created_time`, `modified_time`, `created_by`, `modified_by`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($object['name']) . ",[site_id]"
                    . "," . (($object['category_id']) ? "@" . $store[Yii::app()->params['tables']['se_categories']][$object['category_id']]['map'] : $object['category_id']) . "," . $tracks
                    . "," . $object['status'] . "," . $object['price'] . "," . $object['padding_left'] . "," . $object['padding_right'] . "," . $object['duration'] . "," . $object['order']
                    . "," . ClaGenerate::quoteValue($object['alias']) . "," . ClaGenerate::quoteValue($object['image_path']) . "," . ClaGenerate::quoteValue($object['image_name'])
                    . ",[now],[now],[user_id],[user_id]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['se_services'] . $object['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['se_services']][$object['id']]['map'] = Yii::app()->params['tables']['se_services'] . $object['id'];
            }
            $sql .= "\n";
            // Service info
            $serviceInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_services_info'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($serviceInfos) {
                foreach ($serviceInfos as $info) {
                    if (!isset($store[Yii::app()->params['tables']['se_services']][$info['service_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_services_info'] . " (`service_id`, `site_id`, `description`, `meta_keywords`, `meta_description`, `meta_title`) "
                        . "VALUES ("
                        . '@' . $store[Yii::app()->params['tables']['se_services']][$info['service_id']]['map'] . ",[site_id]"
                        . "," . ClaGenerate::quoteValue($info['description']) . "," . ClaGenerate::quoteValue($info['meta_keywords']) . "," . ClaGenerate::quoteValue($info['meta_description'])
                        . "," . ClaGenerate::quoteValue($info['meta_title'])
                        . ");" . "\n";
                }
                $sql .= "\n\n";
            }
        }
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_providers'))) {
            // Providers
            $providers = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_providers'))
                ->where("site_id=$site_id")
                ->queryAll();
        } else {
            $providers = array();
        }
        if ($providers) {
            foreach ($providers as $object) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_providers'] . " (`id`, `site_id`, `name`, `email`, `address`, `status`, `phone`, `type`, `alias`, `avatar_path`, `avatar_name`, `created_time`, `modified_time`) "
                    . "VALUES (null"
                    . ",[site_id]," . ClaGenerate::quoteValue($object['name']) . "," . ClaGenerate::quoteValue($object['email']) . "," . ClaGenerate::quoteValue($object['address'])
                    . "," . $object['status'] . "," . ClaGenerate::quoteValue($object['phone']) . "," . $object['type']
                    . "," . ClaGenerate::quoteValue($object['alias']) . "," . ClaGenerate::quoteValue($object['avatar_path']) . "," . ClaGenerate::quoteValue($object['avatar_name'])
                    . ",[now],[now]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['se_providers'] . $object['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['se_providers']][$object['id']]['map'] = Yii::app()->params['tables']['se_providers'] . $object['id'];
            }
            // Provider info
            $providerInfos = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_providers_info'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($providerInfos) {
                foreach ($providerInfos as $info) {
                    if (!isset($store[Yii::app()->params['tables']['se_providers']][$info['provider_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_providers_info'] . " (`provider_id`, `site_id`, `description`, `meta_keywords`, `meta_description`, `meta_title`) "
                        . "VALUES ("
                        . '@' . $store[Yii::app()->params['tables']['se_providers']][$info['provider_id']]['map'] . ",[site_id]"
                        . "," . ClaGenerate::quoteValue($info['description']) . "," . ClaGenerate::quoteValue($info['meta_keywords']) . "," . ClaGenerate::quoteValue($info['meta_description'])
                        . "," . ClaGenerate::quoteValue($info['meta_title'])
                        . ");" . "\n";
                }
                $sql .= "\n\n";
            }
        }
        //
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_provider_services'))) {
            $se_provider_services = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_provider_services'))
                ->where("site_id=$site_id")
                ->queryAll();
        } else {
            $se_provider_services = array();
        }
        if ($se_provider_services) {
            foreach ($se_provider_services as $info) {
                if (!isset($store[Yii::app()->params['tables']['se_providers']][$info['provider_id']]) || !isset($store[Yii::app()->params['tables']['se_services']][$info['service_id']])) {
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_provider_services'] . " (`id`, `service_id`, `provider_id`, `site_id`, `price`, `capacity`, `duration`, `created_time`) "
                    . "VALUES (null"
                    . "," . '@' . $store[Yii::app()->params['tables']['se_services']][$info['service_id']]['map']
                    . "," . '@' . $store[Yii::app()->params['tables']['se_providers']][$info['provider_id']]['map']
                    . ",[site_id]," . $info['price'] . "," . $info['capacity'] . "," . $info['duration'] . ",[now]"
                    . ");" . "\n";
            }
            $sql .= "\n\n";
        }
        //
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_provider_schedules'))) {
            $se_provider_schedules = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_provider_schedules'))
                ->where("site_id=$site_id")
                ->queryAll();
        } else {
            $se_provider_schedules = array();
        }
        if ($se_provider_schedules) {
            foreach ($se_provider_schedules as $info) {
                if (!isset($store[Yii::app()->params['tables']['se_providers']][$info['provider_id']])) {
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_provider_schedules'] . " (`id`, `site_id`, `provider_id`, `day_index`, `start_time`, `end_time`) "
                    . "VALUES (null,[site_id]"
                    . "," . '@' . $store[Yii::app()->params['tables']['se_providers']][$info['provider_id']]['map']
                    . "," . $info['day_index'] . "," . $info['start_time'] . "," . $info['end_time']
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['se_provider_schedules'] . $info['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['se_provider_schedules']][$info['id']]['map'] = Yii::app()->params['tables']['se_provider_schedules'] . $info['id'];
            }
            $sql .= "\n";
            //
            $se_provider_schedule_breaks = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_provider_schedule_breaks'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($se_provider_schedule_breaks) {
                foreach ($se_provider_schedule_breaks as $info) {
                    if (!isset($store[Yii::app()->params['tables']['se_provider_schedules']][$info['provider_schedule_id']])) {
                        continue;
                    }
                    $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_provider_schedule_breaks'] . " (`id`, `site_id`, `provider_schedule_id`, `start_time`, `end_time`) "
                        . "VALUES (null,[site_id]"
                        . "," . '@' . $store[Yii::app()->params['tables']['se_provider_schedules']][$info['provider_schedule_id']]['map']
                        . "," . $info['start_time'] . "," . $info['end_time']
                        . ");" . "\n";
                }
            }
        }
        // Dayoff
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('se_daysoff'))) {
            $se_daysoff = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('se_daysoff'))
                ->where("site_id=$site_id")
                ->queryAll();
        } else {
            $se_daysoff = array();
        }
        if ($se_daysoff) {
            while ($cc = array_shift($se_daysoff)) {
                if (!isset($store[ClaTable::getTable('se_daysoff')][$cc['parent_id']]) && $cc['parent_id'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($se_daysoff, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['se_daysoff'] . " (`id`, `site_id`, `provider_id`, `parent_id`, `day`, `month`, `year`, `repeat`, `created_time`) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[Yii::app()->params['tables']['se_providers']][$cc['provider_id']]) ? "@" . $store[Yii::app()->params['tables']['se_providers']][$cc['provider_id']]['map'] : 0)
                    . "," . (isset($store[Yii::app()->params['tables']['se_daysoff']][$cc['parent_id']]) ? "@" . $store[Yii::app()->params['tables']['se_daysoff']][$cc['parent_id']]['map'] : 0)
                    . "," . $cc['day'] . "," . $cc['month'] . "," . $cc['year'] . "," . $cc['repeat']
                    . ",[now]"
                    . ");" . "\n";
                $sql .= "set @" . Yii::app()->params['tables']['se_daysoff'] . $cc['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['se_daysoff']][$cc['id']]['map'] = Yii::app()->params['tables']['se_daysoff'] . $cc['id'];
            }
            $sql .= "\n";
        }
        // --------------------------------------------------- END Service -----------------------------------------------------------------
        // --------------------------------------------------- Gift card -----------------------------------------------------------------
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('gift_card'))) {
            $giftcards = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('gift_card'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($giftcards) {
                foreach ($giftcards as $info) {
                    $sql .= "INSERT INTO " . ClaTable::getTable('gift_card') . " (`id`, `name`, `src`, `width`, `height`, `description`, `created_time`, `order`, `status`, `site_id`) "
                        . "VALUES (null"
                        . "," . ClaGenerate::quoteValue($info['name']) . "," . ClaGenerate::quoteValue($info['src']) . "," . (int) $info['width'] . "," . (int) $info['height']
                        . "," . ClaGenerate::quoteValue($info['description']) . ",[now]," . (int) $info['order'] . "," . (int) $info['status'] . ",[site_id]"
                        . ");" . "\n";
//                    $sql.= "set @" . Yii::app()->params['tables']['gift_card'] . $info['id'] . " = LAST_INSERT_ID();" . "\n";
//                    //
//                    $store[Yii::app()->params['tables']['gift_card']][$info['id']]['map'] = Yii::app()->params['tables']['gift_card'] . $info['id'];
                }
                $sql .= "\n";
            }
        }
        // --------------------------------------------------- END Gift Card -----------------------------------------------------------------
        if (Yii::app()->db->schema->getTable(ClaTable::getTable('brand'))) {
            $brands = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('brand'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($brands) {
                foreach ($brands as $info) {
                    $sql .= "INSERT INTO " . ClaTable::getTable('brand') . " (`id`, `name`, `alias`, `avatar_path`, `avatar_name`, `cover_path`, `cover_name`, `link_site`, `address`, `phone`, `created_time`, `modified_time`, `status`, `site_id`, `order`, `description`, `meta_title`, `meta_description`, `meta_keywords`) "
                        . "VALUES (null"
                        . "," . ClaGenerate::quoteValue($info['name']) . "," . ClaGenerate::quoteValue($info['alias']) . "," . ClaGenerate::quoteValue($info['avatar_path']) . "," . ClaGenerate::quoteValue($info['avatar_name'])
                        . "," . ClaGenerate::quoteValue($info['cover_path']) . "," . ClaGenerate::quoteValue($info['cover_name']) . "," . ClaGenerate::quoteValue($info['link_site']) . "," . ClaGenerate::quoteValue($info['address'])
                        . "," . ClaGenerate::quoteValue($info['phone']) . ",[now],[now]," . (int) $info['status'] . ",[site_id]" . "," . (int) $info['order'] . "," . ClaGenerate::quoteValue($info['description'])
                        . "," . ClaGenerate::quoteValue($info['meta_title']) . "," . ClaGenerate::quoteValue($info['meta_description']) . "," . ClaGenerate::quoteValue($info['meta_keywords'])
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
        }
        // //
        // -------------------------------------------------- Thue Do ----------------------------------------------------------------------------------
        // Rent categories
        $destinations = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('destinations'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($destinations) {
            foreach ($destinations as $cc) {
                $sql .= "INSERT INTO " . ClaTable::getTable('destinations') . " (`id`, `name`, `alias`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `description`, `created_time`, `modified_time`, `image_path`, `image_name`, `ishot`, `status`, `site_id`, `meta_keywords`, `meta_description`, `meta_title`, `showinhome`) "
                    . "VALUES (null"
                    . "," . ClaGenerate::quoteValue($cc['name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . ClaGenerate::quoteValue($cc['address'])
                    . "," . ClaGenerate::quoteValue($cc['province_id']) . "," . ClaGenerate::quoteValue($cc['province_name']) . "," . ClaGenerate::quoteValue($cc['district_id'])
                    . "," . ClaGenerate::quoteValue($cc['district_name']) . "," . ClaGenerate::quoteValue($cc['ward_id']) . "," . ClaGenerate::quoteValue($cc['ward_name']) . "," . ClaGenerate::quoteValue($cc['description'])
                    . ",[now], [now]"
                    . "," . ClaGenerate::quoteValue($cc['image_path']) . "," . ClaGenerate::quoteValue($cc['image_name'])
                    . "," . $cc['ishot'] . "," . $cc['status'] . ",[site_id]" . "," . ClaGenerate::quoteValue($cc['meta_keywords']) . "," . ClaGenerate::quoteValue($cc['meta_description']) . "," . ClaGenerate::quoteValue($cc['meta_title']) . "," . $cc['showinhome']
                    . ");" . "\n";
                $sql .= "set @" . ClaTable::getTable('destinations') . $cc['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[ClaTable::getTable('destinations')][$cc['id']]['map'] = ClaTable::getTable('destinations') . $cc['id'];
            }
            $sql .= "\n";
        }

        // Rent categories
        $rentCategories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('rent_categories'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($destinations) {
            while ($cc = array_shift($rentCategories)) {
                if (!isset($store[ClaTable::getTable('rent_categories')][$cc['cat_parent']]) && $cc['cat_parent'] && !isset($cc['browse'])) {
                    $cc['browse'] = true;
                    array_push($rentCategories, $cc);
                    continue;
                }
                $sql .= "INSERT INTO " . ClaTable::getTable('rent_categories') . " (`cat_id`, `site_id`, `cat_parent`, `cat_name`, `alias`, `cat_order`, `cat_description`, `cat_countchild`, `image_path`, `image_name`, `status`, `created_time`, `modified_time`, `showinhome`, `meta_keywords`, `meta_description`, `meta_title`, `icon_path`, `icon_name`, `layout_action`, `view_action`, `cover_path`, `cover_name`) "
                    . "VALUES (null,[site_id]"
                    . "," . (isset($store[ClaTable::getTable('rent_categories')][$cc['cat_parent']]) ? "@" . $store[ClaTable::getTable('rent_categories')][$cc['cat_parent']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($cc['cat_name']) . "," . ClaGenerate::quoteValue($cc['alias']) . "," . $cc['cat_order']
                    . "," . ClaGenerate::quoteValue($cc['cat_description']) . "," . $cc['cat_countchild'] . "," . ClaGenerate::quoteValue($cc['image_path'])
                    . "," . ClaGenerate::quoteValue($cc['image_name']) . "," . $cc['status'] . ",[now], [now]," . $cc['showinhome'] . "," . ClaGenerate::quoteValue($cc['meta_keywords']) . "," . ClaGenerate::quoteValue($cc['meta_description'])
                    . "," . ClaGenerate::quoteValue($cc['meta_title']) . "," . ClaGenerate::quoteValue($cc['icon_path']) . "," . ClaGenerate::quoteValue($cc['icon_name'])
                    . "," . ClaGenerate::quoteValue($cc['layout_action']) . "," . ClaGenerate::quoteValue($cc['view_action'])
                    . "," . ClaGenerate::quoteValue($cc['cover_path']) . "," . ClaGenerate::quoteValue($cc['cover_name'])
                    . ");" . "\n";
                $sql .= "set @" . ClaTable::getTable('rent_categories') . $cc['cat_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[ClaTable::getTable('rent_categories')][$cc['cat_id']]['map'] = ClaTable::getTable('rent_categories') . $cc['cat_id'];
            }
            $sql .= "\n";
        }
        // Product Rent
        $productRents = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('rent_product'))
            ->where("site_id=$site_id")
            ->order('created_time')
            ->queryAll();
        if ($productRents) {
            foreach ($productRents as $rent) {
                //process category track
                $track = $rent['category_track'];
                $tracks = array();
                if ($track != '') {
                    $tr_temp = explode(' ', $track);
                    if ($tr_temp && count($tr_temp)) {
                        foreach ($tr_temp as $cat_id) {
                            if (isset($store[ClaTable::getTable('rent_categories')][$cat_id])) {
                                array_push($tracks, '@' . $store[ClaTable::getTable('rent_categories')][$cat_id]['map']);
                            }
                        }
                    }
                }
                $tracks = implode(",' ',", $tracks);
                if ($tracks != '')
                    $tracks = "CONCAT(" . $tracks . ")";
                else
                    $tracks = ClaGenerate::quoteValue($tracks);
                //
                $sql .= "INSERT INTO " . ClaTable::getTable('rent_product') . " (`id`, `category_id`, `name`, `sortdesc`, `description`, `alias`, `status`, `meta_keywords`, `meta_description`, `meta_title`, `site_id`, `user_id`, `image_path`, `image_name`, `created_time`, `modified_time`, `modified_by`, `ishot`, `source`, `poster`, `publicdate`, `store_ids`, `viewed`, `category_track`, `video_links`, `use_avatar_in_detail`, `cover_path`, `cover_name`, `cover_id`, `destination_id`, `price`, `order`, `language_path`, `language_name`, `insurance_fee`, `deposits`) "
                    . "VALUES (null"
                    . "," . (isset($store[ClaTable::getTable('rent_categories')][$rent['category_id']]) ? "@" . $store[ClaTable::getTable('rent_categories')][$rent['category_id']]['map'] : 0)
                    . "," . ClaGenerate::quoteValue($rent['name']) . "," . ClaGenerate::quoteValue($tour['sortdesc']) . "," . ClaGenerate::quoteValue($tour['description'])
                    . "," . ClaGenerate::quoteValue($rent['alias']) . "," . (int) $rent['status']
                    . "," . ClaGenerate::quoteValue($rent['meta_keywords']) . "," . ClaGenerate::quoteValue($rent['meta_description']) . "," . ClaGenerate::quoteValue($rent['meta_title'])
                    . "," . "[site_id]" . "," . "[user_id]"
                    . "," . ClaGenerate::quoteValue($rent['image_path']) . "," . ClaGenerate::quoteValue($rent['image_name']) . ",[now],[now],[user_id]"
                    . "," . $rent['ishot'] . "," . ClaGenerate::quoteValue($rent['source']) . "," . ClaGenerate::quoteValue($rent['poster'])
                    . "," . $rent['publicdate'] . "," . ClaGenerate::quoteValue($rent['store_ids']) . "," . (int) ($rent['viewed'])
                    . "," . $tracks
                    . "," . ClaGenerate::quoteValue($rent['video_links']) . "," . (int) ($rent['use_avatar_in_detail'])
                    . "," . ClaGenerate::quoteValue($rent['cover_path']) . "," . ClaGenerate::quoteValue($rent['cover_name']) . "," . (int) ($rent['cover_id'])
                    . "," . (isset($store[ClaTable::getTable('destinations')][$rent['destination_id']]) ? "@" . $store[ClaTable::getTable('destinations')][$rent['destination_id']]['map'] : 0)
                    . "," . floatval($rent['price']) . "," . (int) $rent['order'] . "," . ClaGenerate::quoteValue($rent['language_path']) . "," . (int) ($rent['language_name'])
                    . "," . floatval($rent['insurance_fee']) . "," . floatval($rent['deposits'])
                    . ");" . "\n";
                $sql .= "set @" . ClaTable::getTable('rent_product') . $rent['id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[ClaTable::getTable('rent_product')][$rent['id']]['map'] = ClaTable::getTable('rent_product') . $rent['id'];
                //
            }
            $sql .= "\n";
            // rent product price
            $productRentsPrice = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('rent_product_price'))
                ->where("site_id=$site_id")
                ->queryAll();
            if ($productRentsPrice) {
                foreach ($productRentsPrice as $rent) {
                    //
                    $sql .= "INSERT INTO " . ClaTable::getTable('rent_product_price') . " (`id`, `rent_product_id`, `rent_category_id`, `price_market`, `price`, `insurance_fee`, `deposits`, `site_id`) "
                        . "VALUES (null"
                        . "," . (isset($store[ClaTable::getTable('rent_product')][$rent['rent_product_id']]) ? "@" . $store[ClaTable::getTable('rent_product')][$rent['rent_product_id']]['map'] : 0)
                        . "," . (isset($store[ClaTable::getTable('rent_categories')][$rent['rent_category_id']]) ? "@" . $store[ClaTable::getTable('rent_categories')][$rent['rent_category_id']]['map'] : 0)
                        . "," . floatval($rent['price_market'])
                        . "," . floatval($rent['price'])
                        . "," . floatval($rent['insurance_fee']) . "," . floatval($rent['deposits'])
                        . "," . "[site_id]"
                        . ");" . "\n";
                }
                $sql .= "\n";
            }
        }
        // ------------------
        // -------------------------------------------------- End Thue Do ----------------------------------------------------------------------------------
        // Menu group
        $menugroup = MenuGroups::getAllMenuGroup();
        foreach ($menugroup as $mg) {
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['menu_group'] . " (menu_group_id, menu_group_name, menu_group_description, site_id, user_id, config, created_time, modified_time, modified_by, menu_group_type) "
                . "VALUES (null," . ClaGenerate::quoteValue($mg['menu_group_name']) . "," . ClaGenerate::quoteValue($mg['menu_group_description']) . ",[site_id],[user_id]"
                . "," . ClaGenerate::quoteValue($mg['config']) . ",[now],[now],[user_id]," . $mg['menu_group_type']
                . ");" . "\n";
            //
            $sql .= "set @" . Yii::app()->params['tables']['menu_group'] . $mg['menu_group_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu_group']][$mg['menu_group_id']]['map'] = Yii::app()->params['tables']['menu_group'] . $mg['menu_group_id'];
        }
        $sql .= "\n";
        // Menu
        $menus = Menus::getAllMenuInSite(null, 'created_time');
        $menuTemp = array();
        foreach ($menus as $menu) {
            $menu = Menus::prepareDataForBuild($menu, $store);
            if ($menu['parent_id'] && isset($store[Yii::app()->params['tables']['menu']][$menu['parent_id']])) {
                $parent = "@" . $store[Yii::app()->params['tables']['menu']][$menu['parent_id']]['map'];
            } else {
                if ($menu['parent_id'] && !isset($store[Yii::app()->params['tables']['menu']][$menu['parent_id']])) {
                    $menuTemp[$menu['menu_id']] = $menu['parent_id'];
                }
                $parent = 0;
            }
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['menu'] . " (menu_id, site_id, user_id, menu_group, menu_title, parent_id, menu_linkto, menu_link, menu_basepath, menu_pathparams, menu_order, `alias`, `status`, menu_target, menu_values, icon_path, icon_name, background_path, background_name, description, created_time, modified_time, modified_by) "
                . "VALUES (null,[site_id],[user_id]," . (isset($store[Yii::app()->params['tables']['menu_group']][$menu['menu_group']]) ? '@' . $store[Yii::app()->params['tables']['menu_group']][$menu['menu_group']]['map'] : 0) . "," . ClaGenerate::quoteValue($menu['menu_title'])
                . "," . $parent
                . "," . $menu['menu_linkto'] . "," . ClaGenerate::quoteValue($menu['menu_link']) . ',' . ClaGenerate::quoteValue($menu['menu_basepath']) . "," . $menu['menu_pathparams']
                . "," . $menu['menu_order'] . "," . ClaGenerate::quoteValue($menu['alias']) . "," . $menu['status'] . "," . $menu['menu_target']
                . "," . $menu['menu_values'] . "," . ClaGenerate::quoteValue($menu['icon_path']) . "," . ClaGenerate::quoteValue($menu['icon_name']) . "," . ClaGenerate::quoteValue($menu['background_path']) . "," . ClaGenerate::quoteValue($menu['background_name'])
                . "," . ClaGenerate::quoteValue($menu['description'])
                . ",[now],[now],[user_id]"
                . ");" . "\n";
            //
            $sql .= "set @" . Yii::app()->params['tables']['menu'] . $menu['menu_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu']][$menu['menu_id']]['map'] = Yii::app()->params['tables']['menu'] . $menu['menu_id'];
        }
        if (count($menuTemp)) {
            foreach ($menuTemp as $menu_id => $menu_parent) {
                if (!isset($store[Yii::app()->params['tables']['menu']][$menu_parent]))
                    continue;
                $sql .= "UPDATE " . Yii::app()->params['tables']['menu'] . " SET parent_id=@" . $store[Yii::app()->params['tables']['menu']][$menu_parent]['map']
                    . " WHERE menu_id=@" . $store[Yii::app()->params['tables']['menu']][$menu_id]['map'] . ";\n";
            }
            unset($menuTemp);
        }
        $sql .= "\n\n";
        //
        // Menu Admin
        $menusadmin = MenusAdmin::getAllMenuInSite(null, 'created_time');
        foreach ($menusadmin as $menu) {
            $menu = MenusAdmin::prepareDataForBuild($menu, $store);
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['menu_admin'] . " (menu_id, site_id, user_id, menu_title, parent_id, menu_linkto, menu_link, menu_basepath, menu_pathparams, menu_order, `alias`, `status`, menu_target, menu_values, iconclass, created_time, modified_time, modified_by) "
                . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($menu['menu_title']) . "," . (isset($store[Yii::app()->params['tables']['menu_admin']][$menu['parent_id']]) ? "@" . $store[Yii::app()->params['tables']['menu_admin']][$menu['parent_id']]['map'] : 0)
                . "," . $menu['menu_linkto'] . "," . ClaGenerate::quoteValue($menu['menu_link']) . ',' . ClaGenerate::quoteValue($menu['menu_basepath']) . "," . $menu['menu_pathparams']
                . "," . (int) $menu['menu_order'] . "," . ClaGenerate::quoteValue($menu['alias']) . "," . $menu['status'] . "," . $menu['menu_target']
                . "," . ClaGenerate::quoteValue($menu['menu_values']) . "," . ClaGenerate::quoteValue($menu['iconclass']) . ",[now],[now],[user_id]"
                . ");" . "\n";
            //
            $sql .= "set @" . Yii::app()->params['tables']['menu_admin'] . $menu['menu_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['menu_admin']][$menu['menu_id']]['map'] = Yii::app()->params['tables']['menu_admin'] . $menu['menu_id'];
        }
        $sql .= "\n\n";
        // forms
        $forms = Forms::getAllForm();
        if (count($forms)) {
            foreach ($forms as $form) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['form'] . " (form_id, sendmail, form_code, form_name, form_description, site_id, `status`, created_time, modified_time, user_id) "
                    . "VALUES (null," . (int) $form['sendmail'] . "," . ClaGenerate::quoteValue($form['form_code']) . "," . ClaGenerate::quoteValue($form['form_name']) . "," . ClaGenerate::quoteValue($form['form_description'])
                    . ",[site_id]," . $form['status'] . ",[now],[now],[user_id]"
                    . ");" . "\n";
                //
                $sql .= "set @" . Yii::app()->params['tables']['form'] . $form['form_id'] . " = LAST_INSERT_ID();" . "\n";
                //
                $store[Yii::app()->params['tables']['form']][$form['form_id']]['map'] = Yii::app()->params['tables']['form'] . $form['form_id'];
            }
            $sql .= "\n";
            $formsfields = FormFields::getFieldsInSite();
            $countfields = count($formsfields);
            if ($countfields) {
                $i = 0;
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['formfield'] . " (field_id, form_id, field_key, field_label, field_type, field_options, field_required, `order`, site_id, user_id, `status`) VALUES " . "\n";
                foreach ($formsfields as $ff) {
                    $i++;
                    $sql .= "(null,@" . $store[Yii::app()->params['tables']['form']][$ff['form_id']]['map']
                        . ", " . ClaGenerate::quoteValue($ff['field_key']) . "," . ClaGenerate::quoteValue($ff['field_label']) . "," . ClaGenerate::quoteValue($ff['field_type'])
                        . "," . ClaGenerate::quoteValue($ff['field_options']) . "," . $ff['field_required'] . "," . $ff['order'] . ",[site_id],[user_id]," . $ff['status'] . ")"
                        . (($i == $countfields) ? ";" : ",") . "\n";
                }
            }
            $sql .= "\n\n";
        }
        // site_users
        $siteUsers = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('site_users'))
            ->where("site_id=$site_id")
            ->queryAll();
        if ($siteUsers && count($siteUsers)) {
            foreach ($siteUsers as $su) {
                $sql .= "INSERT INTO " . Yii::app()->params['tables']['site_users'] . " (`id`, `site_id`, `name`, `job_title`, `phone`, `email`, `skype`, `yahoo`, `status`, `type`, `avatar_path`, `avatar_name`, `created_time`, `modified_time`) "
                    . "VALUES (null,[site_id]," . ClaGenerate::quoteValue($su['name']) . "," . ClaGenerate::quoteValue($su['job_title']) . "," . ClaGenerate::quoteValue($su['phone'])
                    . "," . ClaGenerate::quoteValue($su['email']) . "," . ClaGenerate::quoteValue($su['skype']) . "," . ClaGenerate::quoteValue($su['yahoo'])
                    . "," . (int) $su['status'] . "," . (int) $su['type'] . "," . ClaGenerate::quoteValue($su['avatar_path']) . "," . ClaGenerate::quoteValue($su['avatar_name'])
                    . ",[now],[now]"
                    . ");" . "\n";
                //
            }
            $sql .= "\n\n";
        }
        //
        // module (page widget)
        $pagewidges = Widgets::getWidgets();
        foreach ($pagewidges as $pw) {
            $pageKey = ClaGenerate::quoteValue($pw['page_key']);
            if (strpos($pageKey, 'page/category/detail') !== false) {
                $info = explode('_', $pageKey);
                $id = isset($info[1]) ? (int) $info[1] : 0;
                if (isset($store[Yii::app()->params['tables']['categorypage']][$id]['map'])) {
                    $pageKey = "CONCAT('page/category/detail','_',@" . $store[Yii::app()->params['tables']['categorypage']][$id]['map'] . ")";
                } else {
                    continue;
                }
            }
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['pagewidget'] . " (page_widget_id, site_id,user_id, widget_title, position, page_key, widget_type, widget_id, created_time, showallpage, worder) "
                . "VALUES (null,[site_id],[user_id]," . ClaGenerate::quoteValue($pw['widget_title']) . "," . $pw['position']
                . "," . $pageKey . "," . $pw['widget_type'] . ',' . ClaGenerate::quoteValue($pw['widget_id']) . ",[now]," . $pw['showallpage'] . "," . $pw['worder']
                . ");" . "\n";
            //
            $sql .= "set @" . Yii::app()->params['tables']['pagewidget'] . $pw['page_widget_id'] . " = LAST_INSERT_ID();" . "\n";
            //
            $store[Yii::app()->params['tables']['pagewidget']][$pw['page_widget_id']]['map'] = Yii::app()->params['tables']['pagewidget'] . $pw['page_widget_id'];
        }
        $sql .= "\n";
        // module config(page widget config)
        $pagewidgetconfigs = PageWidgetConfig::getAllPageWidgetConfigs();
        foreach ($pagewidgetconfigs as $pwc) {
            if (!isset($store[Yii::app()->params['tables']['pagewidget']][$pwc['page_widget_id']]))
                continue;
            $pwc = PageWidgetConfig::prepareConfig($pwc, $pagewidges[$pwc['page_widget_id']]);
            $sql .= "INSERT INTO " . Yii::app()->params['tables']['pagewidgetconfig'] . " (id, page_widget_id, site_id, user_id, config_data, created_time, modified_time) "
                . "VALUES (null,@" . $store[Yii::app()->params['tables']['pagewidget']][$pwc['page_widget_id']]['map'] . ",[site_id],[user_id]," . $pwc['config_data'] . ",[now],[now]"
                . ");" . "\n";
        }
        $sql .= "\n";

        return $sql;
    }

}
