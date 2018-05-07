<?php

/**
 * 购物车
 */
namespace app\order\api;

class CartApi extends \app\member\api\MemberApi {

    public function index() {

        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id']
        ])->meta()->data()->export(function ($data) {
            $this->success('ok', $data);
        }, function ($message, $code) {
            $this->error($message, $code);
        });
    }

    public function submit() {
        if (!isPost()) {
            target('order/CartSubmit', 'middle')->setParams([
                'user_id' => $this->userInfo['user_id'],
                'add_id' => $this->data['add_id'],
                'cod_status' => $this->data['cod_status'],
                'take_id' => $this->data['take_id'],
            ])->meta()->data()->export(function ($data) {
                $this->success('ok', $data);
            }, function ($message, $code) {
                $this->error($message, $code);
            });
        } else {
            target('order/CartSubmit', 'middle')->setParams([
                'user_id' => $this->userInfo['user_id'],
                'add_id' => $this->data['add_id'],
                'cod_status' => $this->data['cod_status'],
                'coupon' => $this->data['coupon'],
                'take_id' => $this->data['take_id'],
            ])->post()->export(function ($data) {
                if(!$data['cod_status']) {
                    $this->success('订单提交成功,请选择付款方式!', $data);
                }else {
                    $this->success('订单提交成功,请耐心等待发货!');
                }
            }, function ($message, $code) {
                $this->error($message, $code);
            });
        }
    }


    public function num() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'rowid' => $this->data['rowid'],
            'qty' => $this->data['qty'],
        ])->put()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code) {
            $this->error($message, $code);
        });
    }

    public function checked() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'checked' => $this->data['checked'],
            'uncheck' => $this->data['uncheck'],
        ])->checked()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code) {
            $this->error($message, $code);
        });
    }

    public function del() {
        target('order/Cart', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
            'rowid' => $this->data['rowid'],
        ])->delete()->export(function ($data) {
            $this->success($data);
        }, function ($message, $code) {
            $this->error($message, $code);
        });
    }

}