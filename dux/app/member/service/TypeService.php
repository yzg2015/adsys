<?php

namespace app\member\service;
/**
 * 类型接口
 */
class TypeService {

    /**
     * 货币接口
     */
    public function getCurrencyType() {
        return [
            'credit' => [
                'name' => '积分',
                'unit' => '分',
                'target' => 'member/Points',
                'hybrid' => true
            ],

            'd' => array(
                'name' => 'D币',
                'unit' => '币',
                'target' => 'member/Points',
                'hybrid' => false
            ),
        ];
    }

    /**
     * 流水接口
     */
    public function getPayLogType() {
        return [
            'system' => [
                'name' => '余额',
                'url' => 'member/PayLog/index',
            ],
        ];
    }

}

