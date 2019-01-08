<?php

/*
 * This file is part of the overtrue/laravel-wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    /*
     * 默认配置，将会合并到各模块中
     */
    'defaults' => [
        /*
         * 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
         */
        'response_type' => 'array',

        /*
         * 使用 Laravel 的缓存系统
         */
        'use_laravel_cache' => true,

        /*
         * 日志配置
         *
         * level: 日志级别，可选为：
         *                 debug/info/notice/warning/error/critical/alert/emergency
         * file：日志文件位置(绝对路径!!!)，要求可写权限
         */
        'log' => [
            'level' => env('WECHAT_LOG_LEVEL', 'debug'),
            'file' => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
        ],
    ],

    /*
     * 路由配置
     */
    'route' => [
        /*
         * 开放平台第三方平台路由配置
         */
        // 'open_platform' => [
        //     'uri' => 'serve',
        //     'action' => Overtrue\LaravelWeChat\Controllers\OpenPlatformController::class,
        //     'attributes' => [
        //         'prefix' => 'open-platform',
        //         'middleware' => null,
        //     ],
        // ],
    ],

    /*
     * 公众号
     */
    'official_account' => [
        'default' => [
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID', 'wxd5edfce8a4540de9'),         // AppID
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET', 'de2eea7cf9edc9d37c06d2a5784ca89c'),    // AppSecret
            'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN', 'your-token'),           // Token
            'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY', ''),                 // EncodingAESKey
            'oauth_redirect' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_REDIRECT', 'http://pay.fujinfu.cn/oauth2_payservice_test.php?istype=2'),//回调url
            'private_key'=>'-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAJfw61T8oFGX2Axs
rx/UxCDo7NEfw+xs27jHyac5mH27/tPoUytXJFaRkqmrq0YoqBufl7ohQKmC0rtn
bwAFAhc9UWOEo0rfcVgzvWbTXeGUg1lIiuoO9yZ++dtgnrhvDhTuJZsB05eHcchS
dkk16Azjy4+T84sM0Q2zQhJD78aPAgMBAAECgYAhHk1dZ/dV8aARDTua15ish7je
2GqvRQcbnsiwn5hCh9DCxdgjEUqFaBOs0hNyJniGFOJQmuDqUe63FJOYUH8k1aRw
AWaqgVMbZga50ABCUu95xW13iqEHxaJX7GFA2nUK6nZ3o7rqmKmv1u5zonbaLt1d
ghOGsMSQyhHnuhTtwQJBAMlv2t+nsbbLqC41+zHKFvVno9JvEcaQ1D8iIyV5qGfp
b4Vqjw7NYvxKyhsgzOnSL+3NqNXvmxZpMjEI5aCljKECQQDBGOXRbrlKhlAkdU4n
+5VgAymXKyZcyI5zockiqWLmOW18okc1zjJUM6dzM9HoJla4daRfjcDTRrGdvMVp
6dUvAkBI24Q20NieXRr/W9b3MzkKmenO+w1a3JdoHljH/TDEJNKJVvlXSUI8LnDb
TwnOqI9dW71tY7ScboAQ7D7h0/8BAkEAr2j8rEnXDHoCp3vgabXDNhrpVyedi7+s
mCIp4tDYxKb6bLPF2Hzdf1wFC0PRtP/O23YSwbK1rbeUdeQbuWDvhQJAEjjHAqml
LWODxHDk/UPv0bYzR17fyIlLI8JrfCzurOHvPGEHA8RtUzTA5KDzBQgSbfNWg+Zj
P3Iv4/Lj/rwQAw==
-----END PRIVATE KEY-----',
            /*'display_url' => 'http://openapi.query.vip.flnettv.com/fsk_vip_query/GetAccountRight',
            'recharge_url'=>'http://openapi.query.vip.flnettv.com/fsk_vip_query/GetProviderByAccountId',
            'price_url'=>'http://openapi.query.vip.flnettv.com/fsk_vip_query/QueryPacakageBySite',
            'order_url'=>'http://openapi.vip.flnettv.com/fsk_vip/BuyVipOnWechat',*/
            'display_url' => env('OPENAPI_URL', 'http://61.163.237.29').'/fsk_vip_query/GetAccountRight',
            'recharge_url'=>env('OPENAPI_URL', 'http://61.163.237.29').'/fsk_vip_query/GetProviderByAccountId',
            'price_url'=>env('OPENAPI_URL', 'http://61.163.237.29').'/fsk_vip_query/QueryPacakageBySite',
            'order_url'=>env('ORDERAPI_URL', 'http://61.163.237.29').'/fsk_vip/BuyVipOnWechat',
            'my_publickey'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDnf+gDwjU5FZfIOZ+HA4RSNJUtCb61+5tMbb2TPJhuCHaLhTdlm13Bt1spR98AsHYTlWrwhD7pXE3jNXpWzVk6qWXums64WC5Kdm5X0HRFcZNgVmBAZdgE8+danhCqz0WpVUgqCvNXmDiPCzGJQxcxdJAz+sCjRRX7DnwmAEKj+QIDAQAB',
            'my_privatekey'=>'MIICdAIBADANBgkqhkiG9w0BAQEFAASCAl4wggJaAgEAAoGBAOd/6APCNTkVl8g5n4cDhFI0lS0JvrX7m0xtvZM8mG4IdouFN2WbXcG3WylH3wCwdhOVavCEPulcTeM1elbNWTqpZe6azrhYLkp2blfQdEVxk2BWYEBl2ATz51qeEKrPRalVSCoK81eYOI8LMYlDFzF0kDP6wKNFFfsOfCYAQqP5AgMBAAECgYBjThHn8tpD54hZoqZVE2Qio13OmRyPEiR3L6gfzeGRad34UagG1RPt8kqPtb3qnMe59OGP1RrrneXnblxRefspBvAH6am3lh9Cp/GbawKTVAg9iPfgb+HIAlFrHDnka7YHJDRgrfc4XbyALtpIvMDriscr9zZyqpoMTjY7H9kCAQJBAPlwaRXXRF7nxNt82NrXtXbi1FlsGOyyymnWMR0qN6V6pqcaSYFxPlDtp6PtS2iWDQmYUyweNgdToE0YEvJkAcECQQDtlrN2ZnRGlCBMRfX9JHMkzy8H8z1pex5T5BLqHLUPBFgHogR3eqDzZjRrbH6NVVSANyZUK/m/fxtUOyqvDkA5Aj81lvD8wELwINsqTKhKXA2gfRsiGxc/wym5k0r5+Rf7dV5YiE1CghHhUS2zCkgpMBOc/BziXZs997l41rM7YEECQDqfw9qEP06nAC0x2hfDZbIAeV9h0pZzbbFPhqdDvB1fegUwIiAFHy/P2UFkfPmMw5P7h7afPznUOD8ZdlfJkWkCQC0qHaghfBc+ORTtgJYbqVxZXAmdV4PHLkVM1AeaAbzazTYje1SfuwqapXTHXp+MNvCZzfyCPsL0YsF1BQAB+vU=',
            'fzf_publickey'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDVzXvqNOtU+PQ7HmkugsHBNKTUj5Ik59kb2YAH4lJWNgyxA1Ef3f3N0SG/q5olFH+Jdtzc/Dx8Po1YlYLTQa8xxJfQhq73t+1sK9tgWCh7COZwdF6wOzz3yRS1H7KiJXL7YIKnbgnwk2zQjs6KlCbrJrqeN99sNxcu9HuyhuHzIQIDAQAB',
            'newmy_privatekey'=>'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMmdxdPr3700EOMP/CngWOeRED1za2nlOi+QTFSjWtF3ER8TLKlTxc7Ruj3tSlDNFlz1j1X95gTgTww9RsopUEOPuavUIjhAvLLvyMSOClCSqsVYUtmscjW0dH0aD9wx2cYYGxwaBvgFazmHu+eYE7oBTaXWm/0K+8j9hUYfUZczAgMBAAECgYEAwNVQEyM0+afExwfQ7NSQ89qBJ+UuxTfjcP6YoxMil9lD3O7f9owTU36wnO5J+AJP81VCZMLUr7FCqbgp7s2Y33JI1YVXYeOWxiJyMtl1V1wf0BOi1KQwiv4hdLZTqlAMhxpeIqMoVTNdLC8XDanSiU0SeSeezg1J1l14uQzKR/ECQQDxMJtOeNd/5GQuNxNHG7uE+LqvBAE7fAvRhtSqRXJFYVxz/TtS0O1zqpejgAJxGU2xY4bDvY9b9FE+xslj4DyXAkEA1f8WfguQIhW3p9A5GXu1lN3QdPh1Eh2YTTYZMQyQxd0ryacbrINvA957G5fTRtEtXICvZcKTgI1voPM+XJihxQJAI/0fv3bSmRfIRwkazEp8EZxXptPPJ0QcM1iOFRYlteqQNBJ+Lp5UQCUdWV05gAzJhgWWz1BSuuLa2KYq2MdV4wJBAKgm5lyq51nxKLwDoSqGC9vrJEcViKBwguGA9fCVyBjCPwsYdWVsbcpjgubeuVS3P2alc62JZHAqMyIMoN8PzGUCQHvPOjogMiEiirlhZ/LI2vyDoygJK0TrvSvUX/G26gL2XRC1gk8Q3LB6FRqirr3f4rDTanX5pH22a7+b23wHQiU=',
            'newfzf_publickey'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDVzXvqNOtU+PQ7HmkugsHBNKTUj5Ik59kb2YAH4lJWNgyxA1Ef3f3N0SG/q5olFH+Jdtzc/Dx8Po1YlYLTQa8xxJfQhq73t+1sK9tgWCh7COZwdF6wOzz3yRS1H7KiJXL7YIKnbgnwk2zQjs6KlCbrJrqeN99sNxcu9HuyhuHzIQIDAQAB',
            'create_point_url' => env('CREATE_POINT_URL', 'http://123.58.33.163:615/api/v1/post/bonus-point/create'),
            'cancel_point_url'=> env('CANCEL_POINT_URL', 'http://123.58.33.163:615/api/v1/post/bonus-point/cancel'),
            'point_client_id'=>'1707888041',
            'point_client_secret'=>'hxdrtMmSwt6YEJN0bo1ABWRbEG5hXjkqTppcKIFP',
            'platform_param'=>1,
            'point_return_param'=> 0.1,
            'point_register_bounes' => 20,
            'point_bind_device' => 10,
            /*'db_url' => env('DB_HOST', '172.16.25.51'),
            'db_username'=> env('DB_USERNAME', 'dafuprodadm'),
            'db_password'=> env('DB_PASSWORD', 'Dafuprod@2017'),
            'db_name' => env('DB_DATABASE', 'flnet_iot_member_wechat_account_test'),*/
            'db_url' => env('DB_HOST', '127.0.0.1'),
            'db_username'=> env('DB_USERNAME', 'root'),
            'db_password'=> env('DB_PASSWORD', 'root'),
            'db_name' => env('DB_DATABASE', 'cancel'),
            'db_port' => env('DB_PORT', '3306'),
            'dfclient_uuid' => '1707888028',
            'dfclient_sercet' => 'dS834XqxjQ5dxykxQzHgeuzPwPlaKAbQhf1IDectd',
            'client_id'=>env('CLIENT_ID', '1707888041'),
            'client_secret'=>env('CLIENT_SECRET', 'hxdrtMmSwt6YEJN0bo1ABWRbEG5hXjkqTppcKIFP'),
            'exchange-goods'=>env('EXCHANGE_GOODS', 'http://123.58.33.163:615/api/v1/post/bonus-point/exchange-goods'),//http://bonus-st.flnet.com
            'get-remaining'=>env('GET_REMAINING', 'http://123.58.33.163:615/api/v1/post/bonus-point/get-remaining'),
            'detail'=>env('DETAIL_URL', 'http://123.58.33.163:615/api/v1/get/products/detail'),
            'list'=>env('LIST_URL', 'http://123.58.33.163:615/api/v1/post/bonus-point/list'),
            'list_url'=>env('PRODUCT_LIST_URL','http://123.58.33.163:615/api/v1/post/products/list'),
            'create'=>env('CREATE_URL', 'http://123.58.33.163:615/api/v1/post/bonus-point/create'),
            'exchange-history-list'=>env('EXCHANGE_HISTORY_LIST', 'http://123.58.33.163:615/api/v1/post/bonus-point/exchange-history-list'),
            /*
             * OAuth 配置
             *
             * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
             * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
             */
            // 'oauth' => [
            //     'scopes'   => array_map('trim', explode(',', env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_SCOPES', 'snsapi_userinfo'))),
            //     'callback' => env('WECHAT_OFFICIAL_ACCOUNT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
            // ],
        ],
    ],
    'sso'=>[
        'default'=>[
            'sso_url'=>env('SSO_URL','https://iot.flnet.com'),
            'sso_server'=>env('SSO_SERVER','https://iot.flnet.com/sso'),
            'sso_broker_id'=>env('SSO_BROKER_ID','1707888041'),
            'sso_broker_secret'=>env('SSO_BROKER_SECRET','hxdrtMmSwt6YEJN0bo1ABWRbEG5hXjkqTppcKIFP')
        ]
    ]
    /*
     * 开放平台第三方平台
     */
    // 'open_platform' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //         'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //         'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 小程序
     */
    // 'mini_program' => [
    //     'default' => [
    //         'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
    //         'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
    //         'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
    //         'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
    //     ],
    // ],

    /*
     * 微信支付
     */
    // 'payment' => [
    //     'default' => [
    //         'sandbox'            => env('WECHAT_PAYMENT_SANDBOX', false),
    //         'app_id'             => env('WECHAT_PAYMENT_APPID', ''),
    //         'mch_id'             => env('WECHAT_PAYMENT_MCH_ID', 'your-mch-id'),
    //         'key'                => env('WECHAT_PAYMENT_KEY', 'key-for-signature'),
    //         'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', 'path/to/cert/apiclient_cert.pem'),    // XXX: 绝对路径！！！！
    //         'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', 'path/to/cert/apiclient_key.pem'),      // XXX: 绝对路径！！！！
    //         'notify_url'         => 'http://example.com/payments/wechat-notify',                           // 默认支付结果通知地址
    //     ],
    //     // ...
    // ],

    /*
     * 企业微信
     */
    // 'work' => [
    //     'default' => [
    //         'corp_id' => 'xxxxxxxxxxxxxxxxx',
    ///        'agent_id' => 100020,
    //         'secret'   => env('WECHAT_WORK_AGENT_CONTACTS_SECRET', ''),
    //          //...
    //      ],
    // ],
    /*
     * sso的server,url,broker_id,broker_secret
     */

];
