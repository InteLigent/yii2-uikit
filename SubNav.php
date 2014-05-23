<?php
namespace demogorgorn\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

use demogorgorn\uikit\Nav;

/**
 * SubNav renders a subnav UIKit component.
 *
 * For example:
 *
 * ```php
 * echo \demogorgorn\uikit\SubNav::widget([
 * 		'showLine' => true,
 *		'items' => [
 *			[
 *			    'label' => 'Home',
 *				'url' => ['site/index'],	             
 *		    ],
 *			[
 *			    'label' => 'Dropdown',
 *			    'url' => ['site/about'],
 *			],
 *			[
 *			    'label' => 'Dropdown',
 *			    'url' => '#',
 *			    'items' => [
 *					['label' => 'Level 1 - Dropdown A', 'url' => '#'],
 *					'<li class="uk-nav-divider"></li>',
 *					'<li class="uk-nav-header">Dropdown Header</li>',
 *					['label' => 'Level 1 - Dropdown B', 'url' => '#'],
 *				],
 *			],
 *		],
 * ]);
 * ```
 *
 * @see http://www.getuikit.com/docs/subnav.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class SubNav extends Widget
{
	/**
	 * @var array list of items in the nav widget. Each array element represents a single
	 * menu item which can be either a string or an array with the following structure:
	 *
	 * - label: string, required, the nav item label.
	 * - url: optional, the item's URL. Defaults to "#".
	 * - visible: boolean, optional, whether this menu item is visible. Defaults to true.
	 * - linkOptions: array, optional, the HTML attributes of the item's link.
	 * - options: array, optional, the HTML attributes of the item container (LI).
	 * - active: boolean, optional, whether the item should be on active state or not.
	 * - items: array|string, optional, the configuration array for creating a [[Dropdown]] widget,
	 *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
	 *
	 * If a menu item is a string, it will be rendered directly without HTML encoding.
	 */
	public $items = [];
	/**
	 * @var boolean whether the nav items labels should be HTML-encoded.
	 */
	public $encodeLabels = true;
	/**
	 * @var boolean whether to automatically activate items according to whether their route setting
	 * matches the currently requested route.
	 * @see isItemActive
	 */
	public $activateItems = true;
	/**
	 * @var string the route used to determine if a menu item is active or not.
	 * If not set, it will use the route of the current request.
	 * @see params
	 * @see isItemActive
	 */
	public $route;
	/**
	 * @var array the parameters used to determine if a menu item is active or not.
	 * If not set, it will use `$_GET`.
	 * @see route
	 * @see isItemActive
	 */
	public $params;
	
	/**
	 * @var boolean highlight the active menu item with a background.
	 */
	public $showPills = false;

    /**
	 * @var boolean separate menu items with lines.
	 */
	public $showLine = false;

	/**
	 * @var boolean hover mode for dropdowns
	 */
	public $hoverMode = true;

   /**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		if ($this->route === null && Yii::$app->controller !== null) {
			$this->route = Yii::$app->controller->getRoute();
		}

		if ($this->params === null) {
			$this->params = $_GET;
		}

		Html::addCssClass($this->options, 'uk-subnav');

		if ($this->showPills)
			Html::addCssClass($this->options, 'uk-subnav-pill');

		if ($this->showLine)
			Html::addCssClass($this->options, 'uk-subnav-line');
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
			if (isset($item['visible']) && !$item['visible']) {
				unset($items[$i]);
				continue;
			}
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

		$label = $this->encodeLabels ? Html::encode($item['label']) : $item['label'];
		$options = ArrayHelper::getValue($item, 'options', []);
		$items = ArrayHelper::getValue($item, 'items');
		$url = ArrayHelper::getValue($item, 'url', false);
		$linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

		if (isset($item['active'])) {
			$active = ArrayHelper::remove($item, 'active', false);
		} else {
			$active = $this->isItemActive($item);
		}

		if ($active) {
			Html::addCssClass($options, 'uk-active');
		}

		if ($items !== null) {

			if (is_array($items)) {

                $options = array_merge([
		            'data-uk-dropdown' => $this->hoverMode ? '' : "{mode:'click'}",
		        ], $options);

                $items = Html::tag('div', 
                	Nav::widget([ 
                		'items' => $items, 
                		'options' => ['class' => 'uk-nav-dropdown'] 
                	]), 
                	[
                		'class' => 'uk-dropdown uk-dropdown-small'
                	]);
			}

		}

        $link = $label;

        if ($url) {
            $link = Html::a($label, $url, $linkOptions);
        }

        return Html::tag('li', $link . $items, $options);
	}


	/**
	 * Checks whether a menu item is active.
	 * This is done by checking if [[route]] and [[params]] match that specified in the `url` option of the menu item.
	 * When the `url` option of a menu item is specified in terms of an array, its first element is treated
	 * as the route for the item and the rest of the elements are the associated parameters.
	 * Only when its route and parameters match [[route]] and [[params]], respectively, will a menu item
	 * be considered active.
	 * @param array $item the menu item to be checked
	 * @return boolean whether the menu item is active
	 */
	protected function isItemActive($item)
	{
		if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {
			$route = $item['url'][0];
			if ($route[0] !== '/' && Yii::$app->controller) {
				$route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
			}
			if (ltrim($route, '/') !== $this->route) {
				return false;
			}
			unset($item['url']['#']);
			if (count($item['url']) > 1) {
				foreach (array_splice($item['url'], 1) as $name => $value) {
					if (!isset($this->params[$name]) || $this->params[$name] != $value) {
						return false;
					}
				}
			}
			return true;
		}
		return false;
	}
}
