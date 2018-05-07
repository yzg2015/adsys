<?php

/**
 * 支付宝移动端通知
 */

namespace app\member\api;

use Payment\Notify\PayNotifyInterface;

class AlipayWebApi implements PayNotifyInterface {

    /**
     * 异步回调
     */
    public function index() {
        dux_log('test');
        echo target('member/AlipayWeb', 'pay')->notifyPay($this);
    }

    /**
     * 接口回调
     * @param array $data
     * @return bool
     */
    public function notifyProcess(array $data) {
        dux_log('通知回调');
        dux_log(json_encode($data));
        if ($data['trade_state'] <> 'success') {
            dux_log('支付状态失败');
            return false;
        }
        $orderNo = $data['order_no'];
        if (empty($orderNo)) {
            dux_log('支付号错误');
            return false;
        }
        $model = target('member/PayRecharge');
        dux_log($data);

        $app = $data['return_param'];
        dux_log($app);

        $callbackList = target('member/PayConfig')->callbackList();
        $callbackInfo = $callbackList[$app];

        $model->beginTransaction();
        if(!target($callbackInfo['target'], 'service')->pay($orderNo, $data['amount'], '支付宝WEB', $data['transaction_id'], 0, 'alipay_web')) {
            $model->rollBack();
            dux_log(target($callbackInfo['target'], 'service')->getError());
            return false;
        }
        $model->commit();
        return true;
    }

}