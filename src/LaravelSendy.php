<?php
namespace Micovi\LaravelSendy;

/**
 * PHP interface for Sendy api
 *
 * @author Ovidiu Miclea <micleaovidiul@gmail.com>
 * @package micovi/laravel-sendy
 */
class LaravelSendy
{
    const URI_SUBSCRIBE = 'subscribe';
    const URI_UNSUBSCRIBE = 'unsubscribe';
    const URI_DELETE_SUBSCRIBER = 'api/subscribers/delete.php';
    const URI_SUBSCRIPTION_STATUS = 'api/subscribers/subscription-status.php';
    const URI_ACTIVE_SUBSCRIBER_COUNT = 'api/subscribers/active-subscriber-count.php';
    protected $_URL = null;
    protected $_apiKey = null;
    protected $_listId = null;
    protected $_cURLOption = array();

    /**
     * __construct
     *
     * @throws Exception\InvalidURLException
     * @throws Exception\DomainException
     * @throws Exception\ConfigException
     *
     * @return void
     */
    public function __construct()
    {
        $config_url = config('laravel-sendy.URL', null);
        $config_api_key = config('laravel-sendy.API_KEY', null);
        $config_list_id = config('laravel-sendy.LIST_ID', null);

        if ($config_url == null)
            throw new \Exception('SENDY_URL is not defined in env or config file');

        if ($config_api_key == null)
            throw new \Exception('SENDY_API_KEY is not defined in env or config file');

        if ($config_list_id == null)
            throw new \Exception('SENDY_LIST_ID is not defined in env or config file');

        $this->setURL($config_url);
        $this->setApiKey($config_api_key);
        $this->setListId($config_list_id);
    }

    public function subscribe($email, $name = null, $listId = null, $json = false, array $customFields = [])
    {
        if (!self::isEmailValid($email))
            throw new Exception\InvalidEmailException($email);

        if ($listId == null)
            $listId = $this->_listId;

        $request = array(
            'email' => $email,
            'list' => $listId,
            'boolean' => 'true'
        );
        if (!is_null($name))
            $request['name'] = $name;

        foreach ($customFields as $fieldName => $value) {
            if (array_key_exists($fieldName, $request))
                throw new \Exception('Illegal customField name: ', $fieldName);
            else
                $request[$fieldName] = $value;
        }

        $response = $this->_callSendy(self::URI_SUBSCRIBE, $request);

        $return = [
            'success' => false,
            'message' => trans('laravel::sendy::messages.Unknown error.')
        ];

        if (!in_array($response, [1, '1', 'true'])) {
            $return = [
                'success' => false,
                'message' => trans('laravel-sendy::messages.subscribe.'.$response)
            ];
        } else {
            $return = [
                'success' => true,
                'message' => trans('laravel-sendy::messages.subscribe.success')
            ];
        }

        if ($json == true)
            return json()->response($return);

        return $return;
    }

    public function unsubscribe($email, $listId = null, $json = false)
    {
        if (!self::isEmailValid($email))
            throw new Exception\InvalidEmailException($email);

        if ($listId == null)
            $listId = $this->_listId;

        $request = array(
            'email' => $email,
            'list' => $listId,
            'boolean' => 'true'
        );

        $response = $this->_callSendy(self::URI_UNSUBSCRIBE, $request);

        $return = [
            'success' => false,
            'message' => trans('laravel::sendy::messages.Unknown error.')
        ];

        if (!in_array($response, [1, '1', 'true'])) {
            $return = [
                'success' => false,
                'message' => trans('laravel-sendy::messages.unsubscribe.' . $response)
            ];
        } else {
            $return = [
                'success' => true,
                'message' => trans('laravel-sendy::messages.unsubscribe.success')
            ];
        }

        if ($json == true)
            return json()->response($return);

        return $return;
    }


    public function delete($email, $listId = null, $json = false)
    {
        if (!self::isEmailValid($email))
            throw new Exception\InvalidEmailException($email);

        if ($listId == null)
            $listId = $this->_listId;

        $request = array(
            'api_key' => $this->_apiKey,
            'email' => $email,
            'list_id' => $listId
        );

        $response = $this->_callSendy(self::URI_DELETE_SUBSCRIBER, $request);

        $return = [
            'success' => false,
            'message' => trans('laravel::sendy::messages.Unknown error.')
        ];

        if (!in_array($response, [1, '1', 'true'])) {
            $return = [
                'success' => false,
                'message' => trans('laravel-sendy::messages.delete.' . $response)
            ];
        } else {
            $return = [
                'success' => true,
                'message' => trans('laravel-sendy::messages.delete.success')
            ];
        }

        if ($json == true)
            return json()->response($return);

        return $return;
    }

    /**
     * isURLValid
     *
     * @param mixed $url
     *
     * @return bool
     */
    public static function isURLValid($url)
    {
        return (filter_var($url, \FILTER_VALIDATE_URL) !== false);
    }

    /**
     * isEmailValid
     *
     * @param  mixed $email
     *
     * @return bool
     */
    public static function isEmailValid($email)
    {
        return (filter_var($email, \FILTER_VALIDATE_EMAIL) !== false);
    }

    /**
     * setURL
     *
     * @param  mixed $URL
     *
     * @throws \Exception
     *
     * @return void
     * @version 1.0.0
     *
     */
    public function setURL($URL)
    {
        if (!self::isURLValid($URL))
            throw new \Exception('Invalid URL defined in SENDY_URL constant: ' . $URL);

        $this->_URL = $URL;
    }



    /**
     * setApiKey
     *
     * @param string $apiKey
     *
     * @return void
     */
    public function setApiKey($apiKey)
    {
        $this->_apiKey = $apiKey;
    }

    /**
     * setListId
     *
     * @param  mixed $listId
     *
     * @return void
     */
    public function setListId($listId)
    {
        $this->_listId = $listId;
    }

    /**
     * _getURL
     *
     * @return string
     */
    protected function _getURL()
    {
        return $this->_URL;
    }

    /**
     * _getApiKey
     *
     * @return void
     */
    protected function _getApiKey()
    {
        return $this->_apiKey;
    }


    /**
     * _callSendy
     *
     * @param  string $URI
     * @param  array $params
     *
     * @throws Exception\CurlException
     *
     * @return void
     */
    protected function _callSendy($URI, array $params)
    {
        $url = $this->_getURL() . '/' . $URI;
        $resource = curl_init($url);

        if ($resource === false)
            throw new \Exception('CURL initialization failed. URL: ' . $url);

        $postData = http_build_query($params);

        $curlOptions[\CURLOPT_RETURNTRANSFER] = 1;
        $curlOptions[\CURLOPT_POST] = 1;
        $curlOptions[\CURLOPT_POSTFIELDS] = $postData;

        foreach ($curlOptions as $option => $value) {
            if (!curl_setopt($resource, $option, $value))
                throw new \Exception('CURL option setting failed. Option: [' . $option . '] , value [' . $value . '])', $resource);
        }

        $result = curl_exec($resource);

        if ($result === false)
            throw new \Exception('CURL execution failed.', $resource);

        curl_close($resource);

        return $result;
    }
}
