<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArtifactTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$word = yii\helpers\Inflector::camel2words(yii\helpers\Inflector::id2camel($caller));
$plural = yii\helpers\Inflector::pluralize($word);

$this->title = $plural;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= $caller ?>-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create ' . $word, ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'name',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}', 'buttons' => [

                    //view button
                    'delete' => function ($url, $model) use ($caller) {

                        $options = [
                            // 'visible' => (int) $model['status'] != 0 ? TRUE : FALSE,
                            //'hidden' => (int) $model['status'] != 0 ? TRUE : FALSE,
                            'title' => \Yii::t('yii', 'Delete Account'),
                            'aria-label' => \Yii::t('yii', 'Delete Account'),
                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this account?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'caller' => $caller, 'id' => $model['id']], $options);
                    },
                        ],],
                ],
            ]);
            ?>
</div>
