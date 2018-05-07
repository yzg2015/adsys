<?php

/**
 * 领券中心
 */

namespace app\order\controller;


class CouponController extends \app\base\controller\SiteController {

    protected $_middle = 'order/Coupon';

    public function index() {
        $type = request('get', 'type');
        $urlParams = [
            'type' => $type
        ];
        target($this->_middle, 'middle')->setParams([
            'type' => $type
        ])->meta()->data()->export(function ($data) use ($urlParams) {
            $this->assign($data);
            $this->assign('page', $this->htmlPage($data['pageData']['raw'], $urlParams));
            $this->siteDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }


    public function receive() {
        target($this->_middle, 'middle')->setParams([
            'user_id' => target('member/MemberUser')->getUid(),
            'coupon_id' => request('', 'id')
        ])->receive()->export(function ($data, $msg) {
            $this->success($msg);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }


}