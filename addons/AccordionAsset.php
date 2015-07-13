<?php
namespace intelligent\uikit\addons;

use yii\web\AssetBundle;

/**
 * Accordion component asset
 *
 * @author Vjacheslav Demchenko <word2electronics@gmail.com>
 * @since 2.0
 */
class AccordionAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';

    public $js = [
        'js/components/accordion.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'intelligent\uikit\UIkitPluginAsset',
    ];
}