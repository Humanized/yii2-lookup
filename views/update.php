<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\ArtifactType */

$this->title = 'Update' . $caller . ': ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $caller, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="<?= $caller ?>-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
