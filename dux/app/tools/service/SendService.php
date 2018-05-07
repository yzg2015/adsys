<?php
namespace app\tools\service;
/**
 * 发送接口
 */
class SendService {

    /**
     * 获取推送种类
     */
    public function getClassSend() {
        return [
            'sms' => [
                'name' => '短信',
                'editor' => false,
            ],
            'mail' => [
                'name' => '邮件',
                'editor' => true,
                'common' => 'html'
            ],
            'app' => [
                'name' => 'APP',
                'editor' => false,
            ],
            'site' => [
                'name' => '站内信',
                'editor' => false,
            ],

        ];

    }

    /**
     * 获取推送结构
     */
    public function getTypeSend() {
        return array(
            'email' => array(
                'name' => 'SMTP邮件',
                'target' => 'tools/Email',
                'class' => 'mail',
                'configRule' => array(
                    'smtp_host' => '发信地址',
                    'smtp_port' => '发信端口',
                    'smtp_ssl' => '安全链接',
                    'smtp_username' => '发信用户',
                    'smtp_password' => '发信密码',
                    'smtp_from_to' => '发信邮箱',
                    'smtp_from_name' => '发件人',
                )
            ),
            'almail' => array(
                'name' => '阿里邮件',
                'target' => 'tools/AliMail',
                'class' => 'mail',
                'configRule' => array(
                    'id' => 'API账号',
                    'key' => 'API密钥',
                    'mail' => '发信地址',
                )
            ),
            'yunpian' => array(
                'name' => '云片短信',
                'target' => 'tools/YunPian',
                'class' => 'sms',
                'configRule' => array(
                    'apikey' => 'API秘钥',
                    'name' => '签名',
                )
            ),
            'chuanglan' => array(
                'name' => '创蓝短信',
                'target' => 'tools/ChuangLan',
                'class' => 'sms',
                'configRule' => array(
                    'account' => 'API账号',
                    'password' => 'API密码',
                    'label' => '签名',
                )
            ),
            'xiaomi' => array(
                'name' => '小米推送',
                'target' => 'tools/Xiaomi',
                'class' => 'app',
                'configRule' => array(
                    'ios_key' => 'IOS密钥',
                    'android_key' => '安卓密钥',
                    'android_name' => '安卓包名',
                )
            ),
            'site' => array(
                'name' => '会员通知',
                'target' => 'tools/Site',
                'class' => 'site',
                'configRule' => array(
                )
            ),
        );
    }
}

