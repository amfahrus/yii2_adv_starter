<?php

namespace backend\controllers;

use Yii;
use backend\models\Unit;
use backend\models\Customer;
use backend\models\Order;
use backend\models\OrderSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();
        //die(var_dump(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post())) {
            $unit = Unit::find()->where(['=','p_master_unit_id', $_POST['Order']['p_master_unit_id']])->asArray()->one();
            $customer = Customer::find()->where(['=','customer_id', $_POST['Order']['customer_id']])->asArray()->one();
            $model->customer_id = $_POST['Order']['customer_id'];
            $model->p_master_unit_id = $_POST['Order']['p_master_unit_id'];
            $model->order_name = $_POST['Order']['order_name'];
            $model->order_address = $_POST['Order']['order_address'];
            $model->order_hours = $_POST['Order']['order_hours'];
            $model->order_price = $_POST['Order']['order_price'];
            $model->order_date = $_POST['Order']['order_date'];
            $model->order_pickup = $_POST['Order']['order_pickup'];
            $model->order_delivery = $_POST['Order']['order_delivery'];
            if($model->order_pickup > 0 || $model->order_delivery > 0){
              $model->order_lat = $_POST['Order']['order_lat'];
              $model->order_lng = $_POST['Order']['order_lng'];
            } else {
              $latlng = Unit::find()->select(['unit_lat','unit_lng'])->where(['=','p_master_unit_id', $_POST['Order']['p_master_unit_id']])->asArray()->one();
              $model->order_lat = $latlng['unit_lat'];
              $model->order_lng = $latlng['unit_lng'];
            }
            if($customer['customer_is_member'] > 0 && $unit['unit_member_discount'] > 0){
              $model->order_discount = $unit['unit_member_discount'];
            }
      			if($model->save()){
              return $this->redirect(['view', 'id' => $model->order_id]);
            } else {
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(!empty($model->order_start) && !empty($model->order_finish)){
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->customer_id = $_POST['Order']['customer_id'];
            $model->p_master_unit_id = $_POST['Order']['p_master_unit_id'];
            $model->order_name = $_POST['Order']['order_name'];
            $model->order_address = $_POST['Order']['order_address'];
            $model->order_hours = $_POST['Order']['order_hours'];
            $model->order_price = $_POST['Order']['order_price'];
            $model->order_date = $_POST['Order']['order_date'];
            $model->order_pickup = $_POST['Order']['order_pickup'];
            $model->order_delivery = $_POST['Order']['order_delivery'];
            if($model->order_pickup > 0 || $model->order_delivery > 0){
              $model->order_lat = $_POST['Order']['order_lat'];
              $model->order_lng = $_POST['Order']['order_lng'];
            } else {
              $latlng = Unit::find()->select(['unit_lat','unit_lng'])->where(['=','p_master_unit_id', $_POST['Order']['p_master_unit_id']])->asArray()->one();
              $model->order_lat = $latlng['unit_lat'];
              $model->order_lng = $latlng['unit_lng'];
            }
            if($model->update()){
              return $this->redirect(['view', 'id' => $model->order_id]);
            } else {
              return $this->render('update', [
                  'model' => $model,
              ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if(empty($model->order_start) && empty($model->order_finish)){
          $model->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionHours($id)
    {
        $price_6 = Unit::find()->select(["CONCAT('6') as hours","CONCAT('6 Hours = ',unit_price_6) as label"])->where(['=','p_master_unit_id', $id])->asArray()->all();
        $price_12 = Unit::find()->select(["CONCAT('12') as hours","CONCAT('12 Hours = ',unit_price_12) as label"])->where(['=','p_master_unit_id', $id])->asArray()->all();
        $prices = array_merge($price_6, $price_12);
        //die(print_r($prices));
        echo "<option value=''>-Package-</option>";
        foreach($prices as $price)
        {
            echo "<option value='".$price['hours']."'>".$price['label']."</option>";
        }

    }

    public function actionPrices($id,$hours)
    {
        if($hours > 6){
          $price = Unit::find()->select(['unit_price_12 as price'])->where(['=','p_master_unit_id', $id])->asArray()->one();
        } else {
          $price = Unit::find()->select(['unit_price_6 as price'])->where(['=','p_master_unit_id', $id])->asArray()->one();
        }

        //die(print_r($latlng));
        echo json_encode($price);

    }

    public function actionLatlng($id)
    {
        $latlng = Unit::find()->select(['unit_lat','unit_lng','unit_radius'])->where(['=','p_master_unit_id', $id])->asArray()->one();
        //die(print_r($latlng));
        echo json_encode($latlng);

    }

    public function actionCapacity($id,$date)
    {
        $temp = array();
        $temp['open'] = 0;
        //die(date("l", strtotime($date)));
        $unit = Unit::find()->where(['=','p_master_unit_id', $id])->asArray()->one();
        $registered = Order::find()->where(['and',['=','p_master_unit_id', $id],['=','order_date', $date]])->count();
        if($unit['monday'] > 0 && date("l", strtotime($date)) == 'Monday'){
          $temp['open'] = 1;
        }
        if($unit['tuesday'] > 0 && date("l", strtotime($date)) == 'Tuesday'){
          $temp['open'] = 1;
        }
        if($unit['wednesday'] > 0 && date("l", strtotime($date)) == 'Wednesday'){
          $temp['open'] = 1;
        }
        if($unit['thursday'] > 0 && date("l", strtotime($date)) == 'Thursday'){
          $temp['open'] = 1;
        }
        if($unit['friday'] > 0 && date("l", strtotime($date)) == 'Friday'){
          $temp['open'] = 1;
        }
        if($unit['saturday'] > 0 && date("l", strtotime($date)) == 'Saturday'){
          $temp['open'] = 1;
        }
        if($unit['sunday'] > 0 && date("l", strtotime($date)) == 'Sunday'){
          $temp['open'] = 1;
        }
        $temp['capacity'] = $unit['unit_capacity'];
        $temp['registered'] = $registered;
        //die(print_r($latlng));
        echo json_encode($temp);

    }

    public function actionAddress($id)
    {
        $address = Customer::find()->select(['customer_address'])->where(['=','customer_id', $id])->asArray()->one();
        //die(print_r($address));
        echo $address['customer_address'];

    }

    public function actionStart($id)
    {
        $model = $this->findModel($id);
        $model->order_start = date("Y-m-d H:i:s");
        if($model->update() !== false){
  				return $this->redirect(Yii::$app->request->referrer);
  			}

    }

    public function actionFinish($id)
    {
        $cost = array();
        $model = $this->findModel($id);
        $unit = Unit::find()->where(['=','p_master_unit_id', $model->p_master_unit_id])->asArray()->one();
        $customer = Customer::find()->where(['=','customer_id', $model->customer_id])->asArray()->one();
        $model->order_finish = date("Y-m-d H:i:s");

        /*Hitung Biaya Antar Jemput*/
  			$key=Yii::$app->params['google_api_key'];
  			if ( !empty($key)){
  				$api = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($model->order_lat).",".urlencode($model->order_lng)."&destinations=".urlencode($unit['unit_lat']).",".urlencode($unit['unit_lng'])."&key=".urlencode($key);
  			}

  			if (!$json=@file_get_contents($api)){
  				$json = $this->Curl($api,'');
  			}

        if (!empty($json)){
  				$json = json_decode($json);
  				if (isset($json->error_message)){
            $pickup = str_replace('distance',$unit['unit_radius'],$unit['unit_price_pickup']);
            $delivery = str_replace('distance',$unit['unit_radius'],$unit['unit_price_delivery']);
            eval('$pickup_cost = (' . $pickup. ');');
  					eval('$delivery_cost = (' . $delivery. ');');
            $cost['pickup'] = $pickup_cost;
            $cost['delivery'] = $delivery_cost;
  				} else {
  					if($json->status=="OK"){
  						$distance = $json->rows[0]->elements[0]->distance->value;
  					} else {
  						$distance=$unit['unit_radius'];
  					}
            $pickup = str_replace('distance',$unit['unit_radius'],$unit['unit_price_pickup']);
            $delivery = str_replace('distance',$unit['unit_radius'],$unit['unit_price_delivery']);
            //die(var_dump($pickup));
            eval('$pickup_cost = (' . $pickup. ');');
            eval('$delivery_cost = (' . $delivery. ');');
            $cost['pickup'] = $pickup_cost;
            $cost['delivery'] = $delivery_cost;
  				}
  			} else {
            $pickup = str_replace('distance',$unit['unit_radius'],$unit['unit_price_pickup']);
            $delivery = str_replace('distance',$unit['unit_radius'],$unit['unit_price_delivery']);
            eval('$pickup_cost = (' . $pickup. ');');
  					eval('$delivery_cost = (' . $delivery. ');');
            $cost['pickup'] = $pickup_cost;
            $cost['delivery'] = $delivery_cost;
        }

        if($model->order_pickup > 0){
          $model->order_cost_pickup = $cost['pickup'];
        } else {
          $model->order_cost_pickup = 0;
        }

        if($model->order_delivery > 0){
          $model->order_cost_delivery = $cost['delivery'];
        } else {
          $model->order_cost_delivery = 0;
        }

        /*Hitung Biaya Overtime*/
        $a = strtotime($model->order_start);
  			$b = strtotime(date("Y-m-d H:i:s"));
  			$process_minutes = round(($b - $a) / 60);
        $order_minutes = round($model->order_hours * 60);
        if($process_minutes < $order_minutes){
          $overtime = str_replace('hours',0,$unit['unit_price_overtime']);
          eval('$overtime_cost = (' . $overtime. ');');
          $cost['overtime'] = $overtime_cost;
        }
        if($process_minutes > $order_minutes){
          $lenght_hours = round(($process_minutes - $order_minutes) / 60);
          $overtime = str_replace('hours',$lenght_hours,$unit['unit_price_overtime']);
          eval('$overtime_cost = (' . $overtime. ');');
          $cost['overtime'] = $overtime_cost;
        }
        $model->order_cost_overtime = $cost['overtime'];

        $model->order_total_cost = $model->order_price + $model->order_cost_pickup + $model->order_cost_delivery + $model->order_cost_overtime;

        /*discount*/
        if($model->order_discount > 0){
          $model->order_total_cost_discount = $model->order_total_cost - (($model->order_discount / 100) * $model->order_total_cost);
        }

        if($model->update() !== false){
  				return $this->redirect(Yii::$app->request->referrer);
  			}

    }

    protected static function Curl($uri="",$post="")
  	{
  		 $error_no='';
  		 $ch = curl_init($uri);
  		 curl_setopt($ch, CURLOPT_POST, 1);
  		 curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
  		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  		 curl_setopt($ch, CURLOPT_HEADER, 0);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  		 $resutl=curl_exec ($ch);

  		 if ($error_no==0) {
  		 	 return $resutl;
  		 } else return false;
  		 curl_close ($ch);
  	}

}
