<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * ~~~php
 * use demogorgorn\uikit\Modal;
 *
 * Modal::begin([
 *     'toggleButton' => ['label' => 'click me'],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ~~~
 *
 * @see http://www.getuikit.com/docs/modal.html
 * @author Nikolay Kostyurin <nikolay@artkost.ru>
 * @since 2.0
 */
class Modal extends Widget
{

    /**
     * @var array the HTML attributes for the dialog container tag.
     */
    public $dialogOptions = [];

	/**
	 * @var array the options for rendering the close button tag.
	 * The close button is displayed in the header of the modal window. Clicking
	 * on the button will hide the modal window. If this is null, no close button will be rendered.
	 *
	 * The following special options are supported:
	 *
	 * - tag: string, the tag name of the button. Defaults to 'button'.
	 * - label: string, the label of the button. Defaults to '&times;'.
	 *
	 * The rest of the options will be rendered as the HTML attributes of the button tag.
	 * Please refer to the [Modal plugin help](http://www.getuikit.com/docs/modal.html)
	 * for the supported HTML attributes.
	 */
	public $closeButton = [];
	/**
	 * @var array the options for rendering the toggle button tag.
	 * The toggle button is used to toggle the visibility of the modal window.
	 * If this property is null, no toggle button will be rendered.
	 *
	 * The following special options are supported:
	 *
	 * - tag: string, the tag name of the button. Defaults to 'button'.
	 * - label: string, the label of the button. Defaults to 'Show'.
	 *
	 * The rest of the options will be rendered as the HTML attributes of the button tag.
	 * Please refer to the [Modal plugin help](http://www.getuikit.com/docs/modal.html)
	 * for the supported HTML attributes.
	 */
	public $toggleButton;


    /**
     * By default, the modal box has a padding. To avoid this and remove any framing set true
     * @var bool
     */
    public $frameless = false;

	/**
	 * Initializes the widget.
	 */
	public function init()
	{
		parent::init();

		$this->initOptions();

		echo $this->renderToggleButton() . "\n";
		echo Html::beginTag('div', $this->options) . "\n";
		echo Html::beginTag('div', $this->dialogOptions) . "\n";
        echo $this->renderCloseButton();
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{
		echo "\n" . Html::endTag('div'); // uk-modal-dialog
		echo "\n" . Html::endTag('div');
		$this->registerAsset();
	}

	/**
	 * Renders the toggle button.
	 * @return string the rendering result
	 */
	protected function renderToggleButton()
	{
		if ($this->toggleButton !== null) {
			$tag = ArrayHelper::remove($this->toggleButton, 'tag', 'a');
			$label = ArrayHelper::remove($this->toggleButton, 'label', 'Show');

			if ($tag === 'button' && !isset($this->toggleButton['type'])) {
				$this->toggleButton['type'] = 'button';
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
	 * Renders the close button.
	 * @return string the rendering result
	 */
	protected function renderCloseButton()
	{
		if ($this->closeButton !== null) {
			$tag = ArrayHelper::remove($this->closeButton, 'tag', 'a');
			$label = ArrayHelper::remove($this->closeButton, 'label', '');

			if ($tag === 'button' && !isset($this->closeButton['type'])) {
				$this->closeButton['type'] = 'button';
			}

            if ($tag === 'a' && !isset($this->closeButton['href'])) {
                $this->closeButton['href'] = '';
            }

			return Html::tag($tag, $label, $this->closeButton);
		} else {
			return null;
		}
	}

	/**
	 * Initializes the widget options.
	 * This method sets the default values for various options.
	 */
	protected function initOptions()
	{
		$this->options = array_merge([
			'role' => 'dialog',
			'tabindex' => -1,
		], $this->options);

        Html::addCssClass($this->options, 'uk-modal');
		Html::addCssClass($this->dialogOptions, 'uk-modal-dialog');

        if ($this->frameless) {
            Html::addCssClass($this->dialogOptions, 'uk-modal-dialog-frameless');
        }

		if ($this->closeButton !== null) {
			$this->closeButton = array_merge([
				'class' => 'uk-modal-close uk-close',
			], $this->closeButton);

            if ($this->frameless) {
                Html::addCssClass($this->closeButton, 'uk-close-alt');
            }
		}

		if ($this->toggleButton !== null) {

            if (!isset($this->toggleButton['href'])) {
                $this->clientOptions['target'] = '#' . $this->options['id'];
            }

			$this->toggleButton = array_merge([
				'data-uk-modal' => $this->clientOptions ? $this->jsonClientOptions() : true,
			], $this->toggleButton);
		}
	}
}
