<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this \yii\web\View
 * @var $model \floor12\banner\models\AdsBannerFilter;
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPopup;
use floor12\banner\widgets\TabWidget;
use floor12\editmodal\EditModalHelper;
use rmrevin\yii\fontawesome\FontAwesome;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

BannerAsset::register($this);

$this->title = 'Pop-up';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo Html::a(FontAwesome::icon('plus') . " добавить баннер", null, [
    'onclick' => EditModalHelper::showForm('banner/admin/popup-form', 0),
    'class' => 'btn btn-sm btn-primary btn-banner-add'
]);

echo Html::tag('br');

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-striped table-banners'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',
        [
            'attribute' => 'title',
            'content' => function (AdsPopup $model): string {
                if ($model->status == AdsPopup::STATUS_DISABLED)
                    $html = Html::tag('span', $model, ['class' => 'striked']);
                else
                    $html = $model;
                return $html;
            }
        ],
        'views',
        'clicks',
        ['contentOptions' => ['style' => 'min-width:100px; text-align:right;'],
            'content' => function (AdsPopup $model) {
                return
                    Html::a(FontAwesome::icon('pencil'), NULL, ['onclick' => EditModalHelper::showForm('banner/admin/popup-form', $model->id), 'class' => 'btn btn-default btn-sm']) . " " .
                    Html::a(FontAwesome::icon('trash'), NULL, ['onclick' => EditModalHelper::deleteItem('banner/admin/popup-delete', $model->id), 'class' => 'btn btn-default btn-sm']);
            },
        ]
    ]
]);

Pjax::end();
