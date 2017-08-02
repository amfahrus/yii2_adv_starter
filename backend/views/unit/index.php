<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Units';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Unit', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'p_master_unit_id',
            'unit_name',
            //'unit_code',
            //'unit_status',
            //'unit_parent',
            'unit_capacity',
            // 'unit_lat',
            // 'unit_lng',
            // 'unit_radius',
            'unit_price_6',
            'unit_price_12',
            'unit_price_overtime',
            'unit_price_pickup',
            'unit_price_delivery',
            // 'monday',
            // 'tuesday',
            // 'wednesday',
            // 'thursday',
            // 'friday',
            // 'saturday',
            // 'sunday',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
