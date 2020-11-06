<?php
/**
 * Created by PhpStorm.
 * User: shurper
 * Date: 19.06.2018
 * Time: 18:07
 */

namespace shurper\banner\assets;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $sourcePath = '@vendor/shurper/yii2-module-banner/src/assets/slick';

    public $css = [
        'slick.css',
        'slick-theme.css'
    ];

    public $js = [
        'slick.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
