<?php
namespace app\wechat\service;
/**
 * 登录接口
 */
class LoginService {

    /**
     * 获取登录接口
     */
    public function getMemberLogin() {
        return [
            'wechat' => [
                'name' => '微信登录',
                'url' => url('mobile/wechat/Login/index'),
                'jump' => true,
                'check' => true,
                'platform' => 'mobile',
            ],
        ];
    }
}

