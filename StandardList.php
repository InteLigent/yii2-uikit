<?php
namespace demogorgorn\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * StandardList renders a List UIKit component, a nicely looking list, which come in different styles.
 *
 * For example:
 *
 * ```php
 * echo StandardList::widget([
 *     'items' => [
 *         [
 *             'body' => 'Home',
 *             'options' => [ 'class' => '...' ],
 *         ],
 *         [
 *             'body' => '<b>Text</b>',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see http://www.getuikit.com/docs/list.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class StandardList extends Widget
{
    /**
     * @var array list of items in the list widget. Each array element represents a single
     * item which can be either a string or an array with the following structure:
     *
     * - body: string, required, the list item. It can contain everything.
     * - options: array, optional, the HTML attributes of the item container (LI).
     */
    public $items = [];
    
    /**
     * @var bool add the .uk-list-line class to separate list items with lines.
     */
    public $addLine = false;

    /**
     * @var bool add zebra-striping to a list using the .uk-list-striped class.
     */
    public $isStriped = false;

    /**
     * @var bool add the .uk-list-space class to increase the spacing between list items.
     */
    public $addSpace = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-list');

        if ($this->addLine)
            Html::addCssClass($this->options, 'uk-list-line');

        if ($this->isStriped)
            Html::addCssClass($this->options, 'uk-list-striped');

        if ($this->addSpace)
            Html::addCssClass($this->options, 'uk-list-space');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems();
        $this->registerAsset();
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

        if (!isset($item['body'])) {
            throw new InvalidConfigException("The 'body' option is required.");
        }

        $body = $item['body'];
        $options = ArrayHelper::getValue($item, 'options', []);
        
        return Html::tag('li', $body, $options);
    }
}
