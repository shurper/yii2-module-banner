<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 * @var $this View
 * @var $banners \floor12\banner\models\AdsBanner[]
 * @var $place \floor12\banner\models\AdsPlace
 * @var $id string
 */

use floor12\banner\models\AdsBanner;
use yii\helpers\Html;
use yii\web\View;


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

$this->registerJsFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['depends' => ['yii\bootstrap\BootstrapAsset']]);
$this->registerCssFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
$this->registerJs($jsCode, View::POS_READY, 'floor12-banner-slider-' . $id);

echo "<div id='{$id}'>";

foreach ($banners as $banner) {

    if ($banner->file_mobile) {
        $img = Html::img($banner->file_desktop, ['class' => 'img-responsive hidden-xs']);
        $img .= Html::img($banner->file_mobile, ['class' => 'img-responsive visible-xs']);
    } else
        if ($banner->type == AdsBanner::TYPE_IMAGE)
            $img = Html::img($banner->file_desktop, ['class' => 'img-responsive']);
        else
            $img = Html::tag('iframe', null, [
                'src' => $banner->webPath,
                'class' => 'f12-rich-banner',
                'data-href' => $banner->href ? Url::toRoute(['/banner/redirect', 'id' => $banner->id]) : '',
            ]);


    if ($banner->href && $banners->type == AdsBanner::TYPE_IMAGE)
        echo Html::a($img, ['/banner/redirect', 'id' => $banner->id], ['target' => '_blank']);
    else
        echo $img;
}

echo "</div>";