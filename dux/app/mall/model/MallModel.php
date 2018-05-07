<?php

/**
 * 商品管理
 */

namespace app\mall\model;

use app\system\model\SystemModel;

class MallModel extends SystemModel {

    protected $infoModel = [
        'pri' => 'mall_id',
        'validate' => [
            'class_id' => [
                'empty' => ['', '请选择分类!', 'must', 'all'],

            ],
        ],
        'format' => [
            'content' => [
                'function' => ['html_in', 'all', 0],
            ]
        ]
    ];


    protected function base($where, $modelId = 0) {
        $base = $this->table('site_content(A)')
            ->join('mall(B)', ['B.content_id', 'A.content_id'])
            ->join('mall_class(C)', ['C.class_id', 'B.class_id'])
            ->join('site_class(D)', ['D.category_id', 'C.category_id']);
        $field = ['A.*', 'B.*', 'D.name(class_name)', 'D.model_id'];
        if ($modelId) {
            $modelInfo = target('site/SiteModel')->getInfo($modelId);
            $base = $base->join('model_' . $modelInfo['label'] . '(E)', ['E.content_id', 'A.content_id'], '<');
            $field[] = 'E.*';
        }

        return $base
            ->field($field)
            ->where((array)$where);
    }

    public function loadList($where = [], $limit = 0, $order = 'A.sort desc, A.create_time desc, B.mall_id desc', $modelId = 0) {
        $list = $this->base($where, $modelId)
            ->limit($limit)
            ->order($order)
            ->select();
        if (empty($list)) {
            return [];
        }
        foreach ($list as $key => $vo) {
            $list[$key]['url'] = $this->getUrl($vo['mall_id']);
        }
        return $list;
    }

    public function countList($where = []) {
        return $this->base($where)->count();
    }

    public function getWhereInfo($where, $modelId = 0) {
        $info = $this->base($where, $modelId)->find();
        if($info) {
            $info['url'] = $this->getUrl($info['mall_id']);
        }
        return $info;
    }

    public function getInfo($id, $modelId = 0) {
        $where = [];
        $where['B.mall_id'] = $id;
        return $this->getWhereInfo($where, $modelId);
    }

    public function _delBefore($id) {
        $info = $this->getInfo($id);
        return target('site/SiteContent')->delData($info['content_id']);
    }

    public function getUrl($id) {
        return url(VIEW_LAYER_NAME . '/mall/Info/index', ['id' => $id]);
    }

    public function saveData($type = 'add', $data = []) {
        $this->beginTransaction();
        if ($_POST['content'] && empty($_POST['description'])) {
            $_POST['description'] = \dux\lib\Str::strMake($_POST['content'], 240);
        }
        $post = $_POST;
        if (empty($post['images'])) {
            $this->rollBack();
            $this->error = '请至少上传一张图片!';

            return false;
        }
        $images = [];
        foreach ($post['images']['url'] as $key => $vo) {
            $images[] = [
                'url' => $vo,
                'title' => $post['images']['title'][$key]
            ];
        }
        $_POST['images'] = serialize($images);
        //处理缩略图
        $_POST['image'] = target('site/Tools', 'service')->coverImage($post['images']['url'][0]);
        //处理规格数据
        $specData = '';
        if (isset($post['data']['spec'])) {
            $goods_spec_array = [];
            foreach ($post['data']['spec'] as $key => $val) {
                foreach ($val as $v) {
                    $tempSpec = json_decode($v, true);
                    if (!isset($goods_spec_array[$tempSpec['id']])) {
                        $goods_spec_array[$tempSpec['id']] = ['id' => $tempSpec['id'], 'name' => $tempSpec['name'], 'value' => []];
                    }
                    $goods_spec_array[$tempSpec['id']]['value'][] = $tempSpec['value'];
                }
            }
            foreach ($goods_spec_array as $key => $val) {
                $val['value'] = array_unique($val['value']);
                $goods_spec_array[$key]['value'] = join(',', $val['value']);
            }
            $specData = serialize($goods_spec_array);
        }
        $_POST['spec_data'] = $specData;

        $_POST['goods_no'] = $post['data']['goods_no'][0];
        $_POST['sell_price'] = $post['data']['sell_price'][0];
        $_POST['market_price'] = $post['data']['market_price'][0];
        $_POST['cost_price'] = $post['data']['cost_price'][0];
        $_POST['store'] = 0;
        $_POST['weight'] = $post['data']['weight'][0];
        $_POST['update_time'] = time();


        if ($_POST['up_time']) {
            $_POST['up_time'] = strtotime($data['up_time']);
        }
        if ($_POST['down_time']) {
            $_POST['down_time'] = strtotime($data['down_time']);
        }

        $specData = $_POST['data'];
        $proData = [];
        $store = 0;
        foreach ($specData['goods_no'] as $key => $vo) {
            $proData[$key] = [
                'products_id' => $specData['id'][$key],
                'products_no' => $vo,
                'sell_price' => $specData['sell_price'][$key],
                'market_price' => $specData['market_price'][$key],
                'cost_price' => $specData['cost_price'][$key],
                'store' => $specData['store'][$key],
                'weight' => $specData['weight'][$key],
                'spec_data' => $this->mergerSpec($specData['spec'][$key])
            ];
            if (empty($vo)) {
                $this->rollBack();
                $this->error = '商品货号未填写!';
                return false;
            }
            $store += intval($specData['store'][$key]);
        }

        $_POST['store'] = $store;
        $mallId = $_POST['mall_id'];

        if ($type == 'add') {
            $id = target('site/SiteContent')->saveData('add');
            if (!$id) {
                $this->rollBack();
                $this->error = target('site/SiteContent')->getError();

                return false;
            }
            $_POST['content_id'] = $id;
            $id = parent::saveData('add');
            $mallId = $id;
            if (!$id) {
                $this->rollBack();
                $this->error = $this->getError();

                return false;
            }
        }
        if ($type == 'edit') {
            $status = target('site/SiteContent')->saveData('edit');
            if (!$status) {
                $this->rollBack();
                $this->error = target('site/SiteContent')->getError();

                return false;
            }
            $status = parent::saveData('edit');
            if (!$status) {
                $this->rollBack();
                $this->error = $this->getError();

                return false;
            }
        }
        //处理货品
        $proIds = [];
        foreach ($proData as $vo) {
            $vo['mall_id'] = $mallId;
            if ($vo['products_id']) {
                $status = target('mall/MallProducts')->edit($vo);
                $proIds[] = $vo['products_id'];
            } else {
                $status = target('mall/MallProducts')->add($vo);
                $proIds[] = $status;
            }
            if (!$status) {
                $this->error = target('mall/MallProducts')->getError();

                return false;
            }
        }
        $status = target('mall/MallProducts')->where([
            '_sql' => 'products_id NOT IN (' . implode(',', $proIds) . ')',
            'mall_id' => $mallId
        ])->delete();

        if (!$status) {
            $this->error = target('mall/MallProducts')->getError();

            return false;
        }

        $this->commit();

        return $mallId;
    }

    /**
     * 合并规格
     */
    protected function mergerSpec($data) {
        if ($data) {
            $data = str_replace("'", '"', $data);

            return serialize(json_decode('[' . implode(',', $data) . ']', true));
        } else {
            return '';
        }
    }

    public function delData($id) {
        $info = $this->getInfo($id);
        $this->beginTransaction();
        $where = [];
        $where['mall_id'] = $id;
        if (!$this->where($where)->delete()) {
            $this->rollBack();

            return false;
        }
        if (!target('site/SiteContent')->delData($info)) {
            $this->rollBack();

            return false;
        }
        if (!target('mall/MallProducts')->where(['mall_id' => $id])->delete()) {
            $this->rollBack();

            return false;
        }
        $this->commit();

        return true;
    }

}