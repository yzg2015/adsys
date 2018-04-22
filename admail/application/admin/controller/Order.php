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
use app\admin\model\Order as OrderModel;
use think\Cache;
use think\helper\Hash;
use think\Db;
use app\common\builder\ZBuilder;
use app\user\model\User as UserModel;

/**
 * 后台默认控制器
 * @package app\admin\controller
 */
class Order extends Admin
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
        $order = $this->getOrder('admin_order.id desc');
        // 数据列表
        $data_list = OrderModel::getAll($map, $order);
        // 分页数据
        $page = $data_list->render();
        // 使用ZBuilder快速创建数据表格
        return ZBuilder::make('table')
            ->setPageTitle('订单管理') // 设置页面标题
            ->setSearch(['admin_order.order_sn' => '订单号', 'admin_delivery.w_sn' => '物流单号','admin_delivery.z_sn' => '转寄物流单号']) // 设置搜索框
            ->hideCheckbox()
            ->addColumns([ // 批量添加数据列
                ['id', 'ID'],
                ['order_sn', '订单号'],
                ['username', '用户名'],
                ['address', '收货地址'],
                ['total_money', '总金额'],
                ['url', '来源网站'],
                ['status', '订单状态', 'switch'],
                ['ip', '客户IP'],
                ['order_time', '下单时间', 'time', '', 'Y-m-d'],
                ['right_button', '操作', 'btn']
            ])
            ->addOrder(['order_sn' => 'admin_order', 'address' => 'admin_delivery','url' => 'admin_goods'])
            ->addFilter(['admin_order.order_sn', 'admin_delivery.address','admin_goods.url'])
            ->addTopButtons('add,enable,delete,disable')
            ->addRightButtons('edit,delete')
            ->addRightButton('edit', ['icon' => 'fa fa-eye', 'title' => '详情', 'href' => url('details', ['id' => '__id__'])])
            ->setRowList($data_list) // 设置表格数据
            ->setPages($page) // 设置分页数据
            ->fetch(); // 渲染模板

    }


}