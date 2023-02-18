<?php

namespace frontend\base;

use common\models\CartItem;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $userId = \Yii::$app->user->id;
        $this->view->params['cartItemsCnt'] = CartItem::find()->userId($userId)->sum('quantity');

        return parent::beforeAction($action);
    }
}