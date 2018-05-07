<?php

namespace app\order\service;
/**
 * 类型接口
 */
class TypeService {

    /**
     * 优惠券接口
     */
    public function getCouponType() {
        return [
            'common' => [
                'name' => '通用',
                'target' => 'order/Order'
            ],
        ];
    }
}

