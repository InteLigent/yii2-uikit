<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Notify component asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class SortableAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';

    public $js = [
        'js/components/sortable.js',
    ];

    public $css = [
        'css/components/sortable.multi.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}