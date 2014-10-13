<?php
namespace intelligent\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * The container that provides a horizontal scrollbar whenever the 
 * elements inside it are wider than the container itself.
 * This comes in useful when having to handle tables on a responsive website,
 * which at some point would just get too big.
 *
 * For example,
 *
 * ```php
 * echo OverflowBox::widget([
 *      'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the OverflowBox:
 *
 * ```php
 * OverflowBox::begin();
 *
 *       echo 'Say hello...';
 *
 * OverflowBox::end();
 * ```
 *
 * Using options:
 *
 * ```php
 * OverflowBox::begin([
 *      'options' => ['class' => 'customclass'],
 * ]);
 *
 *       echo 'Say hello...';
 *
 * OverflowBox::end();
 * ```
 *
 * @see http://www.getuikit.com/docs/utility.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class OverflowBox extends Widget
{
   /**
     * @var string the body content in the OverflowBox component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the OverflowBox widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-overflow-container');

        echo Html::beginTag('div', $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->body;
        echo "\n" . Html::endTag('div');

        $this->registerAsset();
    }

}
