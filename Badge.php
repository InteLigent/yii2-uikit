<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Badge renders an Badge component.
 *
 * For example,
 *
 * ```php
 * echo Badge::widget([
 *     'options' => [
 *         'class' => 'uk-badge-success',
 *     ],
 *     'body' => 'Say hello...',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the Badge box:
 *
 * ```php
 * Badge::begin([
 *     'isNotification' => true,
 *     'options' => [
 *         'class' => 'uk-badge-success',
 *     ],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Badge::end();
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class Badge extends Widget
{
   /**
     * @var string the body content in the Badge component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the Badge widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * @var boolean use the notification type of the Badge component. 
     */
    public $isNotification = false;

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
        Html::addCssClass($this->options, 'uk-badge');

        if($this->isNotification)
            Html::addCssClass($this->options, 'uk-badge-notification');
    }
}
