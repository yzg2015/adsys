<?php
namespace app\order\service;
/**
 * 菜单接口
 */
class MenuService {
    /**
     * 获取菜单结构
     */
    public function getSystemMenu() {
        return array(
            'order' => array(
                'name' => '订单',
                'icon' => 'carts',
                'order' => 3,
                'menu' => array(
                    array(
                        'name' => '订单设置',
                        'order' => 98,
                        'menu' => array(
                            array(
                                'name' => '订单设置',
                                'icon' => 'cog',
                                'url' => url('order/Config/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '物流列表',
                                'icon' => 'bars',
                                'url' => url('order/ConfigExpress/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '运费模板',
                                'icon' => 'bars',
                                'url' => url('order/ConfigDelivery/index'),
                                'order' => 2
                            ),
                            array(
                                'name' => '物流接口',
                                'icon' => 'bars',
                                'url' => url('order/WayBillConf/index'),
                                'order' => 3
                            ),
                        )
                    ),
                    array(
                        'name' => '订单管理',
                        'icon' => 'build',
                        'order' => 100,
                        'menu' => array(
                            array(
                                'name' => '退款管理',
                                'icon' => 'bars',
                                'url' => url('order/Refund/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '配货管理',
                                'icon' => 'bars',
                                'url' => url('order/Parcel/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '发货管理',
                                'icon' => 'bars',
                                'url' => url('order/Delivery/index'),
                                'order' => 2
                            ),
                            array(
                                'name' => '收款管理',
                                'icon' => 'bars',
                                'url' => url('order/Receipt/index'),
                                'order' => 3
                            ),
                            array(
                                'name' => '自提点管理',
                                'icon' => 'bars',
                                'url' => url('order/Take/index'),
                                'order' => 4
                            ),
                        )
                    ),
                    array(
                        'name' => '优惠券管理',
                        'order' => 101,
                        'menu' => array(
                            array(
                                'name' => '优惠券管理',
                                'icon' => 'bars',
                                'url' => url('order/Coupon/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '领取记录',
                                'icon' => 'bars',
                                'url' => url('order/CouponLog/index'),
                                'order' => 1
                            ),
                        )
                    ),
                ),
            ),
        );
    }

    /**
     * 获取会员菜单
     * @return array
     */
    public function getMemberMenu() {
        return [
            'order' => [
                'name' => '订单',
                'desc' => '订单管理',
                'icon' => 'inbox',
                'order' => 98,
                'menu' => [
                    [
                        'name' => '我的订单',
                        'url' => url('order/Order/index'),
                        'icon' => 'shopping-bag',
                        'order' => 90
                    ],
                    [
                        'name' => '我的优惠券',
                        'url' => url('order/CouponLog/index'),
                        'icon' => 'shopping-bag',
                        'order' => 91
                    ],
                    [
                        'name' => '收货地址',
                        'url' => url('order/Address/index'),
                        'icon' => 'truck',
                        'order' => 92
                    ],
                    [
                        'name' => '退款管理',
                        'url' => url('order/Refund/index'),
                        'icon' => 'thumb-tack',
                        'order' => 93
                    ],
                ]
            ]
        ];
    }

    /**
     * 获取头部菜单
     * @return array
     */
    public function getMemberHeadMenu() {
        return [
            [
                'name' => '购物车',
                'order' => 99,
                'icon' => 'shopping-cart',
                'url' => url('order/cart/index')
            ]
        ];
    }
}

