<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 20.06.2018
 * Time: 9:23
 *
 *  * @var $this View
 * @var $banners \floor12\banner\models\AdsBanner[]
 */

use yii\web\View;
use yii\helpers\Html;

$jsCode = <<< JS

    $('.banner-slider').slick({
        vertical : true,
        arrows: false,
        autoplay: true,
        accessibility: false,
        adaptiveHeight: true,
        autoplaySpeed: 3000,
    });
    
JS;

$this->registerJsFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['depends' => ['yii\bootstrap\BootstrapAsset']]);
$this->registerCssFile('//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
$this->registerJs($jsCode, View::POS_READY, 'floor12-banner-slider');

echo "<div class='banner-slider'>";

foreach ($banners as $banner) {

    if ($banner->file_mobile) {
        $img = Html::img($banner->file_desktop, ['class' => 'img-responsive hidden-xs']);
        $img .= Html::img($banner->file_mobile, ['class' => 'img-responsive visible-xs']);
    } else
        $img = Html::img($banner->file_desktop, ['class' => 'img-responsive']);

    if ($banner->href)
        echo Html::a($img, ['/banner/redirect', 'id' => $banner->id], ['target' => '_blank']);
    else
        echo $img;
}

echo "</div>";