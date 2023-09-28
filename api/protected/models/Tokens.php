<?php

/**
 * Tokens class.
 * Tokens is the data structure for keeping
 * Tokens data. It is used by the 'Tokens' action of 'HomeController'.
 */

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $token
 * @property string $created_at
 */
class Tokens extends ActiveRecord
{

    public function tableName()
    {
        return ClaTable::getTable('tokens');
    }

    public function rules()
    {
        return array(
            array('id, token, created_at', 'safe'),
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}