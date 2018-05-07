<?php
namespace app\tools\service;
/**
 * 模块接口
 */
class ToolsService extends \app\base\service\BaseService {

    /**
     * 添加队列数据
     */
    public function sendMessage($data) {
        $data = [
            'receive' => $data['receive'],
            'class' => html_in($data['class']),
            'title' => html_clear($data['title']),
            'content' => html_in($data['content']),
            'param' => json_encode($data['param']),
            'user_status' => $data['user_status'],
        ];
        if(empty($data['class']) || empty($data['title']) || empty($data['content']) || empty($data['receive'])) {
            $this->error('队列参数不正确!');
        }

        $typeInfo = target('tools/ToolsSendConfig')->defaultType($data['class']);
        //检查接口格式
        if(empty($typeInfo)){
            return $this->error('未发现相关接口!');
        }

        if(!target($typeInfo['target'], 'send')->check($data)){
            return $this->error(target($typeInfo['target'], 'send')->getError());
        }
        if(!empty($typeInfo['tpl'])) {
            $siteConfig = target('site/SiteConfig')->getConfig();
            $replace = [
                '[网站名称]' =>  $siteConfig['info_name'],
                '[网址]' =>  DOMAIN,
                '[版权信息]' =>  $siteConfig['info_copyright'],
                '[站点邮箱]' =>  $siteConfig['info_email'],
                '[站点电话]' =>  $siteConfig['info_tel'],
                '[内容区域]' => $data['content'],
            ];
            $content = $typeInfo['tpl'];
            foreach ($replace as $key => $vo) {
                $content = str_replace($key , $vo, $content);
            }
            $data['content'] = $content;
        }
        $saveData = array();
        $saveData['type'] = $typeInfo['type'];
        $saveData['title'] = $data['title'];
        $saveData['content'] = $data['content'];
        $saveData['param'] = $data['param'];
        $saveData['receive'] = $data['receive'];
        $saveData['user_status'] = $data['user_status'];
        $saveData['start_time'] = time();

        $id = target('tools/ToolsSend')->add($saveData);
        if(!$id){
            return $this->error('发送失败!');
        }

        //添加到队列
        if(!target('tools/Queue', 'service')->add('send', $id, '消息发送', 'tools/toolsSend', 'send', 'model', $saveData, 0)) {
            return $this->error('发送失败!');
        }

        return $this->success();
    }
}

