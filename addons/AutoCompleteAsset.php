<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * AutoComplete component asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class AutoCompleteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';

    public $js = [
        'js/components/autocomplete.js',
    ];

    public $css = [
        'css/components/autocomplete.multi.css',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}