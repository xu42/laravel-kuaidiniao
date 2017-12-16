<?php

namespace Xu42\KuaiDiNiao;

use Exception;

class Utils
{
    /**
     *  post提交数据
     *
     * @param $apiName string 接口名称
     * @param array $businessData 业务数据
     *
     * @return array|null HTTP响应
     * @throws Exception
     */
    public static function httpRequest($apiName, $businessData)
    {
        $apiConfig = config('kdniao.api.' . $apiName);

        if (empty($apiConfig)) {
            throw new Exception(sprintf("laravel-kdniao not found this api name: %s", $apiName));
        }

        $urlInfo = parse_url($apiConfig['url']);
        if (empty($urlInfo['port'])) {
            $urlInfo['port'] = 80;
        }

        $postData = self::makePostData($apiName, $businessData);
        $responseJson = self::post($urlInfo['host'], $urlInfo['port'], $urlInfo['path'], $postData);

        return json_decode($responseJson, true);
    }


    /**
     * 发起请求
     *
     * @param $host
     * @param $port
     * @param $path
     * @param $postDataStr
     *
     * @return string
     */
    private static function post($host, $port, $path, $postDataStr)
    {
        $httpHeader = "POST " . $path . " HTTP/1.0\r\n";
        $httpHeader .= "Host:" . $host . "\r\n";
        $httpHeader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpHeader .= "Content-Length:" . strlen($postDataStr) . "\r\n";
        $httpHeader .= "Connection:close\r\n\r\n";
        $httpHeader .= $postDataStr;

        $fd = fsockopen($host, $port);

        fwrite($fd, $httpHeader);

        $gets = "";
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }

        while (!feof($fd)) {
            $gets .= fread($fd, 512);
        }
        fclose($fd);

        return $gets;
    }


    /**
     * 生成签名
     *
     * @param string $data 内容
     *
     * @return string DataSign签名
     */
    private static function encrypt($data)
    {
        $appKey = config('kdniao.common.app_key');
        return urlencode(base64_encode(md5($data . $appKey)));
    }


    /**
     * 生成postData
     *
     * @param $apiName string 接口名称
     * @param array $businessData 业务数据
     *
     * @return string
     */
    private static function makePostData($apiName, $businessData)
    {
        $systemData['DataType'] = config('kdniao.common.data_type');
        $systemData['RequestData'] = urlencode(json_encode($businessData));
        $systemData['EBusinessID'] = config('kdniao.common.e_business_id');
        $systemData['DataSign'] = self::encrypt(json_encode($businessData));
        $systemData['RequestType'] = config('kdniao.api.' . $apiName . '.type');

        $postData = [];
        foreach ($systemData as $key => $value) {
            $postData[] = sprintf('%s=%s', $key, $value);
        }
        return implode('&', $postData);
    }

}