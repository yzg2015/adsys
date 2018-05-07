<?php

/**
 * 优惠券管理
 */
namespace app\order\model;

use app\system\model\SystemModel;

class OrderCouponModel extends SystemModel {

    protected $infoModel = [
        'pri' => 'coupon_id',
        'format' => [
            'start_time' => [
                'function' => ['strtotime', 'all'],
            ],
            'end_time' => [
                'function' => ['strtotime', 'all'],
            ],
        ]
    ];

    public function loadList($where = [], $limit = 0, $order = '') {
        $list = parent::loadList($where, $limit, $order);

        $currencyList = target('member/MemberCurrency')->typeList();
        $typeList = $this->typeList();

        foreach ($list as $key => $vo) {
            $list[$key]['currencyInfo'] = $currencyList[$vo['exchange_type']];
            $list[$key]['typeInfo'] =$typeList[$vo['type']];
        }
        return $list;
    }

    public function getWhereInfo($where) {
        $info = parent::getWhereInfo($where);
        if($info) {
            $currencyList = target('member/MemberCurrency')->typeList();
            $typeList = target('order/OrderCoupon')->typeList();
            $info['currencyInfo'] = $currencyList[$info['exchange_type']];
            $info['typeInfo'] =$typeList[$info['type']];
        }
        return $info;
    }


    public function _saveBefore($data, $type) {
        $typeList = target('order/OrderCoupon')->typeList();
        $typeInfo = $typeList[$data['type']];
        if(empty($typeInfo)) {
            $this->error = '优惠券类型不存在!';
            return false;
        }
        $info = target($typeInfo['target'])->getCouponHas($data['has_id']);
        if(empty($info)) {
            $this->error = '指定ID的' . $typeInfo['name']. '不存在!';
            return false;
        }
        $data['name'] = $info['title'];
        $data['url'] = $info['url'];
        return $data;
    }

    public function typeList() {
        $list = hook('service', 'Type', 'Coupon');
        $data = [];
        foreach ($list as $value) {
            $data = array_merge_recursive((array)$data, (array)$value);
        }
        return $data;
    }

}