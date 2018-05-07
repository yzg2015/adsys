<?php
namespace app\member\service;
/**
 * 菜单接口
 */
class MenuService {
    /**
     * 获取菜单结构
     */
    public function getSystemMenu() {
        return array(
            'member' => array(
                'name' => '会员',
                'icon' => 'user',
                'order' => 98,
                'menu' => array(
                    array(
                        'name' => '会员管理',
                        'order' => 0,
                        'menu' => array(
                            array(
                                'name' => '会员管理',
                                'icon' => 'user',
                                'url' => url('member/MemberUser/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '角色管理',
                                'icon' => 'group',
                                'url' => url('member/MemberRole/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '实名制管理',
                                'icon' => 'credit-card',
                                'url' => url('member/MemberReal/index'),
                                'order' => 2
                            ),
                        )
                    ),
                    array(
                        'name' => '财务管理',
                        'order' => 1,
                        'menu' => array(
                            array(
                                'name' => '财务账户',
                                'icon' => 'credit-card',
                                'url' => url('member/PayAccount/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '收支记录',
                                'icon' => 'bars',
                                'url' => url('member/PayLog/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '充值记录',
                                'icon' => 'bars',
                                'url' => url('member/PayRecharge/index'),
                                'order' => 2
                            ),
                            array(
                                'name' => '银行管理',
                                'icon' => 'bank',
                                'url' => url('member/PayBank/index'),
                                'order' => 3
                            ),
                            array(
                                'name' => '银行卡管理',
                                'icon' => 'credit-card',
                                'url' => url('member/PayCard/index'),
                                'order' => 4
                            ),
                            array(
                                'name' => '提现管理',
                                'icon' => 'deviantart',
                                'url' => url('member/PayCash/index'),
                                'order' => 5
                            ),
                        )
                    ),
                    array(
                        'name' => '积分管理',
                        'order' => 2,
                        'menu' => array(
                            array(
                                'name' => '积分账户',
                                'icon' => 'credit-card',
                                'url' => url('member/PointsAccount/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '积分记录',
                                'icon' => 'bars',
                                'url' => url('member/PointsLog/index'),
                                'order' => 1
                            ),
                        )
                    ),
                    array(
                        'name' => '会员设置',
                        'order' => 99,
                        'menu' => array(
                            array(
                                'name' => '基本设置',
                                'icon' => 'cog',
                                'url' => url('member/MemberConfig/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '配置管理',
                                'icon' => 'bars',
                                'url' => url('member/MemberConfigManage/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '验证码',
                                'icon' => 'qrcode',
                                'url' => url('member/MemberVerify/index'),
                                'order' => 2
                            ),
                            array(
                                'name' => '支付接口',
                                'icon' => 'bars',
                                'url' => url('member/PayConf/index'),
                                'order' => 3
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
            'bank' => [
                'name' => '钱包',
                'desc' => '钱包管理',
                'icon' => 'bank',
                'order' => 98,
                'menu' => [
                    [
                        'name' => '我的钱包',
                        'icon' => 'area-chart',
                        'url' => url('member/Finance/index'),
                        'order' => 90
                    ],
                    [
                        'name' => '账户充值',
                        'icon' => 'credit-card',
                        'url' => url('member/Recharge/index'),
                        'order' => 90
                    ],
                    [
                        'name' => '账户提现',
                        'icon' => 'credit-card-alt',
                        'url' => url('member/Cash/index'),
                        'order' => 90
                    ],
                    [
                        'name' => '财务记录',
                        'icon' => 'cny',
                        'url' => url('member/Finance/log'),
                        'order' => 91
                    ],
                    [
                        'name' => '积分记录',
                        'icon' => 'diamond',
                        'url' => url('member/Points/index'),
                        'order' => 92
                    ],
                ]
            ],
            'setting' => [
                'name' => '设置',
                'desc' => '账户设置',
                'icon' => 'cog',
                'order' => 99,
                'menu' => [
                    [
                        'name' => '资料修改',
                        'url' => url('member/setting/index'),
                        'icon' => 'user',
                        'order' => 90
                    ],
                    [
                        'name' => '修改头像',
                        'url' => url('member/setting/avatar'),
                        'icon' => 'photo',
                        'order' => 91
                    ],
                    [
                        'name' => '修改密码',
                        'url' => url('member/setting/password'),
                        'icon' => 'lock',
                        'order' => 92
                    ],

                    [
                        'name' => '银行卡管理',
                        'url' => url('member/card/index'),
                        'icon' => 'photo',
                        'order' => 93
                    ],
                    [
                        'name' => '实名认证',
                        'url' => url('member/real/index'),
                        'icon' => 'photo',
                        'order' => 94
                    ],
                ]
            ]

        ];
    }
}

