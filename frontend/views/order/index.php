<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>-->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options'=>['class'=>'grid-view table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'attribute' => 'unit_name',
             'value' => 'unit.unit_name'
            ],
            'order_date',
            'order_name',
            //'order_address:ntext',
            // 'order_lat',
            // 'order_lng',
            //'order_hours',
            //'order_price',
            /*[
             'attribute' => 'order_pickup',
             'value' => function ($model) {
                return $model->order_pickup > 0 ? 'Ya' : 'Tidak';
             }
           ],*/
            /*[
             'attribute' => 'order_delivery',
             'value' => function ($model) {
                return $model->order_delivery > 0 ? 'Ya' : 'Tidak';
             }
           ],*/
            // 'order_start',
            // 'order_finish',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{process} {view} {update} {delete}',
              'buttons' => [
                  'process' => function ($url,$model) {
        						if(empty($model->order_start) && empty($model->order_finish)){
                      return 'Belum Dimulai<br>';
        						}

                    if(!empty($model->order_start) && empty($model->order_finish)){
                      return 'Sedang Berlangsung<br>';
        						}

                    if(!empty($model->order_start) && !empty($model->order_finish)){
                      return 'Sudah Selesai<br>';
        						}
        					},
              ],
            ],
        ],
    ]); ?>
</div>
