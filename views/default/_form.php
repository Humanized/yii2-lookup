<?php

use yii\helpers\Html;
use \kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\core\ArtifactType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= 'test' ?>-form">

    <?php
    $form = ActiveForm::begin([
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Insert Record') ?>


    <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>

    <?php ActiveForm::end(); ?>

</div>
