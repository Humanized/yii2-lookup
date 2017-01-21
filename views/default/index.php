<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ArtifactTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$word = yii\helpers\Inflector::camel2words(yii\helpers\Inflector::id2camel('test'));
$plural = yii\helpers\Inflector::pluralize($word);

$this->title = $plural;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= 'test' ?>-index">



    <?=
    GridView::widget([
        'export' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'beforeHeader' => '<tr><td colspan=20>' . $this->render('@vendor/humanized/yii2-lookup/views/default/_form', [
            'model' => $model,
        ]) . '</td><tr>',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            ['class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name',
                'refreshGrid' => TRUE,
                'editableOptions' => [
                    'header' => 'Attribute Value',
                    'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                    'asPopover' => false,
                ],
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{delete}', 'buttons' => [
                    //view button
                    'delete' => function ($url, $model) {
                        $options = [
                            // 'visible' => (int) $model['status'] != 0 ? TRUE : FALSE,
                            //'hidden' => (int) $model['status'] != 0 ? TRUE : FALSE,
                            'title' => \Yii::t('yii', 'Delete Account'),
                            'aria-label' => \Yii::t('yii', 'Delete Account'),
                            'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this record?'),
                            'data-method' => 'post',
                            'data-params' => [
                                'hasDeletable' => true, 'deletableKey' => $model->id,
                            ],
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['type',], $options);
                    },
                ],],
        ],
    ]);
    ?>
</div>