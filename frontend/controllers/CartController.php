<?php

namespace frontend\controllers;

use common\models\CartItem;
use common\models\Product;
use frontend\base\Controller;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
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
            ],
            [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST', 'DELETE']
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            // get the items from session
            $items = Yii::$app->session->get(CartItem::SESSION_KEY, []);
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
            $cartItem = [
                'id' => $id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'quantity' => 1,
                'total_price' => $product->price,
            ];

            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);

            if (in_array($id, array_keys($cartItems))) {
                $quantity = $cartItems[$id]['quantity'] + 1;
                $cartItems[$id]['quantity'] = $quantity;
                $cartItems[$id]['total_price'] = round($cartItems[$id]['price'] * $quantity, 2);
            } else {
                $cartItems[$id] = $cartItem;
            }

            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
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

    public function actionDelete($id)
    {
        if (isGuest()) {
            $cartItems = Yii::$app->session->get(CartItem::SESSION_KEY, []);
            unset($cartItems[$id]);
            Yii::$app->session->set(CartItem::SESSION_KEY, $cartItems);
        } else {
            $cartItem = CartItem::findOne([
                'product_id' => $id,
                'created_by' => currentUserId()
            ]);

            if ($cartItem) {
                $cartItem->delete();
            }
        }

        return $this->redirect('/cart/index');
    }
}