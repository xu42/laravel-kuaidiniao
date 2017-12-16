<?php

return [

    'common' => [
        'app_key' => 'your_app_key', //AppKey
        'e_business_id' => 'your_e_business_id', //商户ID
        'data_type' => '2', //默认值2 JSON
    ],

    'api' => [

        //即时查询API
        'track' => [
            'url' => 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx',
            'type' => '1002',
        ],

        //物流跟踪API
        'follow' => [
            'url' => 'http://api.kdniao.cc/api/dist',
            'type' => '1008',
        ],


    ],
];