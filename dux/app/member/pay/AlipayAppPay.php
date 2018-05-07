<?php
namespace app\member\pay;
/**
 * 支付宝WEB端服务
 */
class AlipayAppPay extends \app\base\service\BaseService {


    public function getConfig() {
        $config = target('member/PayConfig')->getConfig('alipay_app');
        if (empty($config['partner']) || empty($config['key'])) {
            return $this->error('请先配置支付接口信息!');
        }
        $notifyUrl = url('api/member/AlipayApp/index', [], true);
        $config = [
            'partner' => $config['partner'],
            'app_id' => $config['appid'],
            'sign_type' => 'RSA2',
            'ali_public_key' => $config['public_key'],
            'rsa_private_key' => $this->strPem($config['private_file']),
            "notify_url" => $notifyUrl,
            'return_raw' => false,
        ];
        return $config;
    }

    public function getData($data) {
        if (empty($data)) {
            return $this->error('订单数据未提交!');
        }
        $config = $this->getConfig();
        $payData = [
            'order_no' => $data['order_no'],
            'amount' => $data['money'] ? price_format($data['money']) : 0,
            'subject' => str_len($data['title'], 125),
            'body' => $data['body'] ? $data['body'] : $data['title'],
            'return_param' => $data['app'],
            'timeout_express' => time() + 604800
        ];

        if (empty($payData['order_no'])) {
            return $this->error('订单号不能为空!');
        }
        if ($payData['amount'] <= 0) {
            return $this->error('支付金额不正确!');
        }
        if (empty($payData['subject']) || empty($payData['body'])) {
            return $this->error('支付信息描述不正确!');
        }
        if (empty($payData['return_param'])) {
            return $this->error('订单应用名不正确!');
        }
        try {
            $str = \Payment\Client\Charge::run('ali_app', $config, $payData);
            return $this->success($str);
        } catch (\Payment\Common\PayException $e) {
            return $this->error($e->errorMessage());
        }
    }


    public function notifyPay($class) {
        dux_log('notifyPay');
        if (!is_object($class)) {
            return $this->error('通知类错误!');
        }
        $config = $this->getConfig();
        $callback = $class;
        try {
            return \Payment\Client\Notify::run('ali_charge', $config, $callback);
        } catch (\Payment\Common\PayException $e) {
            dux_log($e->errorMessage());
            return $this->error($e->errorMessage());
        }
    }


    public function strPem($file) {
        $file = ROOT_PATH . $file;
        $str = file_get_contents($file);
        $strData = explode("\n", $str);
        $strData = array_filter($strData);
        if(strstr($strData[0], '---') !== false) {
            array_shift($strData);
        }
        if(strstr(end($strData), '---') !== false) {
            array_pop($strData);
        }
        return implode('', $strData);
    }

    public function addLog($payData) {
        $data = [];
        $data['user_id'] = $payData['user_id'];
        $data['pay_no'] = $payData['pay_no'];
        $data['pay_name'] = $payData['pay_name'];
        $data['type'] = 0;
        $data['deduct'] = 0;
        $data['title']  = $payData['title'];
        $data['remark'] = $payData['remark'];
        $data['money'] = $payData['money'];
        $data['source_value'] = $payData['source_value'];
        $data['source_url'] = $payData['source_url'];
        $payId = target('member/Finance', 'service')->account($data);
        if (!$payId) {
            return $this->error(target('member/Finance', 'service')->getError());
        }
        return $payId;
    }

    public function getLog($id) {
        return target('member/PayLog')->getInfo($id);
    }

    public function refund($data) {
        $payInfo = target('member/PayLog')->getInfo($data['id']);
        if(empty($payInfo)) {
            return $this->error('未发现支付记录!');
        }
        $payData = [
            'trade_no' => $payInfo['pay_no'],
            'reason' => $data['remark'],
            'refund_fee' => $data['money'] ? $data['money'] : $payInfo['money'],
            'refund_no' => $payInfo['log_no'],
        ];
        if ($payData['refund_fee'] <= 0) {
            return $this->error('退款金额不正确!');
        }
        if (empty($payData['trade_no'])) {
            return $this->error('退款单号不正确!');
        }
        $config = $this->getConfig();
        try {
            $return = \Payment\Client\Refund::run('ali_refund', $config, $payData);
            $finaceData = [];
            $finaceData['user_id'] = $data['user_id'];
            $finaceData['pay_no'] = $return['transaction_id'];
            $finaceData['pay_name'] = '支付宝APP';
            $finaceData['type'] = 1;
            $finaceData['deduct'] = 0;
            $finaceData['title'] = $data['title'];
            $finaceData['remark'] = $data['remark'];
            $finaceData['money'] = $payData['refund_fee'];
            $payId = target('member/Finance', 'service')->account($finaceData);
            if (!$payId) {
                return $this->error(target('member/Finance', 'service')->getError());
            }
            return $this->success($return);
        } catch (\Payment\Common\PayException $e) {
            return $this->error($e->errorMessage());
        }
    }


}