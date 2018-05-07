<?php
namespace app\wechat\pay;
/**
 * 微信移动端服务
 */
class WechatMobilePay extends \app\base\service\BaseService {


    private function getConfig($notifyUrl = '') {
        $config = target('member/PayConfig')->getConfig('wechat_mobile');
        if (empty($config['mch_id']) || empty($config['md5_key'])) {
            return $this->error('请先配置支付接口信息!');
        }
        $notifyUrl = DOMAIN . $notifyUrl;
        return [
            'app_id' => $config['app_id'],
            'mch_id' => $config['mch_id'],
            //'sub_mch_id' => $config['mch_id'],
            'md5_key' => $config['md5_key'],
            'sign_type' => 'MD5',
            'app_cert_pem' => ROOT_PATH . $config['app_cert_pem_file'],
            'app_key_pem' => ROOT_PATH . $config['app_key_pem_file'],
            'notify_url' => $notifyUrl,
            'return_raw' => false,
        ];
    }

    public function getData($data, $returnUrl) {
        $ip = \dux\lib\Client::getUserIp();
        $payData = [
            'body' => $data['body'] ? $data['body'] : $data['title'],
            'subject' => str_len($data['title'], 125),
            'order_no' => $data['order_no'],
            'timeout_express' => time() + 604800,
            'amount' => $data['money'] ? price_format($data['money']) : 0,
            'return_param' => $data['app'],
            'client_ip' => ($ip == '::1') ? '127.0.0.1' : $ip,
            'terminal_id' => 'wap',
            'url' => DOMAIN . $returnUrl
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

        $payData['token'] = data_sign($payData);
        if(isWechat()) {
            $url = url('mobile/wechat/Pay/auth') . '?' . http_build_query($payData);
        }else {
            $url = url('mobile/wechat/Pay/browser') . '?' . http_build_query($payData);
        }
        return $this->success([
            'url' => $url
        ]);
    }

    public function getParams($data) {
        if (empty($data)) {
            return $this->error('订单数据未提交!');
        }

        $notifyUrl = url('api/wechat/WechatMobile/index');
        $config = $this->getConfig($notifyUrl);

        $payData = [
            'body' => $data['body'],
            'subject' => $data['subject'],
            'order_no' => $data['order_no'],
            'timeout_express' => $data['timeout_express'],
            'amount' => $data['amount'],
            'return_param' => $data['return_param'],
            'client_ip' => $data['client_ip'],
            'terminal_id' => $data['terminal_id'],
            'openid' => $data['openid'],
        ];
        try {
            $params = \Payment\Client\Charge::run('wx_pub', $config, $payData);
            return $this->success($params);
        } catch (\Payment\Common\PayException $e) {
            return $this->error($e->errorMessage());
        }

    }

    public function notifyPay($class) {
        dux_log('通知访问2');
        if (!is_object($class)) {
            return $this->error('通知类错误!');
        }
        $config = $this->getConfig();
        $callback = $class;
        try {
            return \Payment\Client\Notify::run('wx_charge', $config, $callback);
        } catch (\Payment\Common\PayException $e) {
            return $this->error($e->errorMessage());
        }
    }

    public function addLog($payData) {
        $data = [];
        $data['user_id'] = $payData['user_id'];
        $data['pay_no'] = $payData['pay_no'];
        $data['pay_name'] = $payData['pay_name'];
        $data['type'] = 0;
        $data['deduct'] = 0;
        $data['title'] = $payData['title'];
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
            'transaction_id' => $payInfo['pay_no'],
            'total_fee' => $payInfo['money'],
            'refund_fee' => $data['money'] ? $data['money'] : $payInfo['money'],
            'refund_no' => $payInfo['log_no'],
        ];
        if ($payData['refund_fee'] <= 0) {
            return $this->error('退款金额不正确!');
        }
        if (empty($payData['transaction_id'])) {
            return $this->error('退款单号不正确!');
        }
        $config = $this->getConfig();
        try {
            $return = \Payment\Client\Refund::run('wx_refund', $config, $payData);
            $finaceData = [];
            $finaceData['user_id'] = $data['user_id'];
            $finaceData['pay_no'] = $return['refund_id'];
            $finaceData['pay_name'] = '微信公众号';
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
