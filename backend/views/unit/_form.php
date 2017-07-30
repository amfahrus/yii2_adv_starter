<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Unit;
use yii\helpers\Json;
use mdm\admin\AutocompleteAsset;

/* @var $this yii\web\View */
/* @var $model backend\models\Unit */
/* @var $form yii\widgets\ActiveForm */
AutocompleteAsset::register($this);
$opts = Json::htmlEncode([
        'units' => Unit::getUnitSource(),
    ]);
$this->registerJs("var _opts = $opts;");
$this->registerJs($this->render('_script.js'));
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>
    
	<?= Html::activeHiddenInput($model, 'unit_parent', ['id' => 'parent_id']); ?>

    <?= $form->field($model, 'unit_name')->textInput() ?>

    <?= $form->field($model, 'unit_code')->textInput() ?>

    <?= $form->field($model, 'unit_status')->textInput() ?>

    <?= $form->field($model, 'parent_name')->textInput(['id' => 'parent_name']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
