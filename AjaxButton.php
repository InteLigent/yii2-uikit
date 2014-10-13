<?php
namespace intelligent\uikit;

use intelligent\uikit\Button;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * AjaxButton renders an ajax button in UIKit stylу and is very similar to ajaxSubmitButton from Yii1.
 *
 * Example:
 *
 * ```php
 * <?= Html::beginForm(); ?>
 * <?= Select2::widget([
 *       'name' => 'country_code',
 *       'data' => Country::getAllCountries(),
 *       'options' => [
 *           'id' => 'country_select',
 *           'multiple' => false, 
 *           'placeholder' => 'Select country...',
 *           'class' => 'uk-width-medium-7-10'
 *       ]
 *   ]);?>
 *
 * <?php AjaxButton::begin([
 *       'label'=>'Проверить',
 *       'ajaxOptions'=>
 *           [
 *               'type'=>'POST',
 *               'url'=>'country/getinfo',
 *               'cache' => false,
 *               'success' => new \yii\web\JsExpression('function(html){
 *                   $("#output").html(html);
 *               }'),
 *           ],
 *           'options' => ['type' => 'submit'],
 *       ]);
 *  AjaxButton::end();?>
 *
 * <?= Html::endForm(); ?>
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */

class AjaxButton extends Button
{
    public $ajaxOptions = [];

    public function run()
    {
    	parent::run();
        
        if (!empty($this->ajaxOptions))
            $this->registerAjaxScript();
    }

    protected function registerAjaxScript()
    {
        $view = $this->getView();

        if(!isset($this->ajaxOptions['data']) && isset($this->ajaxOptions['type']))
            $this->ajaxOptions['data'] = new \yii\web\JsExpression('$(this).parents("form").serialize()');

        $this->ajaxOptions= Json::encode($this->ajaxOptions);
        $view->registerJs("$( '#".$this->options['id']."' ).click(function() {
                $.ajax(". $this->ajaxOptions ."); 
                return false;
            });");
    }

} 
