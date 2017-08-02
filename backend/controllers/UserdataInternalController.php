<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserdataInternal;
use backend\models\UserdataInternalSearch;
use backend\models\form\UpdateIntUser;
use backend\models\form\Assignunit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserdataInternalController implements the CRUD actions for UserdataInternal model.
 */
class UserdataInternalController extends Controller
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
     * Lists all UserdataInternal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserdataInternalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		//die(var_dump($dataProvider));
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserdataInternal model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
		$userunit = new Assignunit();
		$user = new UpdateIntUser();

		//die(var_dump($user->getUserId($id)));
        return $this->render('view', [
            'model' => $this->findModel($id),
            'assign' => $userunit,
            'user' => $user->getUserId($id),
        ]);
        ;
    }

    /**
     * Creates a new UserdataInternal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $user = new User();
		$userdata = new UserdataInternal();

		//die(var_dump($_POST['UserdataInternal']['username']));
		if ($userdata->load(Yii::$app->request->post())) {
    			$user->username = $_POST['UserdataInternal']['username'];
    			$user->auth_key = Yii::$app->security->generateRandomString();
    			$user->password_hash = Yii::$app->security->generatePasswordHash($_POST['UserdataInternal']['password']);
    			$user->email = $_POST['UserdataInternal']['email'];
    			$user->created_at = strtotime('now');
    			$user->updated_at = strtotime('now');
          //  die(var_dump($user));
    			if($user->save()){
    				$userdata->user_id = $user->id;
    				$userdata->fullname = $_POST['UserdataInternal']['fullname'];
    				$userdata->nik = $_POST['UserdataInternal']['nik'];
    				$userdata->save();
    				return $this->redirect(['view', 'id' => $userdata->t_userdata_internal_id]);
    			}
        } else {
            return $this->render('create', [
                'model' => $userdata,
            ]);
        }

        //$model = new Signup();
		//die(var_dump($_POST));

        /*if ($model->load(Yii::$app->request->post()) && $model->signup()) {
			die(var_dump($model));
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Updates an existing UserdataInternal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$form = new UpdateIntUser();

		if ($model->load(Yii::$app->request->post())) {
			$model->fullname = $_POST['UserdataInternal']['fullname'];
			$model->nik = $_POST['UserdataInternal']['nik'];
			if($model->update() !== false){
				$user = User::findOne($model->user_id);
				//$user->findOne($model->user_id);
				$user->username = $_POST['UserdataInternal']['username'];
				$user->password_hash = Yii::$app->security->generatePasswordHash($_POST['UserdataInternal']['password']);
				$user->email = $_POST['UserdataInternal']['email'];
				$user->updated_at = strtotime('now');
				$user->update();
				return $this->redirect(['view', 'id' => $id]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
                'user' => $form->getUserId($id),
            ]);
        }
    }

    /**
     * Deletes an existing UserdataInternal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        if (($model = UserdataInternal::findOne($id)) !== null) {
              User::findOne($model->user_id)->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserdataInternal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserdataInternal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserdataInternal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Assign items
     * @param string $id
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignunit();
        $success = $model->addChildren($id,$items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems($id), ['success' => $success]);
    }

    /**
     * Assign or remove items
     * @param string $id
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignunit();
        $success = $model->removeChildren($id,$items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems($id), ['success' => $success]);
    }
}
