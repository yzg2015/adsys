<?php

/**
 * 交易记录
 */

namespace app\member\controller;


class FinanceController extends \app\member\controller\MemberController {

    protected $_middle = 'member/Finance';

    public function index() {
        $type = request('get', 'type');
        $urlParams = [
            'type' => $type
        ];
        target($this->_middle, 'middle')->setParams([
            'account_id' => $this->userInfo['finance_account_id'],
            'type' => $type
        ])->meta('账户资金', '账户资金', url())->statistical()->export(function ($data) use ($urlParams) {
            $this->assign($data);
            $this->memberDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function log() {
        $type = request('get', 'type');
        $urlParams = [
            'type' => $type
        ];
        target($this->_middle, 'middle')->setParams([
            'account_id' => $this->userInfo['finance_account_id'],
            'type' => $type
        ])->meta('交易记录', '交易记录', url())->data()->export(function ($data) use ($urlParams) {
            $this->assign($data);
            $this->assign('urlParams', $urlParams);
            $this->assign('page', $this->htmlPage($data['pageData']['raw'], $urlParams));
            $this->memberDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }


}