<?php
namespace app\sale\service;
/**
 * 商品接口
 */
class MallsellerService extends \app\base\service\BaseService {

    public function merchantGoodsHtml($hasId = 0) {
        return target('sale/SaleContent')->hookHtml($hasId, 'mall');
    }

    public function merchantGoodsSave($hasId = 0) {
        return target('sale/SaleContent')->HookSave($hasId, 'mall');
    }

    public function merchantGoodsDel($hasId = 0) {
        return target('sale/SaleContent')->HookDel($hasId, 'mall');
    }


}

