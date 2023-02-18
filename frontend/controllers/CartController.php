<?php

namespace frontend\controllers;

use common\models\CartItem;
use common\models\Product;
use frontend\base\Controller;
use Yii;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            // get the items from session
            $items = [];
        } else {
            // get the items from db
            $items = CartItem::findBySql("
                SELECT
                    c.id,
                    c.product_id,
                    p.image,
                    p.name,
                    p.price,
                    c.quantity,
                    p.price * c.quantity AS total_price
                FROM cart_items c
                LEFT JOIN products p on p.id = c.product_id
                WHERE c.created_by = :userId",
                ['userId' => Yii::$app->user->id])
                ->asArray()
                ->all();
        }

        return $this->render('index', compact('items'));
    }

    public function actionAdd()
    {
        $id = \Yii::$app->request->post('id');

        $product = Product::find()->id($id)->published()->one();

        if (!$product) {
            throw new NotFoundHttpException();
        }

        if (\Yii::$app->user->isGuest) {
            // TODO: save in session
        } else {
            $userId = Yii::$app->user->id;
            $cartItem = CartItem::find()->userId($userId)->productId($id)->one();

            if ($cartItem) {
                $cartItem->quantity += 1;
            } else {
                $cartItem = new CartItem();
                $cartItem->product_id = $id;
                $cartItem->created_by = Yii::$app->user->id;
                $cartItem->quantity = 1;
            }

            if ($cartItem->save()) {
                return [
                    'success' => true,
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => $cartItem->errors,
                ];
            }
        }
    }
}