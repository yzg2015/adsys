<?php

/**
 * 帮助内容
 */
namespace app\shop\model;

use app\system\model\SystemModel;

class ShopHelpModel extends SystemModel {

    protected $infoModel = [
        'pri' => 'help_id',
        'validate' => [
            'class_id' => [
                'empty' => ['', '请选择分类!', 'must', 'all'],

            ],
        ],
        'format' => [
            'content' => [
                'function' => ['html_in', 'all', 0],
            ]
        ]
    ];

    protected function base($where) {
        $base = $this->table('shop_help(A)')
            ->join('shop_help_class(B)', ['B.class_id', 'A.class_id']);
        $field = ['A.*', 'B.name(class_name)'];
        return $base
            ->field($field)
            ->where((array)$where);
    }

    public function loadList($where = array(), $limit = 0, $order = 'A.sort asc, help_id asc') {
        $list = $this->base($where)
            ->limit($limit)
            ->order($order)
            ->select();
        if(empty($list)){
            return [];
        }
        return $list;
    }

    public function countList($where = array()) {
        return $this->base($where)->count();
    }

    public function getWhereInfo($where) {
        $info = $this->base($where)->find();
        if(empty($info)) {
            return [];
        }
        return $info;
    }

    public function getInfo($id) {
        $where = [];
        $where['A.help_id'] = $id;
        return $this->getWhereInfo($where);
    }

}