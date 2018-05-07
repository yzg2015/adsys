<?php

/**
 * 商城列表
 */

namespace app\mall\mobile;

class IndexMobile extends \app\base\mobile\SiteMobile {


    protected $_middle = 'mall/List';

    /**
     * 首页
     */
    public function index() {

        $classId = request('get', 'id', 0, 'intval');
        $pageLimit = request('get', 'limit', 0, 'intval');
        $sellerId = request('get', 'seller_id', 0, 'intval');
        $keyword = request('get', 'keyword', '');
        $pos = request('get', 'pos', 0, 'intval');

        $urlParams = [
            'id' => $classId,
            'limit' => $pageLimit,
            'seller_id' => $sellerId,
            'vip' => $vip,
            'keyword' => $keyword,
            'group' => $group,
            'pos' => $pos
        ];

        $userId = target('member/MemberUser')->getUid();
        target($this->_middle, 'middle')->setParams([
            'classId' => $classId,
            'limit' => $pageLimit,
            'sellerId' => $sellerId,
            'keyword' => $keyword,
            'user_id' => $userId,
            'layer' => 'mobile',
            'pos' => $pos
        ])->meta()->classInfo()->data()->filter()->share()->export(function ($data) use ($urlParams, $userId) {
            $this->assign($data);
            $this->assign('urlParams', $urlParams);
            $this->assign('page', $this->htmlPage($data['pageData']['raw'], $urlParams));
	    $this->assign('userId', $userId);
            $this->mobileDisplay();
        }, function ($message, $code, $url) {
            $this->errorCallback($message, $code, $url);
        });
    }

    public function ajax() {
        $classId = request('get', 'id', 0, 'intval');
        $pageLimit = request('get', 'limit', 0, 'intval');
        $sellerId = request('get', 'seller_id', 0, 'intval');
        $keyword = request('get', 'keyword', '');
        $pos = request('get', 'pos', 0, 'intval');

        target($this->_middle, 'middle')->setParams([
            'classId' => $classId,
            'limit' => $pageLimit,
            'sellerId' => $sellerId,
            'vip' => $vip,
            'keyword' => $keyword,
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