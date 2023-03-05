<?php

namespace frontend\base;

use common\models\CartItem;
use Yii;

class Controller extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->view->params['cartItemsCnt'] = CartItem::getTotalQuantity(currentUserId());
        return parent::beforeAction($action);
    }
}