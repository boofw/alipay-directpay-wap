boofw/alipay-directpay-wap
=============

支付宝即时到账付款手机版网页版，直接引用官方sdk并进行了封装，官方有升级可直接替换相应文件

libs 目录中为官方sdk原始文件

Installation
--------------

```
composer require boofw/alipay-directpay-wap:dev-master
```

Useage
--------------

```
<?php

use Boofw\Alipay\Wap\Alipay;

// 配置
Alipay::$appId = '2088000000000000';
Alipay::$appKey = 'b3a87287ec1b0e5e329f176e6fd0afe1';
Alipay::$notify_url = 'http://boof.wang/notify_url';
Alipay::$return_url = 'http://boof.wang/return_url';

// 生成订单，跳转到支付宝付款
$url = Alipay::createOrder($orderId, $orderFee, $orderTitle, $orderBody);
header('location: '.$url);

// 付款后，跳转回 return_url，验证支付结果并处理订单
if (Alipay::verifyReturn()) {
    // 修改订单状态为已付款
} else {
    // 返回提示信息页：付款不成功
}

// 异步通知 notify_url 页验证支付结果并处理订单
if (Alipay::verifyNotify()) {
    // 修改订单状态为已付款
    die('success');
} else {
    die('fail');
}
```
