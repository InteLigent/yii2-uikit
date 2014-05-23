<?php
namespace demogorgorn\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use demogorgorn\uikit\Button;

/**
 * Toggle renders a Toggle UIKit component.
 * Hide, switch or change the appearence of different contents through a toggle.
 *
 * For example SubNav mode:
 *
 * ```php
 * echo Toggle::widget([
 *  'caption' => 'Toggle',
 *  'items' => [
 *          [
 *              'content' => 'Big text is written here!',
 *              'itemOptions' => [
 *                  'class' => 'uk-animation-fade',
 *              ],
 *          ],
 *          [
 *              'content' => 'Lorem ipsum...',
 *              'hidden' => true,
 *          ],
 *      ],
 * ]);
 * ```
 *
 * Please note the 'options' array option is connected with button part of widget.
 *
 * @see http://www.getuikit.com/docs/toggle.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Toggle extends Widget
{
    /**
     * @var array list of items in toggle widget. Each array element represents a single
     * item which can be an array with the following structure:
     *
     * - content: string, required, toggle panel content.
     * - hidden: bool, not required, specify if the item is hidden by default.
     * - itemOptions: array, optional, the HTML attributes of the panel's item (DIV).
     */
    public $items = [];

    /**
     * @var string the toggle button caption.
     */
    public $caption;
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        echo $this->renderToggleButton();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->renderItems();
        $this->registerAsset();
    }

    /**
     * Renders a toggle button.
     */
    public function renderToggleButton()
    {
        if (!isset($this->caption))
            throw new InvalidConfigException("Option 'caption' can't be empty!");

        // Nav options
        $this->options = array_merge([
                'data-uk-toggle' => "{target:'.{$this->options['id']}'}",
            ], $this->options);

        return Button::widget([
            'options' => $this->options,
            ]);
    }

    /**
     * Render items.
     */
    public function renderItems()
    {
        if (count($this->items) > 2)
            throw new InvalidConfigException("There can not be specified more than two items!");

        foreach ($this->items as $i => $item) {
            
            if (!isset($item['content']))
                throw new InvalidConfigException("Option 'content' can't be empty!");

            $itemOptions = isset($item['itemOptions']) ? $item['itemOptions'] : [];

            if (isset($item['hidden']) && ($item['hidden'] === true))
                    Html::addCssClass($itemOptions, 'uk-hidden');

            Html::addCssClass($itemOptions, $this->options['id']);

            echo Html::tag('div', $item['content'], $itemOptions) . "\n";
        }
    }

}
