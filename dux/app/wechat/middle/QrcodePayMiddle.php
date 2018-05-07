<?php

/**
 * 微信支付
 */

namespace app\wechat\middle;


class QrcodePayMiddle extends \app\base\middle\BaseMiddle {



    protected function meta() {
        $this->setMeta('微信支付');
        $this->setName('微信支付');
        $this->setCrumb([
            [
                'name' => '微信支付',
                'url' => url()
            ]
        ]);

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    protected function data() {
        $token = $this->params['token'];
        $data = $this->params['data'];
        unset($data['token']);
        if(!data_sign_has($data, $token)) {
            return $this->stop('token验证失败!');
        }

        if($data['tmp'] + 300 < time()) {
            return $this->stop('支付已过期，请重新支付！');
        }

        //扫码支付
        $notifyUrl = url('api/wechat/WechatWeb/index');

        $config = $this->payConfig($notifyUrl);

        if(empty($config)) {
            return $this->stop('请先配置支付信息');
        }

        $ip = \dux\lib\Client::getUserIp();

        $payData = [
            'body' => $data['body'] ? $data['body'] : $data['title'],
            'subject' => str_len($data['title'], 125),
            'order_no' => $data['order_no'],
            'timeout_express' => time() + 604800,
            'amount' => $data['money'] ? price_format($data['money']) : 0,
            'return_param' => $data['app'],
            'client_ip' => ($ip == '::1') ? '127.0.0.1' : $ip,
            'product_id' => $data['order_no'],
            'terminal_id' => 'web',
            'return_raw' => false,
        ];

        if (empty($payData['order_no'])) {
            return $this->stop('订单号不能为空!');
        }
        if(bccomp($payData['amount'], 0, 2)  !== 1) {
            return $this->stop('支付金额不正确!');
        }
        if (empty($payData['subject']) || empty($payData['body'])) {
            return $this->stop('支付信息描述不正确!');
        }
        if (empty($payData['return_param'])) {
            return $this->stop('订单应用名不正确!');
        }
        try {
            $str = \Payment\Client\Charge::run('wx_qr', $config, $payData);
            return $this->run([
                'code' => $str,
                'money' => $data['money'],
                'returnUrl' => $data['return_url'],
                'orderNo' => $data['order_no']
            ]);
        } catch (\Payment\Common\PayException $e) {
            if($e->errorMessage() == '微信返回错误提示:该订单已支付') {
                return $this->stop('支付成功!', 302, $data['return_url']);
            }else {
                return $this->stop($e->errorMessage());
            }
        }
    }

    protected function status() {
        $orderNo = $this->params['order_no'];
        if(empty($orderNo)) {
            return $this->stop('订单号不存在!');
        }

        $query = new \Payment\QueryContext();
        $notifyUrl = url('api/wechat/WechatMobile/index');
        $config = $this->payConfig($notifyUrl);
        try {
            $query->initQuery('wx_charge', $config);
            $data = $query->query(['out_trade_no' => $orderNo]);
            if(empty($data)) {
                return $this->stop('支付查询失败');
            }
            if($data['is_success'] == 'T') {
                return $this->run([], '订单支付成功!');
            }
            return $this->stop('查询请求失败:' . $data['error']);

        } catch (\Payment\Common\PayException $e) {
            return $this->stop($e->errorMessage());
        }
    }




    private function payConfig($notifyUrl = '') {
        $config = target('member/PayConfig')->getConfig('wechat_web');
        if (empty($config['mch_id']) || empty($config['md5_key'])) {
            return [];
        }
        $notifyUrl = DOMAIN . $notifyUrl;
        return [
            'app_id' => $config['app_id'],
            'mch_id' => $config['mch_id'],
            'sub_mch_id' => $config['mch_id'],
            'md5_key' => $config['md5_key'],
            'sign_type' => 'MD5',
            'app_cert_pem' => ROOT_PATH . $config['app_cert_pem_file'],
            'app_key_pem' => ROOT_PATH . $config['app_key_pem'],
            'notify_url' => $notifyUrl,
            'return_raw' => false,
        ];

    }

}