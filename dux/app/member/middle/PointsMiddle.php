<?php

/**
 * 积分记录
 */

namespace app\member\middle;


class PointsMiddle extends \app\base\middle\BaseMiddle {

    private $_model = 'member/PointsLog';

    protected function meta() {
        $this->setMeta('积分记录');
        $this->setName('积分记录');
        $this->setCrumb([
            [
                'name' => '积分记录',
                'url' => url()
            ]
        ]);

        return $this->run([
            'pageInfo' => $this->pageInfo
        ]);
    }

    protected function data() {
        $type = intval($this->params['type']);
        $accountId = intval($this->params['account_id']);
        if ($type == 1) {
            $where['A.type'] = 1;
        }
        if ($type == 2) {
            $where['A.type'] = 0;
        }
        $where['A.account_id'] = $accountId;
        $pageLimit = 20;

        $model = target($this->_model);
        $count = $model->countList($where);
        $pageData = $this->pageData($count, $pageLimit);
        $list = $model->loadList($where, $pageData['limit'], 'log_id desc');

        return $this->run([
            'type' => $type,
            'pageData' => $pageData,
            'countList' => $count,
            'pageList' => $list,
        ]);
    }

}