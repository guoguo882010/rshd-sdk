<?php

namespace RSHDSDK\WeChat;

/**
 * 公众号被动回复消息
 * 被动回复消息是，公众号访问开发者配置的url，这个url返回一个xml结构的字符串
 * 公众号服务器读取这个xml字符串，然后在发送给客户
 * 开发者的url只需要在html页面显示xml字符串便可以正确响应
 * 注意：返回的html页面不能包含其他多余的信息，比如调试信息
 * @since 2.14
 * @see https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Passive_user_reply_message.html
 */
class OfficialSendXMLMessage
{
    /**
     * @param string $msgType
     * @param string $toUser
     *
     * @param string $fromUser
     * @param string $content
     * @return string
     */
    protected static function formatXML($msgType, $toUser, $fromUser, $content)
    {
        return sprintf(
            "<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%d</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              %s
            </xml>",
            $toUser, $fromUser, time(), $msgType, $content
        );
    }

    /**
     * 回复文本消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser 开发者微信号
     * @param string $content 文本消息
     * @return string
     */
    public static function getTextXML($toUser, $fromUser, $content)
    {
        $body = sprintf("<Content><![CDATA[%s]]></Content>", $content);
        return self::formatXML("text", $toUser, $fromUser, $body);
    }

    /**
     * 回复图片消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser
     * @param string $mediaId
     * @return string
     */
    public static function getImageXML($toUser, $fromUser, $mediaId)
    {
        $body = sprintf("<Image><MediaId><![CDATA[%s]]></MediaId></Image>", $mediaId);
        return self::formatXML("image", $toUser, $fromUser, $body);
    }

    /**
     * 回复语音消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser
     * @param string $mediaId
     * @return string
     */
    public static function getVoiceXML($toUser, $fromUser, $mediaId)
    {
        $body = sprintf("<Voice><MediaId><![CDATA[%s]]></MediaId></Voice>", $mediaId);
        return self::formatXML("voice", $toUser, $fromUser, $body);
    }

    /**
     * 回复视频消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser
     * @param string $mediaId
     * @param string $title
     * @param string $description
     * @return string
     */
    public static function getVideoXML($toUser, $fromUser, $mediaId, $title, $description)
    {
        $body = sprintf(
            "<Video>
              <MediaId><![CDATA[%s]]></MediaId>
              <Title><![CDATA[%s]]></Title>
              <Description><![CDATA[%s]]></Description>
            </Video>",
            $mediaId, $title, $description
        );
        return self::formatXML("video", $toUser, $fromUser, $body);
    }

    /**
     * 回复音乐消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser
     * @param string $mediaId
     * @param string $title
     * @param string $description
     * @param string $musicURL
     * @param string $HQMusicUrl
     * @return string
     */
    public static function getMusicXML($toUser, $fromUser, $mediaId, $title, $description, $musicURL, $HQMusicUrl)
    {
        $body = sprintf(
            "<Music>
              <Title><![CDATA[%s]]></Title>
              <Description><![CDATA[%s]]></Description>
              <MusicUrl><![CDATA[%s]]></MusicUrl>
              <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
              <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
            </Music>",
            $title, $description, $musicURL, $HQMusicUrl, $mediaId
        );
        return self::formatXML("music", $toUser, $fromUser, $body);
    }

    /**
     * 回复图文消息
     * @param string $toUser 接收方账号（收到的OpenID）
     * @param string $fromUser
     * @param array $news
     * @return string
     */
    public static function getNewsXML($toUser, $fromUser, $news)
    {
        $articleCount = count($news);
        $articlesXML = "";

        foreach ($news as $new) {
            $articlesXML .= sprintf(
                "<item>
                  <Title><![CDATA[%s]]></Title>
                  <Description><![CDATA[%s]]></Description>
                  <PicUrl><![CDATA[%s]]></PicUrl>
                  <Url><![CDATA[%s]]></Url>
                </item>",
                $new['title'], $new['description'], $new['picurl'], $new['url']
            );
        }

        $body = sprintf("<ArticleCount>%d</ArticleCount><Articles>%s</Articles>", $articleCount, $articlesXML);
        return self::formatXML("news", $toUser, $fromUser, $body);
    }
}