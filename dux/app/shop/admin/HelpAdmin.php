<?php

/**
 * 帮助管理
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\shop\admin;

class HelpAdmin extends \app\system\admin\SystemExtendAdmin {

    protected $_model = 'ShopHelp';

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
                'status' => true,
                'del' => true,
            ]
        ];
    }

    public function _indexParam() {
        return [
            'keyword' => 'name',
            'class_id' => 'A.class_id'
        ];
    }

    public function _indexOrder() {
        return 'sort ASC,class_id ASC';
    }

    public function _indexPage() {
        return 100;
    }

    public function _indexAssign($pageMaps) {
        $classId = $pageMaps['class_id'];
        return array(
            'classList' => target('shop/ShopHelpClass')->loadList([], 0, 'sort asc, class_id asc'),
            'classId' => $classId,
        );
    }

    public function _addAssign() {
        return array(
            'classList' => target('shop/ShopHelpClass')->loadList(),
        );
    }

    public function _editAssign() {
        return array(
            'classList' => target('shop/ShopHelpClass')->loadList(),
        );
    }

}