<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use dosamigos\datepicker\DatePicker;
use backend\models\Customer;
use backend\models\Unit;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\OrderSearch */
/* @var $form yii\widgets\ActiveForm */
$customer = ArrayHelper::map(Customer::find()->select(["customer_id","CONCAT(customer_code,' - ',customer_name) as customer_name"])->all(),"customer_id","customer_name");
$unit = ArrayHelper::map(Unit::find()->all(),'p_master_unit_id','unit_name');
?>

<div class="order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'customer_id')->widget(Select2::classname(), [
        'data' => $customer,
        'language' => 'en',
        'options' => ['placeholder' => '-Customer-'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'p_master_unit_id')->dropdownList($unit,['prompt'=>'-Unit-']) ?>

    <?= $form->field($model, 'start')->widget(DatePicker::className(), [
        'language' => 'en',
        'size' => 'ms',
        'inline' => false,
        'clientOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd',
          //'todayBtn' => true
        ],
    ]);?>

    <?= $form->field($model, 'end')->widget(DatePicker::className(), [
        'language' => 'en',
        'size' => 'ms',
        'inline' => false,
        'clientOptions' => [
          'autoclose' => true,
          'format' => 'yyyy-mm-dd',
          //'todayBtn' => true
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
