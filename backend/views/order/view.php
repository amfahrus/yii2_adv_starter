<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Order */
//Yii::$app->formatter->locale = 'id-ID';
$this->title = $model->order_date;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    "$('#printDiv').click(function(){
				$('#DivIdToPrint').printThis();
		   });"
);

$this->registerJsFile(
    '@web/js/jquery.print.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->order_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <input class='btn btn-warning' type='button' id='printDiv' value='Print'>
    </p>

    <div id='DivIdToPrint'>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'order_id',
            //'customer_id',
            //'p_master_unit_id',
            'customer.customer_name',
            'customer.customer_phone',
            'unit.unit_name',
            'order_name',
            'order_address:ntext',
            'order_lat',
            'order_lng',
            'order_hours',
            [
                'attribute' =>'order_price',
                'value'=> Yii::$app->formatter->asCurrency($model->order_price),
            ],
            [
               'attribute' => 'order_pickup',
               'format'=>'raw',
               'value'=> $model->order_pickup == 1 ? 'Ya' : 'Tidak'
            ],
            [
               'attribute' => 'order_delivery',
               'format'=>'raw',
               'value'=> $model->order_delivery == 1 ? 'Ya' : 'Tidak'
            ],
            'order_start',
            'order_finish',
            [
                'attribute' =>'order_cost_pickup',
                'value'=> (!empty($model->order_cost_pickup))?Yii::$app->formatter->asCurrency($model->order_cost_pickup):null,
            ],
            [
                'attribute' =>'order_cost_delivery',
                'value'=> (!empty($model->order_cost_delivery))?Yii::$app->formatter->asCurrency($model->order_cost_delivery):null,
            ],
            [
                'attribute' =>'order_cost_overtime',
                'value'=> (!empty($model->order_cost_overtime))?Yii::$app->formatter->asCurrency($model->order_cost_overtime):null,
            ],
            [
                'attribute' =>'order_total_cost',
                'value'=> (!empty($model->order_total_cost))?Yii::$app->formatter->asCurrency($model->order_total_cost):null,
            ],
            //'order_cost_pickup',
            //'order_cost_delivery',
            //'order_cost_overtime',
            //'order_total_cost',
        ],
    ]) ?>
    </div>

</div>
