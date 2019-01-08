<?php

namespace App\Services;

use Cache;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Response;


class FlnetIotMemberApiService
{
    /** @var Client  */
    protected $requestClient;

    /** @var string */
    protected $baseApiUrl;

    /** @var string */
    protected $FLNET_IOT_MEMBER_API_CACHE_KEY_PREFIX = 'flnet-iot-member';

    /** @var string */
    private $clientUuid;

    /** @var string */
    private $clientSecret;

    /** @var  ResponseInterface */
    private $response;

    /** @var  string $accessToken */
    private $accessToken;

    /**
     * 建構子
     */
    public function __construct(
    )
    {
        // 大會員的接口初始化設定
        $this->baseApiUrl = config('flnet-iot-member.base_api_url');
        logger()->debug("this->baseApiUrl = $this->baseApiUrl");
        $this->clientUuid = config('flnet-iot-member.client_uuid');
        $this->clientSecret = config('flnet-iot-member.client_secret');

        $this->requestClient = new Client([
            'base_uri' => $this->baseApiUrl,
            'verify' => false
        ]);
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getClientUuid()
    {
        return $this->clientUuid;
    }

    /**
     * @param string $clientUuid
     */
    public function setClientUuid($clientUuid)
    {
        $this->clientUuid = $clientUuid;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * 取得client_credentials token
     * @return mixed
     */
    public function getClientCredentialsToken()
    {
        $accessToken = Cache::get($this->FLNET_IOT_MEMBER_API_CACHE_KEY_PREFIX . '-client-' . $this->clientUuid . '-token');
        if ($accessToken) {
            return $accessToken;
        }
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
        ];

        $params = [
            'client_uuid' => $this->clientUuid,
            'client_secret' => $this->clientSecret,
            'grant_type' => 'client_credentials',
        ];

        $apiEndpoint = 'oauth/token';

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        // 解析回傳，若http status code不為200
        if ($response->getStatusCode() != 200 ) {
            // 回傳失敗結果
            return Response::json([
                'result_code' => 0,
                'message'=>'调用大富会员接口失败',
            ], $response->getStatusCode());
        }

        $responseArray = json_decode($response->getBody(), true);
        if ($responseArray['result_code'] == 0 ) {
            // 回傳失敗結果
            return Response::json([
                'result_code' => 0,
                'message'=> $responseArray['message'],
            ]);
        }

        // 獲取API回傳結果
        $accessToken = $responseArray['access_token'];
        $minutes = $responseArray['expires_in'] / 60;
        Cache::put($this->FLNET_IOT_MEMBER_API_CACHE_KEY_PREFIX . '-client-' . $this->clientUuid . '-token', $accessToken, $minutes);

        return $accessToken;
    }

    /**
     * 發送短信驗證碼
     *
     * @param $type
     * @param $mobile
     * @param $mobileCountryCode
     * @return mixed
     */
    public function sendMobileSms($type, $mobile, $mobileCountryCode = '+86')
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = [
            'type' => $type,
            'mobile_country_code' => $mobileCountryCode,
        ];

        $apiEndpoint = 'sms/codes/'.$mobile;

        logger()->debug('$params = ' . json_encode($params));
        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);
    }

    /**
     * 驗證短信驗證碼
     *
     * @param $type
     * @param $code
     * @param $mobile
     * @param $mobileCountryCode
     * @return mixed
     */
    public function validateMobileConfirmCode($type, $code, $mobile, $mobileCountryCode = '+86')
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = [
            'type' => $type,
        ];

        $apiEndpoint = "sms/codes/$mobile/validation/$code";

        logger()->debug('$params = ' . json_encode($params));
        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        if ($response->getStatusCode() != 200 ) {
            // 回傳失敗結果
            return Response::json([
                'result_code' => 0,
                'message'=>'调用大富会员接口失败',
            ], $response->getStatusCode());
        }

        $this->setResponse($response);

        return $response;
    }

    /**
     * 讓特定平台一次大量導入用戶
     *
     * @param $clientUuid
     * @param $importUsers
     * @return mixed
     */
    public function bulkImportUser($clientUuid, $importUsers)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = [
            'users' => json_encode($importUsers)
        ];

        $apiEndpoint = "clients/".$clientUuid.'/users/import';

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($importUsers));
        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 0,
            'read_timeout' => 0,
        ]);

        $this->setResponse($response);

        return $response;
    }
    /**
     * 一般注册接口
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public function register($username,$mobile_confirm_code, $password)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = [
            'username' => $username,
            'mobile_country_code'=>'+86',
            'mobile_confirm_code'=>$mobile_confirm_code,
            'password' => $password,
        ];

        $apiEndpoint = 'auth/register';

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($params));

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);

        return $response;
    }
    /**
     * 一般登入接口
     *
     * @param $username
     * @param $password
     * @return mixed
     */
    public function login($username, $password)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = [
            'username' => $username,
            'password' => $password,
        ];

        $apiEndpoint = 'auth/login';

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($params));

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);

        return $response;
    }

    /**
     * 用戶快捷登录接口
     *
     * @param $mobile
     * @param $mobile_confirm_code
     * @param $input
     * @return mixed
     */
    public function loginFastRegister($mobile, $mobile_confirm_code, $input)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = array_merge([
            'mobile' => $mobile,
            'mobile_confirm_code' => $mobile_confirm_code,
        ], $input);

        $apiEndpoint = "auth/fast-login";

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($params));

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);

        return $response;
    }
    /**
     * 第三方登入接口
     *
     * @param $unionId
     * @param $openId
     * @param $provider
     * @param $input
     * @return mixed
     */
    public function loginWithThirdParty($unionId, $openId, $provider, $input)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = array_merge([
            'union_id' => $unionId,
            'open_id' => $openId,
        ], $input);

        $apiEndpoint = "auth/$provider/login";

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($params));

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);

        return $response;
    }

    /**
     * 用戶關聯第三方服務資料接口
     *
     * @param $userUuid
     * @param $provider
     * @param $input
     * @return mixed
     */
    public function bindThirdPartyService($userUuid, $provider, $input)
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Connection' => 'keep-Alive',
            'Charset' => 'UTF-8',
            'Authorization' => 'Bearer '. $this->getClientCredentialsToken(),
        ];

        $params = $input;

        $apiEndpoint = "users/$userUuid/bind/$provider";

        logger()->debug('$apiEndpoint = ' . $apiEndpoint);
        logger()->debug('$params = ' . json_encode($params));

        // 發送請求
        $response = $this->requestClient->request('POST', $apiEndpoint, [
            'headers'=> $headers,
            'form_params' => $params,
            'connect_timeout' => 10,
            'timeout' => 30,
            'read_timeout' => 20,
        ]);

        $this->setResponse($response);

        return $response;
    }
}

