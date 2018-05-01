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
/**
 * 前台首页控制器
 * @package app\index\controller
 */
class Index extends Home
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
//        CommentModel::getAll();
        $this->assign('info',$info);
        return $this->fetch();
    }

    public function detail()
    {
        return $this->fetch();
    }
}
