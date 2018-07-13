<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use common\models\Apple;

class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'generate', 'get-list', 'drop', 'eat', 'rot'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Apples list
     *
     * @return string
     */
    public function actionGetList()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if( Yii::$app->request->isAjax ) {

            return Apple::getList();
        }
        
    }

    /**
     * Falling to the ground
     *
     * @return string
     */
    public function actionDrop($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if( Yii::$app->request->isAjax ) {

            $apple = Apple::find()
                ->where([
                    'id' => $id,
                    'state' => Apple::STATE_ON_TREE
                ])->one();

            if ($apple) {
                $apple->state = Apple::STATE_ON_GROUND;
                $apple->fall_date = time();
                $apple->save();
            }

            return Apple::getList();
        }
    }

    /**
     * Eating current apple
     *
     * @return string
     */
    public function actionEat($id,$eat=0)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if( Yii::$app->request->isAjax ) {

            $apple = Apple::find()
                ->where([
                    'id' => $id,
                    'state' => Apple::STATE_ON_GROUND
                ])->one();

            if ($apple && $apple->size >= $eat) {

                if ($apple->size == $eat) {
                    $apple->state = Apple::STATE_EATEN;
                }

                $apple->size = $apple->size - $eat;
                $apple->save();
            }

            return Apple::getList();
        }
    }

    /**
     * Generate apples
     *
     * @return string
     */
    public function actionGenerate()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if( Yii::$app->request->isAjax ) {

            Yii::$app->db->createCommand()->truncateTable('apples')->execute();

            $apples_count = rand(20,30);

            for ($i=0;$i<$apples_count;$i++) {

                $apple = new Apple();
                $apple->color = $apple->colors[array_rand($apple->colors)];

                $start = time();
                $end = $start + 2592000; //3600*24*30

                $apple->creation_date = mt_rand($start, $end);
                $apple->save();
            }

            return Apple::getList();
        }
    }

    /**
     * Rot
     * cron job
     * @return null
     */
    public function actionRot($id)
    {
        Apple::updateAll(['state'=>Apple::STATE_ROTTEN, 'size'=>0], [

            '>', new \yii\db\Expression('NOW()'), new \yii\db\Expression('fall_date + 18000')

        ]);

    }

}
