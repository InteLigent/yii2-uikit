<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Panel-like box which has a max-height and provides a vertical scrollbar.
 *
 * For example,
 *
 * ```php
 * echo ScrollableBox::widget([
 *      'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the ScrollableBox:
 *
 * ```php
 * ScrollableBox::begin();
 *
 *       echo 'Say hello...';
 *
 * ScrollableBox::end();
 * ```
 *
 * Using options:
 *
 * ```php
 * ScrollableBox::begin([
 *     'options' => ['class' => 'customclass'],
 * ]);
 *
 *       echo 'Say hello...';
 *
 * ScrollableBox::end();
 * ```
 *
 * @see http://www.getuikit.com/docs/utility.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class ScrollableBox extends Widget
{
   /**
     * @var string the body content in the ScrollableBox component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the ScrollableBox widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-scrollable-box');

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
