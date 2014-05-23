<?php
namespace demogorgorn\uikit;

use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * Icon renders a UIkit icon
 *
 * For example,
 *
 * ```php
 * echo Icon::widget(['name' => 'fast-backward']);
 * ]);
 * ```
 * @see http://www.getuikit.com/docs/icon.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Icon extends Widget
{
    /**
     * @var string the icon name
     */
    public $name = '';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if (!$this->name) 
            throw new InvalidConfigException("The 'name' option is required.");
        
        Html::addCssClass($this->options, 'uk-icon-' . $this->name);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('i', '', $this->options);
    }
}
