<?php
namespace app\tools\service;
/**
 * 菜单接口
 */
class MenuService {

    /**
     * 获取菜单结构
     */
    public function getSystemMenu() {
        return array(
            'tools' => array(
                'name' => '工具',
                'icon' => 'user',
                'order' => 98,
                'menu' => array(
                    array(
                        'name' => '推送管理',
                        'order' => 0,
                        'menu' => array(
                            array(
                                'name' => '推送管理',
                                'icon' => 'bars',
                                'url' => url('tools/Send/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '模板管理',
                                'icon' => 'file',
                                'url' => url('tools/SendTpl/index'),
                                'order' => 1
                            ),
                            array(
                                'name' => '推送设置',
                                'icon' => 'cog',
                                'url' => url('tools/SendConf/index'),
                                'order' => 2
                            ),
                            array(
                                'name' => '默认设置',
                                'icon' => 'cog',
                                'url' => url('tools/SendDefault/index'),
                                'order' => 2
                            ),
                        )
                    ),
                    array(
                        'name' => '标签生成',
                        'order' => 1,
                        'menu' => array(
                            array(
                                'name' => '标签生成器',
                                'icon' => 'bars',
                                'url' => url('tools/Label/index'),
                                'order' => 0
                            ),
                        )
                    ),
                    array(
                        'name' => '队列管理',
                        'order' => 2,
                        'menu' => array(
                            array(
                                'name' => '队列管理',
                                'icon' => 'bars',
                                'url' => url('tools/Queue/index'),
                                'order' => 0
                            ),
                            array(
                                'name' => '队列设置',
                                'icon' => 'cog',
                                'url' => url('tools/QueueConf/index'),
                                'order' => 1
                            ),
                        )
                    ),
                ),
            ),
        );
    }
}

