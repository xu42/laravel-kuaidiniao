<?php

namespace Xu42\KuaiDiNiao;

use Exception;

class KuaiDiNiao
{

    /**
     * 即时查询
     *
     * @param $logisticCode string 物流公司编号
     * @param $logisticNo string 快递单号
     * @param string $orderNo 订单号
     *
     * @return array|null
     * @throws Exception
     */
    public static function track($logisticCode, $logisticNo, $orderNo = '')
    {
        $businessData = self::makeBusinessData($logisticCode, $logisticNo, $orderNo);

        return self::request(__FUNCTION__, $businessData);
    }


    /**
     * 物流追踪
     *
     * @param $logisticCode string 物流公司编号
     * @param $logisticNo string 快递单号
     * @param string $orderNo 订单号
     *
     * @return array|null
     * @throws Exception
     */
    public static function follow($logisticCode, $logisticNo, $orderNo = '')
    {
        $businessData = self::makeBusinessData($logisticCode, $logisticNo, $orderNo);

        return self::request(__FUNCTION__, $businessData);
    }


    /**
     * 统一HTTP请求入口
     *
     * @param $apiName string 接口名称
     * @param $businessData array 业务参数
     *
     * @return array|null
     * @throws Exception
     */
    private static function request($apiName, $businessData)
    {
        return Utils::httpRequest($apiName, $businessData);
    }


    private static function makeBusinessData($logisticCode, $logisticNo, $orderNo)
    {
        return [
            'OrderCode' => $orderNo,
            'ShipperCode' => $logisticCode,
            'LogisticCode' => $logisticNo,
        ];
    }

}