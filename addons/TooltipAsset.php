<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Sticky addon asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class TooltipAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';
    public $js = [
        'js/components/tooltip.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}