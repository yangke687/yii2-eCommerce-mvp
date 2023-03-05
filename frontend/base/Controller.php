<?php

namespace frontend\base;

use common\models\CartItem;
use Yii;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);

            $sum = 0;
            foreach ($cartItems as $item) {
                $sum += (int)$item['quantity'];
            }
        } else {
            $userId = \Yii::$app->user->id;
            $sum = CartItem::find()->userId($userId)->sum('quantity');;
        }

        $this->view->params['cartItemsCnt'] = $sum;
        return parent::beforeAction($action);
    }
}