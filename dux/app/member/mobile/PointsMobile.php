<?php

/**
 * 积分记录
 */

namespace app\member\mobile;


class PointsMobile extends \app\member\mobile\MemberMobile {

    protected $_middle = 'member/Points';

    public function index() {
        $type = request('get', 'type');
        $urlParams = [
            'type' => $type
        ];
        $type = request('get', 'type');
        target($this->_middle, 'middle')->setParams([
            'account_id' => $this->userInfo['finance_account_id'],
            'type' => $type
        ])->meta()->data()->export(function ($data) use ($urlParams) {
            $this->assign($data);
            $this->assign('urlParams', $urlParams);
            $this->assign('page', $this->htmlPage($data['pageData']['raw'], $urlParams));
            $this->memberDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }



}