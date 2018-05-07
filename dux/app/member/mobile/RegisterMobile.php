<?php

/**
 * 基础控制器
 */

namespace app\member\mobile;


class RegisterMobile extends \app\member\mobile\MemberMobile {


    protected $noLogin = true;
    protected $_middle = 'member/Register';

    public function index() {
        if (!isPost()) {
            target($this->_middle, 'middle')->meta()->data()->export(function ($data) {
                $this->assign($data);
                $this->otherDisplay('', [
                    'name' => '登录',
                    'url' => url('member/Login/index')
                ]);
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        } else {
            $userName = request('post', 'username');
            $password = request('post', 'password');
            $code = request('post', 'code');
            $remember = request('post', 'remember', 0, 'intval');
            $agreement = request('post', 'agreement', 0, 'intval');
            $imgcode = request('post', 'imgcode');
            target($this->_middle, 'middle')->setParams([
                'username' => $userName,
                'password' => $password,
                'code' => $code,
                'agreement' => $agreement,
                'imgcode' => $imgcode
            ])->post()->export(function ($loginData) use ($remember) {
                $time = $remember ? 2592000 : 86400;
                \Dux::cookie()->set('user_login', [
                    'uid' => $loginData['uid'],
                    'token' => $loginData['token']
                ], $time);
                $this->success('账号注册成功!', $this->action ? $this->action : url('member/Index/index'));

            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }

    public function getCode() {
        $userName = request('post', 'username');
        $imgcode = request('post', 'imgcode');
        target($this->_middle, 'middle')->setParams([
            'username' => $userName,
            'imgcode' => $imgcode
        ])->getCode()->export(function () {
            $this->success('验证码已发送,请注意查收!');
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }


    public function code() {
        $this->getImgCode()->showImage();
    }

    public function forgot() {
        if (!isPost()) {
            target('member/Forgot', 'middle')->meta()->data()->export(function ($data) {
                $this->assign($data);
                $this->otherDisplay('', [
                    'name' => '登录',
                    'url' => url('member/Login/index')
                ]);
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        } else {
            $userName = request('post', 'username');
            $password = request('post', 'password');
            $code = request('post', 'code');
            $imgcode = request('post', 'imgcode');
            target('member/Forgot', 'middle')->setParams([
                'username' => $userName,
                'password' => $password,
                'code' => $code,
                'imgcode' => $imgcode
            ])->post()->export(function ($loginData) {
                \Dux::cookie()->set('user_login', [
                    'uid' => $loginData['uid'],
                    'token' => $loginData['token']
                ], 86400);
                $this->success('密码修改成功!', $this->action ? $this->action : url('member/Index/index'));
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }


    public function agreement() {
        target('member/Agreement', 'middle')->meta()->data()->export(function ($data) {
            $this->assign($data);
            $this->otherDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }


}