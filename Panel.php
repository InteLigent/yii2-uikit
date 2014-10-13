<?php
namespace intelligent\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Panel renders an panel component.
 *
 * For example,
 *
 * ```php
 * echo Panel::widget([
 *     'options' => [
 *         'class' => 'some class',
 *     ],
 *     'body' => '<p>Say hello...</p>',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the alert box:
 *
 * ```php
 * Panel::begin([
 *     'title' => 'First Panel',
 *     'badge' => '09 May 2014',
 *     'options' => ['class' => 'some class'],
 *     'isBox' => true,
 * ]);
 *
 * echo '<p>Say hello...</p>';
 *
 * Panel::end();
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class Panel extends Widget
{
   /**
     * @var string the badge data of the panel.
     */
    public $badge;
    
    /**
     * @var string the title of the panel.
     */
    public $title;

    /**
     * @var string the body content in the panel component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the Panel widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

   /**
    * @var boolean the box
    */
    public $isBox = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('div', $this->options) . "\n";
        echo $this->renderBadge() . "\n";
        echo $this->renderTitle() . "\n"; 
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBody();
        echo "\n" . Html::endTag('div');

        $this->registerAsset();
    }

    /**
     * Renders the badge.
     * @return string the rendering result
     */
    protected function renderBadge()
    {
        if ($this->badge !== null) {
            return Html::tag('div', $this->badge, ['class' => 'uk-panel-badge uk-badge']);
        } else {
            return null;
        }
    }

    /**
     * Renders the title of the panel.
     * @return string the rendering result
     */
    protected function renderTitle()
    {
        if ($this->title !== null) {
            return Html::tag('h3', $this->title, ['class' => 'uk-panel-title']);
        } else {
            return null;
        }
    }

    /**
     * Renders the panel body (if any).
     * @return string the rendering result
     */
    protected function renderBody()
    {
        return $this->body . "\n";
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        Html::addCssClass($this->options, 'uk-panel');

        if ($this->isBox)
            Html::addCssClass($this->options, 'uk-panel-box');
    }
}
