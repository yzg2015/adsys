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

/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Classify extends Home
{
    public function index()
    {
        $id=input('id');
        $id= !$id?1:$id;
        $info = CateModel::get($id);
        $_list = CateModel::getAllList($id);
        $goods = GoodsModel::getAllList($id);
        $this->assign('goods_list',$goods);
        $this->assign('title',$info['title']);
        $this->assign('cate_list',$_list);
        return $this->fetch();
    }

    public function search()
    {
        $s = input('q');//http://www.goodluck-3guys.com/  www.goodluck-3guys.com
        $list  =GoodsModel::getSeaList($s);
        $this->assign('_list',$list);
        $this->assign('key',$s);
        return $this->fetch();
    }
}
