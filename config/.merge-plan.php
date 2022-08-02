<?php

declare(strict_types=1);

// Do not edit. Content will be replaced.
return [
    '/' => [
        'common' => [
            'yiisoft/cache-file' => [
                'config/common.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/common.php',
            ],
            'yiisoft/yii-cycle' => [
                'config/common.php',
            ],
            'yiisoft/yii-queue' => [
                'config/common.php',
            ],
            'yiisoft/yii-debug' => [
                'config/common.php',
            ],
            'yiisoft/log-target-file' => [
                'config/common.php',
            ],
            'yiisoft/validator' => [
                'config/common.php',
            ],
            'yiisoft/router' => [
                'config/common.php',
            ],
            'yiisoft/profiler' => [
                'config/common.php',
            ],
            'yiisoft/yii-filesystem' => [
                'config/common.php',
            ],
            'yiisoft/aliases' => [
                'config/common.php',
            ],
            'yiisoft/yii-event' => [
                'config/common.php',
            ],
            'yiisoft/view' => [
                'config/common.php',
            ],
            'yiisoft/cache' => [
                'config/common.php',
            ],
            '/' => [
                'common/*.php',
            ],
        ],
        'params' => [
            'yiisoft/cache-file' => [
                'config/params.php',
            ],
            'yiisoft/router-fastroute' => [
                'config/params.php',
            ],
            'yiisoft/user' => [
                'config/params.php',
            ],
            'yiisoft/yii-cycle' => [
                'config/params.php',
            ],
            'yiisoft/yii-queue' => [
                'config/params.php',
            ],
            'yiisoft/yii-swagger' => [
                'config/params.php',
            ],
            'yiisoft/yii-debug' => [
                'config/params.php',
            ],
            'yiisoft/log-target-file' => [
                'config/params.php',
            ],
            'yiisoft/yii-console' => [
                'config/params.php',
            ],
            'yiisoft/assets' => [
                'config/params.php',
            ],
            'yiisoft/yii-view' => [
                'config/params.php',
            ],
            'yiisoft/profiler' => [
                'config/params.php',
            ],
            'yiisoft/data-response' => [
                'config/params.php',
            ],
            'yiisoft/aliases' => [
                'config/params.php',
            ],
            'yiisoft/csrf' => [
                'config/params.php',
            ],
            'yiisoft/view' => [
                'config/params.php',
            ],
            'yiisoft/session' => [
                'config/params.php',
            ],
            '/' => [
                'params.php',
                '?params-local.php',
            ],
        ],
        'web' => [
            'yiisoft/router-fastroute' => [
                'config/web.php',
            ],
            'yiisoft/user' => [
                'config/web.php',
            ],
            'yiisoft/yii-swagger' => [
                'config/web.php',
            ],
            'yiisoft/yii-debug' => [
                'config/web.php',
            ],
            'yiisoft/error-handler' => [
                'config/web.php',
            ],
            'yiisoft/middleware-dispatcher' => [
                'config/web.php',
            ],
            'yiisoft/assets' => [
                'config/web.php',
            ],
            'yiisoft/yii-view' => [
                'config/web.php',
            ],
            'yiisoft/data-response' => [
                'config/web.php',
            ],
            'yiisoft/yii-event' => [
                'config/web.php',
            ],
            'yiisoft/csrf' => [
                'config/web.php',
            ],
            'yiisoft/view' => [
                'config/web.php',
            ],
            'yiisoft/session' => [
                'config/web.php',
            ],
            '/' => [
                '$common',
                'web/*.php',
            ],
        ],
        'console' => [
            'yiisoft/yii-cycle' => [
                'config/console.php',
            ],
            'yiisoft/yii-debug' => [
                'config/console.php',
            ],
            'yiisoft/yii-console' => [
                'config/console.php',
            ],
            'yiisoft/yii-event' => [
                'config/console.php',
            ],
            '/' => [
                '$common',
                'console/*.php',
            ],
        ],
        'events-console' => [
            'yiisoft/yii-cycle' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-debug' => [
                'config/events-console.php',
            ],
            'yiisoft/log' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-console' => [
                'config/events-console.php',
            ],
            'yiisoft/yii-event' => [
                '$events',
                'config/events-console.php',
            ],
            '/' => [
                '$events',
                'events-console.php',
            ],
        ],
        'delegates' => [
            'yiisoft/yii-cycle' => [
                'config/delegates.php',
            ],
            '/' => [
                'delegates.php',
            ],
        ],
        'providers' => [
            'yiisoft/yii-debug' => [
                'config/providers.php',
            ],
            '/' => [
                'providers.php',
            ],
        ],
        'events-web' => [
            'yiisoft/yii-debug' => [
                'config/events-web.php',
            ],
            'yiisoft/log' => [
                'config/events-web.php',
            ],
            'yiisoft/profiler' => [
                'config/events-web.php',
            ],
            'yiisoft/yii-event' => [
                '$events',
                'config/events-web.php',
            ],
            '/' => [
                '$events',
                'events-web.php',
            ],
        ],
        'providers-console' => [
            'yiisoft/yii-console' => [
                'config/providers-console.php',
            ],
            '/' => [
                '$providers',
                'providers-console.php',
            ],
        ],
        'events' => [
            'yiisoft/yii-event' => [
                'config/events.php',
            ],
            '/' => [
                'events.php',
            ],
        ],
        'providers-web' => [
            '/' => [
                '$providers',
                'providers-web.php',
            ],
        ],
        'delegates-web' => [
            '/' => [
                '$delegates',
                'delegates-web.php',
            ],
        ],
        'delegates-console' => [
            '/' => [
                '$delegates',
                'delegates-console.php',
            ],
        ],
        'routes' => [
            '/' => [
                'routes.php',
            ],
        ],
        'bootstrap' => [
            '/' => [
                'bootstrap.php',
            ],
        ],
        'bootstrap-web' => [
            '/' => [
                '$bootstrap',
                'bootstrap-web.php',
            ],
        ],
        'bootstrap-console' => [
            '/' => [
                '$bootstrap',
                'bootstrap-console.php',
            ],
        ],
    ],
];
