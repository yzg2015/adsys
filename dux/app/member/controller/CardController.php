<?php

/**
 * 银行卡管理
 */

namespace app\member\controller;

class CardController extends \app\member\controller\MemberController {

    protected $_middle = 'member/Card';

    public function index() {
        if (!isPost()) {
            target($this->_middle, 'middle')->setParams([
                'user_id' => $this->userInfo['user_id']
            ])->meta()->info()->export(function ($data) {
                if(empty($data['info']) || empty($data['realInfo'])) {
                    $this->error('请先完成认证！', url('member/Real/index'));
                }
                $this->assign($data);
                $this->memberDisplay();
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
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
}