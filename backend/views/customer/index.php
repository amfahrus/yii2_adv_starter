<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options'=>['class'=>'grid-view table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'attribute' => 'username',
             'value' => 'user.username'
            ],
            [
             'attribute' => 'email',
             'value' => 'user.email'
            ],
            'customer_name',
            'customer_phone',
            'customer_code',
            [
             'attribute' => 'customer_is_member',
             'value' => function ($model) {
                return $model->customer_is_member > 0 ? 'Ya' : 'Tidak';
             }
            ],
            //'customer_address:ntext',
            // 'customer_lat',
            // 'customer_lng',
            // 'device_id:ntext',
            // 'device_platform',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
