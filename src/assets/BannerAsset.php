<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 18:07
 */

namespace floor12\banner\assets;

use yii\web\AssetBundle;

class BannerAsset extends AssetBundle
{
    public $sourcePath  = '@common/modules/banner/assets';

    public $css = [
        'banner.css'
    ];

    public $js = [];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
