<?php

/**
 * 会员上传
 */

namespace app\member\mobile;

class UploadMobile extends \app\member\mobile\MemberMobile {

    public function index() {
        $return = array('status' => 1, 'info' => '上传成功', 'data' => []);
        target('member/Upload', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
        ])->post()->export(function ($data) use ($return) {
            $data = reset($data);
            $return['data'] = $data;
            $this->json($return);
        }, function ($message) use ($return) {
            $return['status'] = 0;
            $return['info'] = $message;
            $this->json($return);
        });
    }

    public function editor() {
        target('member/Upload', 'middle')->setParams([
            'user_id' => $this->userInfo['user_id'],
        ])->post()->export(function ($data, $msg) {
            $info = reset($data);
            exit("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(\"" . request('get', 'CKEditorFuncNum', 0) . "\",'" . $info['url'] . "',\"" . $msg . "\");</script>");
        }, function ($msg) {
            $info = [];
            exit("<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction(\"" . request('get', 'CKEditorFuncNum', 0) . "\",'" . $info['url'] . "',\"" . $msg . "\");</script>");
        });
    }

}