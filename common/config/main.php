<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=10.10.50.71;dbname=daycare',
            'username' => 'root',
            'password' => 'inisangatrahasia',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'formatter' => [
           'class' => 'yii\i18n\Formatter',
           'locale' => 'id-ID', //ej. 'es-ES'
           'thousandSeparator' => '.',
           'decimalSeparator' => ',',
           'currencyCode' => 'Rp',
        ],
    ],
];
