<?php
// +----------------------------------------------------------------------
// | admail-PHP框架 [ admail ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://admail.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

namespace app\index\controller;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Comment as CommentModel;
use app\admin\model\Order as OrderModel;
use app\admin\model\Cate as CateModel;
use app\admin\model\Tops as TopsModel;
use app\common\builder\ZBuilder;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
{
    public function in()
    {
        $_list = CateModel::getAllList();
        $goods = GoodsModel::getAllList();
        $this->assign('goods_list',$goods);
        $this->assign('cate_list',$_list);
        return $this->fetch();
    }

    public function wuliu()
    {
        $key = input('key');
        if(empty($key)){
            $this->error('请输入姓名');
        }
        $map['wfname'] = $key;
        $info=OrderModel::where($map)->find();
        if(empty($info)){
            $this->success('暂无结果');
        }

        $g=GoodsModel::get($info['goods_id']);
        $info['goods_name'] =$g['name'];
        $info['is_send'] ='未发货';
        $this->assign('info',$info);

    }

    public function order()
    {
        $id = input('id');
        if(empty($id)){
            $this->error('id error');
        }
        $info=OrderModel::get($id);
        if(empty($info)){
            $this->error('id error');
        }
        $g=GoodsModel::get($info['goods_id']);
        $info['goods_name'] =$g['name'];

        $info['is_send'] ='未发货';
        $this->assign('info',$info);
        return $this->fetch();
//        return ZBuilder::make('form')
//            ->setPageTitle('订单详情')
//            ->addStatic('goods_name', '订购产品')
//            ->addStatic('wfnums', '订购数量')
//            ->addStatic('wfprice', '订购单价')
//            ->addStatic('total_money', '订单总金额')
//            ->addStatic('order_time', '下单时间')
//            ->addStatic('wfname', '姓名')
//            ->addStatic('wfmob', '手機號碼')
//            ->addStatic('wfemail', '郵箱')
//            ->addStatic('wfpost', '郵編')
//            ->addStatic('wfguige', '訂購産品')
//            ->addStatic('wfshuxing', '规格')
//            ->addStatic('wfaddress', '地址')
//            ->addStatic('is_send', '是否发货')
//            ->setFormData($info)
//            ->fetch();

    }

    public function index()
    {
        $_list = TopsModel::getAllList();
        $one_list = array();
        $two_list = array();
        $three_list_one = array();
        $three_list_two = array();
        $three_list_three = array();
        foreach ($_list as $v){
            if($v['type'] == 1){
                $v['id'] = $v['goods_id'];
                $one_list[] = $v;
            }elseif ($v['type'] == 2){
                $v['id'] = $v['goods_id'];
                $two_list[] = $v;
            }elseif ($v['type'] == 3){
                $v['id'] = $v['goods_id'];
                $three_list_one[] = $v;
            }
            elseif ($v['type'] == 4){
                $v['id'] = $v['goods_id'];
                $three_list_two[] = $v;
            }
            elseif ($v['type'] == 5){
                $v['id'] = $v['goods_id'];
                $three_list_three[] = $v;
            }
        }
        $_list = CateModel::getAllList();
        $goods = GoodsModel::getAllList();
        $this->assign('goods_list',$goods);
        $this->assign('cate_list',$_list);
        $this->assign('one_list',$one_list);
        $this->assign('two_1',isset($two_list[0])?$two_list[0]:'');
        $this->assign('two_2',isset($two_list[1])?$two_list[1]:'');
        $this->assign('two_3',isset($two_list[3])?$two_list[3]:'');
        $this->assign('goods_list_one',$three_list_one);
        $this->assign('goods_list_two',$three_list_two);
        $this->assign('goods_list_three',$three_list_three);
        $this->assign('cate_list',$_list);
        return $this->fetch();
    }
    public function about()
    {
        return $this->fetch();
    }
    public function privacy()
    {
        return $this->fetch();
    }
    public function tuihuo()
    {
        return $this->fetch();
    }
    public function service()
    {
        return $this->fetch();
    }
    public function shipping()
    {
        return $this->fetch();
    }
}
