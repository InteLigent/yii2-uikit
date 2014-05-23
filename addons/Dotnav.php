<?php
namespace demogorgorn\uikit\addons;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Dotnav widget is used to create a dot navigation with a horizontal or vertical layout to navigate through slideshows or to scroll to different page sections.
 *
 * For example:
 *
 * ```php
 * echo Dotnav::widget([
 *     'items' => [
 *         'Text item',
 *         [
 *             'label' => 'Home',
 *             'url' => '#',
 *             'options' => 'someclass...',
 *         ],
 *         [
 *             'label' => 'Another link',
 *             'url' => '#',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see http://www.getuikit.com/docs/addons_dotnav.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Dotnav extends \demogorgorn\uikit\Widget
{
    /**
     * @var array list of items in the dotnav widget. Each array element represents a single
     * item which can be either a string or an array with the following structure:
     *
     * - label: string, required, label of the item.
     * - url: string, optional, link of the item.
     * - options: array, optional, list of LI item's options
     */
    public $items = [];
    
    /**
     * @var bool align items vertically.
     */
    public $isVertical = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-dotnav');

        if ($this->isVertical)
            Html::addCssClass($this->options, 'uk-dotnav-vertical');

    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems();
        $this->registerAsset();
        UIkitAddonsAsset::register($this->getView());
    }

    /**
     * Renders widget items.
     */
    public function renderItems()
    {
        $items = [];
        foreach ($this->items as $i => $item) {
            $items[] = $this->renderItem($item);
        }

        return Html::tag('ul', implode("\n", $items), $this->options);
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return Html::tag('li', $item, []);
        }

        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }

        $body = Html::a($item['label'], $item['url'], []);
        $options = ArrayHelper::getValue($item, 'options', []);
        
        return Html::tag('li', $body, $options);
    }
}
