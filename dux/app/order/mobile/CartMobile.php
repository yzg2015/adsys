<?php

/**
 * 购物车
 */

namespace app\order\mobile;

class CartMobile extends \app\member\mobile\MemberMobile {


    public function index() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id']
        ])->meta()->data()->export(function ($data) {
            $this->assign($data);
            $navData = [];
            if($data['cartData']) {
                $navData = [
                    'name' => '编辑',
                    'url' => 'javascript:;'
                ];
            }
            $this->memberDisplay('', true, $navData);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function submit() {
        if (!isPost()) {
            $urlParams = [
                'user_id' => $this->userInfo['user_id'],
                'add_id' => request('get', 'add_id'),
                'cod_status' => request('get', 'cod_status'),
                'take_id' => request('get', 'take_id'),
                'coupon_id' => request('get', 'coupon_id'),
                'platform' => 'mobile'
            ];
            target('order/CartSubmit', 'middle')->setParams($urlParams)->meta()->data()->export(function ($data) {
                $this->assign($data);
                $this->memberDisplay();
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        } else {
            target('order/CartSubmit', 'middle')->setParams([
                'user_id' => $this->userInfo['user_id'],
                'add_id' => request('get', 'add_id'),
                'cod_status' => request('', 'cod_status'),
                'coupon_id' => request('', 'coupon_id'),
                'take_id' => request('', 'take_id'),
            ])->post()->export(function ($data) {
                if(!$data['cod_status']) {
                    $this->success('订单提交成功,请选择付款方式!', url('order/Pay/index', ['order_no' => $data['order_no']]));
                }else {
                    $this->success('订单提交成功,请耐心等待发货!', url('member/Index/index'));
                }
            }, function ($message, $code, $url) {
                $this->errorCallback($message, $code, $url);
            });
        }
    }

    public function num() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'rowid' => request('post', 'rowid'),
            'qty' => request('post', 'qty')
        ])->put()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function checked() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'checked' => request('post', 'checked'),
            'uncheck' => request('post', 'uncheck')
        ])->checked()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function del() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'rowid' => request('post', 'rowid'),
        ])->delete()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function getJson() {
        $info = target('order/Cart', 'service')->getCart($this->userInfo['user_id']);
        if (!empty($info)) {
            $this->success($info);
        } else {
            $this->error('您的购物车还没有商品，赶紧去选购吧!');
        }
    }

}