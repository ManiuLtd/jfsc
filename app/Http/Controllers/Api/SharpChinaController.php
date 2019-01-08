<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class SharpChinaController extends BaseController
{

    protected $APP_ID = '';

    protected $APP_SECRET = '';

    public function __construct()
    {
        $this->APP_ID = config('sharp_wechat.app_id');
        $this->APP_SECRET = config('sharp_wechat.app_secret');
    }

    /**
     * 代替電視端獲取微信access_token
     *
     * @param Request $request
     */
    public function getWechatAccessTokenApi(Request $request)
    {
        $responseArray = $this->getWechatAccessToken();

        return response()->json($responseArray);
    }

    /**
     * 創建自定義菜單
     *
     * @param Request $request
     */
    public function createMenuApi(Request $request)
    {
        $responseArray = $this->getWechatAccessToken();
        // 若取得access_token失敗
        if ($responseArray['result_code'] == 0) {
            return response()->json($responseArray);
        }

        $access_token = $responseArray['access_token'];
        $input = $request->all();

        // 檢查menu參數格式是否正確
        if (!isset($input['menu']) || !is_array($input['menu'])) {
            return response()->json([
                'result_code' => 0,
                'message' => 'invalid menu'
            ]);
        }

        $menuInputArray = $input['menu'];

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        logger()->debug('$menuInputArray = ' . json_encode($menuInputArray));

        // 發送post request
        $wechatResponse = (new Client())->request('POST', $url, [
            'headers' => [
                'Content-type' => 'application/json; encoding=utf-8',
            ],
            'verify' => false,
            'body' => json_encode($menuInputArray, JSON_UNESCAPED_UNICODE),
            'connect_timeout' => 5, // Float describing the number of seconds to wait while trying to connect to a server
            'timeout' => 10, // Float describing the timeout of the request in seconds
            'read_timeout' => 20, // Float describing the timeout to use when reading a streamed body
        ]);

        $responseArray = $this->generateResponseArray();

        if ($wechatResponse->getStatusCode() != 200) {
            return response()->json([
                'result_code' => 0,
            ], $wechatResponse->getStatusCode());
        }

        $wechatResponseArray = json_decode($wechatResponse->getBody(), true);
        logger()->debug('$wechatResponseArray = ' . json_encode($wechatResponseArray));
        $responseArray = array_merge($responseArray, $wechatResponseArray);
        // 若是有帶errcode回來，代表微信接口拋回錯誤
        if (isset($responseArray['errcode']) && $responseArray['errcode']) {
            $responseArray['result_code'] = 0;
            logger()->error('errcode = ' . $responseArray['errcode']);
            logger()->error('errmsg = ' . $responseArray['errmsg']);
            return response()->json($responseArray);
        }

        return response()->json($responseArray);
    }

    /**
     * 取得自定義菜單
     *
     * @param Request $request
     *
     * {"result_code":1,"menu":{"button":[{"type":"view","name":"\u4f1a\u5458\u670d\u52a1(\u6e2c\u8a66)","url":"http:\/\/iot.flnet.com:8088\/zhuce","sub_button":[]},{"type":"view","name":"\u4f1a\u5458\u670d\u52a1(\u6b63\u5f0f)","url":"https:\/\/vipaccount.flnet.com\/zhuce","sub_button":[]}]}}
     */
    public function getMenuApi(Request $request)
    {
        $responseArray = $this->getWechatAccessToken();
        // 若取得access_token失敗
        if ($responseArray['result_code'] == 0) {
            return response()->json($responseArray);
        }

        $access_token = $responseArray['access_token'];
//        logger()->debug('$access_token = ' . $access_token);
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $access_token;

        //转化成json的格式
        $wechatResponse = (new Client())->get($url);

        $responseArray = $this->generateResponseArray();

        if ($wechatResponse->getStatusCode() != 200) {
            return response()->json([
                'result_code' => 0,
            ], $wechatResponse->getStatusCode());
        }

        $wechatResponseArray = json_decode($wechatResponse->getBody(), true);
        logger()->debug('$wechatResponseArray = ' . json_encode($wechatResponseArray));
        $responseArray = array_merge($responseArray, $wechatResponseArray);
        // 若是有帶errcode回來，代表微信接口拋回錯誤
        if (isset($responseArray['errcode']) && $responseArray['errcode']) {
            $responseArray['result_code'] = 0;
            logger()->error('errcode = ' . $responseArray['errcode']);
            logger()->error('errmsg = ' . $responseArray['errmsg']);
            return response()->json($responseArray);
        }

        return response()->json($responseArray);
    }


    /**
     * 取得微信access_token
     *
     * @return array
     */
    private function getWechatAccessToken()
    {
        // 從cache中取出上一次存的結果
        $responseArray = Cache::get('wechat-client-token');
        $now = Carbon::now();
        $diff = $now->diffInMinutes($responseArray['expires_at']);
        logger()->debug('$diff = ' . $diff);
        // 若判斷到期時間仍大於5分鐘，則直接返回cache
        if ($responseArray && $diff > 5) {
            logger()->debug('hit cache');
            return $responseArray;
        }

        logger()->debug('no cache');
        // 透過wechat接口獲取access_token
        $wechatResponse = (new Client())->get('https://api.weixin.qq.com/cgi-bin/token?appid='
            . $this->APP_ID . '&secret=' . $this->APP_SECRET . '&grant_type=client_credential');

        $responseArray = $this->generateResponseArray();

        if ($wechatResponse->getStatusCode() != 200) {
            return response()->json([
                'result_code' => 0,
            ], $wechatResponse->getStatusCode());
        }

        $wechatResponseArray = json_decode($wechatResponse->getBody(), true);
        logger()->debug('$wechatResponseArray = ' . json_encode($wechatResponseArray));
        $responseArray = array_merge($responseArray, $wechatResponseArray);
        // 若是有帶errcode回來，代表微信接口拋回錯誤
        if (isset($responseArray['errcode']) && $responseArray['errcode']) {
            $responseArray['result_code'] = 0;
            logger()->error('errcode = ' . $responseArray['errcode']);
            logger()->error('errmsg = ' . $responseArray['errmsg']);
            return $responseArray;
        }

        // 記住token的過期時間，當前時間加上expires_in(秒)時間
        $responseArray['expires_at'] = $now->addSecond($responseArray['expires_in']);

        // 將responseArray存在cache中，保存120分鐘
        Cache::put('wechat-client-token', $responseArray, 110);

        return $responseArray;
    }

    /**
     * 生成回傳array
     *
     * @return array
     */
    private function generateResponseArray()
    {
        return [
            'result_code' => 1
        ];
    }
}
