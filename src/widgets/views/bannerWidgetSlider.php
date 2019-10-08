<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 * @var $this View
 * @var $banner \floor12\banner\models\AdsBanner[]
 * @var $place \floor12\banner\models\AdsPlace
 * @var $id string
 */

use floor12\banner\assets\SlickAsset;
use floor12\banner\models\AdsBanner;
use yii\helpers\Html;
use yii\web\View;

SlickAsset::register($this);

$jsCode = <<< JS

    $('#{$id}').slick({
        vertical :  {$place->vertical},
        arrows: {$place->arrows},
        autoplay: true,
        accessibility: false,
        adaptiveHeight: true,
        autoplaySpeed: {$place->slider_time},
    });


    
JS;

$this->registerJs($jsCode, View::POS_READY, 'floor12-banner-slider-' . $id);

echo "<div id='{$id}'>";

foreach ($banners as $banner) {

    if ($banner->type == AdsBanner::TYPE_IMAGE)
        if ($banner->file_mobile)
            $img = "<picture>
                <source type='image/webp' media='(min-width: 700px)' srcset='{$banner->file_desktop->getPreviewWebPath(1920, 0, true)} 1x, {$banner->file_desktop->getPreviewWebPath(3840,0, true)} 2x'>              
                <source type='image/webp' media='(max-width: 700px)' srcset='{$banner->file_mobile->getPreviewWebPath(700, 0, true)} 1x, {$banner->file_mobile->getPreviewWebPath(1400,0, true)} 2x'>
                <source type='{$banner->file_desktop->content_type}' media='(min-width: 700px)' srcset='{$banner->file_desktop->getPreviewWebPath(1920)} 1x, {$banner->file_desktop->getPreviewWebPath(3840)} 2x'>
                <source type='{$banner->file_desktop->content_type}' srcset='{$banner->file_mobile->getPreviewWebPath(700)} 1x, {$banner->file_mobile->getPreviewWebPath(1400)} 2x'>
                <img src='{$banner->file_desktop->getPreviewWebPath(1920)}' class='img-responsive' alt='{$banner->title}'>
            </picture>";
        else
            $img = "<picture>
                <source type='image/webp' srcset='{$banner->file_desktop->getPreviewWebPath(1920, 0, true)} 1x, {$banner->file_desktop->getPreviewWebPath(3840,0, true)} 2x'>              
                <source type='{$banner->file_desktop->content_type}' srcset='{$banner->file_desktop->getPreviewWebPath(1920)} 1x, {$banner->file_desktop->getPreviewWebPath(3840)} 2x'>
                <img src='{$banner->file_desktop->getPreviewWebPath(1920)}' class='img-responsive' alt='{$banner->title}'>
            </picture>";

    else
        $img = Html::tag('iframe', null, [
            'src' => $banner->webPath,
            'class' => 'f12-rich-banner',
            'data-href' => $banner->href ? Url::toRoute(['/banner/redirect', 'id' => $banner->id]) : '',
        ]);


    if ($banner->href && $banner->type == AdsBanner::TYPE_IMAGE)
        echo Html::a($img, ['/banner/redirect', 'id' => $banner->id], ['target' => '_blank']);
    else
        echo $img;
}

echo "</div>";
