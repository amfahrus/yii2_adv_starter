<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserdataInternal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userdata-internal-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

	<?= $form->field($model, 'email') ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nik')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
