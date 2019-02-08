<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this \yii\web\View
 * @var $model \floor12\banner\models\AdsPopPlaceFilter;
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsPopupPlace;
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

echo Html::a(FontAwesome::icon('plus') . " добавить площадку", null, [
    'onclick' => EditModalHelper::showForm('banner/admin/popup-place-form', 0),
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
        'title',
        ['contentOptions' => ['style' => 'min-width:100px; text-align:right;'],
            'content' => function (AdsPopupPlace $model) {
                return
                    Html::a(FontAwesome::icon('pencil'), NULL, ['onclick' => EditModalHelper::showForm('banner/admin/popup-place-form', $model->id), 'class' => 'btn btn-default btn-sm']) . " " .
                    Html::a(FontAwesome::icon('trash'), NULL, ['onclick' => EditModalHelper::deleteItem('banner/admin/popup-place-delete', $model->id), 'class' => 'btn btn-default btn-sm']);
            },
        ]
    ]
]);

Pjax::end();

