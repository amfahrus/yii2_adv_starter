<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use common\models\LoginForm;
use frontend\models\SignupForm;
use frontend\models\PasswordResetRequestForm;
use backend\models\Customer;
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
	      $customer = Customer::find()->where(['=','user_id',Yii::$app->user->identity->id])->one();
				return [
					'code' => 1,
					'message' => 'Login sukses',
					'username' => Yii::$app->user->identity->username,
					'token' => Yii::$app->user->identity->auth_key,
					'email' => Yii::$app->user->identity->email,
					'customer_name' => $customer->customer_name,
					'customer_phone' => $customer->customer_phone,
					'customer_code' => $customer->customer_code,
					'customer_address' => $customer->customer_address,
					'customer_is_member' => $customer->customer_is_member,
					'customer_id' => $customer->customer_id,
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
										'message' => 'Login sukses',
										'username' => Yii::$app->user->identity->username,
										'token' => Yii::$app->user->identity->auth_key,
										'email' => Yii::$app->user->identity->email,
										'customer_name' => $customer->customer_name,
										'customer_phone' => $customer->customer_phone,
										'customer_code' => $customer->customer_code,
										'customer_address' => $customer->customer_address,
										'customer_is_member' => $customer->customer_is_member,
										'customer_id' => $customer->customer_id,
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

	public function actionReset()
	{
			$model = new PasswordResetRequestForm();
			if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
					if ($model->sendEmail()) {
							return [
								'code' => 1,
								'message' => 'Password reset sukses'
							];
					} else {
							return [
								'code' => 0,
								'message' => 'Password reset gagal'
							];
					}
			}


	}

}
