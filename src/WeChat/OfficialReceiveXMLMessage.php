<?php

namespace RSHDSDK\WeChat;

use Exception;

/**
 * 接收普通消息
 * @since 2.14
 * @see https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Receiving_standard_messages.html
 * @see https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Receiving_event_pushes.html
 */
class OfficialReceiveXMLMessage
{
    /**
     * @var string
     */
    protected $xml;

    /**
     * @param $xml
     * @throws Exception
     */
    public function __construct($xml)
    {
        if (empty($xml)) {
            throw new Exception('XML 字符串不能为空');
        }

        $this->xml = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        if ($this->xml === false) {
            throw new Exception('XML 解析失败');
        }
    }

    /**
     * 判断是否为指定类型的消息
     * @param string $type
     * @return bool
     */
    public function isMessageType($type)
    {
        return isset($this->xml->MsgType) && (string) $this->xml->MsgType === $type;
    }

    /**
     * @return bool
     */
    public function isTextMessage()
    {
        return $this->isMessageType('text');
    }

    /**
     * @return bool
     */
    public function isImageMessage()
    {
        return $this->isMessageType('image');
    }

    /**
     * @return bool
     */
    public function isVoiceMessage()
    {
        return $this->isMessageType('voice');
    }

    /**
     * @return bool
     */
    public function isVideoMessage()
    {
        return $this->isMessageType('video');
    }

    /**
     * @return bool
     */
    public function isShortVideoMessage()
    {
        return $this->isMessageType('shortvideo');
    }

    /**
     * @return bool
     */
    public function isLocationMessage()
    {
        return $this->isMessageType('location');
    }

    /**
     * @return bool
     */
    public function isLinkMessage()
    {
        return $this->isMessageType('link');
    }

    /**
     * @return bool
     */
    public function isEventMessage()
    {
        return $this->isMessageType('event');
    }

    /**
     * 判断是否为指定事件类型
     * @param string $eventType
     * @return bool
     */
    public function isEventType($eventType)
    {
        return $this->isEventMessage() && isset($this->xml->Event) && (string) $this->xml->Event === $eventType;
    }

    /**
     * 是否为 关注公众号事件
     * @return bool
     */
    public function isSubscribeEvent()
    {
        return $this->isEventType('subscribe');
    }

    /**
     * 是否为 取消关注公众号事件
     * @return bool
     */
    public function isUnsubscribeEvent()
    {
        return $this->isEventType('unsubscribe');
    }

    /**
     * 是否为 自定义菜单事件
     * @return bool
     */
    public function isClickEvent()
    {
        return $this->isEventType('CLICK');
    }

    /**
     * 是否为上报地理位置事件
     * @return bool
     */
    public function isLocationEvent()
    {
        return $this->isEventType('LOCATION');
    }

    /**
     * 获取 XML 数据中的指定字段
     * @param string $field
     * @param string|null $default
     * @return string|null
     */
    public function getField($field, $default = null)
    {
        return isset($this->xml->$field) ? (string) $this->xml->$field : $default;
    }

    /**
     * 开发者微信号
     * @return string
     */
    public function getToUserName()
    {
        return $this->getField('ToUserName', '');
    }

    /**
     * 发送方账号（一个OpenID）
     * @return string
     */
    public function getFromUserName()
    {
        return $this->getField('FromUserName', '');
    }

    /**
     * 消息创建时间 （整型）
     * @return integer|null
     */
    public function getCreateTime()
    {
        return $this->getField('CreateTime', null);
    }

    /**
     * 消息类型
     * @return string
     */
    public function getMsgType()
    {
        return $this->getField('MsgType', '');
    }

    /**
     * 消息id，64位整型
     * @return string
     */
    public function getMsgId()
    {
        return $this->getField('MsgId', '');
    }

    /**
     * 消息的数据ID（消息如果来自文章时才有）
     * @return string
     */
    public function getMsgDataId()
    {
        return $this->getField('MsgDataId', '');
    }

    /**
     * 获取多图文时第几篇文章，从 1 开始
     * @return int|null
     */
    public function getIdx()
    {
        return isset($this->xml->Idx) ? (int) $this->xml->Idx : null;
    }

    /**
     * 获取xml所有节点的数据，返回一个数组
     * @return array
     */
    public function getXMLData()
    {
        $data = [];
        foreach ($this->xml as $key => $value) {
            $data[$key] = (string) $value; // 转换为字符串，去除 SimpleXMLElement 对象
        }
        return $data;
    }
}