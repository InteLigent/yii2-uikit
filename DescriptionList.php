<?php
namespace intelligent\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * DescriptionList renders a Description list UIKit component, a nicely looking description list, which comes in different styles.
 *
 * For example:
 *
 * ```php
 * echo DescriptionList::widget([
 *     'isHorizontal' => true,
 *     'items' => [
 *         [
 *             'term' => 'Home',
 *             'description' => 'Some text',
 *         ],
 *         [
 *             'term' => 'Lorem ipsum',
 *             'description' => 'Dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see http://www.getuikit.com/docs/description-list.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class DescriptionList extends Widget
{
    /**
     * @var array list of items in the description list widget. Each array element represents a single
     * item which can be an array with the following structure:
     *
     * - term: string, required, the title of the item. It can contain everything.
     * - description: string, required, the list's description. It can contain everything.
     * - termOptions: array, optional, the HTML attributes of the item's term (DT).
     * - descriptionOptions: array, optional, the HTML attributes of the item's description (DD). 
     */
    public $items = [];
    
    /**
     * @var bool display terms and descriptions side by side.
     */
    public $isHorizontal = false;

    /**
     * @var bool separate the description list items with lines.
     */
    public $addLine = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-description-list');

        if ($this->isHorizontal)
            Html::addCssClass($this->options, 'uk-description-list-horizontal');

        if ($this->addLine) {
            if ($this->isHorizontal)
                throw new InvalidConfigException("The options 'isHorizontal' and 'addLine' of the Description lists component are not combinable with each other.");

            Html::addCssClass($this->options, 'uk-description-list-line');
        }
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
            $items[] = $this->renderTermItem($item);
            $items[] = $this->renderDescriptionItem($item);
        }

        return Html::tag('dl', implode("\n", $items), $this->options);
    }

    /**
     * Renders a term item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderTermItem($item)
    {
        if (!isset($item['term'])) {
            throw new InvalidConfigException("The 'term' option is required.");
        }
       
        $term = $item['term'];
        $termOptions = ArrayHelper::getValue($item, 'termOptions', []);
        
        return Html::tag('dt', $term, $termOptions);
    }

    /**
     * Renders a description item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderDescriptionItem($item)
    {
        if (!isset($item['description'])) {
            throw new InvalidConfigException("The 'description' option is required.");
        }
       
        $description = $item['description'];
        $descriptionOptions = ArrayHelper::getValue($item, 'descriptionOptions', []);
        
        return Html::tag('dd', $description, $descriptionOptions);
    }
}
