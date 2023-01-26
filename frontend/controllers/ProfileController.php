<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'update-account', 'update-address'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        /** @var User $user */
        $user = Yii::$app->user->identity;

        $address = $user->getAddress();

        return $this->render('/site/profile', compact('user', 'address'));
    }

    public function actionUpdateAddress()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException();
        }

        $user = Yii::$app->user->identity;
        $address = $user->getAddress();

        $postData = Yii::$app->request->post();
        $success = false;

        if ($postData && $address->load($postData) && $address->save()) {
            $success = true;
        }

        return $this->renderAjax('/site/user_address', compact('address', 'success'));
    }

    /**
     * @throws ForbiddenHttpException
     */
    public function actionUpdateAccount()
    {
        if (!Yii::$app->request->isAjax) {
            throw new ForbiddenHttpException();
        }

        $user = Yii::$app->user->identity;

        $postData = Yii::$app->request->post();
        $success = false;

        if ($postData && $user->load($postData) && $user->save()) {
            $success = true;
        }

        return $this->renderAjax('/site/user_account', compact('user', 'success'));
    }
}