<?php

/**
 * 微信支付
 */

namespace app\wechat\mobile;

class PayMobile extends  \app\member\mobile\MemberMobile {

    protected $noLogin = true;
    protected $_middle = 'wechat/MobilePay';

    protected $oauth = null;
    public $wechat = null;
    public $config = [];

    public function initPay($url = '') {
        $target = target('wechat/Wechat', 'service');
        $target->init([
            'oauth_url' => $url ? $url : url('index')
        ]);
        $this->wechat = $target->wechat();
        $this->config = $target->config();
        $this->oauth = $this->wechat->oauth;
    }

    public function auth() {
        $data = request('get');
        $this->initPay(url('index') . '?' . http_build_query($data));
        $response = $this->oauth->redirect();
        $response->send();
    }


    public function index() {
        $getData = request('get');
        if(empty($getData['openid'])) {
            $this->initPay();
            $user = $this->oauth->user();
            $getData['openid'] = $user->getId();
            $this->redirect(url('index') . '?' . http_build_query($getData));
        }

        //$payUrl = url("index", $getData, true, false, false);
        //$payUrl = $this->wechat->url->shorten($payUrl);

        $openId = $getData['openid'];
        $token = $getData['token'];
        $getData = [
            'body' => urldecode($getData['body']),
            'subject' => urldecode($getData['subject']),
            'order_no' => $getData['order_no'],
            'timeout_express' => $getData['timeout_express'],
            'amount' => $getData['amount'],
            'return_param' => $getData['return_param'],
            'client_ip' => $getData['client_ip'],
            'terminal_id' => $getData['terminal_id'],
            'url' => $getData['url'],
        ];
        if(!data_sign_has($getData, $token)) {
            $this->error('支付数据验证失败!');
        }

        $getData['openid'] = $openId;
        $data = target('wechat/WechatMobile', 'pay')->getParams($getData);
        if(!$data) {
            $this->errorCallback(target('wechat/WechatMobile', 'pay')->getError());
        }
        $data['url'] = $getData['url'];
        target($this->_middle, 'middle')->meta()->export(function ($pageData) use ($data, $getData) {
            $this->assign($pageData);
            $this->assign('getData', $getData);
            $this->assign('data', $data);
            $this->memberDisplay('', false);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function browser() {
        $getData = request('get');
        $this->initPay();
        $payUrl = url("auth", $getData, true, false, false);
        $urlData = $this->wechat->url->shorten($payUrl);
        $shareUrl = $urlData['short_url'];
        target($this->_middle, 'middle')->meta()->export(function ($data) use ($shareUrl, $getData) {
            $this->assign($data);
            $this->assign('getData', $getData);
            $this->assign('shareUrl', $shareUrl);
            $this->memberDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

}