<?php
namespace demogorgorn\uikit;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * ButtonGroup renders an UIKit component, which groups buttons.
 *
 * For example:
 *
 * ```php
 * <?php ButtonGroup::begin([
 *    'options' => ['class' => 'uk-margin-top'],
 * ]); ?>
 *      <?= Html::a('Южная Америка', \yii\helpers\Url::toRoute(['country/mainland', 'alias' => 'south-america']), ['class' => 'uk-button uk-button-primary'] ) ?>
 *      <?= Html::a('Африка', \yii\helpers\Url::toRoute(['country/mainland', 'alias' => 'africa']), ['class' => 'uk-button uk-button-primary'] ) ?>
 *      <?= Html::a('Австралия', \yii\helpers\Url::toRoute(['country/mainland', 'alias' => 'australia']), ['class' => 'uk-button uk-button-primary'] ) ?>
 * <?php ButtonGroup::end(); ?>
 * ```
 *
 * @see http://www.getuikit.com/docs/button.html
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class ButtonGroup extends Widget
{
    /**
     * @var bool toggle between a group of buttons like a checkbox.
     */
    public $checkboxButtons = false;

    /**
     * @var bool toggle between a group of buttons, like radio buttons.
     */
    public $radioButtons = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-button-group');

        if ($this->checkboxButtons)
            $this->options = array_merge(['data-uk-button-checkbox' => ''], $this->options);

        if ($this->radioButtons)
            if ($this->checkboxButtons)
                throw new InvalidConfigException("Options 'checkboxButtons' and 'radioButtons' cannot be used at the same time.");
            else
                $this->options = array_merge(['data-uk-button-radio' => ''], $this->options);

        echo Html::beginTag('div', $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::endTag('div');
        $this->registerAsset();
    }

  
}
