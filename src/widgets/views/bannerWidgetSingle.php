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

use yii\helpers\Html;

if ($banners->file_mobile) {
    $img = Html::img($banners->file_desktop, ['class' => 'img-responsive hidden-xs']);
    $img .= Html::img($banners->file_mobile, ['class' => 'img-responsive visible-xs']);
} else
    $img = Html::img($banners->file_desktop, ['class' => 'img-responsive']);

if ($banners->href)
    echo Html::a($img, ['/banner/redirect', 'id' => $banners->id], ['target' => '_blank']);
else
    echo $img;