说明文档

----

# 全局配置

```php

$config = [
    'rshd-project-name' => '项目名称',
    'rshd-project-key'  => '项目key',
];

```

# 阿里 sls 日志写入

```php

// 发送普通日志
$sls = new \RSHDSDK\SLS($config);
$sls->putData('数据数组','主题');

// 发送主题为 Request 的日志
$sls->putRequest('数据数组');

// 发送主题为 Exception 的日志，参数为 Exception 类型
$sls->putException(Exception $e);

```

# 阿里 oss 存储

```php

$oss = new \RSHDSDK\OSS($config);

// 上传文件到 oss
$oss->uploadFile('文件本地路径','文件存储到oss的路径');

//上传内容到 oss
$oss->uploadContent('内容字符串','文件存储到oss的路径');

// 判断文件是否存在
$oss->objectExist('oss中的路径');

// 获取文件内容
$oss->getObjectContent('oss中的路径');

// 获取有过期时间的 图片url
$oss->getPicSignUrl('oss中的路径','fixed 固定宽高缩放（默认值），lfit 等比缩放','图片宽','图片高');

// 获取有过期时间的文件 url
$oss->getSignUrl('oss中的路径');
```

# 短信发送

```php

//发送百度短信

$sms = new \RSHDSDK\SMS($config);
$sms->sendBaidu('电话号码','模版id','短信中变量数组');

//发送阿里短信
$sms = new \RSHDSDK\SMS($config);
$sms->sendAliyun('电话号码','模版id','短信中变量数组');

//发送esms100短信
$sms = new \RSHDSDK\SMS($config);
$sms->sendESMS100('电话号码','内容');
```

**成功返回结果**

```php
[
    "status": 200,
    "message": "",
    "data": []
]
```

# 检测身份证

**检测身份证号码和名字是否匹配**

```php
$idcard = new \RSHDSDK\IdCard($config);
$idcard->check('身份证号码','姓名');
```

**返回结果**

```php
[
    "status": 200,
    "message": "",
    "data":[
        "result": 1,
        "message": "核验一致",
        "birthday": "20000201",
        "sex": "男",
        "address": "四川省成都市"
    ]
]
```

# 电话号码归属地查询

```php
$tel = new \RSHDSDK\Tel($config);
$tel->getAddress('电话号码');
```

**返回成功结果**

```php
[
    "status": 200,
    "message": "",
    "data": [
        "province": "四川",
        "areacode": "028",
        "postcode": "610000",
        "city": "成都",
        "isp": "电信"
    ]
]
```

# 微信支付

## 调用支付

```php

$pay = new \RSHDSDK\WeChat($config)
$pay->miniPay('小程序appid', '商户订单号',
 '订单中文描述', '回调地址', '订单金额',
  '支付用户的openid');
```

**返回结果**

```php
// 返回结果是一个数组
// data中的数据返回给前台小程序给wx.requestPayment方法使用
[
    "status": 200,
    "message": "",
    "data": [
        "appId": "xx",
        "timeStamp": "1735546754",
        "nonceStr": "xx",
        "package": "prepay_id=xx",
        "signType": "RSA",
        "paySign": "xxx"
    ]
]
```

## 通过微信订单号查询订单

```php
$pay = new \RSHDSDK\WeChat($config);
$pay->miniGetOrderByWeChat('订单号');
```

**返回结果**

```json
{
  "status": 200,
  "message": "",
  "data": {
    "amount": {
      "currency": "CNY",
      "payer_currency": "CNY",
      "payer_total": 1,
      "total": 1
    },
    "appid": "wxd8ba3fc250296e6a",
    "attach": "",
    "bank_type": "BOC_DEBIT",
    "mchid": "1681735611",
    "out_trade_no": "20250101152912100-wn6ufK",
    "payer": {
      "openid": "o3Bwh7WFmbtQycUCWrr_P5zy0ElY"
    },
    "promotion_detail": [],
    "success_time": "2025-01-01T17:03:11+08:00",
    "trade_state": "SUCCESS",
    "trade_state_desc": "支付成功",
    "trade_type": "JSAPI",
    "transaction_id": "4200002447202501018994887678"
  }
}
```

## 通过商户订单号查询订单

```php
$pay = new \RSHDSDK\WeChat($config);
$pay->miniGetOrderByOut('订单号');
```

**返回结果**

```json
{
    "status": 200,
    "message": "",
    "data": {
        "amount": {
            "currency": "CNY",
            "payer_currency": "CNY",
            "payer_total": 1,
            "total": 1
        },
        "appid": "wxd8ba3fc250296e6a",
        "attach": "",
        "bank_type": "BOC_DEBIT",
        "mchid": "1681735611",
        "out_trade_no": "20250101152912100-wn6ufK",
        "payer": {
            "openid": "o3Bwh7WFmbtQycUCWrr_P5zy0ElY"
        },
        "promotion_detail": [],
        "success_time": "2025-01-01T17:03:11+08:00",
        "trade_state": "SUCCESS",
        "trade_state_desc": "支付成功",
        "trade_type": "JSAPI",
        "transaction_id": "4200002447202501018994887678"
    }
}
```

## 解密微信支付、退款回调

```php
$pay = new \RSHDSDK\WeChat($config);
$pay->decodeCallBack($associated_data, $nonce, $ciphertext);
```

## 退款

```php
$pay = new \RSHDSDK\WeChat($config);

// 通过微信订单号退款
$pay->miniOrderRefundsByWeChat('微信订单号','商户退款单号','退款金额','订单原始金额','回调url');

// 通过商户订单号退款
$pay->miniOrderRefundsByOut('商户订单号','商户退款单号','退款金额','订单原始金额','回调url');
```

# 微信小程序

```php
$wehcat = new \RSHDSDK\WeChat($config);

//生成小程序二维码
$wehcat->miniUnlimitedQRCode('scene');
//生成小程序url，邮件、网页、微信内部都可以通过这个url打开小程序
$wehcat->miniGenerateUrlLink();
```

# 微信公众号

```php
$wehcat = new \RSHDSDK\WeChat($config);

//创建公众号自定义菜单
$wehcat->officialCreateMenu([]);
//删除清空自定义菜单
$wehcat->officialDeleteMenu();
//发送模版消息
$wehcat->officialTemplateMessageSend();
//发送客户消息
$wehcat->officialCustomSend($message);
//客户消息-发送文本消息
$wehcat->officialCustomSendText($to_user_openid, $content);
//客户消息-发送图片消息
$wehcat->officialCustomSendImage($to_user_openid, $media_id);
//客户消息-发送语音消息
$wehcat->officialCustomSendVoice($to_user_openid, $media_id);
//客户消息-发送图文消息（点击跳转到外链）
$wehcat->officialCustomSendNews($to_user_openid, $title, $description, $url, $picurl);
//客户消息-发送图文消息
$wehcat->officialCustomSendMPNews($to_user_openid, $media_id);
```

## 接收和返回XML消息类

OfficialReceiveXMLMessage 类接收微信的的消息

OfficialSendXMLMessage 类获取需要返回给微信的xml字符串格式

这两个类不需要传送config配置，只需要传需要解析的xml字符串

```php
//获取php请求的原始数据
$xml = file_get_contents("php://input");

//OfficialReceiveXMLMessage，其他方法查看类
$msg = new \RSHDSDK\WeChat\OfficialReceiveXMLMessage($xml);

$msg->isSubscribeEvent();//是否是订阅事件
$msg->isTextMessage();//是否是文本消息
$msg->getField('Content');//给定xml节点名字，获取这个节点的内容
$msg->getToUserName();//开发者微信号
$msg->getFromUserName();//客户openid

//OfficialSendXMLMessage，其他方法查看类

//返回文本消息xml格式字符串
\RSHDSDK\WeChat\OfficialSendXMLMessage::getTextXML('客户openid','开发者微信号','文本内容');
//返回图片消息xml格式字符串
\RSHDSDK\WeChat\OfficialSendXMLMessage::getImageXML('客户openid','开发者微信号','媒体id');
```

# 快递查询

```php
$e = new \RSHDSDK\Express($config);
$e->juMei('快递单号');

```

# 百度编辑器

更改百度编辑器的配置文件 ueditor.config.js 中的 serverUrl 为你项目的控制器方法

```php
//百度编辑器，后端图片处理
$baidu = new \RSHDSDK\UEditor\UEditor($config);

//前台接收的 url 参数数组传给 action 方法
$baidu->action($this->request->param());

$baidu->getHtml('html字符串');
$baidu->setHtml('html字符串');
```

# 一些工具

```php

// 生成一个随机 32 位 md5 字符串
\RSHDSDK\Util\Str::generateUniqueMD5();

// 生成一个 16 位订单号
\RSHDSDK\Util\Str::generateOrderNO();

// 生成一个 20 位年月日的订单号
\RSHDSDK\Util\Str::generateDateOrderNumber();

// 获取文件后缀名
\RSHDSDK\Util\Str::getFileExtension('文件名.jpg');

//发送 http 请求
\RSHDSDK\Util\HTTP::sendRequest('url','POST或GET','请求头数组', '请求body数组','超时时间秒','是否是ssl请求');

\RSHDSDK\Util\HTTP::downloadURLToTempDir('url','文件名前缀');
```

# 更新日志

## 20250125
增加一些小程序，公众号方法

## 20250122

增加 `HTTP::downloadURLToTempDir` 方法