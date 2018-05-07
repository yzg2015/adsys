<?php

/**
 * 购物车提交
 */

namespace app\order\middle;


class CartSubmitMiddle extends \app\base\middle\BaseMiddle {


    /**
     * 媒体信息
     */
    protected function meta() {
        $this->setMeta('结算购物车');
        $this->setName('结算购物车');
        $this->setCrumb([
            [
                'name' => '结算购物车',
                'url' => url()
            ]
        ]);

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    protected function data() {
        $this->params['user_id'] = intval($this->params['user_id']);
        $addId = intval($this->params['add_id']);
        $codStatus = intval($this->params['cod_status']);
        $addInfo = target('order/OrderAddress')->getAddress($this->params['user_id'], $addId);
        $takeId = intval($this->params['take_id']);
        $couponId = intval($this->params['coupon_id']);

        $addList = target('order/OrderAddress')->loadList(['user_id' => $this->params['user_id']]);
        $list = target('order/Cart', 'service')->getList($this->params['user_id']);
        $info = target('order/Cart', 'service')->getCart($this->params['user_id']);

        if (empty($list)) {
            return $this->stop('购物车商品为空');
        }

        $orderPrice = $info['total'];
        $deliveryPrice = 0;
        $discountsPrice = 0;
        $orderData = target('order/Order', 'service')->splitOrder($addInfo['province'], $list);

        $takeStatus = false;
        foreach ($orderData as $vo) {
            foreach ($vo['items'] as $v)
                if ($v['take_status']) {
                    $takeStatus = true;
                    break;
                }
        }

        if (!$takeId && $takeStatus) {
            foreach ($orderData as $vo) {
                $deliveryPrice += $vo['freight_price'];
            }
        }

        $couponList = target('order/OrderCouponLog')->loadList([
            'A.user_id' => $this->params['user_id'],
            'A.status' => 0,
            'A.del' => 0,
            '_sql' => 'A.end_time >= ' . time()
        ]);
        $couponInfo = [];

        foreach ($couponList as $key => $vo) {
            foreach ($orderData as $v) {
                if ($vo['seller_id'] <> 0 || $vo['seller_id'] <> $v['seller_id']) {
                    continue 2;
                }
                if (!target($vo['typeInfo']['target'])->isCoupon($vo, $v)) {
                    unset($couponList[$key]);
                }
                if($couponId == $vo['log_id']) {
                    $couponInfo = $vo;
                }
            }
        }
        if($couponInfo) {
            $discountsPrice += $couponInfo['money'];
        }

        if (!$takeId) {
            foreach ($list as $vo) {
                if ($vo['take_id']) {
                    $takeId = $vo['take_id'];
                }
            }
        }

        $takeInfo = [];
        if ($takeStatus) {
            $takeList = target('order/OrderTake')->loadList([
                'province' => $addInfo['province'],
                'city' => $addInfo['city'],
            ]);

            foreach ($takeList as $key => $vo) {
                $takeList[$key]['active'] = 0;
                if ($vo['take_id'] == $takeId) {
                    $takeList[$key]['active'] = 1;
                    $takeInfo = $vo;
                }
            }

            $takeList = array_sort($takeList, 'active', 'desc');
        } else {
            $takeList = [];
        }

        $urlParams = [
            'add_id' => $addId,
            'take_id' => $takeId,
            'coupon_id' => $couponId,
            'cod_status' => $codStatus
        ];

        $totalPrice = price_format($deliveryPrice + $orderPrice - $discountsPrice);


        $currency = target('order/Order', 'service')->getCurrency($list);


        return $this->run([
            'cartData' => $orderData,
            'list' => $list,
            'info' => $info,
            'deliveryPrice' => $deliveryPrice,
            'orderPrice' => $orderPrice,
            'discountsPrice' => $discountsPrice,
            'totalPrice' => $totalPrice,
            'addList' => $addList,
            'addInfo' => $addInfo,
            'couponList' => $couponList,
            'couponInfo' => $couponInfo,
            'couponId' => $couponId,
            'takeList' => $takeList,
            'takeInfo' => $takeInfo,
            'codStatus' => $codStatus,
            'takeId' => $takeId,
            'urlParams' => $urlParams,
            'currencyAppend' => $currency['append'],
            'currencyExchange' => $currency['exchange'],
        ]);
    }

    protected function post() {
        $this->params['user_id'] = intval($this->params['user_id']);
        $codStatus = intval($this->params['cod_status']);
        $couponId = intval($this->params['coupon_id']);
        $takeId = intval($this->params['take_id']);
        $addId = $this->params['add_id'];

        if ($takeId) {
            $addInfo = target('order/OrderAddress')->getAddress($this->params['user_id'], $addId);
            $takeIfo = target('order/OrderTake')->getWhereInfo([
                'province' => $addInfo['province'],
                'city' => $addInfo['city'],
                'take_id' => $takeId
            ]);
            if (empty($takeIfo)) {
                return $this->stop('自提点不存在!');
            }
        }

        $target = target('order/Order', 'service');
        $orderNos = $target->addOrder($this->params['user_id'], '', $addId, $codStatus, $takeId, $couponId, $this->params['remark']);
        if (!$orderNos) {
            return $this->stop($target->getError());
        }
        target('order/Cart', 'service')->clear($this->params['user_id']);

        $orderList = target('order/Order')->loadList([
            '_sql' => 'order_no in(' . implode(',', $orderNos) . ')'
        ]);

        $deliveryPrice = 0;
        $orderPrice = 0;
        $app = [];

        foreach ($orderList as $vo) {
            if (!$takeId) {
                $deliveryPrice += $vo['delivery_price'];
            }
            $orderPrice += $vo['order_price'];
            $app[] = $vo['order_app'];
        }
        $app = array_unique($app);

        $accountInfo = target('member/PayAccount')->getWhereInfo([
            'A.user_id' => $this->params['user_id']
        ]);

        return $this->run(['cod_status' => $codStatus, 'order_no' => implode('|', $orderNos), 'order_price' => $orderPrice, 'delivery_price' => $deliveryPrice, 'user_money' => $accountInfo['money'], 'app' => $app]);
    }

}