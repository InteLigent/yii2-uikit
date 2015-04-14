<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Notify component asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class NestableAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';

    public $js = [
        'js/components/nestable.js',
    ];

    public $css = [
        'css/components/nestable.multi.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}