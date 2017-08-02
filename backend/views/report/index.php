<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report';
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

$amount = 0;
if (!empty($dataProvider->getModels())) {
    foreach ($dataProvider->getModels() as $key => $val) {
        $amount += !empty($val->order_total_cost_discount)?$val->order_total_cost_discount:$val->order_total_cost;
    }
}

?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <input class='btn btn-warning' type='button' id='printDiv' value='Print'>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'showFooter' => TRUE,
        'options'=>['class'=>'grid-view table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
             'attribute' => 'unit_name',
             'value' => 'unit.unit_name'
            ],
            'order_name',
            'order_date',
            'order_hours',
            'order_start',
            'order_finish',
            [
                'attribute' =>'order_price',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
                'attribute' =>'order_cost_pickup',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
                'attribute' =>'order_cost_delivery',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
                'attribute' =>'order_cost_overtime',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
                'attribute' =>'order_total_cost',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
               'attribute' => 'order_discount',
               'value' => function ($model) {
                  return $model->order_discount > 0 ? $model->order_discount.' %'  : 'Tidak';
               }
            ],
            [
                'attribute' =>'order_total_cost_discount',
                'format'=>[
                    'decimal',
                    0,
                ]
            ],
            [
              'attribute' =>'sum',
              'label' => 'Total',
              'footer' => $amount,
              'format'=>[
                  'decimal',
                  0,
              ],
           ],
        ],
    ]); ?>
</div>
