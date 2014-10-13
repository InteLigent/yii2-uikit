<?php
namespace intelligent\uikit;

use yii\helpers\Html;

/**
 * Close renders a UIkit close button
 *
 * For example,
 *
 * ```php
 * echo Close::widget(['tagName' => 'button']);
 * ]);
 * ```
 * @see http://www.getuikit.com/docs/close.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Close extends Widget
{

    /**
     * @var string the tag to be used. an <a> or <button> element.
     */
    public $tagName = 'a';

    /**
     * @var boolean an alternative styling to the close button.
     */
    public $isAlternative = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag($this->tagName, $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::endTag($this->tagName);
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        Html::addCssClass($this->options, 'uk-close');

        if ($this->isAlternative)
            Html::addCssClass($this->options, 'uk-close-alt');
    }

}
