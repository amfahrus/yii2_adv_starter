<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Json;
use mdm\admin\AnimateAsset;
use yii\web\YiiAsset;
/* @var $this yii\web\View */
/* @var $model backend\models\UserdataInternal */

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Userdata Internals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

AnimateAsset::register($this);
YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $assign->getItems($model->user_id)
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>
<div class="userdata-internal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->t_userdata_internal_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->t_userdata_internal_id], [
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
            't_userdata_internal_id',
			[
				'label' => 'Username',
				'value' => $user->username,
			],
			[
				'label' => 'Email',
				'value' => $user->email,
			],
            'fullname',
            'nik',
        ],
    ]) ?>

    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="avaliable"
                   placeholder="Search for avaliable">
            <select multiple size="20" class="form-control list" data-target="avaliable"></select>
        </div>
        <div class="col-sm-1">
            <br><br>
            <?= Html::a('&gt;&gt;' . $animateIcon, ['assign', 'id' => $model->user_id], [
                'class' => 'btn btn-success btn-assign',
                'data-target' => 'avaliable',
                'title' => 'Assign'
            ]) ?><br><br>
            <?= Html::a('&lt;&lt;' . $animateIcon, ['remove', 'id' => $model->user_id], [
                'class' => 'btn btn-danger btn-assign',
                'data-target' => 'assigned',
                'title' => 'Remove'
            ]) ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned"
                   placeholder="Search for assigned">
            <select multiple size="20" class="form-control list" data-target="assigned"></select>
        </div>
    </div>
</div>
