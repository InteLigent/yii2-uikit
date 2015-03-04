<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace intelligent\uikit;

use Yii;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

/**
 * A UIkit enhanced version of [[\yii\widgets\ActiveForm]].
 *
 * This class mainly adds the [[layout]] property to choose a UIkit form layout.
 * So for example to render a horizontal form you would:
 *
 * ```php
 * use intelligent\uikit\ActiveForm;
 *
 * $form = ActiveForm::begin(['layout' => 'horizontal'])
 * ```
 *
 * This will set default values for the [[yii\bootstrap\ActiveField|ActiveField]]
 * to render horizontal form fields. In particular the [[yii\bootstrap\ActiveField::template|template]]
 * is set to `{label} {beginWrapper} {input} {error} {endWrapper} {hint}` and the
 * [[yii\bootstrap\ActiveField::horizontalCssClasses|horizontalCssClasses]] are set to:
 *
 * ```php
 * [
 *     'offset' => 'col-sm-offset-3',
 *     'label' => 'col-sm-3',
 *     'wrapper' => 'col-sm-6',
 *     'error' => '',
 *     'hint' => 'col-sm-3',
 * ]
 * ```
 *
 * To get a different column layout in horizontal mode you can modify those options
 * through [[fieldConfig]]:
 *
 * ```php
 * $form = ActiveForm::begin([
 *     'layout' => 'horizontal',
 *     'fieldConfig' => [
 *         'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
 *         'horizontalCssClasses' => [
 *             'label' => 'col-sm-4',
 *             'offset' => 'col-sm-offset-4',
 *             'wrapper' => 'col-sm-8',
 *             'error' => '',
 *             'hint' => '',
 *         ],
 *     ],
 * ]);
 * ```
 *
 * @see \intelligent\uikit\ActiveField for details on the [[fieldConfig]] options
 * @see http://getuikit.com/docs/form.html
 *
 * @author Demchenko Vjacheslav <word2electronics@gmail.com>
 * @since 2.0
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    /**
     * @var array HTML attributes for the form tag. Default is `['class' => 'uk-form']`.
     */
    public $options = ['class' => 'uk-form'];

    public $fieldClass = 'intelligent\uikit\ActiveField';

    /**
     * @var string the form layout. Either 'default', 'horizontal' or 'stacked'.
     */
    public $layout = 'default';

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!in_array($this->layout, ['default', 'horizontal', 'stacked'])) {
            throw new InvalidConfigException('Invalid layout type: ' . $this->layout);
        }

        Html::addCssClass($this->options, 'uk-form');

        if ($this->layout !== 'default') {
            Html::addCssClass($this->options, 'uk-form-' . $this->layout);

            if ($this->layout == 'horizontal') {
                $this->fieldConfig['template'] = "{label}\n<div class=\"uk-form-controls\">{input}\n{error}\n{hint}\n</div>\n";
            }
            else {
                $this->fieldConfig['template'] = "{label}\n<div class=\"uk-form-controls\">{input}\n{error}\n{hint}\n</div>\n";
            }
        }

        if (!isset($this->fieldConfig['labelOptions'])) {
            $this->fieldConfig['labelOptions'] = ['class' => 'uk-form-label'];
        }

        if (!isset($this->fieldConfig['options'])) {
            $this->fieldConfig['options'] = ['class' => 'uk-form-row'];
        }

        if (!isset($this->fieldConfig['errorOptions'])) {
            $this->fieldConfig['errorOptions'] = ['class' => 'uk-form-help-block'];
        }

        if (!isset($this->fieldConfig['inputOptions'])) {
            $this->fieldConfig['inputOptions'] = ['class' => 'uk-form-large uk-width-1-1'];
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function errorSummary($models, $options = [])
    {
        Html::addCssClass($options, $this->errorSummaryCssClass);
        $options['encode'] = $this->encodeErrorSummary;

        $header = isset($options['header']) ? $options['header'] : '<p>' . Yii::t('yii', 'Please fix the following errors:') . '</p>';
        $footer = isset($options['footer']) ? $options['footer'] : '';
        $encode = !isset($options['encode']) || $options['encode'] !== false;
        unset($options['header'], $options['footer'], $options['encode']);

        $lines = [];
        if (!is_array($models)) {
            $models = [$models];
        }
        foreach ($models as $model) {
            /* @var $model Model */
            foreach ($model->getFirstErrors() as $name => $error) {
                $lines[] = [
                    'error' => ($encode ? Html::encode($error) : $error),
                    'name'  => $name,
                    'model' => $model
                ];
            }
        }

        if (empty($lines)) {
            // still render the placeholder for client-side validation use
            $content = "<ul></ul>";
            $options['style'] = isset($options['style']) ? rtrim($options['style'], ';') . '; display:none' : 'display:none';
        } else {
            //$content = "<ul><li class=\"field-\">" . implode("</li>\n<li>", $lines) . "</li></ul>";
            $content = "<ul>" . implode("\n", array_map(function($line) {
                return Html::tag('li', $line['error'], ['class' => 'field-' . Html::getInputId($line['model'], $line['name'])]);
            }, $lines)) . "</ul>";
        }
        return Html::tag('div', $header . $content . $footer, $options);

        //return Html::errorSummary($models, $options);
    }
}
