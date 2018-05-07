<?php

/**
 * 商品列表
 */

namespace app\mall\controller;

class IndexController extends \app\base\controller\SiteController {

    protected $_middle = 'mall/List';

    /**
     * 首页
     */
    public function index() {

        $classId = request('get', 'id', 0, 'intval');
        $pageLimit = request('get', 'limit', 0, 'intval');
        $sellerId = request('get', 'seller_id', 0, 'intval');
        $vip = request('get', 'vip', 0, 'intval');
        $discount = request('get', 'discount', 0, 'intval');
        $order = request('get', 'order');
        $pos = request('get', 'pos', 0, 'intval');

        $urlParams = [
            'id' => $classId,
            'limit' => $pageLimit,
            'seller_id' => $sellerId,
            'vip' => $vip,
            'discount' => $discount,
            'order' => $order,
            'pos' => $pos
        ];

        target($this->_middle, 'middle')->setParams([
            'classId' => $classId,
            'limit' => $pageLimit,
            'sellerId' => $sellerId,
            'vip' => $vip,
            'discount' => $discount
        ])->meta()->classInfo()->data()->filter()->export(function ($data) use ($urlParams) {
            $this->assign($data);
            $this->assign('urlParams', $urlParams);
            $this->assign('page', $this->htmlPage($data['pageData']['raw'], $urlParams));
            $this->siteDisplay($data['tpl']);
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function ajax() {
        $classId = request('get', 'id', 0, 'intval');
        $pageLimit = request('get', 'limit', 0, 'intval');
        $sellerId = request('get', 'seller_id', 0, 'intval');
        $vip = request('get', 'vip', 0, 'intval');
        $discount = request('get', 'discount', 0, 'intval');
        $order = request('get', 'order');
        $pos = request('get', 'pos', 0, 'intval');

        target($this->_middle, 'middle')->setParams([
            'classId' => $classId,
            'limit' => $pageLimit,
            'sellerId' => $sellerId,
            'vip' => $vip,
            'discount' => $discount,
            'order' => $order,
            'pos' => $pos
        ])->data()->export(function ($data) {
            if(!empty($data['pageList'])) {
                $this->success([
                    'data' => $data['pageList'],
                    'page' => $data['pageData']['page'],
                ]);
            }else {
                $this->error('暂无数据');
            }

        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

}