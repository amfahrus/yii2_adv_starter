<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\Customer;
use backend\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();
        $user = new User();

        if ($model->load(Yii::$app->request->post())) {
            $user->username = $_POST['Customer']['username'];
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash($_POST['Customer']['password']);
            $user->email = $_POST['Customer']['email'];
      			$user->created_at = strtotime('now');
      			$user->updated_at = strtotime('now');
            //die(var_dump($user));
            if($user->save()){
               $model->user_id = $user->id;
               $model->customer_code = $this->getCode();
               $model->customer_name = $_POST['Customer']['customer_name'];
               $model->customer_phone = $_POST['Customer']['customer_phone'];
               $model->customer_address = $_POST['Customer']['customer_address'];
               $model->customer_is_member = $_POST['Customer']['customer_is_member'];
               $model->device_id = $_POST['Customer']['device_id'];
               $model->device_platform = $_POST['Customer']['device_platform'];
               $model->save();
               return $this->redirect(['view', 'id' => $model->customer_id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

             $model->user_id = $model->user_id;
             $model->customer_name = $_POST['Customer']['customer_name'];
             $model->customer_phone = $_POST['Customer']['customer_phone'];
             $model->customer_address = $_POST['Customer']['customer_address'];
             $model->customer_is_member = $_POST['Customer']['customer_is_member'];
             $model->device_id = $_POST['Customer']['device_id'];
             $model->device_platform = $_POST['Customer']['device_platform'];

            if($model->update() !== false){
              $user = User::findOne($model->user_id);
              //$user->findOne($model->user_id);
              $user->username = $_POST['Customer']['username'];
              $user->password_hash = Yii::$app->security->generatePasswordHash($_POST['Customer']['password']);
              $user->email = $_POST['Customer']['email'];
              $user->updated_at = strtotime('now');
              $user->update();
              return $this->redirect(['view', 'id' => $model->customer_id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        if (($model = Customer::findOne($id)) !== null) {
              User::findOne($model->user_id)->delete();
              $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getCode()
    {
        if (($model = Customer::find()->orderBy('customer_id DESC')->one()) !== null) {
            return str_pad($model->customer_id, 4, '0', STR_PAD_LEFT).'/'.date("m").date("y");
        } else {
            return str_pad(1, 4, '0', STR_PAD_LEFT).'/'.date("m").date("y");
        }
    }
}
