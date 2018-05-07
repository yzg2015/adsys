<?php

/**
 * 用户设置
 */

namespace app\member\middle;


class SettingMiddle extends \app\base\middle\BaseMiddle {


    private $config = [];


    private function getConfig() {
        if ($this->config) {
            return $this->config;
        }
        $this->config = target('member/memberConfig')->getConfig();

        return $this->config;
    }

    protected function meta($title = '', $name = '', $url = '') {
        $this->setMeta($title);
        $this->setName($name);
        $this->setCrumb([
            [
                'name' => '会员中心',
                'url' => url('member/index/index')
            ]
        ],[
            [
                'name' => $name,
                'url' => $url
            ]
        ]);
        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    protected function putInfo() {
        $data = $this->params;
        if (empty($data)) {
            return $this->stop('账号资料获取失败!');
        }
        foreach ($data as $key => $vo) {
            $data[$key] = html_clear($vo);
        }
        $userId = intval($data['user_id']);
        $data = [
            'user_id' => $userId,
            'nickname' => $data['nickname'],
            'province' => $data['province'],
            'city' => $data['city'],
            'region' => $data['region'],
            'email' => $data['email'],
            'tel' => $data['tel'],
            'sex' => intval($data['sex']) ? 1 : 0,
            'birthday' => $data['birthday'] ? strtotime($data['birthday']) : 0
        ];
        if (empty($data['nickname'])) {
            return $this->stop('请填写用户昵称!');
        }
        $data['nickname'] = \dux\lib\Str::symbolClear($data['nickname']);
        if (empty($data['nickname'])) {
            return $this->stop('昵称填写不正确，请勿使用符号!');
        }
        if (empty($data['user_id'])) {
            return $this->stop('用户获取错误!');
        }
        $info = target('member/MemberUser')->getUser($userId);

        $config = $this->getConfig();
        if (in_array($data['nickname'], explode('|', $config['reg_ban_name']))) {
            return $this->stop('当前昵称被禁止使用!');
        }
        $count = target('member/MemberUser')->where(['nickname' => $data['nickname'], '_sql' => 'user_id <> ' . $data['user_id']])->count();
        if ($count) {
            return $this->stop('该昵称已被使用!');
        }

        if(!empty($info['email'])) {
            unset($data['email']);
        }
        if(!empty($info['tel'])) {
            unset($data['tel']);
        }
        if(!empty($data['email'])) {
            if(!filter_var($data['email'], \FILTER_VALIDATE_EMAIL)) {
                return $this->stop('邮箱格式输入错误!');
            }
            $count = target('member/MemberUser')->where(['email' => $data['emall'], '_sql' => 'user_id <> ' . $data['user_id']])->count();
            if ($count) {
                return $this->stop('该邮箱已被使用!');
            }
        }

        if(!empty($data['tel'])) {
            if(!preg_match('/(^1[3|4|5|6|7|8][0-9]{9}$)/', $data['tel'])) {
                return $this->stop('手机号码输入错误!');
            }
            $count = target('member/MemberUser')->where(['tel' => $data['tel'], '_sql' => 'user_id <> ' . $data['user_id']])->count();
            if ($count) {
                return $this->stop('该手机已被使用!');
            }
        }

        if (!target('member/MemberUser')->edit($data)) {
            return $this->stop(target('member/MemberUser')->getError());
        }
        return $this->run($data, '修改资料成功!');
    }

    protected function putAvatar() {
        $userId = intval($this->params['user_id']);
        return target('member/Upload', 'middle')->setParams([
            'user_id' => $userId,
            'width' => 256,
            'height' => 256
        ])->post()->export(function ($data) use($userId) {
            $file = reset($data);
            if (!target('member/MemberUser')->avatarUser($userId,  $file['url'])) {
                return $this->stop(target('member/MemberUser')->getError());
            }
            return $this->run($data, '头像修改成功!');
        }, function ($message) {
            return $this->stop($message);
        });
    }

    protected function putPassword() {
        $userId = intval($this->params['user_id']);
        $oldPassword = $this->params['old_password'];
        $password = $this->params['password'];
        $password2 = $this->params['password2'];
        $userInfo = target('member/MemberUser')->getInfo($userId);
        if (md5($oldPassword) <> $userInfo['password']) {
            return $this->stop('原始密码输入不正确!');
        }
        if (empty($password)) {
            return $this->stop('请输入新密码!');
        }
        if ($password <> $password2) {
            return $this->stop('两次密码输入不正确!');
        }
        $data = [];
        $data['user_id'] = $userId;
        $data['password'] = md5($password);
        if (!target('member/MemberUser')->edit($data)) {
            return $this->stop('密码修改失败!');
        }
        return $this->run([], '密码修改成功!');
    }
}