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
use app\admin\model\Order as OrderModel;
use app\admin\model\Comment as CommentModel;
use app\admin\model\Delivery as DeliveryModel;
use app\admin\model\Cate as CateModel;

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Goods extends Home
{
    public function index()
    {

        $id = input('id');
        if(empty($id)){
            $this->error('id error');
        }

        $info = GoodsModel::get($id);
        if(empty($info['status'])){
            $this->error('商品还没上架 ');
        }
        // 默认跳转模块
        if (config('home_default_module') != 'index') {
            $this->redirect(config('home_default_module'). '/index/index');
        }
        $c_list = CommentModel::getList($id);
        $d_list = DeliveryModel::getList($id);
        $this->assign('info',$info);
        $this->assign('c_list',$c_list);
        $this->assign('d_list',$d_list);
        $this->assign('c_count',count($c_list));

        return $this->fetch();
    }

    public function cx(){
        $key = input('key');
        if(empty($key)){
            $this->error('参数错误');
        }
        $this->success('暂无结果');
    }

    public function save(){
        $id = input('id');
        $mes =   '';
        $data['order_sn'] = $id.rand(100,999).'_'.time();
        $data['user_id'] =0;
        $wfprosize = input('wfprosize');
        $wfprocolour = input('wfprocolour');
        $wfpayment = input('wfpayment');
        $wfpayzk = input('wfpayzk');
        $wfproup = input('wfproup');
        $wfprice = input('wfprice');
        $wfismob = input('wfismob');
        $data['goods_id']= $id;
        if(empty($id)){
            exit('id is  empty');
        }
        $data['wfnums'] = intval(input('wfnums'));
        $data['wfname'] = input('wfname');
        $data['ip'] = '127.0.0.1';
        $data['wfmob'] = input('wfmob');
        $data['wfpost'] = input('wfpost');
        $data['wfemail'] = input('wfemail');
        $wfuprovince = input('wfuprovince');
        $wfucity = input('wfucity');
        $wfaddress = input('wfaddress');
        $data['wfaddress'] =$wfuprovince.$wfucity.$wfaddress;
        $data['remark'] = input('wfguest');
        if(empty($data['wfname'])){
            exit('请填写姓名');
        }

        if(empty($data['wfaddress'])){
            exit('请填写具体收货地址');
        }



        if(empty($data['wfmob'])){
            exit('请填写手机号');
        }
        if(empty($wfproup)){
            exit('商品价格不能为空');
        }

        if(empty($data['wfnums'])){
            exit('商品数为空量不能');
        }
        // 保存数据
        if ($this->request->isPost()) {
            $data['total_money'] = $wfproup* $data['wfnums'];
            $data['order_time'] = time();
            if (false !== OrderModel::create($data)) {
                $mes ='ok';

            } else {
                $mes='error';
            }
        }

        if(empty($id)){
            exit('id error');
        }
        echo $mes;
        exit;
    }

    public function detail()
    {
        $id = input('id');
        if(empty($id)){
            $this->error('id error');
        }
        $info = GoodsModel::get($id);
        if(empty($info['status'])){
            $this->error('error');
        }

        $spec_arr_list = '';
        $shuxing_arr_list='';
        $spec_arr = explode(';',$info['spec']);
        if(!empty($spec_arr)){
            foreach ($spec_arr as $v){
                if(empty($v)){
                    continue;
                }
                $arr = explode('#',$v);
                if(count($arr)<=1){
                    continue;
                }
                $o = array();
                $o['name'] = $arr[0];
                $info['guige']=$o['name'];
                $arr[1] = explode('|',$arr[1]);
                if(!empty($arr[1])) {
                    foreach ($arr[1] as $i) {
                        $g_l = explode(',', $i);
                        $g_item['zhi'] = isset($g_l[0]) ? $g_l[0] : '';
                        $g_item['pic'] = isset($g_l[1]) ? intval($g_l[1]) : 0;
                        $o['_list'][] = $g_item;
                    }
                }
                $spec_arr_list[] = $o;
            }
        }

        if(!empty($info['shuxing'])){
            $shuxing_arr = explode(';',$info['shuxing']);
            if(!empty($shuxing_arr)){
                foreach ($shuxing_arr as $v){
                    if(empty($v)){
                        continue;
                    }
                    $arr = explode('|',$v);
                    if(count($arr)<=4){
                        continue;
                    }
                    if(empty($arr[0])){
                        continue;
                    }
                    $info['shuxing']=$arr[0];
                    $info['price']=$arr[2];
                    $iy['sx_name'] = $arr[0];
                    $iy['sx_price']=$arr[1];

                    $iy['sx_zhekou'] = $arr[2];
                    $iy['sx_sku']=$arr[3];
                    $iy['sx_pic'] = $arr[4];
                    $shuxing_arr_list[] = $iy;
                }
            }
        }





        $d_list = DeliveryModel::getList($id);
        $this->assign('d_list',$d_list);
        $this->assign('spec_arr',$spec_arr_list);
        $this->assign('shuxing_arr',$shuxing_arr_list);
        $this->assign('info',$info);
        return $this->fetch();
    }
}
