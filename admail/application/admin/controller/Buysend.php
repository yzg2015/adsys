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
/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Buysend extends Admin
{
    /**
     * 后台首页
     * @author 蔡伟明 <314013107@qq.com>
     * @return string
     */
    public function index()
    {
        // 查询
        $map = $this->getMap();
        // 排序
        $order = $this->getOrder('admin_buysend.id desc');
        // 数据列表
        $data_list = BuysendModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('促销买送管理') // 设置页面标题
            ->setSearch(['admin_buysend.title' => '名称']) // 设置搜索框
            ->hideCheckbox()
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['title', '促销名称'],
                ['status', '状态', 'switch'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['id' => 'admin_buysend'])
            ->addFilter(['admin_buysend.title'])
            ->addRightButton('edit', ['icon' => 'fa fa-eye', 'title' => '详情', 'href' => url('details', ['id' => '__id__'])])
            ->setRowList($data_list) // 设置表格数据
            ->addTopButtons('add,enable,delete,disable')
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板
    }


}