<?php
namespace demogorgorn\uikit;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Create different thumbnail images, which come in various styles and sizes.
 *
 * Thumb mode example:
 *
 * ```php
 * echo Thumbnail::widget([
 *   'image' => Yii::$app->request->getBaseUrl() . '/theme/logo.png',
 *   'caption' => 'Oleg',
 *   'tagName' => 'a',
 *   'url' => '#',
 *   ]);
 * ```
 * Please note, that if you define 'url' automatically will be used the 'a' tag instead of defined.
 * The'div' tag will be used instead of 'img' if the caption is set. 'div'.
 *
 * @see http://www.getuikit.com/docs/thumbnail.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Thumbnail extends Widget
{
    /**
     * @var string the tag to be used. an <a>, <div>, <img> or <figure> element.
     * Note that the 'div' tag ('a' is url is set) will be used instead of 'img' if the caption is set.
     */
    public $tagName = 'div';

    /**
     * @var string image url.
     */
    public $image;

    /**
     * @var string url.
     */
    public $url;

    /**
     * @var string caption.
     */
    public $caption;

    /**
     * Defines to use single img tag or other.
     */
    private $mixMode = false;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, 'uk-thumbnail');

        if ($this->tagName !== 'img' || isset($this->caption))
            $this->mixMode = true;

        if (isset($this->url)) {
            $this->options = array_merge([
                    'href' => $this->url,
                    ], $this->options);

            $this->tagName = 'a';

            $this->mixMode = true;
        }

        if ($this->mixMode)
            echo Html::beginTag($this->tagName, $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderImage();
        
        if ($this->mixMode) {
            echo "\n" . $this->renderCaption();
            echo "\n" . Html::endTag($this->tagName);
        }

        $this->registerAsset();
    }

    /**
     * Renders the image.
     */
    protected function renderImage()
    {
        if ($this->image == null)
            throw new InvalidConfigException("Option 'image' can't be empty!");

        return Html::img($this->image, $this->mixMode ? [] : $this->options);
    }

    /**
     * Renders the caption.
     */
    protected function renderCaption()
    {
        if (isset($this->caption))
            return Html::tag('div', $this->caption, ['class' => 'uk-thumbnail-caption']);
    }

}
