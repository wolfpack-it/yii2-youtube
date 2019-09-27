# YouTube widget for Yii2

This extension provides a widget to show a YouTube player for Yii2 Framework.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require wolfpack-it/yii2-youtube
```

or add

```
"wolfpack-it/yii2-youtube": "^<latest version>"
```

to the `require` section of your `composer.json` file.

## Usage

```php
echo \WolfpackIT\youtube\widgets\YouTube::widget([
    'id' => 'yt-video-player',
    'videoId' => '<videoId>',
    'enableJsApi' => true,
    'jsEvents' => [
        'onStateChange' => new JsExpression('onStateChange'),
    ],
]);
```

## Full width or responseive video
If you want to have the video to be full width or responsive, check out the following link: https://avexdesigns.com/responsive-youtube-embed/.
 
## Credits
- [Joey Claessen](https://github.com/joester89)
- [Wolfpack IT](https://github.com/wolfpack-it)

## License

The MIT License (MIT). Please see [LICENSE](https://github.com/wolfpack-it/yii2-youtube/blob/master/LICENSE) for more information.