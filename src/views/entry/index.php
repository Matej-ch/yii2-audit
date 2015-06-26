<?php

use bedezign\yii2\audit\Audit;
use yii\helpers\Html;
use yii\grid\GridView;

use bedezign\yii2\audit\models\AuditEntrySearch;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('audit', 'Entries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('audit', 'Audit'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="audit-entry-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}'],
            'id',
            [
                'attribute' => 'user_id',
                'label' => Yii::t('audit', 'User'),
                'class' => 'yii\grid\DataColumn',
                'value' => function ($data) {
                    return Audit::current()->getUserIdentifier($data->user_id);
                },
                'format' => 'raw',
            ],
            'request_method',
            'ajax',
            'created',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'route',
                'filter' => AuditEntrySearch::routeFilter(),
                'format' => 'html',
                'value' => function ($data) {
                    return HTML::tag('span', '', [
                        'title' => $data->url,
                        'class' => 'glyphicon glyphicon-link'
                    ]) . ' ' . $data->route;
                },
            ],
            [
                'attribute' => 'duration',
                'format' => 'decimal',
                'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
            ],
            [
                'attribute' => 'memory_max',
                'format' => 'shortsize',
                'contentOptions' => ['class' => 'text-right', 'width' => '100px'],
            ],
            [
                'attribute' => 'trails',
                'value' => function ($data) {
                    return $data->trails ? count($data->trails) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'javascripts',
                'value' => function ($data) {
                    return $data->javascripts ? count($data->javascripts) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
            [
                'attribute' => 'errors',
                'value' => function ($data) {
                    return $data->linkedErrors ? count($data->linkedErrors) : '';
                },
                'contentOptions' => ['class' => 'text-right'],
            ],
        ],
    ]); ?>
</div>
