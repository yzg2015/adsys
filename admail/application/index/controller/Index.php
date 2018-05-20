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
    public function index()
    {
        $_list = CateModel::getAllList();
        $goods = GoodsModel::getAllList();
        $this->assign('goods_list',$goods);
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
