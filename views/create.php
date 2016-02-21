<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\core\ArtifactType */

$this->title = 'Create ' . $caller;
$this->params['breadcrumbs'][] = ['label' => $caller, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $caller ?>-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
