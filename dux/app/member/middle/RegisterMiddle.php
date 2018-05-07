<?php

/**
 * 基础控制器
 */

namespace app\member\middle;


class RegisterMiddle extends \app\base\middle\BaseMiddle {


    private $config = [];

    /**
     * 媒体信息
     */
    protected function meta() {
        $this->setMeta('注册');
        $this->setName('注册');
        $this->setCrumb([
            [
                'name' => '注册',
                'url' => url()
            ]
        ]);

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    private function getConfig() {
        if ($this->config) {
            return $this->config;
        }
        $this->config = target('member/memberConfig')->getConfig();

        return $this->config;
    }

    private function getNameTip() {
        $this->config = $this->getConfig();
        $nameTip = '手机号/邮箱';
        if ($this->config['reg_type'] == 'email') {
            $nameTip = '邮箱';
        }
        if ($this->config['reg_type'] == 'tel') {
            $nameTip = '手机号码';
        }

        return $nameTip;
    }

    protected function data() {
        $hookField = [];
        $hookList = run('service', 'member', 'regField');

        foreach ($hookList as $app => $vo) {
            if (!empty($vo)) {
                $hookField = array_merge($hookField, $vo);
            }
        }
        return $this->run([
            'nameTip' => $this->getNameTip(),
            'hookField' => $hookField,
            'userConfig' => $this->config,
        ]);
    }

    protected function post() {
        $this->config = $this->getConfig();
        $model = target('member/MemberUser');
        $model->beginTransaction();
        $userName = $this->params['username'];
        $password = $this->params['password'];
        $code = $this->params['code'];
        if (empty($userName) || empty($password)) {
            return $this->stop('用户名或密码未填写！');
        }
        $agreement = intval($this->params['agreement']);
        if (!$agreement) {
            return $this->stop('请先阅读注册协议!');
        }
        if ($this->config['verify_image']) {
            $imgCode = new \dux\lib\Vcode(90, 37, 4, '', 'code');
            if (!$imgCode->check($this->params['imgcode'])) {
                return $this->stop('图片验证码输入不正确!');
            }
        }
        target('member/MemberUser')->beginTransaction();
        $loginData = target('member/Member', 'service')->regUser($userName, $password, $code);
        if (!$loginData) {
            target('member/MemberUser')->rollBack();

            return $this->stop(target('member/Member', 'service')->getError());
        }
        $model->commit();

        $loginData = target('member/Member', 'service')->loginUser($userName, $password);
        if (!$loginData) {
            return $this->stop(target('member/Member', 'service')->getError());
        }
        return $this->run($loginData);
    }

    protected function getCode() {
        $config = $this->getConfig();
        $imgCode = new \dux\lib\Vcode(90, 37, 4, '', 'code');
        if (!$imgCode->check($this->params['imgcode']) && $config['verify_image']) {
            return $this->stop('图片验证码输入不正确!');
        }
        if (!target('member/Member', 'service')->getVerify($this->params['username'])) {
            return $this->stop(target('member/Member', 'service')->getError());
        }
        return $this->run();
    }

}