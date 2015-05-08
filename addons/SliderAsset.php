<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Slider component asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class SliderAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';

    public $js = [
        'js/components/slider.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}