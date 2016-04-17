<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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

    <div class="row">

        <div class="col-md-3">
            <div class="well">
                <?php echo $this->render('_form', ['model' => $model, 'caller' => $caller]); ?>
            </div>
        </div>

        <div class="col-md-9">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    [ 'class' => 'kartik\grid\EditableColumn',
                        'attribute' => 'name',
                        'refreshGrid' => TRUE,
                        'editableOptions' => [
                            'header' => 'Buy Amount',
                            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
                        ],
                    ],
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
    </div>



</div>
