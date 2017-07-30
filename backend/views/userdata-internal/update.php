<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\UserdataInternal */

$this->title = 'Update Userdata Internal: ' . $model->t_userdata_internal_id;
$this->params['breadcrumbs'][] = ['label' => 'Userdata Internals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->t_userdata_internal_id, 'url' => ['view', 'id' => $model->t_userdata_internal_id]];
$this->params['breadcrumbs'][] = 'Update';
$model->username = $model->isNewRecord ? '' : $user->username;
$model->email = $model->isNewRecord ? '' : $user->email;
?>
<div class="userdata-internal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
