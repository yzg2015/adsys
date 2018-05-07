<?php

/**
 * 实名认证
 */

namespace app\member\controller;

class RealController extends \app\member\controller\MemberController {

    protected $_middle = 'member/Real';

    public function index() {
        if (!isPost()) {
            target($this->_middle, 'middle')->setParams([
                'user_id' => $this->userInfo['user_id']
            ])->meta()->info()->export(function ($data) {
                $this->assign($data);
                $this->memberDisplay();
            });
        } else {
            $data = request('post');
            target($this->_middle, 'middle')->setParams(
                array_merge($data, [
                    'user_info' => $this->userInfo,
                    'val_type' => $data['valtype'],
                    'user_id' => $this->userInfo['user_id']
                ]))->post()->export(function ($data, $msg) {
                $this->success($msg);
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }

    public function getCode() {
        $valType = request('post', 'valtype');
        $imgCode = request('post', 'imgcode');
        target($this->_middle, 'middle')->setParams([
            'user_info' => $this->userInfo,
            'val_type' => $valType,
            'img_code' => $imgCode
        ])->getCode()->export(function ($data, $msg) {
            $this->success($msg);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }
}