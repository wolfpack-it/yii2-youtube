<?php

namespace WolfpackIT\youtube\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

/**
 * Class YouTube
 * @package WolfpackIT\youtube\widgets
 */
class YouTube extends Widget
{
    /**
     * @var string
     */
    public $baseUrl = 'https://www.youtube.com/embed/';

    /**
     * Default options in a property so they can be overriden by DI
     * @var array
     */
    public $defaultOptions = [
        'allow' => 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture',
        'allowfullscreen' => true,
        'frameborder' => 0,
    ];

    /**
     * @var bool
     */
    public $enableJsApi = false;

    /**
     * Javascript events, required js api to be enabled
     * @var array
     */
    public $jsEvents = [];

    /**
     * @var string
     */
    public $listId;

    /**
     * @var array
     */
    public $options = [];

    /**
     * @var string
     */
    public $videoId;

    public function init()
    {
        if (
            (!isset($this->listId) && !isset($this->videoId))
            || (isset($this->listId) && isset($this->videoId))
        ) {
            throw new InvalidConfigException('listId OR videoId must be set.');
        }

        $this->options = ArrayHelper::merge(
            $this->defaultOptions,
            $this->options
        );

        $this->options['id'] = $this->id;
        Html::addCssClass($this->options, 'youtube');

        parent::init();
    }

    public function run(): void
    {
        parent::run();

        $tag = ArrayHelper::remove($this->options, 'tag', 'iframe');
        $url = $this->baseUrl
            . (isset($this->videoId) ? $this->videoId : ('/videoseries?list=' . $this->listId));

        if($this->enableJsApi) {
            $url .= strpos($url, '?') === false ? '?enablejsapi=1' : '&enablejsapi=1';
        }

        $options = ArrayHelper::merge(
            $this->options,
            [
                'src' => $url,
            ]
        );

        echo Html::tag($tag, '', $options);
        $this->registerJs();
    }

    protected function registerJs(): void
    {
        if ($this->enableJsApi) {
            $this->view->registerJsFile('https://www.youtube.com/iframe_api', [], self::class . '.jsApi');
            if(!empty($this->jsEvents)) {
                $events = Json::encode($this->jsEvents);
                $this->view->registerJs(<<<JS
function onYouTubeIframeAPIReady() {
    const player = new YT.Player('yt-video-player', {
        events: {$events}
    });
    
    $('#{$this->id}').data('player', player);
  }
JS
                    , View::POS_END);
            }
        }
    }
}