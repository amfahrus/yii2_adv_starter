<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Unit;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */
/* @var $form yii\widgets\ActiveForm */
$listData= array(
    1 => 'Open',
    0 => 'Close'
);
$root_parent = array(0 => "Root");
$parent = ArrayHelper::map(Unit::find()->all(),'p_master_unit_id','unit_name');
$parents = array_merge($root_parent, $parent);
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'unit_status')->dropdownList($listData) ?>

    <?= $form->field($model, 'unit_parent')->dropdownList($parents) ?>

    <?= $form->field($model, 'unit_capacity')->textInput() ?>

    <?= $form->field($model, 'unit_lat')->textInput() ?>

    <?= $form->field($model, 'unit_lng')->textInput() ?>

    <?= $form->field($model, 'unit_radius')->textInput(['placeholder' => "KM"]) ?>

    <?= $form->field($model, 'unit_price_6')->textInput() ?>

    <?= $form->field($model, 'unit_price_12')->textInput() ?>

    <?= $form->field($model, 'unit_member_discount')->textInput() ?>

    <?= $form->field($model, 'unit_price_overtime')->textInput() ?>

    <?= $form->field($model, 'unit_price_pickup')->textInput() ?>

    <?= $form->field($model, 'unit_price_delivery')->textInput() ?>

    <?= $form->field($model, 'monday')->dropdownList($listData) ?>

    <?= $form->field($model, 'tuesday')->dropdownList($listData) ?>

    <?= $form->field($model, 'wednesday')->dropdownList($listData) ?>

    <?= $form->field($model, 'thursday')->dropdownList($listData) ?>

    <?= $form->field($model, 'friday')->dropdownList($listData) ?>

    <?= $form->field($model, 'saturday')->dropdownList($listData) ?>

    <?= $form->field($model, 'sunday')->dropdownList($listData) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
