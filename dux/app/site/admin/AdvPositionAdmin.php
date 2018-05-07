<?php

/**
 * 广告位管理
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\site\admin;

class AdvPositionAdmin extends \app\system\admin\SystemExtendAdmin {

    protected $_model = 'SiteAdvPosition';

    /**
     * 模块信息
     */
    protected function _infoModule() {
        return [
            'info' => [
                'name' => '广告位管理',
                'description' => '管理站点广告位信息',
            ],
            'fun' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'status' => true,
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
        return 'pos_id asc';
    }

}