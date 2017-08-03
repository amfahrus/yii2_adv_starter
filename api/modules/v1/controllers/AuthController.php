<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;
use frontend\models\SignupForm;
/**
 * Auth Controller API
 */
class AuthController extends Controller
{
	public function actions()
	{
		return [
				'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

    public function actionLogin(){
		$model = new LoginForm();
		//die(var_dump(Yii::$app->request->post()));
			if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
				return [
					'code' => 1,
					'message' => 'Login sukses',
					'username' => Yii::$app->user->identity->username,
					'token' => Yii::$app->user->identity->auth_key
				];
			} else {
				return [
					'code' => 0,
					'message' => 'Login gagal'
			];
		}
	}

	public function actionSignup()
	{
			$model = new SignupForm();
			if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
					if ($user = $model->signup()) {
							if (Yii::$app->getUser()->login($user)) {
									return [
										'code' => 1,
										'message' => 'Pendaftaran sukses',
										'username' => Yii::$app->user->identity->username,
										'token' => Yii::$app->user->identity->auth_key
									];
							}
					}
			} else {
				return [
					'code' => 0,
					'message' => 'Pendaftaran gagal'
				];
			}
	}

	public function actionLogout()
	{
			Yii::$app->user->logout();

			return [
				'code' => 1,
				'message' => 'Logout sukses'
			];
	}


}
