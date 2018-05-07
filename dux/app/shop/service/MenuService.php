<?php
namespace app\shop\service;
/**
 * 系统菜单接口
 */
class MenuService {
    /**
     * 获取菜单结构
     */
    public function getSystemMenu() {
        return array(
            'shop' => array(
                'name' => '商城',
                'icon' => 'bars',
                'order' => 2,
                'menu' => array(
                    array(
                        'name' => '品牌管理',
                        'icon' => 'build',
                        'order' => 100,
                        'menu' => array(
                            array(
                                'name' => '品牌管理',
                                'icon' => 'bars',
                                'url' => url('shop/Brand/index'),
                                'order' => 0
                            ),
                        )
                    ),
                    array(
                        'name' => '规格管理',
                        'icon' => 'build',
                        'order' => 101,
                        'menu' => array(
                            array(
                                'name' => '规格管理',
                                'icon' => 'bars',
                                'url' => url('shop/Spec/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '规格分组',
                                'icon' => 'code-fork',
                                'url' => url('shop/SpecGroup/index'),
                                'order' => 1
                            ),
                        )
                    ),
                    array(
                        'name' => '商城设置',
                        'order' => 102,
                        'menu' => array(
                            array(
                                'name' => '基本设置',
                                'icon' => 'cog',
                                'url' => url('shop/Config/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '帮助管理',
                                'icon' => 'bars',
                                'url' => url('shop/Help/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '帮助分类',
                                'icon' => 'code-fork',
                                'url' => url('shop/HelpClass/index'),
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
        return [
            'shop' => [
                'name' => '商品',
                'desc' => '商品管理',
                'icon' => 'shopping-bag',
                'order' => 97,
                'menu' => [
                    [
                        'name' => '商品收藏',
                        'url' => url('shop/Follow/index'),
                        'icon' => 'tags',
                        'order' => 91
                    ],
                ]
            ],

        ];
    }


}

