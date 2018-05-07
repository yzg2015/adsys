<?php
namespace app\member\service;
/**
 * 积分处理
 */
class PointsService extends \app\base\service\BaseService {

    /**
     * 操作账户
     * @param $data
     * @return bool
     */
    public function account($data) {
        $data = [
            'user_id' => intval($data['user_id']),
            'points' => price_format($data['points']),
            'type' => isset($data['type']) ? intval($data['type']) : 1,
            'deduct' => isset($data['deduct']) ? intval($data['deduct']) : 1,
            'title' => html_clear($data['title']),
            'remark' => html_clear($data['remark']),
            'force' => false
        ];
        if(empty($data['user_id'])) {
            return $this->error('无法识别用户!');
        }
        if(bccomp($data['points'], 0, 2) === -1) {
            return $this->error('处理金额不正确!');
        }
        $model = target('member/PointsAccount');
        $userInfo = $model->getWhereInfo([
            'A.user_id' => $data['user_id']
        ]);
        if(empty($userInfo)) {
            $accountData = [
                'user_id' => $data['user_id']
            ];
            $accountId = target('member/PointsAccount')->add($accountData);
            if(!$accountId) {
                return $this->error('账户创建失败！');
            }
            $userInfo = [
                'account_id' => $accountId,
                'user_id' => $data['user_id'],
                'points' => 0,
                'charge' => 0,
                'spend' => 0
            ];
        }
        //实际操作
        if($data['deduct']) {
            if(!$data['type']){
                if(bccomp($userInfo['points'], $data['points'], 2) === -1 && !$data['force']) {
                    return $this->error('账户积分不足,无法进行扣除!');
                }
            }
            if($data['type']){
                $status = $model->where(['user_id' => $data['user_id']])->setInc('points', $data['points']);
            }else{
                $status = $model->where(['user_id' => $data['user_id']])->setDec('points', $data['points']);
            }
            if(!$status){
                return $this->error('账户积分操作失败,请稍候再试!');
            }
        }

        if($data['type']){
            $status = $model->where(['user_id' => $data['user_id']])->setInc('charge', $data['points']);
        }else{
            $status = $model->where(['user_id' => $data['user_id']])->setInc('spend', $data['points']);
        }

        if(!$status){
            return $this->error('账户积分操作失败,请稍候再试!');
        }
        //写入记录
        $logData = array();
        $logData['account_id'] = $userInfo['account_id'];
        $logData['log_no'] = $this->logNo($userInfo['user_id']);
        $logData['time'] = time();
        $logData['points'] = $data['points'];
        $logData['title'] = $data['title'];
        $logData['remark'] = $data['remark'];
        $logData['type'] = $data['type'];
        $logId = target('member/PointsLog')->add($logData);
        if(!$logId) {
            return $this->error('积分记录失败,请稍候再试!');
        }
        return $this->success($logId);
    }

    /**
     * 获取流水号
     * @param $userId
     * @return string
     */
    public function logNo($userId = ''){
        mt_srand((double) microtime() * 1000000);
        return $userId . date('Ymd') . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * 增加资金
     * @param $userId
     * @param $points
     * @param $payNo
     * @param $payName
     * @param string $remark
     * @param int $deduct
     * @return bool
     */
    public function incAccount($userId, $points, $payName, $payNo = '', $title = '', $remark = '', $deduct = 1) {
        return $this->account([
            'user_id' =>$userId,
            'points' => $points,
            'pay_no' => $payNo,
            'pay_name' => $payName,
            'type' => 1,
            'title' => $title,
            'deduct' => $deduct,
            'remark' => $remark
        ]);
    }

    /**
     * 减少资金
     * @param $userId
     * @param $points
     * @param $payNo
     * @param $payName
     * @param string $title
     * @param string $remark
     * @param int $deduct
     * @return bool
     */
    public function decAccount($userId, $points, $payName, $payNo = '', $title = '', $remark = '', $deduct = 1) {
        return $this->account([
            'user_id' =>$userId,
            'points' => $points,
            'pay_no' => $payNo,
            'pay_name' => $payName,
            'type' => 0,
            'title' => $title,
            'deduct' => $deduct,
            'remark' => $remark
        ]);
    }

    /**
     * 检测账户积分
     * @param $userId
     * @param $balance
     * @return bool
     */
    public function checkAccount($userId, $balance) {
        $model = target('member/PointsAccount');
        $userInfo = $model->getWhereInfo([
            'A.user_id' => $userId
        ]);
        if($userInfo['points'] < $balance){
            return $this->error('账户余额不足!');
        }
        return $this->success();
    }

    /**
     * 账户余额
     * @param $userId
     * @return mixed
     */
    public function amountAccount($userId) {
        $info = target('member/PointsAccount')->getWhereInfo(['A.user_id' => $userId]);
        return $info['points'];
    }

    /**
     * 汇率
     * @return int
     */
    public function erAccount() {
        return 1;
    }

}
