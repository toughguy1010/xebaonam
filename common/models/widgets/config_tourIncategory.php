<?php

/**
 * Description of config_newtour
 *
 * @author minhbn
 */
class config_tourIncategory extends ConfigWidget
{
 
     public $limit = 1;
     public $cat_id = 0;
     public $full = 0;
     public $tour_hot = 0;
     public $tour_in_cate = 0;

     public function rules()
     {
          return array_merge(array(
               array('limit,cat_id', 'required'),
               array('limit,cat_id', 'numerical', 'min' => 1),
               array('limit,cat_id,full,tour_hot,tour_in_cate', 'safe'),
          ), parent::rules());
     }

     public function loadDefaultConfig()
     {
          $this->limit = 10;
     }

     public function buildConfigAttributes()
     {
          $data = array_merge(parent::buildConfigAttributes(), array(
               'config_data' => json_encode(array(
                    'limit' => $this->limit,
                    'cat_id' => $this->cat_id,
                    'full' => $this->full,
                    'tour_hot' => $this->tour_hot,
                    'showallpage' => $this->showallpage,
                    'widget_title' => $this->widget_title,
                    'show_wiget_title' => $this->show_wiget_title,
                    'tour_in_cate' => $this->tour_in_cate,
               ))
          ));
          return $data;
     }

     public function getPrimaryKey()
     {
          return 'cat_id';
     }

     public function getTableName()
     {
          return ClaTable::getTable('tour_categories');
     }

}
