<?php

/**
 * 积分记录
 */
namespace app\member\model;

use app\system\model\SystemModel;

class PointsLogModel extends SystemModel {

    protected $infoModel = [
        'pri' => 'log_id',
    ];

    protected function base($where) {
        return $this->table('points_log(A)')
            ->join('points_account(B)', ['B.account_id', 'A.account_id'])
            ->join('member_user(C)', ['C.user_id', 'B.user_id'])
            ->field(['A.*', 'C.email(user_email)', 'C.tel(user_tel)', 'C.nickname(user_nickname)'])
            ->where((array)$where);
    }

    public function loadList($where = array(), $limit = 0, $order = 'log_id desc') {
        $list = $this->base($where)
            ->limit($limit)
            ->order($order)
            ->select();
        foreach ($list as $key => $vo) {
            $list[$key]['show_name'] = target('member/MemberUser')->getNickname($vo['user_nickname'], $vo['user_tel'], $vo['user_email']);
        }
        return $list;
    }

    public function countList($where = array()) {
        return $this->base($where)->count();
    }

    public function getWhereInfo($where) {
        $info = $this->base($where)->find();
        if($info) {
            $info['show_name'] = target('member/MemberUser')->getNickname($info['user_nickname'], $info['user_tel'], $info['user_email']);
        }
        return $info;
    }


}