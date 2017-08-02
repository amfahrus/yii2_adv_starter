<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="unit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'p_master_unit_id') ?>

    <?= $form->field($model, 'unit_name') ?>

    <?= $form->field($model, 'unit_code') ?>

    <?= $form->field($model, 'unit_status') ?>

    <?= $form->field($model, 'unit_parent') ?>

    <?php // echo $form->field($model, 'unit_capacity') ?>

    <?php // echo $form->field($model, 'unit_latlng') ?>

    <?php // echo $form->field($model, 'unit_radius') ?>

    <?php // echo $form->field($model, 'unit_price') ?>

    <?php // echo $form->field($model, 'unit_price_overtime') ?>

    <?php // echo $form->field($model, 'unit_price_pickup') ?>

    <?php // echo $form->field($model, 'unit_price_delivery') ?>

    <?php // echo $form->field($model, 'monday') ?>

    <?php // echo $form->field($model, 'tuesday') ?>

    <?php // echo $form->field($model, 'wednesday') ?>

    <?php // echo $form->field($model, 'thursday') ?>

    <?php // echo $form->field($model, 'friday') ?>

    <?php // echo $form->field($model, 'saturday') ?>

    <?php // echo $form->field($model, 'sunday') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
