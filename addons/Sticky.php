<?php
namespace intelligent\uikit\addons;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Sticky renders an Sticky component.
 *
 * For example,
 *
 * ```php
 * echo Sticky::widget([
 *     'offset' => 100,
 *     'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the Sticky:
 *
 * ```php
 * Sticky::begin([
 *     'offset' => 40,
 * ]);
 *
 *       echo 'Say hello...';
 *
 * Sticky::end();
 * ```
 * @see http://www.getuikit.com/docs/addons_sticky.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class Sticky extends \intelligent\uikit\Widget
{
   /**
     * @var string the body content in the Sticky component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the Sticky widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * @var integer position the element below the viewport edge.
     */
    public $offset;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('div', $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->body;
        echo "\n" . Html::endTag('div');

        StickyAsset::register($this->getView());
    }

   /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        $class = '';
        if ($this->offset && is_int($this->offset))
            $class = "{top:{$this->offset}}";
       
        $this->options = array_merge([
            'data-uk-sticky' => $class,
        ], $this->options);
    }
}
