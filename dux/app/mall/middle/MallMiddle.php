<?php

/**
 * 商品操作
 */

namespace app\mall\middle;

class MallMiddle extends \app\base\middle\BaseMiddle {


    public function addCart() {
        $this->params['user_id'] = intval($this->params['user_id']);
        $this->params['qty'] = intval($this->params['qty']);
        $qty = $this->params['qty'] ? $this->params['qty'] : 1;
        $this->params['pro_id'] = intval($this->params['pro_id']);
        $this->params['mall_id'] = intval($this->params['mall_id']);
        $rowId = $this->params['row_id'];

        if ((empty($this->params['pro_id']) || empty($this->params['mall_id'])) && empty($this->params['user_id'])) {
            return $this->stop('商品参数有误');
        }
        if ($this->params['mall_id']) {
            $proInfo = target('mall/MallProducts')->getMallInfo(['A.mall_id' => $this->params['mall_id']]);
        } else {
            $proInfo = target('mall/MallProducts')->getMallInfo(['A.products_id' => $this->params['pro_id']]);
        }

        if (empty($proInfo) || !$proInfo['status']) {
            return $this->stop('该商品不存在或已下架');
        }
        if ($proInfo['up_time']) {
            if ($proInfo['up_time'] > time()) {
                return $this->stop('该商品还未上架');
            }
        }
        if ($proInfo['down_time']) {
            if ($proInfo['down_time'] < time()) {
                return $this->stop('该商品已下架!');
            }
        }
        if (empty($proInfo['store'])) {
            return $this->stop('该商品已售完！');
        }

        if ($proInfo['store'] < $this->params['qty']) {
            return $this->stop('该商品已售完!');
        }

        $info = target('mall/Mall')->getInfo($proInfo['mall_id']);

        //限购
        if ($info['attr_limit']) {
            $orderGoods = target('order/OrderGoods')->loadList([
                'user_id' => $this->params['user_id'],
                'has_id' => $proInfo['mall_id'],
            ]);
            $goodsNum = $qty;
            foreach ($orderGoods as $vo) {
                $goodsNum += $vo['goods_qty'];
            }
            if ($goodsNum > $info['attr_limit']) {
                $surplus = $info['attr_limit'] - $goodsNum;

                if($info['attr_limit'] <= $goodsNum) {
                    return $this->stop('该商品限购' . $info['attr_limit'] . $info['unit'] . ', 您已不能购买!');
                }else {
                    return $this->stop('限购您最多只能购买' . $surplus . $info['unit'] . '！');
                }
            }
        }
        $cartData = [];


        if($info['mall_id'] == 1) {
            $cartData['currency'] = [
                'type' => 'd',
                'money' => 30
            ];
        }else {
            $cartData['currency'] = [
                'type' => 'credit',
                'money' => 30
            ];

        }
        $cartData['item_no'] = $proInfo['products_no'];
        $cartData['app'] = 'mall';
        $cartData['app_id'] = $proInfo['mall_id'];
        $cartData['id'] = $proInfo['products_id'];
        $cartData['qty'] = $qty;
        $cartData['price'] = $proInfo['sell_price'];
        $cartData['cost_price'] = $proInfo['cost_price'];
        $cartData['market_price'] = $proInfo['market_price'];
        $cartData['name'] = $proInfo['title'];
        $cartData['options'] = $proInfo['spec_data'];
        $cartData['image'] = $proInfo['image'];
        $cartData['weight'] = $proInfo['weight'];
        $cartData['url'] = url(VIEW_LAYER_NAME . '/mall/info/index', ['id' => $proInfo['mall_id']]);
        $cartData['freight_type'] = $proInfo['freight_type'];
        $cartData['freight_tpl'] = $proInfo['freight_tpl'];
        $cartData['freight_price'] = $proInfo['freight_price'];
        $cartData['service_status'] = $proInfo['service_status'];
        $cartData['cod_status'] = $proInfo['cod_status'];
        $cartData['seller_id'] = $proInfo['seller_id'];
        $cartData['point'] = 0;

        $config = target('shop/ShopConfig')->getConfig();
        if ($config['point_status'] && $proInfo['point_status']) {
            $cartData['point'] = round($proInfo['sell_price'] * $config['point_rate'] / 100);
        }

        if (!target('order/Cart', 'service')->add($this->params['user_id'], $cartData, $rowId)) {
            return $this->stop(target('order/Cart', 'service')->getError());
        }

        return $this->run([], '加入购物车成功！');
    }

    public function addFollow() {
        $this->params['mall_id'] = intval($this->params['mall_id']);
        $this->params['user_id'] = intval($this->params['user_id']);

        if (empty($this->params['mall_id']) && empty($this->params['user_id'])) {
            return $this->stop('商品参数有误!');
        }

        $mallInfo = target('mall/Mall')->getInfo($this->params['mall_id']);
        if (empty($mallInfo)) {
            return $this->stop('该商品不存在!');
        }
        if (!$mallInfo['status']) {
            return $this->stop('该商品已下架!');
        }
        if ($mallInfo['up_time']) {
            if ($mallInfo['up_time'] > time()) {
                return $this->stop('该商品还未上架!');
            }
        }
        if ($mallInfo['down_time']) {
            if ($mallInfo['down_time'] < time()) {
                return $this->stop('该商品已下架!');
            }
        }
        $type = target('shop/Shop', 'service')->addFollow('mall', $mallInfo['mall_id'], $this->params['user_id'], $mallInfo['title'], $mallInfo['image'], $mallInfo['sell_price']);
        if (!$type) {
            $this->stop(target('shop/Shop', 'service')->getError());
        }
        $msg = '';
        if($type == 'inc') {
            if(!target('mall/Mall')->where(['mall_id' => $this->params['mall_id']])->setInc('favorite', 1)) {
                $this->stop('添加收藏失败！');
            }
            $msg = '收藏商品成功！';
        }
        if($type == 'dec') {
            if(!target('mall/Mall')->where(['mall_id' => $this->params['mall_id']])->setDec('favorite', 1)) {
                $this->stop('取消收藏失败！');
            }
            $msg = '取消收藏成功！';
        }
        return $this->run([], $msg);
    }

    public function addFaq() {
        $this->params['mall_id'] = intval($this->params['mall_id']);
        $this->params['user_id'] = intval($this->params['user_id']);
        $this->params['content'] = html_clear($this->params['content']);
        $info = target('mall/Mall')->getInfo($this->params['mall_id']);
        if (empty($info) || !$info['status']) {
            $this->stop('商品不存在！');
        }
        $msg = target('shop/Shop', 'service')->addFaq('mall', $this->params['mall_id'], $this->params['user_id'], 0, $this->params['content']);
        if (!$msg) {
            $this->stop(target('shop/Shop', 'service')->getError());
        }
        return $this->run([], $msg);
    }

}