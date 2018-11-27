<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 * @var $this \yii\web\View
 * @var $banners \floor12\banner\models\AdsBanner
 */

use floor12\banner\assets\BannerAsset;
use floor12\banner\models\AdsBanner;
use yii\helpers\Html;
use yii\helpers\Url;

BannerAsset::register($this);

if ($banners->file_mobile) {
    $img = Html::img($banners->file_desktop, ['class' => 'img-responsive hidden-xs']);
    $img .= Html::img($banners->file_mobile, ['class' => 'img-responsive visible-xs']);
} else
    if ($banners->type == AdsBanner::TYPE_IMAGE)
        $img = Html::img($banners->file_desktop, ['class' => 'img-responsive']);
    else
        $img = Html::tag('iframe', null, [
            'src' => $banners->webPath,
            'class' => 'f12-rich-banner',
            'data-href' => $banners->href ? Url::toRoute(['/banner/redirect', 'id' => $banners->id]) : '',
        ]);


if ($banners->href && $banners->type == AdsBanner::TYPE_IMAGE)
    echo Html::a($img, ['/banner/redirect', 'id' => $banners->id], ['target' => '_blank', 'id' => '']);
else
    echo $img;

