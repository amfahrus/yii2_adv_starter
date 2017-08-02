<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */

$this->title = $model->p_master_unit_id;
$this->params['breadcrumbs'][] = ['label' => 'Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->p_master_unit_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->p_master_unit_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'p_master_unit_id',
            'unit_name',
            'unit_code',
            'unit_status',
            'unit_parent',
            'unit_capacity',
            'unit_lat',
            'unit_lng',
            'unit_radius',
            'unit_price_6',
            'unit_price_12',
            'unit_member_discount',
            'unit_price_overtime',
            'unit_price_pickup',
            'unit_price_delivery',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday',
        ],
    ]) ?>

</div>
