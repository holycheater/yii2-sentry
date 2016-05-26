Yii2 Sentry error handler
=========================

Config
-----
```php
'components' => [
    'sentry' => [
        'class' => 'alexsalt\sentry\Client',
        'dsn' => '<your_dsn_url>',
        'options' => [
            'exclude' => [
                'yii\\web\\NotFoundHttpException',
                'yii\\web\\ForbiddenHttpException',
                'yii\\web\\UnauthorizedHttpException',
                'yii\\base\\InvalidRouteException',
            ],
        ],
    ],
    'errorHandler' => [
        'class' => 'alexsalt\sentry\ConsoleErrorHandler',
    ],
    'log' => [
        'targets' => [
            [
                'class' => 'alexsalt\\sentry\\LogTarget',
                'levels' => [ 'warning', 'error' ],
            ],
        ],
    ],
]
```
Use `alexsalt\sentry\WebErrorHandler` for web apps

Logging
-------
```php
// basic
Yii::error('message');
// extra data
Yii::error([
    'msg' => 'message name',
    'data' => [
        'foo' => 'bar',
    ],
]);
// capture exception
try {
    throw new \Exception('test');
} catch (\Exception $e) {
    Yii::$app->errorHandler->logException($e);
}
```
