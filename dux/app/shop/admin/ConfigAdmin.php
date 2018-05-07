<?php

/**
 * 商城设置
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\shop\admin;


class ConfigAdmin extends \app\system\admin\SystemAdmin {

    /**
     * 模块信息
     */
    protected function _infoModule() {
        return [
            'info' => [
                'name' => '商城设置',
                'description' => '配置商城基本功能',
            ],
        ];
    }

    /**
     * 商城设置
     */
    public function index() {
        if (!isPost()) {
            $info = target('ShopConfig')->getConfig();
            $this->assign('info', $info);
            $this->systemDisplay();
        } else {
            if (target('ShopConfig')->saveInfo()) {
                $this->success('功能配置成功！');
            } else {
                $this->error('功能配置失败');
            }
        }
    }

    public function store() {
        if (!isPost()) {
            $info = target('ShopConfig')->getConfig();
            $this->assign('info', $info);
            $this->systemDisplay();
        } else {
            if (target('ShopConfig')->saveInfo()) {
                $this->success('功能配置成功！');
            } else {
                $this->error('功能配置失败');
            }
        }
    }

}