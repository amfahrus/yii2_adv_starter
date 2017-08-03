<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use common\models\LoginForm;
use common\models\User;
use backend\models\Customer;
use backend\models\Unit;
use backend\models\Order;
use backend\models\OrderSearch;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Unit Controller API
 */
class CustomerController extends ActiveController
{
    public $modelClass = 'backend\models\Customer';

    public function behaviors()
    {
		$behaviors = parent::behaviors();
		/* http://domain.name/api/web/v1/unit?access-token=YOUR_AUTH_KEY*/
		$behaviors['authenticator'] = [
			'class' => QueryParamAuth::className(),
			/*'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],*/
		];
		return $behaviors;
    }

    public function actionProfile()
    {
        $param = Yii::$app->getRequest()->getBodyParams();
        $user = Yii::$app->user->identity->id;
        $model = $this->findModel($param['id'],$user);
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();

        if ($customer->load(Yii::$app->getRequest()->getBodyParams())) {
            $customer->customer_id = $customer->customer_id;
            $customer->user_id = $customer->user_id;
            $customer->customer_name = (!empty($param['customer_name']))?$param['customer_name']:$customer->customer_name;
            $customer->customer_phone = (!empty($param['customer_phone']))?$param['customer_phone']:$customer->customer_phone;
            $customer->customer_address = (!empty($param['customer_address']))?$param['customer_address']:$customer->customer_address;
            $customer->customer_code = (!empty($param['customer_code']))?$param['customer_code']:$customer->customer_code;
            $customer->customer_is_member = (!empty($param['customer_is_member']))?$param['customer_is_member']:$customer->customer_is_member;
            $customer->device_id = (!empty($param['device_id']))?$param['device_id']:$customer->device_id;
            $customer->device_platform = (!empty($param['device_platform']))?$param['device_platform']:$customer->device_platform;
            if($customer->update()){
              return [
                'code' => 1,
                'message' => 'Update sukses'
              ];
            } else {
              return [
                'code' => 0,
                'message' => 'Update gagal'
              ];
            }
        } else {
          return [
            'code' => 0,
            'message' => 'Update gagal'
          ];
        }
    }

    public function actionStatus()
    {
      $result = array();
      $user = Yii::$app->user->identity->id;
      $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
      $searchModel = new OrderSearch();
      $dataProvider = $searchModel->search_customer(Yii::$app->getRequest()->getBodyParams(),$customer['customer_id']);
      if (!empty($dataProvider->getModels())) {
          foreach ($dataProvider->getModels() as $key => $val) {
              $result[] = array(
                'unit_name' => $val->unit->unit_name,
                'order_name' => $val->order_name,
                'order_date' => $val->order_date,
                'order_hours' => $val->order_hours,
                'order_start' => $val->order_start,
                'order_finish' => $val->order_finish,
                'order_price' => $val->order_price,
                'order_cost_pickup' => $val->order_cost_pickup,
                'order_cost_delivery' => $val->order_cost_delivery,
                'order_cost_overtime' => $val->order_cost_overtime,
                'order_total_cost' => $val->order_total_cost,
                'order_discount' => $val->order_discount,
                'order_total_cost_discount' => $val->order_total_cost_discount,
              );
          }
        return $result;
      } else {
        return [
					'message' => 'Tidak ada data'
				];
      }
    }

    public function actionDetail()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      $val = $this->findModel($param['id'],Yii::$app->user->identity->id)
      return [
        'unit_name' => $val->unit->unit_name,
        'order_name' => $val->order_name,
        'order_date' => $val->order_date,
        'order_hours' => $val->order_hours,
        'order_start' => $val->order_start,
        'order_finish' => $val->order_finish,
        'order_price' => $val->order_price,
        'order_cost_pickup' => $val->order_cost_pickup,
        'order_cost_delivery' => $val->order_cost_delivery,
        'order_cost_overtime' => $val->order_cost_overtime,
        'order_total_cost' => $val->order_total_cost,
        'order_discount' => $val->order_discount,
        'order_total_cost_discount' => $val->order_total_cost_discount,
      ];
    }

    public function actionAdd()
    {
        $model = new Order();
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        $param = Yii::$app->getRequest()->getBodyParams();
        if ($model->load(Yii::$app->getRequest()->getBodyParams())) {
            $model->customer_id = $customer['customer_id'];
            $model->p_master_unit_id = $param['Order']['p_master_unit_id'];
            $model->order_name = $param['Order']['order_name'];
            $model->order_address = $param['Order']['order_address'];
            $model->order_hours = $param['Order']['order_hours'];
            $model->order_price = $param['Order']['order_price'];
            $model->order_date = $param['Order']['order_date'];
            $model->order_pickup = $param['Order']['order_pickup'];
            $model->order_delivery = $param['Order']['order_delivery'];
            if(!empty($param['Order']['order_lat']) && !empty($param['Order']['order_lng'])){
              $model->order_lat = $param['Order']['order_lat'];
              $model->order_lng = $param['Order']['order_lng'];
            } else {
              $latlng = Unit::find()->select(['unit_lat','unit_lng'])->where(['=','p_master_unit_id', $param['Order']['p_master_unit_id']])->asArray()->one();
              $model->order_lat = $latlng['unit_lat'];
              $model->order_lng = $latlng['unit_lng'];
            }
      			if($model->save()){
              return [
      					'code' => 1,
      					'message' => 'Order sukses'
      				];
            } else {
              return [
      					'code' => 0,
      					'message' => 'Order gagal'
      				];
            }
        } else {
          return [
  					'code' => 0,
            'message' => 'Order gagal'
          ];
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpd()
    {
        $param = Yii::$app->getRequest()->getBodyParams();
        $user = Yii::$app->user->identity->id;
        $model = $this->findModel($param['id'],$user);
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();

        if(!empty($model->order_start) && !empty($model->order_finish)){
          return [
  					'code' => 0,
            'message' => 'Order sudah diproses'
          ];
        }

        if ($model->load(Yii::$app->getRequest()->getBodyParams())) {
            $model->customer_id = $customer['customer_id'];
            $model->p_master_unit_id = $param['Order']['p_master_unit_id'];
            $model->order_name = $param['Order']['order_name'];
            $model->order_address = $param['Order']['order_address'];
            $model->order_hours = $param['Order']['order_hours'];
            $model->order_price = $param['Order']['order_price'];
            $model->order_date = $param['Order']['order_date'];
            $model->order_pickup = $param['Order']['order_pickup'];
            $model->order_delivery = $param['Order']['order_delivery'];
            if(!empty($param['Order']['order_lat']) && !empty($param['Order']['order_lng'])){
              $model->order_lat = $param['Order']['order_lat'];
              $model->order_lng = $param['Order']['order_lng'];
            } else {
              $latlng = Unit::find()->select(['unit_lat','unit_lng'])->where(['=','p_master_unit_id', $param['Order']['p_master_unit_id']])->asArray()->one();
              $model->order_lat = $latlng['unit_lat'];
              $model->order_lng = $latlng['unit_lng'];
            }
            if($model->update()){
              return [
                'code' => 1,
                'message' => 'Order sukses'
              ];
            } else {
              return [
                'code' => 0,
                'message' => 'Order gagal'
              ];
            }
        } else {
          return [
            'code' => 0,
            'message' => 'Order gagal'
          ];
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDel()
    {
        $param = Yii::$app->getRequest()->getBodyParams();
        $user = Yii::$app->user->identity->id;
        $model = $this->findModel($param['id'],$user);
        if(empty($model->order_start) && empty($model->order_finish)){
          $model->delete();
          return [
            'code' => 1,
            'message' => 'Order sukses dihapus'
          ];
        } else {
          return [
            'code' => 0,
            'message' => 'Order gagal dihapus'
          ];
        }
    }

    protected function findModel()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      $user = Yii::$app->user->identity->id;
      if(!empty($user)){
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        //die(var_dump($user));
        if (($model = Order::find()->where(['and',['=','order_id',$param['order_id']],['=','customer_id',$customer['customer_id']]])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
      } else {
        throw new NotFoundHttpException('The requested page does not exist.');
      }

    }

    public function actionHours()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      $result = array();
      $price_6 = Unit::find()->select(["CONCAT('6') as hours","CONCAT('6 Hours = ',unit_price_6) as label"])->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->all();
      $price_12 = Unit::find()->select(["CONCAT('12') as hours","CONCAT('12 Hours = ',unit_price_12) as label"])->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->all();
      $prices = array_merge($price_6, $price_12);
      //die(print_r($prices));
      foreach($prices as $price)
      {
        $result[$price['hours']] = $price['label'];
      }
      return $result;

    }

    public function actionPrices()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      if($param['hours'] > 6){
        $price = Unit::find()->select(['unit_price_12 as price'])->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->one();
      } else {
        $price = Unit::find()->select(['unit_price_6 as price'])->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->one();
      }

      //die(print_r($latlng));
      //echo json_encode($price);
      return $price;

    }

    public function actionLatlng()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      $latlng = Unit::find()->select(['unit_lat','unit_lng','unit_radius'])->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->one();
      //die(print_r($latlng));
      //echo json_encode($latlng);
      return $latlng;

    }

    public function actionCapacity()
    {
      $param = Yii::$app->getRequest()->getBodyParams();
      $temp = array();
      $temp['open'] = 0;
      //die(date("l", strtotime($date)));
      $unit = Unit::find()->where(['=','p_master_unit_id', $param['p_master_unit_id']])->asArray()->one();
      $registered = Order::find()->where(['and',['=','p_master_unit_id', $param['p_master_unit_id']],['=','order_date', $param['order_date']]])->count();
      if($unit['monday'] > 0 && date("l", strtotime($param['order_date'])) == 'Monday'){
        $temp['open'] = 1;
      }
      if($unit['tuesday'] > 0 && date("l", strtotime($param['order_date'])) == 'Tuesday'){
        $temp['open'] = 1;
      }
      if($unit['wednesday'] > 0 && date("l", strtotime($param['order_date'])) == 'Wednesday'){
        $temp['open'] = 1;
      }
      if($unit['thursday'] > 0 && date("l", strtotime($param['order_date'])) == 'Thursday'){
        $temp['open'] = 1;
      }
      if($unit['friday'] > 0 && date("l", strtotime($param['order_date'])) == 'Friday'){
        $temp['open'] = 1;
      }
      if($unit['saturday'] > 0 && date("l", strtotime($param['order_date'])) == 'Saturday'){
        $temp['open'] = 1;
      }
      if($unit['sunday'] > 0 && date("l", strtotime($param['order_date'])) == 'Sunday'){
        $temp['open'] = 1;
      }
      $temp['capacity'] = $unit['unit_capacity'];
      $temp['registered'] = $registered;
      //die(print_r($latlng));
      //echo json_encode($temp);
      return $temp;

    }

    public function actionAddress()
    {
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        $address = Customer::find()->select(['customer_address'])->where(['=','customer_id', $customer['customer_id']])->asArray()->one();
        //die(print_r($address));
        //echo $address['customer_address'];
        return $address['customer_address'];

    }
}
