<?php

/**
 * 收货地址
 */

namespace app\order\controller;

class AddressController extends \app\member\controller\MemberController {


    protected $_middle = 'order/Address';

    public function index() {
        target($this->_middle, 'middle')->setParams([
            'user_id' => $this->userInfo['user_id']
        ])->meta('收货地址', '收货地址')->data()->export(function ($data) {
            $this->assign($data);
            $this->memberDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function add() {
        if(!isPost()) {
            target($this->_middle, 'middle')->meta('添加地址', '添加地址')->export(function ($data) {
                $this->assign($data);
                $this->memberDisplay('info');
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
            $this->memberDisplay();
        }else {
            target($this->_middle, 'middle')->setParams(array_merge(request('post'), ['user_id' => $this->userInfo['user_id']]))->add()->export(function ($data, $msg) {
                if($this->action) {
                    $url = $this->action;
                }else {
                    $url = url('index');
                }
                if($data['refresh']) {
                    $url = '';
                }
                $this->success($msg, $url);
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }

    public function edit() {
        if(!isPost()) {
            target($this->_middle, 'middle')->setParams([
                'id' => request('get', 'id'),
                'user_id' => $this->userInfo['user_id']
            ])->meta('编辑地址', '编辑地址')->info()->export(function ($data) {
                $this->assign($data);
                $this->memberDisplay('info');
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }else {
            target($this->_middle, 'middle')->setParams(array_merge(request('post'), ['user_id' => $this->userInfo['user_id']]))->edit()->export(function ($data, $msg) {
                if($this->action) {
                    $url = $this->action;
                }else {
                    $url = url('index');
                }
                if($data['refresh']) {
                    $url = '';
                }
                $this->success($msg, $url);
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }

    public function del() {
        target($this->_middle, 'middle')->setParams([
            'id' => request('get', 'id'),
            'user_id' => $this->userInfo['user_id']
        ])->del()->export(function ($data, $msg) {
            $this->success($msg);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function setting() {
        target($this->_middle, 'middle')->setParams([
            'id' => request('get', 'id'),
            'user_id' => $this->userInfo['user_id']
        ])->default()->export(function ($data, $msg) {
            $this->success($msg);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

}