<?php

/**
 * 领券中心
 */

namespace app\order\middle;

class CouponMiddle extends \app\base\middle\BaseMiddle {

    private $_model = 'order/OrderCoupon';


    protected function meta() {
        $this->setMeta('领券中心');
        $this->setName('领券中心');
        $this->setCrumb([
            [
                'name' => '领券中心',
                'url' => URL
            ]
        ]);

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }


    protected function data() {
        $type = $this->params['type'];
        $where = [];
        if ($type) {
            $where['type'] = $type;
        }
        $pageLimit = $this->params['limit'] ? $this->params['limit'] : 20;

        $model = target($this->_model);
        $count = $model->countList($where);
        $pageData = $this->pageData($count, $pageLimit);
        $list = $model->loadList($where, $pageData['limit'], 'coupon_id desc');
        $typeList = $model->typeList();

        return $this->run([
            'type' => $type,
            'pageData' => $pageData,
            'countList' => $count,
            'pageList' => $list,
            'pageLimit' => $pageLimit,
            'typeList' => $typeList,
        ]);
    }

    protected function receive() {
        $userId = intval($this->params['user_id']);
        $couponId= intval($this->params['coupon_id']);
        $info = target($this->_model)->getInfo($couponId);
        if(empty($userId)) {
            return $this->stop('您尚未登录！');
        }
        if(empty($info)) {
            return $this->stop('该优惠券不存在！');
        }
        if(!$info['status']) {
            return $this->stop('该优惠券已下架！');
        }
        if($info['start_time'] > time()) {
            return $this->stop('该优惠券未到领取时间！');
        }
        if($info['end_time'] < time()) {
            return $this->stop('该优惠券已过领取时间！');
        }
        $logInfo = target('order/OrderCouponLog')->getWhereInfo([
            'A.coupon_id' => $couponId,
            'A.user_id' => $userId
        ]);
        if(!empty($logInfo)) {
            return $this->stop('您已领取过该券！');
        }

        if($info['exchange_price']) {
            $currencyList = target('member/MemberCurrency')->typeList();
            $status = target($currencyList[$info['exchange_type']]['target'], 'service')->payAmount($info['exchange_type'], $userId, $info['exchange_price'], '', '账号支付', '优惠券', '优惠券兑换', 0);
            if(!$status) {
                return $this->stop(target($currencyList[$info['exchange_type']]['target'], 'service')->getError());
            }
        }
        $data = [
            'user_id' => $userId,
            'coupon_id' => $couponId,
            'start_time' => time(),
            'end_time' => time() + $info['expiry_day'] * 86400,
        ];
        if(!target('order/OrderCouponLog')->add($data)) {
            return $this->stop(target('order/OrderCouponLog')->getError());
        }
        $status = target($this->_model)->edit([
            'coupon_id' => $couponId,
            'stock' => $info['stock']-1,
            'receive' => $info['receive']+1
        ]);
        if(!$status) {
            return $this->stop(target($this->_model)->getError());
        }
        return $this->run([], '领券成功！');


    }


}