<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use backend\models\Unit;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
$unit = ArrayHelper::map(Unit::find()->all(),'unit_name','unit_name');
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'order_id') ?>

    <?php // echo  $form->field($model, 'customer_id') ?>

    <?php // echo  $form->field($model, 'p_master_unit_id') ?>

    <?php // echo  $form->field($model, 'order_name') ?>

    <?php // echo  $form->field($model, 'order_address') ?>

    <?php // echo $form->field($model, 'order_lat') ?>

    <?php // echo $form->field($model, 'order_lng') ?>

    <?php // echo $form->field($model, 'order_price') ?>

    <?php echo $form->field($model, 'unit_name')->dropdownList($unit,['prompt'=>'-Unit-']) ?>

    <?php echo $form->field($model, 'order_date')->widget(DatePicker::className(), [
        'language' => 'en',
        'size' => 'ms',
        'inline' => false,
        'clientOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd',
          //'todayBtn' => true
        ]
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
