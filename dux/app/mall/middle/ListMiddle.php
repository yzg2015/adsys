<?php

/**
 * 商品列表
 */

namespace app\mall\middle;

class ListMiddle extends \app\base\middle\BaseMiddle {

    protected $crumb = [];
    protected $classInfo = [];
    protected $listWhere = [];
    protected $listOrder = [];
    protected $listLimit = 20;
    protected $listModel = 0;
    private $tpl = '';

    private function getClass() {
        if ($this->classInfo) {
            return $this->classInfo;
        }
        $classId = $this->params['classId'];
        if (empty($classId)) {
            return [];
        }
        $this->classInfo = target('mall/MallClass')->getInfo($classId);

        return $this->classInfo;
    }

    private function getCrumb() {
        if ($this->crumb) {
            return $this->crumb;
        }
        $classId = $this->params['classId'];
        if (empty($classId)) {
            return [];
        }
        $this->crumb = target('mall/MallClass')->loadCrumbList($classId);

        return $this->crumb;
    }

    protected function classInfo() {
        $this->classInfo = $this->getClass();
        if (empty($this->classInfo)) {
            return $this->run([
                'classInfo' => $this->classInfo,
                'parentClassInfo' => [],
                'topClassInfo' => [],
            ]);
        }
        if ($this->classInfo['url']) {
            $this->data['url'] = $this->classInfo['url'];

            return $this->stop('跳转', 302, $this->classInfo['url']);
        }
        $this->crumb = $this->getCrumb();
        $parentClassInfo = array_slice($this->crumb, -2, 1);
        if (empty($parentClassInfo)) {
            $parentClassInfo = $this->crumb[0];
        } else {
            $parentClassInfo = $parentClassInfo[0];
        }
        $topClassInfo = $this->crumb[0];

        if ($this->classInfo['tpl_class']) {
            $this->tpl = $this->classInfo['tpl_class'];
        }

        return $this->run([
            'classInfo' => $this->classInfo,
            'parentClassInfo' => $parentClassInfo,
            'topClassInfo' => $topClassInfo,
            'tpl' => $this->tpl
        ]);
    }


    protected function meta($title = '', $name = '', $url = '') {
        $classId = $this->params['classId'];
        if ($classId) {
            $this->crumb = $this->getCrumb();
            $this->classInfo = $this->getClass();
            $this->setMeta($this->classInfo['name'], $this->classInfo['keyword'], $this->classInfo['description']);
            $this->setCrumb($this->crumb);
        } else {
            $this->setName($name ? $name : '全部商品');
            $this->setMeta($title ? $title : '全部商品');
            $this->setCrumb([
                [
                    'name' => '全部商品',
                    'url' => $url ? $url : url()
                ]
            ]);
        }

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    private $filter = [];

    protected function data($filterStatus = true) {
        $classId = $this->params['classId'];
        $sellerId = $this->params['sellerId'];
        $pos = $this->params['pos'];

        $keyword = str_len(html_clear(urldecode($this->params['keyword'])), 10, false);
        $listLimit = $this->params['limit'] ? $this->params['limit'] : 20;
        $modelId = $this->params['model_id'] ? $this->params['model_id'] : 0;
        $filterWhere = [];
        if ($classId) {
            $this->classInfo = $this->getClass();
            $modelId = $this->classInfo['model_id'];
            $classIds = target('mall/MallClass')->getSubClassId($classId);
            if ($classIds) {
                $filterWhere['_sql'][] = 'B.class_id in(' . $classIds . ')';
            }
        }
        $filterWhere['_sql'][] = '(B.up_time <= ' . time() . ' OR B.up_time = 0) AND (B.down_time >= ' . time() . ' OR B.down_time = 0)';
        if ($sellerId) {
            $filterWhere['B.seller_id'] = $sellerId;
        }
        if ($keyword) {
            $filterWhere['_sql'][] = 'A.title like "%' . $keyword . '%"';
            target('site/SiteSearch')->stats($keyword, APP_NAME);
        }
        if($pos) {
            $filterWhere['_sql'][] = 'FIND_IN_SET('.$pos.', A.pos_id)';
        }

        $data = [];
        if ($filterStatus) {
            $service = target('shop/Filter', 'service');
            $data = $service->getData('mall', $filterWhere, [
                'class_id' => $classId,
                'seller_id' => $sellerId,
                'pos' => $pos,
                'keyword' => $keyword,
            ]);
            $this->filter = $data['filter'];
            $listWhere = $data['where'];
        } else {
            $filterWhere['A.status'] = 1;
            $listWhere = $filterWhere;
        }
        if ($this->params['where']) {
            $listWhere = array_merge($listWhere, $this->params['where']);
        }

        $listOrder = $this->params['order'] ? $this->params['order'] : $data['order'];

        if ($listWhere) {
            $model = target('mall/Mall');
            $count = $model->countList($listWhere);
            $pageData = $this->pageData($count, $listLimit);
            $list = $model->loadList($listWhere, $pageData['limit'], $listOrder, $modelId);
        } else {
            $pageData = [];
            $list = [];
            $count = 0;
        }
        return $this->run([
            'pageData' => $pageData,
            'countList' => $count,
            'pageList' => $list
        ]);
    }

    protected function filter() {
        $service = target('shop/Filter', 'service');
        $priceList = $service->getPriceData($this->filter['ids']);
        $brandList = $service->getBrandData($this->filter['ids']);

        return $this->run([
            'pageParams' => $this->filter['urlParam'],
            'attrList' => $this->filter['attrList'],
            'priceList' => $priceList,
            'brandList' => $brandList,
            'orderList' => $service->getOrderData(),
        ]);
    }
}