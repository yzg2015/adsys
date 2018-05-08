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

namespace app\admin\controller;

use think\Cache;
use think\helper\Hash;
use think\Db;
use app\common\builder\ZBuilder;
use app\user\model\User as UserModel;
use app\admin\model\Buysend as BuysendModel;
use app\admin\model\Fullminus as FullminusModel;
use app\admin\model\Discount as DiscountModel;

/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Cuxiao extends Admin
{
    /**
     * 后台首页
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    public function index()
    {
        $admin_pass = Db::name('admin_user')->where('id', 1)->value('password');

        if (UID == 1 && $admin_pass && Hash::check('admin', $admin_pass)) {
            $this->assign('default_pass', 1);
        }
        return $this->fetch();
    }

    /**
     * 后台首页
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    public function guige()
    {
        $id = input('id');
        if(empty($id)){
            exit;
        }
        $html = '';
        if($id=='1'){
            $list = BuysendModel::getList();

        }
        if($id=='2'){
            $list = FullminusModel::getList();
        }
        if($id=='3'){
            $list = DiscountModel::getList();
        }
        foreach ($list as $v){
            $html .= "<option value='".$v['id']."'>".$v['title']."</option>";
        }
        echo $html;
        exit;
    }

}