<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii;

class Apple extends ActiveRecord
{
    const STATE_ON_TREE=1; //висит на дереве
    const STATE_ON_GROUND=2; //лежит на земле
    const STATE_ROTTEN=3; //гнилое
    const STATE_EATEN=4; //съедено

    public $colors = array('black','green','white','blue','orange');

    public static function tableName()
    {
        return '{{apples}}';
    }

    public static function getList()
        {
        return self::find()
            ->select('id, color, size, state, FROM_UNIXTIME(`creation_date`) as creation_date, FROM_UNIXTIME(`fall_date`) as fall_date')
            //->where(['state'=>[Apple::STATE_ON_GROUND,Apple::STATE_ON_TREE,Apple::STATE_ROTTEN]])
            ->asArray()
            ->all();
        }
}