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

use floor12\banner\widgets\TabWidget;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use floor12\editmodal\ModalWindow;
use rmrevin\yii\fontawesome\FontAwesome;
use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsBanner;

BannerAsset::register($this);

$this->title = 'Баннерные площадки';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo Html::a(FontAwesome::icon('plus') . " добавить баннер", null, [
    'onclick' => ModalWindow::showForm('banner/admin/banner-form', 0),
    'class' => 'btn btn-sm btn-success btn-banner-add'
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
            'content' => function (AdsBanner $model): string {
                if ($model->status == AdsBanner::STATUS_DISABLED)
                    $html = Html::tag('span', $model, ['class' => 'striked']);
                else
                    $html = $model;
                $html .= Html::tag('div', implode(', ', $model->places), ['class' => 'small']);
                return $html;
            }
        ],
        'views',
        'clicks',
        ['contentOptions' => ['style' => 'min-width:100px; text-align:right;'],
            'content' => function (AdsBanner $model) {
                return
                    Html::a(FontAwesome::icon('pencil'), NULL, ['onclick' => ModalWindow::showForm('banner/admin/banner-form', $model->id), 'class' => 'btn btn-default btn-sm']) . " " .
                    Html::a(FontAwesome::icon('trash'), NULL, ['onclick' => ModalWindow::deleteItem('banner/admin/banner-delete', $model->id), 'class' => 'btn btn-default btn-sm']);
            },
        ]
    ]
]);

Pjax::end();

