<?php

class RatingController extends PublicController {

    public $layout = '//layouts/service';

    /**
     * Index
     */
    public function actionRating() {
        if (Yii::app()->request->isAjaxRequest) {
            $rating_overall = Yii::app()->request->getParam('rating_overall');
            $rating_punctuality = Yii::app()->request->getParam('rating_punctuality');
            $rating_value = Yii::app()->request->getParam('rating_value');
            $rating_service = Yii::app()->request->getParam('rating_service');
            $arrayRating = array(
                $rating_overall,
                $rating_punctuality,
                $rating_value,
                $rating_service
            );
            //
            $rating = self::getAverageRating($arrayRating);
            //
            $content = Yii::app()->request->getParam('content');
            //
            $object_id = Yii::app()->request->getParam('object_id');
            $type = Yii::app()->request->getParam('type');
            //
            $model = new Rating();
            $model->type = $type;
            $model->object_id = $object_id;
            $model->content = $content;
            $model->rating = $rating;
            $model->user_id = Yii::app()->user->id;
            $model->data = json_encode(array(
                'overall' => $rating_overall,
                'punctuality' => $rating_punctuality,
                'value' => $rating_value,
                'service' => $rating_service
            ));
            if ($model->save()) {
                $this->assignDataSiteTable();
                $this->jsonResponse(200);
            }
        }
    }

    public function assignDataSiteTable() {
        //
        $site_id = Yii::app()->controller->site_id;
        $site = SiteSettings::model()->findByPk($site_id);
        //
        $ratings = Yii::app()->db->createCommand()
                ->select('*')
                ->from('rating')
                ->where('type=:type AND object_id=:object_id', array(':type' => Rating::RATING_BUSINESS, ':object_id' => $site_id))
                ->queryAll();
        //
        $rating_count = count($ratings);
        $total_point = 0;
        //
        foreach ($ratings as $rating) {
            $total_point += $rating['rating'];
        }
        $rating_point = $total_point / $rating_count;
        //
        $site->rating_count = $rating_count;
        $site->rating_point = $rating_point;
        $site->save(false);
    }

    public static function getAverageRating($arrayRating) {
        $totalitem = count($arrayRating);
        $sum = array_sum($arrayRating);
        $result = $sum / $totalitem;
        return $result;
    }

}
