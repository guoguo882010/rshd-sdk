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

**调用支付**

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