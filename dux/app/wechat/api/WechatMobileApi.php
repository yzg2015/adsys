<?php

/**
 * 支付宝公众号支付
 */

namespace app\wechat\api;

use Payment\Notify\PayNotifyInterface;

class WechatMobileApi implements PayNotifyInterface {

    /**
     * 异步回调
     */
    public function index() {
        echo target('wechat/WechatMobile', 'pay')->notifyPay($this);
    }

    /**
     * 接口回调
     * @param array $data
     * @return bool
     */
    public function notifyProcess(array $data) {
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

        $app = $data['return_param'];
        dux_log($app);

        $callbackList = target('member/PayConfig')->callbackList();
        $callbackInfo = $callbackList[$app];

        $model->beginTransaction();
        if(!target($callbackInfo['target'], 'service')->pay($orderNo, $data['amount'], '微信公众号', $data['transaction_id'], 0, 'wechat_mobile')) {
            $model->rollBack();
            dux_log(target($callbackInfo['target'], 'service')->getError());
            return false;
        }
        $model->commit();
        return true;
    }

}