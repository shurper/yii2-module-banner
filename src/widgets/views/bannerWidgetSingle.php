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


if ($banners->type == AdsBanner::TYPE_IMAGE)


    if ($banners->file_mobile)
        $img = "<picture>
                <source type='image/webp' media='(min-width: 700px)' srcset='{$banners->file_desktop->getPreviewWebPath(1920,0,true)} 1x, {$banners->file_desktop->getPreviewWebPath(3840,0,true)} 2x'>              
                <source type='image/webp' media='(max-width: 700px)' srcset='{$banners->file_mobile->getPreviewWebPath(700,true)} 1x, {$banners->file_mobile->getPreviewWebPath(1400,true)} 2x'>
                <source type='{$banners->file_desktop->content_type}' media='(min-width: 700px)' srcset='{$banners->file_desktop->getPreviewWebPath(1920)} 1x, {$banners->file_desktop->getPreviewWebPath(3840)} 2x'>
                <source type='{$banners->file_desktop->content_type}' smedia='(max-width: 700px)' rcset='{$banners->file_mobile->getPreviewWebPath(700)} 1x, {$banners->file_mobile->getPreviewWebPath(1400)} 2x'>
                <img src='{$banners->file_desktop->getPreviewWebPath(1920)}' class='img-responsive' alt='{$banners->title}'>
            </picture>";
    else
        $img = "<picture>
                <source type='image/webp' srcset='{$banners->file_desktop->getPreviewWebPath(1920,0,true)} 1x, {$banners->file_desktop->getPreviewWebPath(3840,0,true)} 2x'>              
                <source type='{$banners->file_desktop->content_type}'srcset='{$banners->file_desktop->getPreviewWebPath(1920)} 1x, {$banners->file_desktop->getPreviewWebPath(3840)} 2x'>
                <img src='{$banners->file_desktop->getPreviewWebPath(1920)}' class='img-responsive' alt='{$banners->title}'>
            </picture>";
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

