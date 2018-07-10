<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this \yii\web\View
 * @var $model \floor12\banner\models\AdsPlaceFilter;
 */

use floor12\banner\widgets\TabWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FontAwesome;
use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPlace;
use floor12\editmodal\EditModalHelper;

BannerAsset::register($this);

$this->title = 'Баннерные площадки';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo Html::a(FontAwesome::icon('plus') . " добавить площадку", null, [
    'onclick' => EditModalHelper::showForm('banner/admin/place-form', 0),
    'class' => 'btn btn-sm btn-success btn-banner-add'
]);

echo Html::tag('br');

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-stiped'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',

        [
            'attribute' => 'title',
            'content' => function (AdsPlace $model): string {
                if ($model->status == AdsPlace::STATUS_DISABLED)
                    return Html::tag('span', $model->title, ['class' => 'striked']);
                return $model->title;
            }
        ],
        [
            'header' => 'Десктоп',
            'content' => function (AdsPlace $model): string {
                return "{$model->desktop_width}x{$model->desktop_height}px";
            }
        ],
        [
            'header' => 'Мобильный',
            'content' => function (AdsPlace $model): string {
                return "{$model->mobile_width}x{$model->mobile_height}px";
            }
        ],
        [
            'contentOptions' => ['style' => 'min-width:100px; text-align:right;'],
            'content' => function (AdsPlace $model) {
                return
                    Html::a(FontAwesome::icon('pencil'), NULL, ['onclick' => EditModalHelper::showForm('banner/admin/place-form', $model->id), 'class' => 'btn btn-default btn-sm']) . " " .
                    Html::a(FontAwesome::icon('trash'), NULL, ['onclick' => EditModalHelper::deleteItem('banner/admin/place-delete', $model->id), 'class' => 'btn btn-default btn-sm']);
            },
        ]
    ]
]);

Pjax::end();

