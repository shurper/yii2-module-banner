<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 13:13
 *
 * @var $this View
 * @var $model AdsPopPlaceFilter;
 */

use shurper\banner\assets\BannerAsset;
use shurper\banner\models\AdsPopPlaceFilter;
use shurper\banner\widgets\TabWidget;
use shurper\editmodal\EditModalAsset;
use shurper\editmodal\EditModalColumn;
use shurper\editmodal\EditModalHelper;
use shurper\editmodal\IconHelper;
use yii\bootstrap\BootstrapAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

BootstrapAsset::register($this);
BannerAsset::register($this);
EditModalAsset::register($this);


$this->title = 'Pop-up';

echo Html::tag('h1', 'Баннеры');

echo TabWidget::widget();

echo EditModalHelper::editBtn(
    'popup-place-form', 
    0, 
    'btn btn-sm btn-primary btn-banner-add', 
    IconHelper::PLUS . " добавить площадку"
);

echo Html::tag('br');

Pjax::begin(['id' => 'items']);

echo GridView::widget([
    'dataProvider' => $model->dataProvider(),
    'tableOptions' => ['class' => 'table table-striped table-banners'],
    'layout' => "{items}\n{pager}\n{summary}",
    'columns' => [
        'id',
        'title',
        [
            'class' => EditModalColumn::class,
            'editPath' => 'popup-place-form',
            'deletePath' => 'popup-place-delete',
        ]
    ]
]);

Pjax::end();

