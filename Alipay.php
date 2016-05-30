<?php

namespace Boofw\Alipay\Wap;

require __DIR__.'/libs/alipay_submit.class.php';
use AlipaySubmit;
require __DIR__.'/libs/alipay_notify.class.php';
use AlipayNotify;

class Alipay
{
    static $appId = '';
    static $appKey = '';
    static $notify_url = '';
    static $return_url = '';

    static $config = [];

    static function config($config = [])
    {
        if ( ! static::$config) {
            require __DIR__.'/libs/alipay.config.php';
            $alipay_config['cacert'] = __DIR__.'/libs/cacert.pem';
            $alipay_config['partner'] = static::$appId;
            $alipay_config['seller_id'] = static::$appId;
            $alipay_config['key'] = static::$appKey;
            $alipay_config['notify_url'] = static::$notify_url;
            $alipay_config['return_url'] = static::$return_url;
            static::$config = $alipay_config;
        }
        static::$config = array_merge(static::$config, $config);
        return static::$config;
    }

    static function createOrder($orderId, $orderFee, $orderTitle, $orderBody)
    {
        $config = static::config();
        $parameter = array(
            '_input_charset'    => $config['input_charset'],
            'service'           => $config['service'],
            'partner'           => $config['partner'],
            'seller_id'         => $config['seller_id'],
            'payment_type'      => $config['payment_type'],
            'notify_url'        => $config['notify_url'],
            'return_url'        => $config['return_url'],

            'out_trade_no'      => $orderId,
            'subject'           => $orderTitle,
            'total_fee'         => $orderFee,
            'body'              => $orderBody,
        );
        $alipaySubmit = new AlipaySubmit($config);
        $para = $alipaySubmit->buildRequestPara($parameter);
        $url = 'https://mapi.alipay.com/gateway.do?'.http_build_query($para);
        return $url;
    }

    static function verifyReturn()
    {
        $alipayNotify = new AlipayNotify(static::config());
        return $alipayNotify->verifyReturn();

    }

    static function verifyNotify()
    {
        $alipayNotify = new AlipayNotify(static::config());
        return $alipayNotify->verifyNotify();
    }
}
