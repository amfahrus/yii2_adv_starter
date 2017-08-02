<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Customer */

$this->title = $model->customer_id;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->customer_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->customer_id], [
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
            [
              'label' => 'Username',
              'value' => $model->user->username,
            ],
            [
              'label' => 'Email',
              'value' => $model->user->email,
            ],
            'customer_name',
            'customer_code',
            'customer_phone',
            'customer_address:ntext',
            [
               'attribute' => 'customer_is_member',
               'format'=>'raw',
               'value'=> $model->customer_is_member == 1 ? 'Ya' : 'Tidak'
            ],
            'device_id:ntext',
            'device_platform',
        ],
    ]) ?>

</div>
