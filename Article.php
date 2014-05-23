<?php
namespace demogorgorn\uikit;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Article renders an article component.
 *
 * For example,
 *
 * ```php
 * echo Article::widget([
 *     'options' => [
 *         'class' => 'uk-panel uk-panel-box',
 *     ],
 *     'body' => '<p>Say hello...</p>',
 * ]);
 * ```
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the alert box:
 *
 * ```php
 * Article::begin([
 *     'title' => 'First Article',
 *     'meta' => '09 May 2014',
 *     'lead' => 'This is my first article',
 *     'options' => ['class' => 'uk-panel uk-panel-box']
 * ]);
 *
 * echo '<p>Say hello...</p>';
 *
 * Article::end();
 * ```
 *
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 *
 */
class Article extends Widget
{
   
    
    /**
     * @var string the title of the article.
     */
    public $title;

    /**
     * @var string the meta data of the article.
     */
    public $meta;

    /**
     * @var string the lead of the article.
     */
    public $lead;

    /**
     * @var string the body content in the article component. Note that anything between
     * the [[begin()]] and [[end()]] calls of the Article widget will also be treated
     * as the body content, and will be rendered before this.
     */
    public $body;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->initOptions();

        echo Html::beginTag('article', $this->options) . "\n";
        echo $this->renderTitle() . "\n";
        echo $this->renderMeta() . "\n";
        echo $this->renderLead() . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderBody();
        echo "\n" . Html::endTag('article');

        $this->registerAsset();
    }

    /**
     * Renders the title of the article.
     * @return string the rendering result
     */
    protected function renderTitle()
    {
        if ($this->title !== null) {
            return Html::tag('h1', $this->title, ['class' => 'uk-article-title']);
        } else {
            return null;
        }
    }

    /**
     * Renders the meta data.
     * @return string the rendering result
     */
    protected function renderMeta()
    {
        if ($this->meta !== null) {
            return Html::tag('p', $this->meta, ['class' => 'uk-article-meta']);
        } else {
            return null;
        }
    }

    /**
     * Renders the lead data.
     * @return string the rendering result
     */
    protected function renderLead()
    {
        if ($this->lead !== null) {
            return Html::tag('p', $this->lead, ['class' => 'uk-article-lead']);
        } else {
            return null;
        }
    }

    /**
     * Renders the article body (if any).
     * @return string the rendering result
     */
    protected function renderBody()
    {
        return $this->body . "\n";
    }

    /**
     * Initializes the widget options.
     * This method sets the default values for various options.
     */
    protected function initOptions()
    {
        Html::addCssClass($this->options, 'uk-article');
    }
}
