<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Flnet iot memeber client id
    |--------------------------------------------------------------------------
    |
    | 富連網智能家居公眾號client id
    |
    */
    'client_uuid' => env('FLNET_IOT_MEMBER_CLIENT_ID', '1707888028'),

    /*
    |--------------------------------------------------------------------------
    | Flnet iot memeber client id
    |--------------------------------------------------------------------------
    |
    | 富連網智能家居公眾號client secret
    |
    */
    'client_secret' => env('FLNET_IOT_MEMBER_CLIENT_SECRET', 'dS834XqxjQ5dxykxQzHgeuzPwPlaKAbQhf1IDect'),

    /*
    |--------------------------------------------------------------------------
    | Flnet iot memeber api url
    |--------------------------------------------------------------------------
    |
    | 大會員api url
    |
    */
    //'base_api_url' => env('FLNET_IOT_MEMBER_API_BASEURL', 'https://iot.flnet.com/api/'),
    'base_api_url' => 'https://iot.flnet.com/api/',
);
