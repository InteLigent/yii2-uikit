<?php
namespace intelligent\uikit;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

/**
 * Create an image overlay, which comes in different styles.
 *
 * Thumb mode example:
 *
 * ```php
 * echo Overlay::widget([
 *   'image' => Yii::$app->request->getBaseUrl() . '/theme/logo.png',
 *   'overlayContent' => 'Oleg',
 *   'tagName' => 'a',
 *   //'options' => ['href' => '#'], // overlay options
 *   'enableCaptionMode' => false,
 *   'enableThumbMode' => true,
 *   'thumbOptions' => [
 *     'url' => '#',
 *     ],
 *   ]);
 * ```
 * Please note, that in thumb mode the defined in tagName option tag will be replaced by 'div'.
 * Also, if you want to specify an url for thumb - define the thumbOptions and url option especially.
 *
 * Non-thumb mode:
 *
 * ```php
 * echo Overlay::widget([
 *   'image' => Yii::$app->request->getBaseUrl() . '/theme/logo.png',
 *   'overlayContent' => 'Oleg',
 *   'tagName' => 'a',
 *   'options' => ['href' => '#', 'class' => 'someclass'],
 *   'enableCaptionMode' => false,
 *   ]);
 * ```
 *
 * Feel free to use anything (e.g. another widget) in the overlayContent.
 *
 * @see http://www.getuikit.com/docs/overlay.html
 * @author Oleg Martemjanov <demogorgorn@gmail.com>
 * @since 2.0
 */
class Overlay extends Widget
{

    /**
     * @var string the tag to be used. an <a> or <div> element.
     * Note that the 'div' tag will be used instead of defined if the Thumb mode is enabled.
     */
    public $tagName = 'a';

    /**
     * @var bool determines to use the full overlay or partial caption mode.
     */
    public $enableCaptionMode = false;

    /**
     * @var string overlay content.
     */
    public $overlayContent;

    /**
     * @var string image url.
     */
    public $image;

    /**
     * @var bool enable thumb mode.
     */
    public $enableThumbMode = false;

    /**
     * @var bool, optional, array of thumb options.
     * - url: string, the link for the thumb. 
     *
     * The rest of the options will be rendered as the HTML attributes of the 'a' tag.
     */
    public $thumbOptions = [];


    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if ($this->enableThumbMode) {

            Html::addCssClass($this->thumbOptions, 'uk-thumbnail');

            if (isset($this->thumbOptions['url'])) {
                $url = ArrayHelper::remove($this->thumbOptions, 'url', '');

                $this->thumbOptions = array_merge([
                    'href' => $url,
                    ], $this->thumbOptions);
            }

            echo Html::beginTag('a', $this->thumbOptions);
        }


        Html::addCssClass($this->options, 'uk-overlay');

        echo Html::beginTag($this->enableThumbMode ? 'div' : $this->tagName, $this->options) . "\n";
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo "\n" . $this->renderImage();
        echo "\n" . $this->renderOverlayContent();
        echo "\n" . Html::endTag($this->enableThumbMode ? 'div' : $this->tagName);
        
        if ($this->enableThumbMode)
            echo Html::endTag('a');

        $this->registerAsset();
    }

    /**
     * Renders the image.
     */
    protected function renderImage()
    {
        if ($this->image == null)
            throw new InvalidConfigException("Option 'image' can't be empty!");

        return Html::img($this->image, []);
    }

    /**
     * Renders the overlay.
     */
    protected function renderOverlayContent()
    {
        $class = $this->enableCaptionMode ? 'uk-overlay-caption' : 'uk-overlay-area-content';

        $overlay = Html::tag('div', $this->overlayContent, ['class' => $class]);

        if ($this->enableCaptionMode)
            return $overlay;
        
        return Html::tag('div', $overlay, ['class' => 'uk-overlay-area']);
    }

}
