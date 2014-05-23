<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * SmoothScroll renders an SmoothScroll component.
 *
 * For example,
 *
 * ```php
 * echo SmoothScroll::widget([
 *     'showButton' => true,
 *     'options' => ['href' => '#footer'],
 *     'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the SmoothScroll box:
 *
 * ```php
 * SmoothScroll::begin([
 *     'showButton' => true,
 * ]);
 *
 * echo 'Say hello...';
 *
 * SmoothScroll::end();
 * ```
 * @see http://www.getuikit.com/docs/smooth-scroll.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class SmoothScroll extends Widget
{
   /**
     * @var string the body content in the SmoothScroll component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the SmoothScroll widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * @var boolean add button css class to SmoothScroll component. 
     */
    public $showButton = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('a', $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->body;
        echo "\n" . Html::endTag('a');

        $this->registerAsset();
    }

   /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        if($this->showButton)
            Html::addCssClass($this->options, 'uk-button');

        $this->options = array_merge([
            'data-uk-smooth-scroll' => '',
        ], $this->options);
    }
}
