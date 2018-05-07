<?php
namespace app\mall\service;
/**
 * 订单操作
 */
class OrderService extends \app\base\service\BaseService {

    private $model = 'mall/MallOrder';


    /**
     * 刷新购物车
     * @param $userId
     * @param $info
     * @return bool
     */
    public function refreshCart($userId, $info) {
        if (empty($info)) {
            return $this->success();
        }

        $ids = [];
        foreach ($info['items'] as $key => $vo) {
            $ids[] = $vo['id'];
        }
        $where = [];
        $where['_sql'] = 'A.products_id in (' . implode(',', $ids) . ')';
        $proList = target('mall/MallProducts')->loadList($where);

        $proData = [];
        foreach ($proList as $vo) {
            $proData[$vo['products_id']] = $vo;
        }
        $storeError = 0;
        $priceError = 0;
        $emptyError = 0;
        $cartData = [];

        foreach ($info['items'] as $key => $vo) {

            if (empty($proData[$vo['id']]) || $vo['qty'] < 1) {
                $emptyError = 1;
                target('order/Cart', 'service')->del($userId, $vo['rowid']);
                continue;
            }

            $cart = [];
            if ($vo['qty'] > $proData[$vo['id']]['store']) {
                $storeError = 1;
                $cart['qty'] = 1;
            }
            if ($vo['price'] <> $proData[$vo['id']]['sell_price']) {
                $priceError = 1;
                $cart['price'] = $proData[$vo['id']]['sell_price'];
            }
            if ($cart) {
                $cart['rowid'] = $vo['rowid'];
                $cartData[] = $cart;
            }
        }

        if ($emptyError) {
            return $this->error('您购买的产品库存不足，已取消!');
        }

        if (!empty($cartData)) {
            if (!target('order/Cart', 'service')->update($userId, $cartData)) {
                return $this->error(target('order/Cart', 'service')->getError());
            }
            if ($storeError && $priceError) {
                return $this->error('您购买的产品由于库存和价格更改,请重新提交订单!');
            }
            if ($storeError) {
                return $this->error('您购买的产品由于库存不足,请重新提交订单!');
            }
            if ($priceError) {
                return $this->error('您购买的产品由于价格更改,请重新提交订单!');
            }
        }

        return $this->success();
    }

    /**
     * 提交订单
     * @param array $data
     * @param array $goodsData
     * @return bool
     */
    public function addOrder($data = [], $goodsData = [], $addId = 0, $codStatus = 0, $takeId = 0, $couponId = 0) {
        if (empty($data) || empty($goodsData)) {
            return $this->error('订单数据为空!');
        }
        $id = target($this->model)->add([
            'order_id' => $data['order_id']
        ]);
        if (!$id) {
            return $this->error(target($this->model)->getError());
        }

        $config = target('shop/ShopConfig')->getConfig();
        if (!$config['stock_type']) {
            if (!$this->saleOrder($goodsData)) {
                return false;
            }
        }

        return $this->success($id);
    }

    /**
     * 支付订单检查
     * @param $orderList
     * @return bool
     */
    public function checkOrder($orderList) {
        return true;
    }

    /**
     * 付款成功回调
     * @param $orderList
     * @return bool
     */
    public function payOrder($orderList) {
        $config = target('shop/ShopConfig')->getConfig();
        if ($config['stock_type']) {
            $orderIds = [];
            foreach ($orderList as $vo) {
                $orderIds[] = $vo['order_id'];
            }
            $goodsList = target('order/OrderGoods')->loadList([
                '_sql' => 'order_id in ('. implode(',', $orderIds).')'
            ]);
            if (!$this->saleOrder($goodsList)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 取消订单操作
     * @param $orderList
     * @return bool
     */
    public function cancelOrder($orderList) {
        return true;
    }

    /**
     * 订单发货
     * @param $orderInfo
     * @return bool
     */
    public function deliveryOrder($orderInfo) {
        return true;
    }

    /**
     * 订单完成
     * @param $orderInfo
     * @return bool
     */
    public function confirmOrder($orderInfo) {
        return true;
    }

    /**
     * 库存处理
     * @param $goodsData
     * @return bool
     */
    public function saleOrder($goodsData) {
        if (empty($goodsData)) {
            return true;
        }
        $data = [];
        foreach ($goodsData as $vo) {
            $data[$vo['has_id']][] = $vo;
        }

        foreach ($data as $hasId => $goods) {
            $qty = 0;
            foreach ($goods as $vo) {
                $qty += $vo['goods_qty'];
                if (!target('mall/MallProducts')->where(['products_id' => $vo['sub_id']])->setDec('store', $vo['goods_qty'])) {
                    return $this->error('库存处理失败！');
                }
                if (!target('mall/MallProducts')->where(['products_id' => $vo['sub_id']])->setInc('sale', $vo['goods_qty'])) {
                    return $this->error('销量处理失败！');
                }
            }
            if (!target('mall/Mall')->where(['mall_id' => $hasId])->setDec('store', $qty)) {
                return $this->error('库存处理失败！');
            }
            if (!target('mall/Mall')->where(['mall_id' => $hasId])->setInc('sale', $qty)) {
                return $this->error('销量处理失败！');
            }

        };

        return true;

    }
}

