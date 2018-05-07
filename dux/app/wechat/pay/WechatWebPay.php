<?php
namespace app\wechat\pay;
/**
 * 微信移动端服务
 */
class WechatWebPay extends \app\base\service\BaseService {

    private $rsa = '';

    private function getConfig($notifyUrl = '') {
        $config = target('member/PayConfig')->getConfig('wechat_web');
        if (empty($config['mch_id']) || empty($config['md5_key'])) {
            return $this->error('请先配置支付接口信息!');
        }
        $notifyUrl = DOMAIN . $notifyUrl;
        return [
            'app_id' => $config['app_id'],
            'mch_id' => $config['mch_id'],
            'sub_mch_id' => $config['mch_id'],
            'md5_key' => $config['md5_key'],
            'sign_type' => 'MD5',
            'app_cert_pem' => ROOT_PATH . $config['app_cert_pem_file'],
            'app_key_pem' => ROOT_PATH . $config['app_key_pem_file'],
            'notify_url' => $notifyUrl,
            'return_raw' => false,
        ];
    }

    public function getData($data, $returnUrl) {
        if (empty($data)) {
            return $this->error('订单数据未提交!');
        }
        unset($data['user_id']);
        $data['return_url'] = DOMAIN . urldecode($returnUrl);
        $data['tmp'] = time();
        $data['token'] = data_sign($data);
        $url = url('wechat/WebPay/index') . '?' . http_build_query($data);
        return $this->success([
            'url' => $url
        ]);
    }

    public function notifyPay($class) {

        if (!is_object($class)) {
            return $this->error('通知类错误!');
        }
        $config = $this->getConfig();
        $callback = $class;
        try {
            return \Payment\Client\Notify::run('wx_qr', $config, $callback);
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
            $finaceData['pay_name'] = '微信网页版';
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