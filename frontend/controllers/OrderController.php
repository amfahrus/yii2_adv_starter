<?php

namespace frontend\controllers;

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
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search_customer(Yii::$app->request->queryParams,$customer['customer_id']);

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
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        //die(var_dump(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post())) {
            $model->customer_id = $customer['customer_id'];
            $model->p_master_unit_id = $_POST['Order']['p_master_unit_id'];
            $model->order_name = $_POST['Order']['order_name'];
            $model->order_address = $_POST['Order']['order_address'];
            $model->order_hours = $_POST['Order']['order_hours'];
            $model->order_price = $_POST['Order']['order_price'];
            $model->order_date = $_POST['Order']['order_date'];
            $model->order_pickup = $_POST['Order']['order_pickup'];
            $model->order_delivery = $_POST['Order']['order_delivery'];
            if(!empty($_POST['Order']['order_lat']) && !empty($_POST['Order']['order_lng'])){
              $model->order_lat = $_POST['Order']['order_lat'];
              $model->order_lng = $_POST['Order']['order_lng'];
            } else {
              $latlng = Unit::find()->select(['unit_lat','unit_lng'])->where(['=','p_master_unit_id', $_POST['Order']['p_master_unit_id']])->asArray()->one();
              $model->order_lat = $latlng['unit_lat'];
              $model->order_lng = $latlng['unit_lng'];
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
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();

        if(!empty($model->order_start) && !empty($model->order_finish)){
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->customer_id = $customer['customer_id'];
            $model->p_master_unit_id = $_POST['Order']['p_master_unit_id'];
            $model->order_name = $_POST['Order']['order_name'];
            $model->order_address = $_POST['Order']['order_address'];
            $model->order_hours = $_POST['Order']['order_hours'];
            $model->order_price = $_POST['Order']['order_price'];
            $model->order_date = $_POST['Order']['order_date'];
            $model->order_pickup = $_POST['Order']['order_pickup'];
            $model->order_delivery = $_POST['Order']['order_delivery'];
            if(!empty($_POST['Order']['order_lat']) && !empty($_POST['Order']['order_lng'])){
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
        if(!empty(Yii::$app->user->identity->id)){
          $user = Yii::$app->user->identity->id;
          $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
          //die(var_dump($user));
          if (($model = Order::find()->where(['and',['=','order_id',$id],['=','customer_id',$customer['customer_id']]])->one()) !== null) {
              return $model;
          } else {
              throw new NotFoundHttpException('The requested page does not exist.');
          }
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

    public function actionAddress()
    {
        $user = Yii::$app->user->identity->id;
        $customer = Customer::find()->where(['=','user_id',$user])->asArray()->one();
        $address = Customer::find()->select(['customer_address'])->where(['=','customer_id', $customer['customer_id']])->asArray()->one();
        //die(print_r($address));
        echo $address['customer_address'];

    }

}
