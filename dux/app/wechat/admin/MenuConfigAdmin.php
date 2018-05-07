<?php

/**
 * 菜单设置
 * @author  Mr.L <349865361@qq.com>
 */

namespace app\wechat\admin;


class MenuConfigAdmin extends \app\wechat\admin\WechatAdmin {

    protected $_model = 'WechatMenu';

    /**
     * 模块信息
     */
    protected function _infoModule() {
        return array(
            'info' => array(
                'name' => '菜单设置',
                'description' => '设置微信自定义菜单',
            ),
            'fun' => [
                'index' => true,
                'add' => true,
                'edit' => true,
                'del' => true
            ]
        );
    }


    public function _indexOrder() {
        return 'sort asc, menu_id asc';
    }

    public function _indexData($where, $limit, $order) {
        return target($this->_model)->loadTreeList($where, $limit, $order);
    }

    protected function _addAssign() {
        return array(
            'menuList' => target('wechat/WechatMenu')->loadTreeList([], 0, $this->_indexOrder())
        );
    }

    protected function _editAssign($info) {
        return array(
            'menuList' => target('wechat/WechatMenu')->loadTreeList([], 0, $this->_indexOrder())
        );
    }


    public function updateMenu() {
        $menu = $this->wechat->menu;


        $data = target($this->_model)->loadTreeList([], 0, $this->_indexOrder());

        $menuData = [];

        foreach ($data as $vo) {
            if (!$vo['parent_id']) {
                $menuData[$vo['menu_id']] = $this->_subMenu($vo);
            }else {
                unset($menuData[$vo['parent_id']]['type']);
                unset($menuData[$vo['parent_id']]['key']);
                unset($menuData[$vo['parent_id']]['url']);
                $menuData[$vo['parent_id']]['sub_button'][] = $this->_subMenu($vo);
            }
        }
        $menuData = array_values($menuData);
        $menu->destroy();

        $menu->add($menuData);

        $this->success('上传菜单成功!');
    }


    public function _subMenu($data) {
        if ($data['type']) {
            $menuData['type'] = 'click';
            $menuData['key'] = $data['key'];
        }else {
            $menuData['type'] = 'view';
            $menuData['url'] = $data['key'];
        }
        $menuData['name'] = $data['name'];
        return $menuData;

    }

}