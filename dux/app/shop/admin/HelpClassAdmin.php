<?php

/**
 * 帮助分类管理
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\shop\admin;

class HelpClassAdmin extends \app\system\admin\SystemExtendAdmin {

    protected $_model = 'ShopHelpClass';

    /**
     * 模块信息
     */
    protected function _infoModule() {
        return [
            'info' => [
                'name' => '帮助分类',
                'description' => '帮助分类管理',
            ],
            'fun' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'del' => true,
            ]
        ];
    }

    public function _indexParam() {
        return [
            'keyword' => 'name'
        ];
    }

    public function _indexOrder() {
        return 'sort ASC,class_id ASC';
    }

    public function _indexPage() {
        return 100;
    }

}