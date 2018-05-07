<?php

/**
 * 分销商品管理
 */
namespace app\sale\model;

use app\system\model\SystemModel;

class SaleContentModel extends SystemModel {

    protected $infoModel = [
        'pri' => 'id',
        'into' => '',
        'out' => '',
    ];

    public function hookHtml($hasId, $app) {
        if ($hasId) {
            $info = target('sale/SaleContent')->getWhereInfo([
                'app' => $app,
                'has_id' => $hasId
            ]);
        } else {
            $info = [
                'sale_status' => 1,
                'sale_special' => 0
            ];
        }
        $saleRate = unserialize($info['sale_rate']);

        $saleConfig = target('sale/SaleConfig')->getConfig();

        $html = '<div class="am-panel am-panel-default dux-panel"> <div class="am-panel-hd">分销设置</div><div class="am-panel-bd">';
        $html .= '<div class="am-form-group"><label class="am-form-label am-u-md-2">分销返利</label><div class="am-u-md-10">';
        $html .= '<label class="am-radio-inline"><input name="sale_status" value="1" ' . ($info['sale_status'] ? 'checked="checked"' : '') . ' type="radio">开启</label>';
        $html .= '<label class="am-radio-inline"><input name="sale_status" value="0" ' . (!$info['sale_status'] ? 'checked="checked"' : '') . ' type="radio">关闭</label>';
        $html .= '</div></div>';

        $html .= '<div class="am-form-group"><label class="am-form-label am-u-md-2">独立佣金比例</label><div class="am-u-md-10">';
        $html .= '<label class="am-radio-inline"><input name="sale_special" value="1" ' . ($info['sale_special'] ? 'checked="checked"' : '') . ' type="radio">开启</label>';
        $html .= '<label class="am-radio-inline"><input name="sale_special" value="0" ' . (!$info['sale_special'] ? 'checked="checked"' : '') . ' type="radio">关闭</label>';
        $html .= '<div class="am-form-help">启用独立佣金设置，此商品拥有独自的佣金比例,不受分销商等级比例及默认设置限制 </div></div></div>';

        for ($i = 1; $i <= $saleConfig['sale_level']; $i++) {
            $html .= '<div class="am-form-group"><label class="am-form-label am-u-md-2">' . $i . '级分销佣金比例</label><div class="am-u-md-10">';
            $html .= '<div class="am-input-group">';
            $html .= '<input type="text" name="sale_rate[' . $i . '][rate]" value="' . $saleRate[$i]['rate'] . '" placeholder="" ><span class="am-input-group-label">% 或</span><input type="text" name="sale_rate[' . $i . '][money]" value="' . $saleRate[$i]['money'] . '" placeholder="" ><span class="am-input-group-label">元</span>';
            $html .= '</div></div></div>';
        }
        $html .= '</div></div>';
        return [
            'name' => '分销设置',
            'order' => 99,
            'html' => $html
        ];
    }

    public function HookSave($hasId, $app) {
        $data = [];
        $data['sale_status'] = request('post', 'sale_status');
        $data['sale_special'] = request('post', 'sale_special');
        $data['sale_rate'] = serialize($_POST['sale_rate']);
        $data['has_id'] = $hasId;
        $data['app'] = $app;

        $info = target('sale/SaleContent')->getWhereInfo([
            'app' => $app,
            'has_id' => $hasId
        ]);

        if (!empty($info)) {
            $data['id'] = $info['id'];
            $status = target('sale/SaleContent')->edit($data);
        }else {
            $status = target('sale/SaleContent')->add($data);
        }
        if(!$status) {
            $this->error = '保存分销信息失败!';
            return false;
        }
        return true;
    }

    public function HookDel($hasId, $app) {
        target('sale/SaleContent')->where(['has_id' => $hasId , 'app' => $app])->delete();
        return true;
    }


}