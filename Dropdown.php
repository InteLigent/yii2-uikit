<?php
namespace intelligent\uikit;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use intelligent\uikit\Icon;

/**
 * Dropdown renders a UIkit dropdown menu component.
 *
 * ```php
 * use intelligent\uikit\Dropdown;
 * use intelligent\uikit\Nav;
 *
 * Dropdown::begin([
 *  'tagOptions' => ['class' => 'uk-button-dropdown'],
 *  'toggleButton' => ['label' => 'Action'],
 *  'items' => []
 * ]);
*   echo Nav::widget([
 *     'options' => ['class' => 'uk-nav-dropdown'],
 *     'items' => [
 *         [
 *             'label' => 'Home',
 *             'url' => ['site/index'],
 *             'linkOptions' => [...],
 *         ],
 *         [
 *             'label' => 'Dropdown',
 *             'items' => [
 *                  ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
 *                  '<li class="divider"></li>',
 *                  '<li class="dropdown-header">Dropdown Header</li>',
 *                  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *             ],
 *         ],
 *     ],
 * ]);
 * Dropdown::end();
 * ```
 *
 * Dropdown button example:
 * ```php
 *   echo Dropdown::widget([
 *               'tagOptions' => ['class' => 'uk-button-dropdown'],
 *               'toggleButton' => ['label' => 'Action', 'tag' => 'button'],
 *               'items' => [
 *                  ['label' => 'Level 1 - Dropdown A', 'url' => '#'],
 *                  '<li class="uk-nav-divider"></li>',
 *                  '<li class="uk-nav-header">Dropdown Header</li>',
 *                  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *             ],
 *         ]);
 * ```
 *
 * @see http://www.getuikit.com/docs/dropdown.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @author Nikolay Kostyurin <nikolay@artkost.ru>
 * @since 2.0
 */
class Dropdown extends Widget
{
    /**
     * @var array list of menu items in the dropdown. Each array element can be either an HTML string,
     * or an array representing a single menu with the following structure:
     *
     * - label: string, required, the label of the item link
     * - url: string, optional, the url of the item link. Defaults to "#".
     * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     *
     * To insert divider use `<li role="presentation" class="divider"></li>`.
     */
    public $items = [];

    public $itemsOptions = [];

    public $toggleButton = [];

    /**
     * Container tag name, by default it can be div
     * @var string
     */
    public $tag = 'div';

    public $tagOptions = [];

    public $navbar = false;

    public $showCaret = true;

    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        parent::init();
        Html::addCssClass($this->options, 'uk-dropdown');

        $this->tagOptions['data-uk-dropdown'] = $this->jsonClientOptions();

        if ($this->navbar) {
            Html::addCssClass($this->options, 'uk-dropdown-navbar');
        }
        else {
            if ($this->toggleButton !== null)
                Html::addCssClass($this->tagOptions, 'uk-button-dropdown');

            if ($this->tag)
                echo Html::beginTag($this->tag, $this->tagOptions) . "\n";

            echo $this->renderToggleButton() . "\n";
        }

        echo Html::beginTag('div', $this->options);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo $this->renderItems($this->items);
        echo Html::endTag('div');

        if (!$this->navbar && $this->tag) {
            echo Html::endTag($this->tag);
        }

        $this->registerAsset();
    }

    /**
     * Renders the toggle button.
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        if ($this->toggleButton !== null) {
            $tag        = ArrayHelper::remove($this->toggleButton, 'tag', 'a');
            $label      = ArrayHelper::remove($this->toggleButton, 'label', 'Show');
            $alignCaret = ArrayHelper::remove($this->toggleButton, 'alignCaret');

            if ($this->showCaret) {
                if ($alignCaret == 'right') {
                    $label =
                        Html::tag('div', $label, ['class' => 'uk-float-left'])
                        .
                        Html::tag('div', Icon::widget(['name' => 'caret-down']), ['class' => 'uk-float-right']);

                    Html::addCssClass($this->toggleButton, 'uk-clearfix');
                }
                else
                    $label .= ' ' . Icon::widget(['name' => 'caret-down']);
            }

            if ($tag === 'button' && !isset($this->toggleButton['type'])) {
                $this->toggleButton['type'] = 'button';
                $this->toggleButton['class'] = 'uk-button';
            }

            if ($tag === 'a' && !isset($this->toggleButton['href'])) {
                $this->toggleButton['href'] = '#' . $this->options['id'];
            }

            return Html::tag($tag, $label, $this->toggleButton);
        } else {
            return null;
        }
    }

    /**
     * Renders menu items.
     * @param array $items the menu items to be rendered
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items)
    {
        if ($this->tag && !$this->navbar) {
            Html::addCssClass($this->itemsOptions, 'uk-nav-dropdown');
        }

        if (is_array($items)) {
            $encodeLabels = ArrayHelper::remove($this->itemsOptions, 'encodeLabels');

            $options = [
                'encodeSpaces'  => ArrayHelper::remove($this->itemsOptions, 'encodeSpaces', false),
                'activateItems' => ArrayHelper::remove($this->itemsOptions, 'activateItems', true),
                'options'       => $this->itemsOptions,
                'items'         => $items
            ];

            if (!is_null($encodeLabels))
                $options['encodeLabels'] = $encodeLabels;

            if ($this->navbar) {
                $options['encodeLabels'] = false;
            }

            return Nav::widget($options);
        }

        return $items;
    }
}
