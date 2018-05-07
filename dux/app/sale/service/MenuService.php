<?php
namespace app\sale\service;
/**
 * 菜单接口
 */
class MenuService {
    /**
     * 获取菜单结构
     */
    public function getSystemMenu() {
        return array(
            'sale' => array(
                'name' => '分销',
                'icon' => 'carts',
                'order' => 5,
                'menu' => array(
                    array(
                        'name' => '分销设置',
                        'order' => 1,
                        'menu' => array(
                            array(
                                'name' => '功能设置',
                                'icon' => 'cog',
                                'url' => url('sale/Config/index'),
                                'order' => 0
                            ),
                        )
                    ),
                    array(
                        'name' => '分销商管理',
                        'order' => 2,
                        'menu' => array(
                            array(
                                'name' => '分销用户',
                                'icon' => 'user',
                                'url' => url('sale/User/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '用户审核',
                                'icon' => 'bars',
                                'url' => url('sale/UserApply/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '分销等级',
                                'icon' => 'users',
                                'url' => url('sale/UserLevel/index'),
                                'order' => 0
                            ),
                        )
                    ),
                    array(
                        'name' => '分销管理',
                        'icon' => 'build',
                        'order' => 3,
                        'menu' => array(
                            array(
                                'name' => '订单管理',
                                'icon' => 'bars',
                                'url' => url('sale/Order/index'),
                                'order' => 0
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
        $login = \Dux::cookie()->get('user_login');

        $info = target('sale/SaleUser')->getWhereInfo([
            'A.user_id' => $login['uid']
        ]);
        if (!$info['agent']) {
            $menu = [
                [
                    'name' => '分销商申请',
                    'url' => url('sale/Apply/index'),
                    'icon' => 'code-fork',
                    'order' => 1
                ],
            ];
        } else {

            $menu = [
                [
                    'name' => '推广信息',
                    'url' => url('sale/Info/index'),
                    'icon' => 'code-fork',
                    'order' => 0

                ],
                [
                    'name' => '我的二维码',
                    'url' => url('sale/Qrcode/index'),
                    'icon' => 'qrcode',
                    'order' => 1

                ],
                [
                    'name' => '分销订单',
                    'url' => url('sale/Order/index'),
                    'icon' => 'bookmark',
                    'order' => 2

                ],
                [
                    'name' => '我的会员',
                    'url' => url('sale/UserHas/index'),
                    'icon' => 'cc',
                    'order' => 3

                ]

            ];
        }

        return [
            'sale' => [
                'name' => '分销',
                'desc' => '分销管理',
                'icon' => 'line-chart',
                'order' => 98,
                'menu' => $menu
            ]
        ];
    }


}

