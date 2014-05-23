<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * ScrollSpy renders an ScrollSpy component.
 *
 * For example,
 *
 * ```php
 * echo ScrollSpy::widget([
 *     'animation' => ScrollSpy::ANIMATION_SLIDE_RIGHT,
 *     'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the ScrollSpy box:
 *
 * ```php
 * ScrollSpy::begin([
 *     'animation' => ScrollSpy::ANIMATION_SLIDE_RIGHT,
 *     'repeat' => true,
 *     'delay' => 600
 * ]);
 *
 *       echo SmoothScroll::widget([
 *           'showButton' => true,
 *           'body' => 'Say hello...',
 *       ]);
 *
 * ScrollSpy::end();
 * ```
 * @see http://www.getuikit.com/docs/scrollspy.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class ScrollSpy extends Widget
{
    /**
     * @see http://www.getuikit.com/docs/animation.html
     */
    const ANIMATION_FADE = "fade";
    const ANIMATION_SCALE_UP = "scale-up";
    const ANIMATION_SCALE_DOWN = "scale-down";
    const ANIMATION_SLIDE_TOP = "slide-top";
    const ANIMATION_SLIDE_BOTTOM = "slide-bottom";
    const ANIMATION_SLIDE_LEFT = "slide-left";
    const ANIMATION_SLIDE_RIGHT = "slide-right";

    /**
     * @var string the animation effect.
     */
    public $animation;

   /**
     * @var string the body content in the ScrollSpy component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the ScrollSpy widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * @var boolean applies the class everytime the element appears in the viewport. 
     */
    public $repeat = false;

    /**
     * @var integer a delay in milliseconds to the animation. 
     */
    public $delay;

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

        $this->registerAsset();
    }

   /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {

        if (!$this->animation) {
            throw new InvalidConfigException("The 'animation' option is required.");
        }

        $class = "{cls:'uk-animation-{$this->animation}'";

        if ($this->repeat)
            $class .= ", repeat:true";

        if (isset($this->delay) && is_int($this->delay))
            $class .= ", delay:{$this->delay}";

        $class .= "}";

        $this->options = array_merge([
            'data-uk-scrollspy' => $class,
        ], $this->options);
    }
}
