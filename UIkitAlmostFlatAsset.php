<?php
namespace intelligent\uikit;

use yii\web\AssetBundle;

/**
 * Almost flat theme for UIkit
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @author Nikolay Kostyurin <nikolay@artkost.ru>
 * @since 2.0
 */
class UIkitAlmostFlatAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';
    public $css = [
        'css/uikit.almost-flat.css',
    ];
    /*public $depends = [
        'intelligent\uikit\UIkitAsset',
    ];*/
}