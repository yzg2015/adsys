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
/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Goods extends Home
{
    public function index()
    {

        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> '.config("dolphin.product_name").' '.config("dolphin.product_version").'<br/><span style="font-size:30px">hshshh</span></p></div>';

    }

    public function save(){
        $id = input('id');
        $mes =   '';
        $data['order_sn'] = rand(1,100).'_'.time().'_'.$id;
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

        if(empty($data['address'])){
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
            $this->error('商品还没上架 ');
        }
        $this->assign('info',$info);
        return $this->fetch();
    }
}
