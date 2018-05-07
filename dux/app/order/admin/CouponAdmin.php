<?php

/**
 * 优惠券管理
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\order\admin;

class CouponAdmin extends \app\system\admin\SystemExtendAdmin {

    protected $_model = 'OrderCoupon';

    /**
     * 模块信息
     */
    protected function _infoModule() {
        return [
            'info' => [
                'name' => '优惠券管理',
                'description' => '管理订单优惠券',
            ],
            'fun' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'del' => true,
                'status' => true,
            ]
        ];
    }

    public function _indexParam() {
        return [
            'keyword' => 'name',
            'status' => 'status',
        ];
    }

    public function _indexWhere($whereMaps) {
        switch($whereMaps['status']) {
            case 1:
                $where = 'status = 1';
                break;
            case 2:
                $where = 'status = 0';
                break;
        }
        if(!empty($where)) {
            $whereMaps['_sql'] = $where;
        }
        unset($whereMaps['status']);
        return $whereMaps;
    }



    public function _indexAssign($pageMaps) {
        return [
            'typeList' => target('order/OrderCoupon')->typeList(),
            'currencyList' => target('member/MemberCurrency')->typeList()
        ];
    }

    public function _addAssign() {
        return [
            'typeList' => target('order/OrderCoupon')->typeList(),
            'currencyList' => target('member/MemberCurrency')->typeList()
        ];
    }

    public function _editAssign($info) {
        return [
            'typeList' => target('order/OrderCoupon')->typeList(),
            'currencyList' => target('member/MemberCurrency')->typeList()
        ];
    }

    public function _indexOrder() {
        return 'coupon_id desc';
    }

    protected function _delAfter($id) {
        target('order/OrderCouponLog')->where([
            'coupon_id' => $id
        ])->delete();
    }

}