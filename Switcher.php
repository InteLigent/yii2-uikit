<?php
namespace intelligent\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use intelligent\uikit\SubNav;

/**
 * Switcher renders a Switcher UIKit component, Dynamically transition through different content panes.
 *
 * For example SubNav mode:
 *
 * ```php
 * echo Switcher::widget([
 *           'navOptions' => [
 *               'class' => 'uk-subnav-pill',
 *           ],
 *           'items' => [
 *               [
 *                   'label' => 'Tab1',
 *                   'content' => 'Big text is written here!',
 *                   'itemOptions' => [
 *                       'class' => 'uk-animation-fade',
 *                   ],
 *               ],
 *               [
 *                   'label' => 'Tab2',
 *                   'content' => 'Hello',
 *                   'itemOptions' => [
 *                       'class' => 'uk-animation-slide-left',
 *                   ],
 *               ],
 *               [
 *                   'label' => 'Tab3',
 *                   'content' => 'Lorem ipsum...',
 *               ],
 *           ],
 *
 *       ]);
 * ```
 *
 * Please note the 'options' array option is connected with panels part of widget.
 *
 * @see http://www.getuikit.com/docs/switcher.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Switcher extends Widget
{
    /**
     * @var array list of items in the description list widget. Each array element represents a single
     * item which can be an array with the following structure:
     *
     * - label: string, required, the title of the nav item.
     * - url: string, not required, nav required.
     * - content: string, required, panel content.
     * - itemOptions: array, optional, the HTML attributes of the panel's item (LI).
     */
    public $items = [];

    /**
     * @var bool to use SubNav or Tab component
     */
    public $useSubNav = true;

    /**
     * @var array the HTML attributes of the nav bar
     */
    public $navOptions = [];
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();
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
     * Renders a Nav bar.
     */
    public function renderItems()
    {
        $navItems = [];
        $panelItems = [];

        foreach ($this->items as $i => $item) {
            
            if (!isset($item['label']))
                throw new InvalidConfigException("Option 'content' can't be empty!");

            $label = $item['label'];

            $url = isset($item['url']) ? $item['url'] : '#';
                

            $navItems[] = [
                'label' => $label,
                'url' => $url,
            ];

            if (!isset($item['content']))
                throw new InvalidConfigException("Option 'content' can't be empty!");

            $panelItems[] = Html::tag('li', $item['content'], isset($item['itemOptions']) ? $item['itemOptions'] : []);

        }

        echo $this->renderNav($navItems);
        echo $this->renderPanels($panelItems);
    }

    /**
     * Renders Nav.
     */
    public function renderNav($navItems)
    {
        return SubNav::widget([
               'items' => $navItems,
               'options' => $this->navOptions,
          ]);
    }

    /**
     * Renders Content.
     */
    public function renderPanels($panelItems)
    {
        return Html::tag('ul', implode("\n", $panelItems), $this->options);
    }

     /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        // Panels options
        Html::addCssClass($this->options, 'uk-switcher');

        $this->navOptions['data-uk-switcher'] = \yii\helpers\Json::encode(['connect' => '#' . $this->options['id'] ]);
    }

}
