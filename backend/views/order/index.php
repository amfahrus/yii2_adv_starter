<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs(
    "$('#printDiv').click(function(){
				$('.table').printThis({
          importCSS: true
        });
		   });"
);

$this->registerJsFile(
    '@web/js/jquery.print.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
        <input class='btn btn-warning' type='button' id='printDiv' value='Print'>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'attribute' => 'customer_name',
             'value' => 'customer.customer_name'
            ],[
             'attribute' => 'customer_phone',
             'value' => 'customer.customer_phone'
            ],
            [
             'attribute' => 'unit_name',
             'value' => 'unit.unit_name'
            ],
            'order_name',
            'order_address:ntext',
            // 'order_lat',
            // 'order_lng',
            //'order_hours',
            //'order_price',
            [
             'attribute' => 'order_pickup',
             'value' => function ($model) {
                return $model->order_pickup > 0 ? 'Ya' : 'Tidak';
             }
            ],
            [
             'attribute' => 'order_delivery',
             'value' => function ($model) {
                return $model->order_delivery > 0 ? 'Ya' : 'Tidak';
             }
            ],
            // 'order_start',
            // 'order_finish',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{process} {view} {update} {delete}',
              'buttons' => [
                  'process' => function ($url,$model) {
        						if(empty($model->order_start) && empty($model->order_finish)){
                      return Html::a(
                          '<span class="glyphicon glyphicon-play"></span>',
                          ['order/start', 'id' => $model->order_id],
                          [
                              'title' => 'Mulai',
                              'data-pjax' => '0',
                          ]
                      );
        						}

                    if(!empty($model->order_start) && empty($model->order_finish)){
                      return Html::a(
                          '<span class="glyphicon glyphicon-stop"></span>',
                          ['order/finish', 'id' => $model->order_id],
                          [
                              'title' => 'Berhenti',
                              'data-pjax' => '0',
                          ]
                      );
        						}

                    if(!empty($model->order_start) && !empty($model->order_finish)){
                      return '<span class="glyphicon glyphicon-ok"></span>';
        						}
        					},
              ],
            ],
        ],
    ]); ?>
</div>
