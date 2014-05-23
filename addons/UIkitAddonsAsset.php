<?php
namespace demogorgorn\uikit\addons;

use yii\web\AssetBundle;

/**
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class UIkitAddonsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/uikit/uikit/dist';
    public $css = [
        'css/addons/uikit.almost-flat.addons.css',
    ];
}