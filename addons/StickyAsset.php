<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Sticky addon asset
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class StickyAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';
    public $js = [
        'js/addons/sticky.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\addons\UIkitAddonsAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}