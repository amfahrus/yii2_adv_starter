<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserdataInternalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Userdata Internals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdata-internal-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Userdata Internal', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            't_userdata_internal_id',
            'username',
            'email',
            'fullname',
            'nik',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
