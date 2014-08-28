<?php

/**
 * @var \yii\base\View $this View
 * @var \yii\data\ActiveDataProvider $dataProvider Data provider
 * @var \vova07\blogs\models\backend\BlogSearch $searchModel Search model
 * @var array $statusArray Statuses array
 */

use backend\themes\admin\widgets\Box;
use backend\themes\admin\widgets\GridView;
use vova07\blogs\Module;
use yii\grid\ActionColumn;
use yii\grid\CheckboxColumn;
use yii\helpers\Html;
use yii\jui\DatePicker;

$this->title = Module::t('blogs', 'BACKEND_INDEX_TITLE');
$this->params['subtitle'] = Module::t('blogs', 'BACKEND_INDEX_SUBTITLE');
$this->params['breadcrumbs'] = [
    $this->title
]; ?>

<div class="row">
    <div class="col-xs-12">
        <?php Box::begin(
            [
                'title' => $this->params['subtitle'],
                'bodyOptions' => [
                    'class' => 'table-responsive'
                ],
                'buttonsTemplate' => '{create} {batch-delete}',
                'grid' => 'blogs-grid'
            ]
        ); ?>
        <?= GridView::widget(
            [
                'id' => 'blogs-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => CheckboxColumn::classname()
                    ],
                    'id',
                    [
                        'attribute' => 'title',
                        'format' => 'html',
                        'value' => function ($model) {
                                return Html::a(
                                    $model['title'],
                                    ['update', 'id' => $model['id']]
                                );
                            }
                    ],
                    'views',
                    [
                        'attribute' => 'status_id',
                        'format' => 'html',
                        'value' => function ($model) {
                                $class = ($model->status_id === $model::STATUS_PUBLISHED) ? 'label-success' : 'label-danger';

                                return '<span class="label ' . $class . '">' . $model->status . '</span>';
                            },
                        'filter' => Html::activeDropDownList(
                                $searchModel,
                                'status_id',
                                $statusArray,
                                [
                                    'class' => 'form-control',
                                    'prompt' => Module::t('blogs', 'BACKEND_PROMPT_STATUS')
                                ]
                            )
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'date',
                        'filter' => DatePicker::widget(
                                [
                                    'model' => $searchModel,
                                    'attribute' => 'created_at',
                                    'options' => [
                                        'class' => 'form-control'
                                    ],
                                    'clientOptions' => [
                                        'dateFormat' => 'dd.mm.yy',
                                    ]
                                ]
                            )
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => 'date',
                        'filter' => DatePicker::widget(
                                [
                                    'model' => $searchModel,
                                    'attribute' => 'updated_at',
                                    'options' => [
                                        'class' => 'form-control'
                                    ],
                                    'clientOptions' => [
                                        'dateFormat' => 'dd.mm.yy',
                                    ]
                                ]
                            )
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{update} {delete}'
                    ]
                ]
            ]
        ); ?>
        <?php Box::end(); ?>
    </div>
</div>